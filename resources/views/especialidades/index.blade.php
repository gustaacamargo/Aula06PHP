 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

 @extends('templates.main', ['titulo' => "Especialidades", 'tag' => "ESP"])

 @section('titulo') Especialidades @endsection
 
 @section('conteudo')
 
     <div class='row'>
         <div class='col-sm-6'>
            <button class="btn btn-primary btn-block" onClick="criar()">
                <b>Cadastrar especialidade</b>
             </button>
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
             "header" => ['ID', 'Nome', 'Eventos'],
             "data" => $especialidades
         ]
     )
     @endcomponent

     <div class="modal fade" tabindex="-1" role="dialog" id="modalRemove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="id_remove" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title">Remover Especialidade</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onClick="remove()">Sim</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Não</button>
                </div>
            </div>
        </div>
     </div>

     <div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informações da Especialidade</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="cancel" class="btn btn-success" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
     </div>

     <div class="modal" tabindex="-1" role="dialog" id="modalEspecialidade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formEspecialidades">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Especialidade</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label>Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>Descrição</label>
                            <input type="text" class="form-control" name="descricao" id="descricao" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
 @endsection

 @section('script')


    <script type="text/javascript">
        function criar() {
            $('#modalEspecialidade').modal().find('.modal-title').text("Nova Especialidade");
            $('#nome').val('');
            $('#descricao').val('');
            $('#modalEspecialidade').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formEspecialidades").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalEspecialidade').modal('hide')
        })

        function insert() {
            especialidades = {
                nome: $("#nome").val(),
                descricao: $("#descricao").val(),
            };
            $.post("/api/especialidades", especialidades, function(data) {
                novaEspecialidade = JSON.parse(data);
                linha = getLin(novaEspecialidade);
                console.log(novaEspecialidade);
                $('#tabela>tbody').append(linha);
            });
        }

        function update(id) {
            especialidades = {
                nome: $("#nome").val(),
                descricao: $("#descricao").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/especialidades/"+id,
                context: this,
                data: especialidades,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    const dataParse = (JSON.parse(data));

                    e = linhas.filter( function(i, e) {
                        return e.cells[0].textContent == dataParse.id;
                    } );

                    if(e) {
                        e[0].cells[1].textContent = especialidades.nome;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

        function getLin(especialidade) {
            var linha = 
            "<tr style='text-align: center'>"+
                "<td>"+ especialidade.id +"</td>"+
                "<td>"+ especialidade.nome +"</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='visualizar("+especialidade.id+")'><img src='{{ asset('img/icons/info.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='editar("+especialidade.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='remover("+especialidade.id+", '"+especialidade.nome+"'"+")'><img src='{{ asset('img/icons/delete.png') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function visualizar(id) { 
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/especialidades/'+id, function(data) {
                $('#modalInfo').modal().find('.modal-body').append("<p>ID: <b>"+ data.id +"</b></p>");
                $('#modalInfo').modal().find('.modal-body').append("<p>Nome: <b>"+ data.nome +"</b></p>");
                $('#modalInfo').modal().find('.modal-body').append("<p>Descrição: <b>"+ data.descricao +"</b></p>");

                $('#modalInfo').modal('show');
            });
        }

        function editar(id) { 
            $('#modalEspecialidade').modal().find('.modal-title').text("Alterar Especialidade");

            $.getJSON('/api/especialidades/'+id, function(data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#descricao').val(data.descricao);
                $('#modalEspecialidade').modal('show');
            });
         }
        function remover(id, nome) { 
            $('#modalRemove').modal().find('.modal-body').html("");
            $('#modalRemove').modal().find('.modal-body').append("Deseja remover a especialidade ''"+nome+"'?'");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show'); 
        }

        function remove() {
            var id = $('#id_remove').val();
            $.ajax({
                type: "DELETE",
                url: "/api/especialidades/"+id,
                context: this,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    e = linhas.filter( function(i, e) {
                        

                        console.log(id);
                        console.log(data);
                        return e.cells[0].textContent == id;
                    } );
                    //console.log(e[0]);

                    if(e) {
                        e.remove();
                    }
                },
                error: function(error) {
                    alert('ERRO - DELETE');
                    console.log(error);
                }
            });

            $('#modalRemove').modal('hide'); 
        }

    </script>

@endsection
 
 