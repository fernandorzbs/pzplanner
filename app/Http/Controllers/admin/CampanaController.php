<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessageJob;
use App\Models\Campana;
use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CampanaController extends Controller
{
    public function index()
    {
        $title = 'Lista de campañas';
        $Data = Campana::orderBy('id', 'desc')->get();

        return view('admin.campana.list', compact('title', 'Data'));
    }
    public function create()
    {
        $title  = 'Crea una campaña';
        $from   = "Lista de campañas";

        return view('admin.campana.create', compact('title', 'from'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required',
        ]);

        $Data = Campana::create([
            'nombre'    => $request->nombre,
            'fecha'    => $request->fecha,
        ]);

        return back()->with('success', 'Campaña creada');
    }

    public function edit($id)
    {
        $title  = 'Edita una campañas';
        $from   = "Lista de campañas";
        $Data   = Campana::findorFail($id);

        return view('admin.campana.edit', compact('title', 'from', 'Data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'    => 'required',
        ]);

        $Data = Campana::findorFail($id);
        $Data->update([
            'nombre'    => $request->nombre,
            'fecha'    => $request->fecha,
        ]);

        return back()->with('success', 'Campaña actualizada');
    }

    public function destroy($id)
    {
        $data = Campana::findOrFail($id);
        $data->delete();
        
        $result = [
            'mensaje' => 'Elemento eliminado correctamente.',
        ];

        return json_encode($result);
    }
    //===================================================
    // VISTA PARA CREAR MENSAJES E IMPORTAR CONTACTOS
    //===================================================
    public function makeMessage($id)
    {
        $title      = 'Mensajes masivos';
        $from       = "Lista de campañas";

        $Data       = Campana::findorFail($id);
        $Invitados  = Contacto::where('campana_id', $id)->count();

        $invitadoData   = Contacto::where('campana_id', $id)->orderBy('id', 'desc')->get();

        $filtro = [
            [
                'id'    => 0,
                'name'  => 'Todos',
            ],
            [
                'id'    => 1,
                'name'  => 'Sin respuesta',
            ],
            [
                'id'    => 2,
                'name'  => 'Confirmados',
            ],
            [
                'id'    => 3,
                'name'  => 'Con parejas',
            ],
        ];

        $filtroObjeto = json_decode(json_encode($filtro));

        return view('admin.campana.broadcast', compact('title', 'from', 'Data', 'Invitados', 'invitadoData', 'filtroObjeto'));
    }
    public function sendmensajewhatsap(Request $request, $id)
    {
        $mensaje = $this->formaterText($request->input('mensaje'));

        if ($request->input('destinatario') == 0) {
            $contactos = Contacto::where('campana_id', $id)->get();
        } elseif ($request->input('destinatario') == 1) {
            $contactos = Contacto::where('campana_id', $id)->where('confirmado', 1)->get();
        } elseif ($request->input('destinatario') == 2) {
            $contactos = Contacto::where('campana_id', $id)->where('confirmado', 2)->get();
        } elseif ($request->input('destinatario') == 3) {
            $contactos = Contacto::where('campana_id', $id)->where('confirmado', 3)->get();
        }

        foreach ($contactos as $contacto) {
            SendMessageJob::dispatch($contacto->celular, $mensaje, $contacto->nombre)->onQueue('default');
        }
        
        return back()->with('success', 'Mensajes en cola para ser enviados');
    }
    private function formaterText($mensajeHtml)
    {
        $mensajeWhatsapp = str_replace(['<strong>', '</strong>'], '*', $mensajeHtml);
        $mensajeWhatsapp = str_replace(['<em>', '</em>'], '_', $mensajeWhatsapp);
        $mensajeWhatsapp = str_replace(['<s>', '</s>'], '~', $mensajeWhatsapp);
        $mensajeWhatsapp = str_replace(['<p>', '</p>'], "", $mensajeWhatsapp);
        $mensajeWhatsapp = strip_tags($mensajeWhatsapp);
        return html_entity_decode($mensajeWhatsapp, ENT_QUOTES, 'UTF-8');
    }
}

