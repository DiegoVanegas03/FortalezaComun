<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\FormResponse;
use Illuminate\Support\Facades\Config;

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
    public function analyzeResponses($form): string
    {
        // 1. Obtener las respuestas del formulario
        $formResponses = FormResponse::where('form_id', $form->id)->get();
        // Obtener todos los valores de 'value' de todas las respuestas de campo
        $responses = $formResponses->flatMap(function ($formResponse) {
            return $formResponse->fieldResponses->pluck('value');
        })->toArray();

        if (empty($responses)) {
            return 'No hay respuestas para analizar.';
        }
        // 2. Crear el prompt para ChatGPT
        $prompt = $this->createPrompt($responses, $form->fields()->get()->pluck('label')->toArray());
        // 3. Enviar el prompt a ChatGPT
        $url = Config::get('services.openai.api_url');
        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "model" => "gpt-3.5-turbo-0125",
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
    private function createPrompt(array $responses, array $formFields): string
    {
        $relationalData = implode("\n", array_map(fn($question, $response) => "- Pregunta: " . $question . "\n  Respuesta: " . $response, $formFields, $responses));

        return "Analiza las siguientes preguntas y respuestas. Cada respuesta está directamente relacionada con la pregunta correspondiente. Proporciona un análisis detallado enfocado en Recursos Humanos, sugiriendo cómo estas respuestas pueden ayudar a mejorar la gestión y el desarrollo dentro de la empresa.\n\n$relationalData";
    }
}
