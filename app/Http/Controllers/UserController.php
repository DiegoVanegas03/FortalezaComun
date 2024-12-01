<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Exports\FailedRowsExport;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where("rol", "user")->paginate(10);

        return view('users.index', compact('users'));
    }

    public function import(): View
    {
        return view('users.import-excel');
    }

    public function importRegister(Request $request): RedirectResponse
    {
        try {

            $request->validate([
                'formateo' => ['required', 'string', 'in:definido,default'],
                'excel_usuarios' => ["required", "file", "mimes:xlsx,xls,csv"],
            ]);
            $typeFormateo = $request->get('formateo');
            $password = null;
            if ($typeFormateo == "default") {
                $request->validate([
                    'password' => ['required', Rules\Password::defaults()],
                ]);
                $password = $request->get('password');
            }
            $import = new UsersImport($password);
            Excel::import($import, $request->file('excel_usuarios'));
            if ($import->failures()->isNotEmpty()) {
                // Generar archivo de feedback con errores
                $failures = $import->failures();
                $feedbackFile = 'failed_rows_' . now()->timestamp . '.xlsx';
                Excel::store(new FailedRowsExport($failures, $password), $feedbackFile, 'local');
            }
            return redirect()->route('users.index');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return response()->json(['message' => 'Ocurrió un error durante la importación.', 'errors' => $e->getMessage()]);
        }
    }


    public function create(): View
    {
        $user = null;
        return view('users.add-edit', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.add-edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Asegúrate de validar el ID que siempre debe estar presente
        $request->validate(['id' => ['required']]);
        // Encuentra al usuario por ID
        $user = User::findOrFail($request->id);
        // Define las reglas de validación
        $columns = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'puesto' => ['required', 'string', 'max:200'],
        ];
        // Crear un arreglo para las reglas de validación a aplicar
        $rules = [];
        // Recorre cada columna para verificar si ha cambiado
        foreach ($columns as $column => $validationRules) {
            // Verifica si el valor ha cambiado
            if ($request[$column] !== (string)$user[$column]) {
                $rules[$column] = $validationRules;
            }
        }
        // Si hay cambios en el email, asegúrate de que sea único
        if (isset($rules['email'])) {
            $rules['email'][] = 'unique:users,email,' . $user->id; // Excluye el email actual
        }
        // Valida los datos de la solicitud solo para los campos modificados
        $request->validate($rules);
        // Actualiza el usuario con los nuevos valores
        $user->update($request->only(array_keys($rules)));
        return redirect()->route('users.index')->with('status', 'Success-update');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'puesto' => ['required', 'string', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        User::create([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'puesto' => $request->get('puesto'),
            'password' => $request->get('password'),
        ]);
        return redirect(route('users.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $id = $request->get('id');
        $form = User::findOrFail($id);
        $form->delete();
        return redirect(route('users.index'));
    }
}
