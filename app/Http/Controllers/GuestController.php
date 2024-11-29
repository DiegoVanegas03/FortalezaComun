<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reviews;


class GuestController extends Controller
{
    public function reseñas()
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Verificar si el usuario tiene alguna reseña en la tabla `Reviews`
        $exists = Reviews::where('user_id', $userId)->exists();

        // Obtener todas las reseñas de la tabla
        $reviews = Reviews::latest()->take(6)->get()->map(function ($review) {
            // Agregar una foto desde RandomUser.me a cada reseña
            $response = Http::get('https://randomuser.me/api/');
            $review['photo'] = $response->json()['results'][0]['picture']['large'];
            return $review;
        });

        // Enviar los datos a la vista
        return view('reviews', compact('reviews', 'exists'));
    }

    // Pura mamada contigo we

    public function reviewsAdd(Request $request): RedirectResponse
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'review' => 'required|string',
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Crear una nueva reseña
        Reviews::create([
            'user_id' => $userId,
            'review' => $validated['review'],
            'date' => now()->toDateString(),
        ]);

        // Redirigir a la página de reseñas
        return redirect()->route('reseñas')->with('success', 'Reseña añadida con éxito.');
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
