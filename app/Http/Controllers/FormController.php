<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\RedirectResponse;


class FormController extends Controller
{
    public function index(): View
    {
        $forms = Form::paginate(10);

        return view('forms.index', compact('forms'));
    }

    public function create(): View
    {
        return view('forms.add');
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
        return view('forms.previsualizer', compact('form'));
    }
}
