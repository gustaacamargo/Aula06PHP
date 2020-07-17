<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veterinario;
use App\Especialidade;

class Veterinarios extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $veterinarios = Veterinario::all();
        $clinica = 'VetClin DWII';

        return view('veterinarios.index', compact(['veterinarios', 'clinica']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $especialidades = Especialidade::all();
        return view('veterinarios.create', compact(['especialidades']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $novo = new Veterinario();
        $novo->nome = $request->input('nome');
        $novo->crmv = $request->input('crmv');
        $novo->especialidade_id = $request->input('especialidades');
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
        $dados = Veterinario::findOrFail($id);
        if(isset($dados)) {
            return json_encode($dados);
        }
        return response('Veterinários nao encontrado', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = Veterinario::findOrFail($id);
        $especialidades = Especialidade::all();

        return view('veterinarios.edit', compact(['dados', 'especialidades']));
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
        $veterinario = Veterinario::findOrFail($id);
        if(isset($veterinario)) {
            $veterinario->nome = $request->input('nome');
            $veterinario->crmv = $request->input('crmv');
            $veterinario->especialidade_id = $request->input('especialidades');

            $veterinario->save();

            return json_encode($veterinario);
        }
        return response('Veterinário nao encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $veterinario = Veterinario::findOrFail($id);
        if(isset($veterinario)) {
            $veterinario->delete();
            return response('OK', 200);
        }

        return response('Veterinário não encontrado', 404);
    }
}
