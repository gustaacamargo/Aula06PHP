 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

 @extends('templates.main', ['titulo' => "Clientes", 'tag' => "CLI"])

 @section('titulo') Clientes @endsection
 
 @section('conteudo')
 
     <div class='row'>
         <div class='col-sm-6'>
             <a  href="{{ route('clientes.create') }}" type="button" class="btn btn-primary btn-block">
                 <b>Cadastrar Novo Cliente</b>
             </a>
         </div>
         <div class='col-sm-5' style="text-align: center">
             <input type="text" list="clientes" class="form-control" autocomplete="on" placeholder="buscar">
             <datalist id="clientes">
                 @foreach ($clientes as $item)
                     <option value="{{ $item['nome'] }}">
                 @endforeach
             </datalist>
         </div>
         {{-- <div class='col-sm-1' style="text-align: center">
             <button type="button" class="btn btn-default btn-block">
                 <img src="{{ asset('img/icons/search.svg') }}">
             </button>
         </div> --}}
     </div>
     <br>
 
     @component(
         'components.tablelist', [
             "header" => ['ID', 'Nome', 'E-mail', 'Telefone', 'Eventos'],
             "data" => $clientes
         ]
     )
     @endcomponent
 
 @endsection
 
 