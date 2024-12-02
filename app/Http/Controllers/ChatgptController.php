<?php

namespace App\Http\Controllers;

use App\Services\FormAnalysisService;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    protected $formAnalysisService;

    public function __construct(FormAnalysisService $formAnalysisService)
    {
        $this->formAnalysisService = $formAnalysisService;
    }

    /**
     * Genera el reporte de análisis del formulario.
     */
    public function analyzeForm(Request $request, int $formId)
    {
        $analysis = $this->formAnalysisService->analyzeResponses($formId);

        return view('analysis.report', ['analysis' => $analysis]);
    }
}
