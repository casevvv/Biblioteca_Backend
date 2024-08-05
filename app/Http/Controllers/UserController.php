<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function mostrarUsers(Request $request)
    {

        $get_users = User::all();
        return view('Usuario')->with(['users' => $get_users]);
    }

    public function mostrarPorId($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('perfil')->with(['user' => $user]);
        } catch (ModelNotFoundException $e) {
            Log::error('Usuario no encontrado: ' . $e->getMessage());
            return redirect()->route('perfil')->with('error', 'Usuario no encontrado.');
        } catch (Exception $e) {
            Log::error('Error al mostrar el usuario: ' . $e->getMessage());
            return back()->with('error', 'Error al mostrar el usuario: ' . $e->getMessage());
        }
    }

    public function guardarUser(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:users,id',
                'nameedit' => 'required|string',
                'emailedit' => 'required|string|email',
                'tipo_usuarioedit' => 'nullable|string'
            ]);

            
            // Crear y guardar el nuevo Usuario
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->created_at = $request->created_at;
            $user->updated_at = $request->updated_at;
            $user->tipo_usuario = $request->tipo_usuario;
            
            $user->save();

            return redirect()->route('mostrar_usuarios')->with('success', 'Usuario agregado exitosamente');
        } catch (Exception $e) {
            Log::error('Error al guardar el Usuario: ' . $e->getMessage());
            return back()->with('error', 'Error al guardar el Usuario: ' . $e->getMessage());
        }
    }

    public function actualizarUser(Request $request)
{
    try {
        // Validar los datos de la solicitud
        $request->validate([
            'id' => 'required|integer|exists:users,id',
            'nameedit' => 'required|string',
            'emailedit' => 'required|string|email',
            'tipo_usuarioedit' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $user = User::findOrFail($request->id);

        $user->name = $request->nameedit;
        $user->email = $request->emailedit;
        $user->tipo_usuario = $request->tipo_usuarioedit;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageName, 'public');
            $user->profile_image = $imageName;
        }

        $user->save();

        return back()->with(['message' => 'Usuario actualizado exitosamente']);
    } catch (QueryException $e) {
        if ($e->getCode() == '23505') {
            return response()->json(['error' => 'El correo electrónico ya está en uso.'], 409);
        } else {
            Log::error('Error al actualizar el usuario: ' . $e->getMessage());
            return back()->with(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()], 500);
        }
    } catch (Exception $e) {
        Log::error('Error al actualizar el usuario: ' . $e->getMessage());
        return response()->json(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()], 500);
    }
}


    public function eliminarUser(Request $request)
    {
        try {
            $request->validate([
                'id_delete' => 'required|integer|exists:users,id',
                'deletename' => 'required|string'
            ]);

            $user = User::findOrFail($request->id_delete);

            $user->delete();

            return back()->with('success', 'Usuario eliminado exitosamente');
        } catch (ModelNotFoundException $e) {
            return Response()->json(['message' => 'El Usuario buscado no se encuentra'], 404);
        } catch (Exception $e) {
            return Response()->json(['message' => 'Error al eliminar el usuario: ' . $e->getMessage()], 500);
        }
    }
}
