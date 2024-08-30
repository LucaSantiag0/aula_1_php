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
        $user = User::select('id', 'name', 'email')->paginate('2');

        return [
            'status' => 200,
            'menssagem' => 'Usuários encontrados!!',
            'user' => $user
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return [
            'status' => 200,
            'menssagem' => 'Usuário cadastrado com sucesso!!',
            'user' => $user
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{

    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    try {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 400,
            'message' => 'Erro ao atualizar usuário!',
            'error' => $e->getMessage()
        ], 400);
    }

    public function destroy(string $id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => 204,
            'message' => 'Usuário deletado com sucesso!'
        ], 204);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 400,
            'message' => 'Erro ao deletar usuário!',
            'error' => $e->getMessage()
        ], 400);
    }
}
