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
        $regras = [
            'nome' => 'required|max:100|min:10',
            'crmv' => 'required|max:6|min:6',
        ];
        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!"
        ];

        $request->validate($regras, $msgs);

        $novo = new Veterinario([
            'nome' => $request->nome,
            'crmv' => $request->crmv,
            'especialidade_id' => $request->especialidades
        ]);

        $novo->save();

        return redirect()->route('veterinarios.index');
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

        return view('veterinarios.show', compact('dados'));
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
        $regras = [
            'nome' => 'required|max:100|min:10',
            'crmv' => 'required|max:6|min:6',
        ];
        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!"
        ];

        $request->validate($regras, $msgs);
        
        $veterinario = Veterinario::findOrFail($id);
        $veterinario->nome = $request->nome;
        $veterinario->crmv = $request->crmv;
        $veterinario->especialidade_id = $request->especialidades;

        $veterinario->save();

        return redirect()->route('veterinarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
