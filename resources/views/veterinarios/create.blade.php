@extends('templates.main', ['titulo' => "Cadastrar veterinário", 'tag' => "VET"])

@section('titulo') Novo Veterinário @endsection

@section('conteudo')

    <form action="{{ route('veterinarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class='column'>
                <div class='col-sm-12'>
                    <label>Nome</label>
                    <input type="text" class="form-control" name="nome">
                </div>
                <div class="row mt-2">
                    <div class='col-sm-6'>
                        <label>CRMV</label>
                        <input type="text" class="form-control" name="crmv">
                    </div>
                    <div class='col-sm-6'>
                        <label>Especialidades</label>
                        <select name="especialidades" id="especialidades" class="form-control">
                            @foreach( $especialidades as $esp )
                            <option value="{{ $esp->id }}"><p> {{ $esp->nome }} </p></option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class='row' style="margin-top:20px">
                <div class='col-sm-4'>
                        <a href="{{route('veterinarios.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>

@endsection
