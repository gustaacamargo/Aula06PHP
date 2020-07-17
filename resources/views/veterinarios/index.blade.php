 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

 @extends('templates.main', ['titulo' => "Veterinários", 'tag' => "VET"])

 @section('titulo') Veterinários @endsection
 
 @section('conteudo')
 
     <div class='row'>
         <div class='col-sm-6'>
            <button class="btn btn-primary btn-block" onClick="criar()">
                <b>Cadastrar Novo Veterinário</b>
            </button>
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
             "header" => ['ID', 'Nome', 'Eventos'],
             "data" => $veterinarios
         ]
     )
     @endcomponent

     <div class="modal fade" tabindex="-1" role="dialog" id="modalRemove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="id_remove" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title">Remover Veterinário</h5>
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
                    <h5 class="modal-title">Informações do Veterinário</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="cancel" class="btn btn-success" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
     </div>

     <div class="modal" tabindex="-1" role="dialog" id="modalVeterinario">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formVeterinarios">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Veterinário</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label>Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>CRMV</label>
                            <input type="text" class="form-control" name="crmv" id="crmv" required>
                        </div>
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>Especialidades</label>
                            <select name="especialidades" id="especialidades" class="form-control" required>
                                
                            </select>
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
        function loadEsps() {
            $.getJSON('/api/especialidades/load', function (data) {
                console.log(data);
                for(i = 0; i < data.length; i++) {
                    console.log(data[i].nome);
                    item = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';
                    $('#especialidades').append(item);
                }
            })
        }

        $(function() {
            loadEsps();
        })

        function criar() {
            $('#modalVeterinario').modal().find('.modal-title').text("Novo Veterinário");
            $('#nome').val('');
            $('#crmv').val('');
            $('#especialides').val('');
            $('#modalVeterinario').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formVeterinarios").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalVeterinario').modal('hide')
        })

        function insert() {
            veterinarios = {
                nome: $("#nome").val(),
                crmv: $("#crmv").val(),
                especialidades: $("#especialidades").val(),
            };
            console.log(veterinarios);
            $.post("/api/veterinarios", veterinarios, function(data) {
                novoVeterinario = JSON.parse(data);
                linha = getLin(novoVeterinario);
                $('#tabela>tbody').append(linha);
            });
        }

        function update(id) {
            veterinarios = {
                nome: $("#nome").val(),
                crmv: $("#crmv").val(),
                especialidades: $("#especialidades").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/veterinarios/"+id,
                context: this,
                data: veterinarios,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    const dataParse = (JSON.parse(data));
                    e = linhas.filter( function(i, e) {
                        console.log(e.cells);
                        console.log(dataParse);
                        return e.cells[0].textContent == dataParse.id;
                    } );

                    if(e) {
                        e[0].cells[0].textContent = dataParse.id;
                        e[0].cells[1].textContent = veterinarios.nome;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

        function getLin(veterinario) {
            var linha = 
            "<tr style='text-align: center'>"+
                "<td>"+ veterinario.nome +"</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='visualizar("+veterinario.id+")'><img src='{{ asset('img/icons/info.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='editar("+veterinario.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='remover("+veterinario.id+", '"+veterinario.nome+"'"+")'><img src='{{ asset('img/icons/delete.png') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function visualizar(id) { 
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/veterinarios/'+id, function(data) {
                $('#modalInfo').modal().find('.modal-body').append("<p>ID: <b>"+ data.id +"</b></p>");
                $('#modalInfo').modal().find('.modal-body').append("<p>Nome: <b>"+ data.nome +"</b></p>");
                $('#modalInfo').modal().find('.modal-body').append("<p>CRMV: <b>"+ data.crmv +"</b></p>");
                $('#modalInfo').modal().find('.modal-body').append("<p>Especiaidade: <b>"+ data.especialidade.nome +"</b></p>");

                $('#modalInfo').modal('show');
            });
        }

        function editar(id) { 
            $('#modalVeterinario').modal().find('.modal-title').text("Alterar Veterinário");

            $.getJSON('/api/veterinarios/'+id, function(data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#crmv').val(data.crmv);
                $('#especialidades').val(data.especialidade);
                $('#modalVeterinario').modal('show');
            });
         }
        function remover(id, nome) { 
            $('#modalRemove').modal().find('.modal-body').html("");
            $('#modalRemove').modal().find('.modal-body').append("Deseja remover o veterinário ''"+nome+"'?'");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show'); 
        }

        function remove() {
            var id = $('#id_remove').val();
            $.ajax({
                type: "DELETE",
                url: "/api/veterinarios/"+id,
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
 
 