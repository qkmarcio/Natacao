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
                <h2 class="page--title h5">Cadastro de Tipos Despesas</h2>
                <!-- Page Title End -->

                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item"><span>Cadastro</span></li>
                    <li class="breadcrumb-item active"><span>Tipos Despesas</span></li>
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
                    <h3 class="panel-title">Lista de Tipos Despesas</h3>
                </div>
                <div class="col-lg-8 app_searchBar" style="max-width: 500px;">
                    <input id="inpBuscar" type="search" name="tasks" placeholder="Buscar Aulas..." class="form-control">
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
                            <th class="col-5 text-left">Tipos Despesa</th>
                            <th class="col-2 text-left">Criado</th>
                            <th class="col-2 text-center">Status</th>
                            <th class="col-2 text-center">Actions</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro de Tipos Despesas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group px-2 col-lg-4" style="display: none">
                        <label>Codigo</label>
                        <input class="limpar form-control px-2" id="tipo_despesa_id" disabled="">
                        <input id="insert" value="insert" style="display: none">
                    </div>
                    <div class="form-group px-2 col-lg-9">
                        <label name="tipo_despesa_nome">Tipos Despesa </label>
                        <input class="limpar form-control px-2" id="tipo_despesa_nome" name="tipo_despesa_nome">
                    </div>
                    <div class="form-group px-2 col-lg-3">
                        <label >Status</label>
                        <select class="form-control px-2" id="tipo_despesa_ativado" >
                            <option value="1">ATIVO</option>
                            <option value="0">INATIVO</option>
                        </select>
                    </div>
                    <div class="form-group px-2 col-lg-12">
                        <label>Obs</label>
                        <textarea class="limpar form-control px-2" id="tipo_despesa_obs" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-sm btn-rounded btn-danger" id="Sair" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-rounded btn-primary" id="Gravar">Gravar</button>
                </div>
            </div>
        </div>
    </div>
</div>
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
    loadjscssfile('../js/jTipoDespesa.js?nocache=' + Math.random(), 'js');

</script>