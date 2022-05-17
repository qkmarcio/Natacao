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
                <h2 class="page--title h5">Cadastro de Alunos</h2>
                <!-- Page Title End -->
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item"><span>Cadastro</span></li>
                    <li class="breadcrumb-item active"><span>Alunos</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Main Content Start -->
<section class="main--content">
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
                    <h3 class="panel-title">Lista de Alunos</h3>
                </div>
                <div class="col-lg-8 app_searchBar" style="max-width: 500px;">
                    <input id="inpBuscar" type="search" name="tasks" placeholder="Buscar Alunos..." class="form-control">
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
                            <th class="col-3 text-left">Nome</th>
                            <th class="col-2 text-left">Responsavel</th>
                            <th class="col-1 text-left">Telefone</th>
                            <th class="col-2 text-left">Email</th>
                            <th class="col-1 text-center">Status</th>
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
<!-- Main Footer Start -->
<footer class="main--footer main--footer-dark">
    <p>Copyright &copy; <a href="#">MOS Plataforma</a>. Marcio Olivira de Souza.</p>
</footer>
<!-- Main Footer End -->

<!-- Large Modal Start -->
<form id="formCadastro" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro de Alunos</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group px-2 col-lg-2" style="display: none">
                        <label>Codigo</label>
                        <input class="form-control px-2" id="alu_id" disabled="">
                        <input id="insert" value="insert" style="display: none">
                    </div>
                    <div class="form-group px-2 col-lg-6">
                        <label name="alu_nome">Nome Completo</label>
                        <input class="form-control px-2" id="alu_nome" name="alu_nome">
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label name="alu_cpf">Cpf</label>
                        <input type="text" class="form-control px-2" id="alu_cpf" name="alu_cpf">
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label name="alu_nascimento">Anivers?rio</label>
                        <input type='date' class="form-control px-2" id="alu_nascimento" name="alu_nascimento">
                    </div>
                    <div class="form-group px-2 col-lg-6">
                        <label name="alu_resposavel">Responsavel</label>
                        <input class="form-control px-2" id="alu_resposavel" name="alu_resposavel">
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label>Cep</label>
                        <input class="form-control px-2" id="alu_cep" >
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label>Bairro</label>
                        <input class="form-control px-2" id="alu_bairro" >
                    </div>
                    <div class="form-group px-2 col-lg-6">
                        <label>Endere?o</label>
                        <input class="form-control px-2" id="alu_endereco" >
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label>Cidade</label>
                        <input class="form-control px-2" id="alu_cidade" >
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label name="alu_sexo">Sexo</label>
                        <select class="form-control px-2" id="alu_sexo" name="alu_sexo">
                            <option >SELECIONE</option>
                            <option value="MASCULINO">MASCULINO</option>
                            <option value="FEMININO">FEMININO</option>
                        </select>
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label name="alu_telefone">Telefone</label>
                        <input type="text" class="form-control px-2" id="alu_telefone" >
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label name="alu_celular">Celular</label>
                        <input type="text" class="form-control px-2" id="alu_celular" name="alu_celular">
                    </div>
                    <div class="form-group px-2 col-lg-4">
                        <label name="alu_email">E-mail</label>
                        <input class="form-control px-2" id="alu_email" name="alu_email">
                    </div>
                    <div class="form-group px-2 col-lg-2">
                        <label >Status</label>
                        <select class="form-control px-2" id="alu_ativado" >
                            <option value="1">ATIVO</option>
                            <option value="0">INATIVO</option>
                        </select>
                    </div>
                    <div class="form-group px-2 col-lg-9">
                        <label>Obs</label>
                        <textarea class="form-control px-2" id="alu_obs" rows="3"></textarea>
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label style="text-align: center;" >Foto</label>
                        <div class="profile--panel">
                            <div class="img online">
                                <img id="thumbnail" src="../Fotos/semfoto.jpg" alt="" class="rounded-circle">
                                <input type="file" id="alu_foto" accept="image/*" style="display: none">
                            </div>
                        </div>
                    </div>
                    <div class="form-group px-2 col-lg-12">
                        <label >Enviar recibo por E-mail? <l style="font-size: 10px"> (Envia confirma??o de pagamento para o e-mail do aluno)</l></label>
                        <div class="form-group px-2 col-lg-3">
                            <select class="form-control px-2" id="alu_email_recibo">
                                <option value="0">N?O</option>
                                <option value="1">SIM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-sm btn-rounded btn-danger" id="Sair" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-rounded btn-primary" id="Gravar">Gravar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Large Modal End -->


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
    //loadjscssfile('../js/custom_jquery.js?nocache=' + Math.random(), 'js');
    loadjscssfile('../js/jAluno.js?nocache=' + Math.random(), 'js');

</script>
