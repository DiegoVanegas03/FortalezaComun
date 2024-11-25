<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FailedRowsExport implements FromCollection, WithHeadings
{
    protected $failures;
    protected $defaultPassword;

    public function __construct($failures, $defaultPassword)
    {
        $this->failures = $failures;
        $this->defaultPassword = $defaultPassword;
    }
    public function collection()
    {
        return collect($this->failures)
            ->groupBy('row') // Agrupamos por la fila que falló
            ->map(function ($failures, $row) {
                // Obtenemos los valores de la fila que falló
                $values = $failures->first()->values();

                // Concatenamos todos los errores de esa fila separados por comas
                $errors = $failures->map(function ($failure) {
                    return implode(', ', $failure->errors());
                })->join(', ');

                // Retornamos la fila con los valores originales más el row y los errores concatenados
                return array_merge($values, [
                    'row' => $row,
                    'error' => $errors
                ]);
            })
            ->values(); // Para obtener solo los valores y no las claves del agrupamiento
    }

    public function headings(): array
    {
        // Construcción dinámica del arreglo de encabezados
        $headings = ['nombres', 'apellidos', 'correo'];

        // Condición para agregar 'password' según $defaultPassword
        if (!$this->defaultPassword) {
            $headings[] = 'contraseña';
        }

        // Agregar encabezados adicionales
        $headings[] = 'puesto';
        $headings[] = 'row';
        $headings[] = 'error';

        return $headings;
    }
}
