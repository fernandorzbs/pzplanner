<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $title = "Administradores";
        $data  = User::role('administrador')->get();

        return view('admin.administradores.list', compact('title', 'data'));
    }

    public function create()
    {
        $title  = "Agregar administrador";
        $from   = "Lista de administradores";
        return view('admin.administradores.create', compact('title', 'from'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'lastname'      => 'required',
            'email'         => 'required|email|unique:users,email',
            'celular'       => 'required',
            'password'      => 'required|min:6',
        ],[],[
            'name'          => "nombre",
            'lastname'      => "apellido",
            'email'         => "correo",
            'password'      => "contraseña"
        ]);

        $User = User::create([
            'name'          => $request->name,
            'lastname'      => $request->lastname,
            'email'         => $request->email,
            'password'      => bcrypt(trim($request->password)),
            'celular'       => $request->celular,
        ]);
        $User->assignRole('administrador');

        if ($request->hasFile('profile_image')) {
            $User->clearMediaCollection('profile_image');
            $Media = $User->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            $originalPath = $Media->getPath();
            if (file_exists($originalPath)) {
                unlink($originalPath);
            }
        }

        return back()->with('success', 'Administrador creado con éxito.');
    }

    public function edit($id)
    {
        $title = "Editar administrador";
        $from = "Lista de administradores";

        $User = User::findOrFail($id);
    
        return view('admin.administradores.edit', compact('title', 'from', 'User'));
    }

    public function update(Request $request, $id)
    {
        $User = User::findOrFail($id);
        $this->validate($request, [
            'name'          => 'required',
            'lastname'      => 'required',
            'email'         => 'required|email|unique:users,email,' . $User->id,
            'celular'       => 'required',
        ],[],[
            'name'          => "nombre",
            'lastname'      => "apellido",
            'email'         => "correo",
        ]);

        $User->update([
            'name'          => $request->name,
            'lastname'      => $request->lastname,
            'email'         => $request->email,
            'password'      => $request->password ? bcrypt(trim($request->password)) : $User->password,
            'celular'       => $request->celular,
        ]);

        if ($request->hasFile('profile_image')) {
            $User->clearMediaCollection('profile_image');
            $Media = $User->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            $originalPath = $Media->getPath();
            if (file_exists($originalPath)) {
                unlink($originalPath);
            }

        }
        return back()->with('success', 'Administrador actualizado correctamente.');
    }

    // Eliminar un plan
    public function destroy($id)
    {
        $data = User::findOrFail($id);


        if ($data->hasMedia('profile_image')) {
            $data->clearMediaCollection('profile_image');
        }

        $data->delete();
        
        $result = [
            'mensaje' => 'Administrador eliminado correctamente.',
        ];

        return json_encode($result);
    }
}
