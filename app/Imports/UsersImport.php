<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rules;


class UsersImport implements ToModel, WithValidation,  WithHeadingRow, SkipsOnFailure, SkipsEmptyRows
{
    use Importable, SkipsFailures;
    protected $defaultPassword;

    public function __construct($defaultPassword)
    {
        $this->defaultPassword = $defaultPassword;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['nombres'],
            'last_name' => $row['apellidos'],
            'email' => $row['correo'],
            'password' => Hash::make($this->defaultPassword ?? $row['password']),
            'rol' => "user",
            'puesto' => $row['puesto'],
        ]);
    }
    public function prepareForValidation(array $data)
    {
        return collect($data)->mapWithKeys(function ($value, $key) {
            return [$key => is_string($value) ? trim($value) : $value];
        })->toArray();
    }
    public function rules(): array
    {
        $rules = [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'max:255', 'unique:users,email'],
            'puesto' => ['required', 'string', 'max:255'],
        ];
        if (!$this->defaultPassword) {
            $rules['password'] = ['required', Rules\Password::defaults()];
        }
        return $rules;
    }
}
