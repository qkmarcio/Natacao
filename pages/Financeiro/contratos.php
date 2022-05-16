<?php
/*
 * Autor: Marcio Souza
 * Revisao: 0
 * Data: 12/04/2022
 * Arquivo principal do sistema, faz chamadas para todas as interfaces
 */
header('Content-type: text/html; charset=ISO-8859-1');
?>
<style type="text/css">
    input {
        text-transform: uppercase;
    }
    textarea {
        text-transform: uppercase;
    }
    .table-fixed thead tr th {
        /*background-color: #f39c12;
        border-color: #e67e22;*/
        padding: 4px 2px 4px 2px;
    }
    .table-fixed tbody {
        display:block;
        height:300px;
        overflow:auto;
    }
    .table-fixed tbody tr td {
        padding: 4px 2px 4px 2px;
    }
    .table-fixed thead, tbody tr {
        display:table;
        width:100%;
        table-layout:auto;
    }
    .table-fixed thead {
        /*width: calc( 100% - 1em )*/
    }

    .profile--panel .img{
        height: 150px;
    }
    #thumbnail {
        height: 100%
    }
</style>
<!-- Page Header Start -->
<section class="page--header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <!-- Page Title Start -->
                <h2 class="page--title h5">Cadastro de Contratos</h2>
                <!-- Page Title End -->
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item"><span>Financeiro</span></li>
                    <li class="breadcrumb-item active"><span>Contratos</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Main Content Start -->
<section class="main--content Contratos" >
    <div class="panel">
        <div class="panel-heading">
            <div class="dropdown">
                <button type="button" class="btn-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-sync"></i>Atualizar Data</a></li>
                    <li><a href="#formCadastro" id="btnNovoCadastro" data-toggle="modal"><i class="fa fa-cogs" ></i>Novo</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-4" style="margin-bottom: 20px;">
                    <h3 class="panel-title">Lista de Contratos</h3>
                </div>
                <div class="col-lg-8 app_searchBar" style="max-width: 500px;">
                    <input id="inpBuscar" type="search" name="tasks" placeholder="Buscar Contratos..." class="form-control">
                    <button id="btnBuscar" type="submit" class="btn btn-rounded">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="col-lg-12 table-fixed table style--3 table-hover" style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th class="col-1 text-center">ID</th>
                            <th class="col-1 text-center">Vencimento</th>
                            <th class="col-1 text-center">Status</th>
                            <th class="col-1 text-center">Criado</th>
                            <th class="col-1 text-center">Valor</th>
                            <th class="col-1 text-center">Meses</th>
                            <th class="col-3 text-left">Cliente</th>
                            <th class="col-2 text-left">Modalidade</th>
                            <th class="col-1 text-center"></i></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ListView"></tbody>
                </table>
            </div>
            <div id="pager">
                <ul id="pagination" class="pagination-sm "></ul>
            </div>
        </div>
    </div>
</section>

<section id="ContratoView" class="main--content Contrato_Mesalidade" style="display: none">
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-4" style="margin-bottom: 20px;">
                    <h3 class="panel-title">Contrato</h3>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="col-lg-12 table-fixed table style--3 table-hover" style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th class="col-1 text-center">ID</th>
                            <th class="col-1 text-center">Vencimento</th>
                            <th class="col-1 text-center">Status</th>
                            <th class="col-1 text-center">Criado</th>
                            <th class="col-1 text-center">Valor</th>
                            <th class="col-1 text-center">Meses</th>
                            <th class="col-3 text-left">Cliente</th>
                            <th class="col-2 text-left">Modalidade</th>
                            <th class="col-1 text-center"></i></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="Contrato_ListView"></tbody>
                </table>
            </div>
            <div id="pager">
                <ul id="pagination" class="pagination-sm "></ul>
            </div>
        </div>
    </div>
</section>
<section class="main--content Contrato_Mesalidade" style="display: none">
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-4" style="margin-bottom: 20px;">
                    <h3 class="panel-title">Mensalidades referenciadas</h3>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="col-lg-12 table-fixed table style--3 table-hover" style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th class="col-1 text-center">ID</th>
                            <th class="col-1 text-center">Vencimento</th>
                            <th class="col-1 text-center">Data Pago</th>
                            <th class="col-2 text-center">Status</th>
                            <th class="col-1 text-center">Valor</th>
                            <th class="col-1 text-center">Valor Pago</th>
                            <th class="col-2 text-center">Modalidade</th>
                            <th class="col-2 text-center"></i></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="Mesalidade_ListView"></tbody>
                </table>
            </div>
            <div id="pager">
                <ul id="pagination" class="pagination-sm "></ul>
            </div>
        </div>
    </div>
</section>
<!-- Main Footer Start -->
<footer class="main--footer main--footer-dark">
    <p>Copyright &copy; <a href="#">MOS Plataforma</a>. Marcio Olivira de Souza.</p>
</footer>
<!-- Main Footer End -->

<!-- Large Modal Start Cadastro Contratos -->
<form id="formCadastro" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Contrato</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group px-2 col-lg-2" style="display: none">
                        <label>Codigo</label>
                        <input class="form-control px-2" id="con_id" disabled="">
                        <input id="insert" value="insert" style="display: none">
                    </div>
                    <div class="form-group px-2 col-sm-4">
                        <label name="con_vencimento">Primeiro vencimento</label>
                        <input type='date' class="form-control px-2" id="con_vencimento" name="con_vencimento">
                    </div>
                    <div class="form-group px-2 col-sm-4">
                        <label name="con_valor">Valor</label>
                        <input class="form-control px-2" id="con_valor" name="con_valor">
                    </div>
                    <div class="form-group px-2 col-sm-4">
                        <label name="con_meses">Meses</label>
                        <input type="text" class="form-control px-2" id="con_meses" name="con_meses">
                    </div>
                    <div class="form-group px-2 col-sm-4">
                        <label name="modalidades_id">Modalidade</label>
                        <select class="form-control px-2" id="modalidades_id" name="modalidades_id">
                        </select>
                    </div>
                    <div class="form-group px-2 col-sm-8">
                        <label name="alunos_id">Aluno</label>
                        <select class="form-control px-2" id="alunos_id" name="alunos_id">
                        </select>
                    </div>
                    <div class="form-group px-2 col-sm-12">
                        <label>Obs</label>
                        <textarea class="form-control px-2" id="con_obs" rows="3"></textarea>
                    </div>
                    <div class="form-group px-2 col-sm-12">
                        <label>Status</label>
                        <div class="form-group px-2 col-sm-3">
                            <select class="form-control px-2" id="con_ativado">
                                <option value="1">ATIVO</option>
                                <option value="0">INATIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group px-2 col-sm-12">
                        <label >Enviar lembrete de fatura em atraso? <l style="font-size: 10px">  (Após o vencimento da mensalidade será enviado um lembrete)</l></label>
                        <div class="form-group px-2 col-sm-3">
                            <select class="form-control px-2" id="con_email_notificacao">
                                <option value="0">NÃO</option>
                                <option value="1">SIM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-sm btn-rounded btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-rounded btn-primary" >Gravar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Large Modal End -->


<!--  Modal Start Mudar data Mensaidade -->
<div id="formMensalidadeData" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar mensalidade</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group px-2 col-lg-2" style="display: none">
                        <label>Codigo</label>
                        <input class="form-control px-2" id="data_men_id" disabled="">
                        <input class="form-control px-2" id="data_men_contrato" disabled="">
                        
                    </div>
                    <div class="form-group px-2 col-sm-4">
                        <label name="men_vencimento">Vencimento</label>
                        <input type='date' class="form-control px-2" id="men_vencimento" name="men_vencimento">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-sm btn-rounded btn-danger"  data-dismiss="modal" >Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-rounded btn-primary" id="gravar_men_data" >Gravar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
<!--  Modal Start Pagar Mensaidade -->
<div id="formMensalidadePagar" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Efetuar Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group px-2 col-lg-2" style="display: none">
                        <label>Codigo</label>
                        <input class="form-control px-2" id="pago_men_id" disabled="">
                        <input class="form-control px-2" id="pago_men_contrato" disabled="">
                    </div>
                    <div class="form-group px-2 col-sm-4">
                        <label name="men_data_pago">Data Pago</label>
                        <input type='date' class="form-control px-2" id="men_data_pago" name="men_data_pago">
                    </div>
                     <div class="form-group px-2 col-sm-4">
                        <label name="men_valor_pago">Valor pago</label>
                        <input class="form-control px-2" id="men_valor_pago" name="men_valor_pago">
                    </div>
                    <div class="form-group px-2 col-sm-3">
                        <label >Forma de Pagamento</label>
                        <div class="form-group px-2">
                            <select class="form-control px-2" id="men_pago_tipo">
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Deposito(Pix)">Deposito(Pix)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group px-2 col-sm-12">
                        <label>Obs</label>
                        <textarea class="form-control px-2" id="men_pago_obs" rows="3"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-sm btn-rounded btn-danger"  data-dismiss="modal" >Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-rounded btn-primary" id="gravar_men_pago" >Gravar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->


<script type="text/javascript">
    function loadjscssfile(filename, filetype) {
        var fileref = null;
        if (filetype == "js") { //if filename is a external JavaScript file
            fileref = document.createElement('script');
            fileref.setAttribute("type", "text/javascript");
            fileref.setAttribute("src", filename);
        } else if (filetype == "css") { //if filename is an external CSS file
            fileref = document.createElement("link");
            fileref.setAttribute("rel", "stylesheet");
            fileref.setAttribute("type", "text/css");
            fileref.setAttribute("href", filename);
        }
        if (typeof fileref != "undefined") {
            document.getElementsByTagName("head")[0].appendChild(fileref);
        }
    }
    loadjscssfile('../js/jContrato.js?nocache=' + Math.random(), 'js');

</script>
