<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class FormAnalysisService
{
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Procesa las respuestas del formulario y devuelve retroalimentación.
     */
    public function analyzeResponses(int $formId): string
    {
        // 1. Obtener las respuestas del formulario
        $responses = DB::table('responses')
            ->where('form_id', $formId)
            ->pluck('response_text')
            ->toArray();

        if (empty($responses)) {
            return 'No hay respuestas para analizar.';
        }

        // 2. Crear el prompt para ChatGPT
        $prompt = $this->createPrompt($responses);

        // 3. Enviar el prompt a ChatGPT
        $url = config('services.openai.api_url');

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un analista de datos experto en formularios de retroalimentación. Proporciona análisis detallado y sugerencias basadas en las respuestas dadas.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ],
        ]);

        $chatResponse = json_decode($response->getBody(), true);

        return $chatResponse['choices'][0]['message']['content'] ?? 'No se recibió respuesta.';
    }

    /**
     * Construye el prompt para enviar a ChatGPT.
     */
    private function createPrompt(array $responses): string
    {
        $formattedResponses = implode("\n- ", $responses);

        return "Analiza las siguientes respuestas del formulario y proporciona un resumen con sugerencias para mejorar:\n- {$formattedResponses}";
    }
}
