@extends('templates.main', ['titulo' => "Cadastrar Cliente", 'tag' => "CLI"])

@section('titulo') Novo Cliente @endsection

@section('conteudo')

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class='row'>
                <div class='col-sm-4'>
                    <label>Nome</label>
                    <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }} " name="nome" value="{{ old('nome') }}">
                    @if ($errors->has('nome'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nome') }}
                        </div>
                    @endif
                </div>
                <div class='col-sm-4'>
                    <label>E-mail</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class='col-sm-4'>
                    <label>Telefone</label>
                    <input type="text" class="form-control {{ $errors->has('telefone') ? 'is-invalid' : '' }}" name="telefone" value="{{ old('telefone') }}">
                    @if ($errors->has('telefone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('telefone') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class='row' style="margin-top:20px">
                <div class='col-sm-4'>
                        <a href="{{route('clientes.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>
@endsection
