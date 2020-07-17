<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Especialidade;

class Especialidades extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especialidades = Especialidade::all();
        $clinica = 'VetClin DWII';

        return view('especialidades.index', compact(['especialidades', 'clinica']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('especialidades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $novo = new Especialidade();
        $novo->nome = $request->input('nome');
        $novo->descricao = $request->input('descricao');
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

        $dados = Especialidade::findOrFail($id);
        if(isset($dados)) {
            return json_encode($dados);
        }
        return response('Especialidade nao encontrada', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = Especialidade::findOrFail($id);

        return view('especialidades.edit', compact('dados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function loadJson() {
        $especialidades = Especialidade::all();
        return json_encode($especialidades);
    }

    public function update(Request $request, $id)
    {
        $novo = Especialidade::findOrFail($id);
        if(isset($novo)) {
            $novo->nome = $request->input('nome');
            $novo->descricao = $request->input('descricao');

            $novo->save();

            return json_encode($novo);
        }
        return response('Especialidade nao encontrada', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $novo = Especialidade::findOrFail($id);
        if(isset($novo)) {
            $novo->delete();
            return response('OK', 200);
        }

        return response('Especialidade nao encontrada', 404);
    }
}
