 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

 @extends('templates.main', ['titulo' => "Veterinários", 'tag' => "VET"])

 @section('titulo') Veterinários @endsection
 
 @section('conteudo')
 
     <div class='row'>
         <div class='col-sm-6'>
             <a  href="{{ route('veterinarios.create') }}" type="button" class="btn btn-primary btn-block">
                 <b>Cadastrar veterinário</b>
             </a>
         </div>
         <div class='col-sm-5' style="text-align: center">
             <input type="text" list="veterinarios" class="form-control" autocomplete="on" placeholder="buscar">
             <datalist id="veterinarios">
                 @foreach ($veterinarios as $item)
                     <option value="{{ $item['nome'] }}">
                 @endforeach
             </datalist>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelistVeterinarios', [
             "header" => ['Nome', 'Eventos'],
             "data" => $veterinarios
         ]
     )
     @endcomponent
 
 @endsection
 
 