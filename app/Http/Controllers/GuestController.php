<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GuestController extends Controller
{
    public function reseñas()
    {
        // Datos de ejemplo de reseñas
        $reviews = [
            [
                'name' => 'María López',
                'date' => '2024-10-18',
                'review' => 'Esta plataforma ha mejorado mi experiencia laboral. Me siento más valorada y en un ambiente seguro.',
                'rol' => 'operario'
            ],
            [
                'name' => 'Juan Pérez',
                'date' => '2024-09-21',
                'review' => 'Gran herramienta para promover la inclusión y el bienestar en el trabajo.',
                'rol' => 'master'
            ],
            [
                'name' => 'Juan Pérez',
                'date' => '2024-09-21',
                'review' => 'Gran herramienta para promover la inclusión y el bienestar en el trabajo.',
                'rol' => 'master'
            ],
            // Más reseñas...
        ];
        // Para cada reseña, obtenemos una foto de usuario desde RandomUser.me
        foreach ($reviews as $key => $review) {
            $response = Http::get('https://randomuser.me/api/');
            $photoUrl = $response->json()['results'][0]['picture']['large'];
            $reviews[$key]['photo'] = $photoUrl;  // Asigna la foto a la reseña
        }
        return view('reviews', compact('reviews'));
    }

    public function home()
    {
        return view('home');
    }

    public function proposito()
    {
        return view('proposito');
    }

    public function soporte()
    {
        return view('soporte');
    }
}
