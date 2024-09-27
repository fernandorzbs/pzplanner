<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validación de los datos que recibes desde el frontend o una API
        $request->validate([
            'celular' => 'required|regex:/^[0-9]+$/',  // Asegúrate de validar el celular como numérico
            'mensaje' => 'required|string',
        ]);

        // Datos que se enviarán en el cuerpo de la solicitud POST
        $data = [
            'celular' => $request->input('celular'),
            'mensaje' => $request->input('mensaje'),
        ];

        try {
            // Enviar la solicitud POST a la API externa
            $response = Http::post('https://whatzaby-api-production-d8f0.up.railway.app/send-message', $data);

            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Mensaje enviado con éxito',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al enviar el mensaje',
                    'response' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Manejar errores de la solicitud
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error al intentar enviar el mensaje',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
