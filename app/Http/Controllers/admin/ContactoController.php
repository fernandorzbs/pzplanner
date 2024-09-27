<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use Illuminate\Http\Request;
use App\Imports\ContactosImport;
use Maatwebsite\Excel\Facades\Excel;

class ContactoController extends Controller
{
    public function index()
    {
        $title = "Lista de contactos";
        $data = Contacto::orderBy('id', 'desc')->get();

        return view('admin.contacto.list', compact('title', 'data'));
    }

    public function create()
    {
        $title = "Agregar contacto";
        $from = "Listado de contactos";

        return view('admin.contacto.create', compact('title', 'from'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required',
            'celular'   => 'required',
        ]);

        $Data = Contacto::create([
            'nombre'    => $request->nombre,
            'apellido'  => $request->apellido,
            'email'     => $request->email,
            'celular'   => $request->celular,
            'confirmado'   => $request->confirmado,
        ]);

        if($request->hasFile('profile_image')) {
            $Data->clearMediaCollection('profile_image');
            $Media = $Data->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            $originalPath = $Media->getPath();
            if (file_exists($originalPath)) {
                unlink($originalPath);
            }
        }


        return back()->with('success', 'Contacto creado con exito');
    }
    public function edit($id)
    {
        $title = "Editar contacto";
        $from = "Listado de contactos";
        $data = Contacto::findorFail($id);

        return view('admin.contacto.edit', compact('title', 'from', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'    => 'required',
            'celular'   => 'required',
        ]);

        $Data = Contacto::findorFail($id);
        $Data->update([
            'nombre'    => $request->nombre,
            'apellido'  => $request->apellido,
            'email'     => $request->email,
            'celular'   => $request->celular,
            'confirmado'   => $request->confirmado,
        ]);

        if($request->hasFile('profile_image')) {
            $Data->clearMediaCollection('profile_image');
            $Media = $Data->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            $originalPath = $Media->getPath();
            if (file_exists($originalPath)) {
                unlink($originalPath);
            }
        }

        return back()->with('success', 'Contacto actualizado con exito');
    }// Eliminar un plan
    public function destroy($id)
    {
        $data = Contacto::findOrFail($id);


        if ($data->hasMedia('profile_image')) {
            $data->clearMediaCollection('profile_image');
        }

        $data->delete();
        
        $result = [
            'mensaje' => 'Contacto eliminado correctamente.',
        ];

        return json_encode($result);
    }
    //===========================
    // IMPORTAR CONTACTOS
    //===========================
    public function importarContactos(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        $import = new ContactosImport($id);

        Excel::import($import, $request->file('file'));
        $insertados = $import->getRowCount();

        return redirect()->back()->with('success', 'Nuevos contactos insertados: ' . $insertados);
    }
}
