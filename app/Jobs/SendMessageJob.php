<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;  
    public $timeout = 120;  

    protected $telefono;
    protected $mensaje;
    protected $nombre;

    public function __construct($telefono, $mensaje, $nombre)
    {
        $this->telefono = $telefono;
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
    }

    public function handle()
    {
        try {
            $mensaje = str_replace('{nombre}', $this->nombre, $this->mensaje);
            $mensaje_utf8 = html_entity_decode($mensaje, ENT_QUOTES, 'UTF-8');

            $response = Http::post('https://whatzaby-api-production-d8f0.up.railway.app/send-message', [
                'celular' => $this->telefono,
                'mensaje' => $mensaje_utf8,
            ]);
            if ($response->failed()) {
                dd($response->json()); 
            }

            if ($response->successful() && $response->json('status') === true) {
                Log::info("Mensaje enviado con éxito a {$this->telefono}");
            } else {
                Log::error("Error al enviar el mensaje a {$this->telefono}: " . $response->body());
                $this->release(20); // Reintentar después de 30 segundos
            }
            sleep(2);
        } catch (\Exception $e) {
            Log::error("Excepción en SendMessageJob: " . $e->getMessage());
            $this->release(30);
        }
    }
}

