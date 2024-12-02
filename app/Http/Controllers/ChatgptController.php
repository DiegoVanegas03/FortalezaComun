<?php

namespace App\Http\Controllers;

use App\Services\FormAnalysisService;
use Illuminate\Http\Request;
use App\Models\Form;

class ChatgptController extends Controller
{
    protected $formAnalysisService;

    public function __construct(FormAnalysisService $formAnalysisService)
    {
        $this->formAnalysisService = $formAnalysisService;
    }

    public function index()
    {
        $forms = Form::pluck('name', 'id')->toArray();
        return view('analysis')->with(compact('forms'));
    }

    /**
     * Genera el reporte de análisis del formulario.
     */
    public function analyzeForm(int $formId)
    {
        $form = Form::findOrFail($formId);
        $forms = Form::pluck('name', 'id')->toArray();

        $text = $this->formAnalysisService->analyzeResponses($form);

        $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);

        // Reemplazar saltos de línea por <br> para mantener el formato
        $html = nl2br($html);

        // Convertir elementos numerados en una lista ordenada
        $html = preg_replace('/\n(\d+)\.\s/', '<li>', $html);
        $html = preg_replace('/(.*<\/li>)(.*?)(?=\<li>)/', '$1</li>', $html);
        $analysis = "<ol>{$html}</ol>";


        return view('analysis')->with(compact('analysis', 'form', 'forms'));
    }
}
