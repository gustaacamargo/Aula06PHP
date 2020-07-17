<?php

namespace App\Http\Controllers;
use App\Cliente;
use Illuminate\Http\Request;

class Clientes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $clientes = Cliente::all();
        $clinica = 'VetClin DWII';

        return view('clientes.index', compact(['clientes', 'clinica']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $novo = new Cliente();
        $novo->nome = $request->input('nome');
        $novo->email = $request->input('email');
        $novo->telefone = $request->input('telefone');
        $novo->save();

        return json_encode($novo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados = Cliente::findOrFail($id);
        if(isset($dados)) {
            return json_encode($dados);
        }
        return response('Cliente nao encontrado', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = Cliente::findOrFail($id);

        return view('clientes.edit', compact('dados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $cliente = Cliente::findOrFail($id);
        if(isset($cliente)) {
            $cliente->nome = $request->input('nome');
            $cliente->email = $request->input('email');
            $cliente->telefone = $request->input('telefone');
            $cliente->save();

            return json_encode($cliente);
        }
        return response('Cliente nao encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        if(isset($cliente)) {
            $cliente->delete();
            return response('OK', 200);
        }

        return response('Cliente não encontrado', 404);
    }
}
