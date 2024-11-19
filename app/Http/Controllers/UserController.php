<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where("rol", "user")->paginate(10);

        return view('users.index', compact('users'));
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'puesto' => ['required', 'string', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'puesto' => $request->get('puesto'),
            'password' => $request->get('password'),
        ]);
        return redirect(route('users.index'));
    }
}
