@extends('templates.main', ['titulo' => "Cadastrar Cliente", 'tag' => "CLI"])

@section('titulo') Novo Cliente @endsection

@section('conteudo')

    <form action="{{ route('especialidades.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class='column'>
                <div class='col-sm-12'>
                    <label>Nome</label>
                    <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" name="nome" value="{{ old('nome') }}">
                    @if ($errors->has('nome'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nome') }}
                        </div>
                    @endif
                </div>
                <div class='col-sm-12 mt-2'>
                    <label>Descrição</label>
                    <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" name="descricao" value="{{ old('descricao') }}">
                    @if ($errors->has('descricao'))
                        <div class="invalid-feedback">
                            {{ $errors->first('descricao') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class='row' style="margin-top:20px">
                <div class='col-sm-4'>
                        <a href="{{route('especialidades.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>

@endsection
