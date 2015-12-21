    <header class="page-header">
        <h2>Consulta de Menu</h2>
    </header>


    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <a href="{NOVO_MENU}" class="btn btn-primary {dis_incluir}"><i class="glyphicon glyphicon-plus"></i> Novo Menu</a>
                        <div class="pull-right">
                            <a onclick="abrirDialogRelatorio()" class="btn btn-primary {dis_imprimir}"><i class="glyphicon glyphicon-print"></i> Imprimir</a>
                        </div>
                    </div>
                    </br>
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover table-condensed" id="tb_menu">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th class="coluna-acao" width="80"></th>
                                    <th class="coluna-acao" width="80"></th>

                                </tr>
                            </thead>
                            <tbody>
                                {BLC_DADOS}
                                    <tr>
                                        <td class="vertical-center">{hel_desc_men}</td>
                                        <td class="text-center"><a href="{EDITAR_MENU}" class="btn btn-link btn-xs {dis_alterar}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
                                        <td class="text-center"><a onclick="{APAGAR_MENU}" class="btn btn-link btn-xs {dis_excluir}" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
                                    </tr>
                                {/BLC_DADOS}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="relatorio_menu" tabindex="-1" role="dialog" aria-labelledby="relatorio_cidade_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_cidade_label">Relatório - Menu</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="ordenacao_relatorio" class="col-sm-2 ">Ordenar por</label>
                            <div class="col-sm-4">
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" id="ordenacao_codigo" name="ordenacao_relatorio" value="0" checked/>Código
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" id="ordenacao_nome" name="ordenacao_relatorio" value="1"/>Descrição
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br/>
                    <div class="form-group">
                        <center>
                            <button onclick="visualizarRelatorio()" name="salvar_usuario" class="btn btn-primary" > <i class="glyphicon glyphicon-print"></i> Visualizar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h3 class="modal-title" id="myModalLabel">Info Rio Sistemas</h3>
                    </div>
                    <div class="modal-body">
                        <h4>Deseja realmente apagar menu  ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        var idExclusao = "";

        function abrirConfirmacao(id){
            idExclusao = id;
            $('#myModal').modal('show');
        }

        function apagar(){
            $('#myModal').modal('hide');
            location.href = 'menu/apagar/' + idExclusao;
        }

        function abrirDialogRelatorio(){
            $('#relatorio_menu').modal('show');
        }

        function visualizarRelatorio() {
            var orderBy = "";

            if (document.getElementById('ordenacao_codigo').checked) {
                orderBy = " ORDER BY hel_pk_seq_men ";
            } else {
                orderBy = " ORDER BY hel_desc_men ";
            }

            $('#relatorio_menu').modal('hide');

            window.open('menu/relatorio/'+ orderBy, '_blank');
        }

    </script>