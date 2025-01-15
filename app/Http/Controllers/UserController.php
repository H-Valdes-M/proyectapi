<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getUsers()
    {
        $users = User::select('id', 'name')->orderBy('name')->get();
        return response()->json($users);
    }
    
     
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    //cambio de rol
    public function changeRole(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Alternar entre roles
            if ($user->role === 0) {
                $user->role = 1; // Cambiar a trabajador
            } else {
                $user->role = 0; // Cambiar a administrador
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Rol actualizado exitosamente.',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el rol: ' . $e->getMessage(),
            ], 500);
        }
    }

    //desactivar usuario
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->save();

        return response()->json(['message' => 'User activated successfully', 'user' => $user]);
    }
    //desactivar usuario
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = false;
        $user->save();

        return response()->json(['message' => 'User deactivated successfully', 'user' => $user]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Borrado lógico

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id); // Buscar solo los eliminados lógicamente
        $user->restore(); // Recuperar el usuario eliminado lógicamente

        return response()->json(['message' => 'User restored successfully', 'user' => $user]);
    }





//Log de usuario
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
}

// Verificar si el usuario está eliminado lógicamente (deleted_at no es null)
if ($user->deleted_at !== null) {
    return response()->json(['success' => false, 'message' => 'User is inactive'], 403);
}

    // Generar un token
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user,
    ]);
}






}
