 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

 @extends('templates.main', ['titulo' => "Especialidades", 'tag' => "ESP"])

 @section('titulo') Especialidades @endsection
 
 @section('conteudo')
 
     <div class='row'>
         <div class='col-sm-6'>
             <a  href="{{ route('especialidades.create') }}" type="button" class="btn btn-primary btn-block">
                 <b>Cadastrar especialidade</b>
             </a>
         </div>
         <div class='col-sm-5' style="text-align: center">
             <input type="text" list="especialidades" class="form-control" autocomplete="on" placeholder="buscar">
             <datalist id="especialidades">
                 @foreach ($especialidades as $item)
                     <option value="{{ $item['nome'] }}">
                 @endforeach
             </datalist>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelistEspecialidades', [
             "header" => ['Nome', 'Eventos'],
             "data" => $especialidades
         ]
     )
     @endcomponent
 
 @endsection
 
 