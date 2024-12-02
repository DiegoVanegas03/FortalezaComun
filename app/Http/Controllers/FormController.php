<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Form;
use App\Models\FormResponse;
use App\Models\FormFieldResponse;
use App\Models\User;
use App\Models\FormField;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\RedirectResponse;
use App\Mail\FormInvitationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class FormController extends Controller
{
    private function convertOnOffToInt($value)
    {
        return $value === "on" ? 1 : 0;
    }

    public function index(): View
    {
        $forms = Form::paginate(10);

        return view('forms.index', compact('forms'));
    }

    public function create(): View
    {
        return view('forms.add')->with(['form' => null]);
    }

    public function edit($id): View
    {
        $form = Form::findOrFail($id);

        return view('forms.add')->with(compact('form'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Asegúrate de validar el ID que siempre debe estar presente
        $request->validate(['id' => ['required']]);
        // Encuentra al usuario por ID
        $form = Form::findOrFail($request->id);
        // Define las reglas de validación
        $columns = [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
        // Crear un arreglo para las reglas de validación a aplicar
        $rules = [];
        // Recorre cada columna para verificar si ha cambiado
        foreach ($columns as $column => $validationRules) {
            // Verifica si el valor ha cambiado
            if ($request[$column] !== (string)$form[$column]) {
                $rules[$column] = $validationRules;
            }
        }
        // Valida los datos de la solicitud solo para los campos modificados
        $request->validate($rules);
        // Actualiza el usuario con los nuevos valores
        $form->update($request->only(array_keys($rules)));
        //Verificacion de fields
        $fields = $request->get('fields');
        $originalFields = $form->fields()->get();
        $columnsFields = ['label', 'type', 'options', 'required'];
        foreach ($fields as $field) {
            $originalField = $originalFields->find($field['id'] ?? null);
            if ($originalField != null) {
                $keys = [];
                foreach ($columnsFields as $column) {
                    if ($column != 'required' && $originalField[$column] != (string)$field[$column]) {
                        $keys[] = $column;
                    }
                    if ($column == 'required' && $originalField[$column] != $this->convertOnOffToInt($field[$column] ?? "off")) {

                        $field[$column] =  $this->convertOnOffToInt($field[$column] ?? "off");
                        $keys[] = $column;
                    }
                }
                if (count($keys) > 0) $originalField->update($field, array_flip($keys));
            } else {
                FormField::create([
                    'form_id' => $form->id,
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'options' => $field['options'] ?? null,  // Usa null si no existen opciones
                    'required' => isset($field['required']) && $field['required'] === 'on' ? true : false,
                ]);
            }
        }
        $idToDelte = array_diff($originalFields->pluck('id')->toArray(), array_map('intval', array_column($fields, 'id')));
        if (count($idToDelte) > 0) FormField::destroy($idToDelte);

        return redirect()->route('forms.index')->with('status', 'Success-update');
    }

    public function notify($id)
    {
        $form = Form::findOrFail($id);
        //modificar comenta los $users actuales y descomenta la linea abajo de ella
        $users = User::whereNot('rol', 'admin')->take(5)->get();
        $users = User::whereNot('rol', 'admin')->get();
        $expiry = now()->addWeeks(2);
        $data = [
            'id' => $id,
            'expiry' => $expiry->format('Y-m-d H:i:s')  // Convertir la fecha a formato string
        ];
        // Encriptar los datos
        $encryptedData = Crypt::encrypt(json_encode($data));
        $url = route('forms.response.show', $encryptedData);
        foreach ($users as $user) {
            Mail::To($user->email)->send(new FormInvitationMail($user->nombreCompleto(), $form->name, $form->description, $url));
        }
        return redirect()->route('forms.index')->with('status', 'Successfully sends');
    }

    public function responseShow($encrypt)
    {
        $data = json_decode(Crypt::decrypt($encrypt), true);
        try {

            // Ahora puedes acceder al id y la fecha de vencimiento
            $id = $data['id'];
            $expiry = Carbon::parse($data['expiry']);  // Convertir el string a un objeto de fecha
            // Verificar si la fecha de vencimiento ha pasado
            if ($expiry->isPast()) {
                throw new \RuntimeException('La fecha de vencimiento ha pasado.');
            }
            $form = Form::findOrFail($id);
            $permitedAction = true;
            return view('forms.previsualizer')->with(compact('form', 'permitedAction'));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token inválido o expirado'], 400);
        }
    }

    public function response(Request $request)
    {
        $id = $request->get('id');
        $user = $request->user();
        $form = Form::findOrFail($id);

        $formResponse = FormResponse::create([
            'user_id' => $user->id,
            'form_id' => $form->id,
        ]);

        $fieldsForm = $form->fields()->get();
        foreach ($fieldsForm as $field) {
            $responseField = $request->get($field->label);
            if ($responseField != null) {
                FormFieldResponse::create([
                    'form_response_id' => $formResponse->id,
                    'form_field_id' => $field->id,
                    'value' => $responseField,
                ]);
            }
        }
        return redirect()->route('home')->with('status', 'Successfully sends');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $form = Form::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        foreach ($request->get('fields') as $field) {
            FormField::create([
                'form_id' => $form->id,
                'label' => $field['label'],
                'type' => $field['type'],
                'options' => $field['options'] ?? null,  // Usa null si no existen opciones
                'required' => isset($field['required']) && $field['required'] === 'on' ? true : false,
            ]);
        }
        return redirect(route('forms.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $id = $request->get('id');
        $form = Form::findOrFail($id);
        $form->delete();
        return redirect(route('forms.index'));
    }

    public function previsualizer($id)
    {
        $form = Form::findOrFail($id);
        $permitedAction = false;
        return view('forms.previsualizer', compact('form', 'permitedAction'));
    }
}
