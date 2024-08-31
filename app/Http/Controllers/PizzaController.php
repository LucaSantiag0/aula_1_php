<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PizzaController extends Controller
{
    
        public function index()
    {
        $pizza = Pizza::select()->paginate(5);

        return response()->json([
            'status' => 200,
            'message' => 'Pizza encontrada!',
            'users' => $pizza
        ]);
    }

    public function create(PizzaCreateRequest $request) {
        $data = $request->validated();

        $pizza = Pizza::create([
            'sabor' => $data['sabor']
        ]);

        return response()->json([
            'status' =>201,
            'message' => 'Pizza cadastrada com sucesso!',
            'pizza' => $user
        ]);
    }

    public function show(string $id)
    {
        try {
            $pizza = Pizza::findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'Pizza encontrada',
                'pizza' => $pizza
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Pizza não encontrada!',
                'error' => $e->getMessage()
            ], 404);
        }

    } 

    public function update(Request $request, string $id)
    {
        $request->validate([
            'sabor' => 'required|string|max:225',
        ]);

        try {
            $pizza = Pizza::findOrfail($id);
            $pizza->update($request->only('sabor'));

            return response()->json([
                'status' => 200,
                'mesasge' => 'Sabor atualizado com sucesso!',
                'pizza' =>  $pizza
            ]);
        }
        catch (\Expeption $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Erro ao atualizar sabor da pizza!',
                'error' => $e->getMessage()
            ], 400);
        }
        
    }

    public function destroy(string $id) 
    {
        try {
            $pizza = Pizza::findOrFail($id);
            $pizza->delete();

            return response()->json([
                'status'=> 200,
                'message' => 'Pizza deletada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return reponse()->json([
                'status' =>400,
                'message' => 'Erro ao deletar pizza!',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
