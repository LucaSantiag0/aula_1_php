<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Lucas Santiago
 * RA: 2210370
 * @link https://github.com/LucaSantiag0
 * 
 * @copyright Lucas Santiago
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email')->paginate(2);

        return response()->json([
            'status' => 200,
            'message' => 'Usuários encontrados!',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Método não utilizado em APIs geralmente
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Usuário cadastrado com sucesso!',
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'Usuário encontrado!',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Usuário não encontrado!',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Método não utilizado em APIs geralmente
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update($request->only('name', 'email', 'password'));

            return response()->json([
                'status' => 200,
                'message' => 'Usuário atualizado com sucesso!',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Erro ao atualizar usuário!',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Usuário deletado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Erro ao deletar usuário!',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
