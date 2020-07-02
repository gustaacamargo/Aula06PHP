

@extends('templates.main', ['titulo' => "Alterar especialidade", 'tag' => "ESP"])

@section('titulo') {{$dados['nome']}} @endsection

@section('conteudo')

    <form action="{{ route('especialidades.update', $dados['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class='column'>
                <div class='col-sm-12'>
                    <label>Nome</label>
                    <input type="text" class="form-control" name="nome" value="{{$dados['nome']}}">
                </div>
                <div class="row mt-2">
                    <div class='col-sm-6'>
                        <label>CRMV</label>
                        <input type="text" class="form-control" name="crmv" value="{{$dados['crmv']}}">
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
                    <a href="{{route('especialidades.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>

@endsection
