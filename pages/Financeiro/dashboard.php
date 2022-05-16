<style>
    .vermelho {
        color: white !important;
        background-color:#D9534F !important;
    }
    .azul {
        color: white !important;
        background-color:#337AB7 !important;
    }

    .verde {
        color: white !important;
        background-color: #5CB85C !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <h4 id="titulo_Dashboard">
            Periodo: <div id="dataInicio"></div>
        </h4>

    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">

    <div class="col-lg-3 ">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-5x" ></i><br>
                        <i style="font-size: 14px" id="dasTMargen"></i>
                    </div>
                    <div class="col-xs-9 text-right"> 
                        <i id="dasTFaturamento">0</i><br>
                        <i id="dasTCobros">0</i><br>
                        <i id="dasTEstoque">0</i><br>
                        <i id="dasTReceber">0</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-print fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <i id="dasTPedido">0</i><br>
                        <i id="dasTFatura">0</i><br>
                        <i id="dasTItens">0</i><br>
                        <i id="dasTClientes">0</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    <div class="col-lg-3 col-md-6">
            <div class="progress" id="metas" style="height: 40px;">
                <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%" id="final" aria-valuemax="100"><h4></h4></div>
            </div>
        </div>-->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right" id="metas">
<!--                        <i> Meta 02/2018 >  35% / 65% </i><br>
                        <i> Meta 01/2019 > 100% / (+ 6%) </i>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12"><!-- Rank Ventas Por Vendedor -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Rank Ventas Por Vendedor
                <div class="btn-group pull-right"> 
                    <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#upRank" aria-expanded="true" aria-controls="upRank">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body collapse in" id="upRank">
                <div class="row">
                    <div class="col-lg-6"><!-- Grafico-->
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Grafico
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body" >
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="listaVentas" ></div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <div class="col-lg-3"> <!-- Rank Ventas Por Vendedor -->
                        <!-- Margen de Ventas -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Faturacion %
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body ">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="listaMVentas" ></div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <!-- Margen de Ganancia -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw" ></i> Ganáncia %
                            </div>
                            <div class="panel-body ">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="listaMGanacia" ></div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading" >
                <i class="fa fa-list-ul fa-fw"></i> Lista de Clientes por Vendedor
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-primary btn-xs ExcelDashbord2" ><i class="fa fa-save fa-fw"></i>Guardar</button>
                </div>
            </div>
            <!--/.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="list_Cliente"></div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
            <!--  modal -->
            <div class="modal fade" id="ModHistoricoCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Historico</h5>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> 
</div>
<div class="row"><!-- Rank Ventas Por Vendedor -->
    <div class="col-lg-4">
        <div class="panel panel-danger">
            <div class="panel-heading" >
                <i class="fa fa-money fa-fw"></i> Cheques Recebidos e Cuentas A Cobrar
                <div class="btn-group pull-right">
                    <button class="btn btn-primary btn-xs ExcelDashbord1" type="button">
                        <i class="fa fa-save fa-fw"></i> Guardar
                    </button>
                </div>
            </div>
            <!--/.panel-heading -->
            <div class="panel-body collapse in" id="upCheques"> 
                <div class="row">
                    <div class="col-lg-12">
                        <div id="list_ChequeRecebidos"></div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-info">
            <div class="panel-heading" >
                <i class="fa fa-list-ul fa-fw"></i> Vendas e Devoluções
                <div class="btn-group pull-right">
                    <button class="btn btn-primary btn-xs ExcelDashbord3" type="button">
                        <i class="fa fa-save fa-fw"></i> Guardar
                    </button>
                </div>
            </div>
            <!--/.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="list_Venda_Dev_Rota"></div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-info">
            <div class="panel-heading" >
                <i class="fa fa-list-ul fa-fw"></i> Separação
                <div class="btn-group pull-right">
                    <button class="btn btn-primary btn-xs ExcelDashbord4" type="button">
                        <i class="fa fa-save fa-fw"></i> Guardar
                    </button>
                </div>
            </div>
            <!--/.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="list_Separacao"></div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
<!-- /.row -->

<script type="text/javascript">

    function loadjscssfile(filename, filetype) {
        var fileref = null;
        if (filetype === "js") { //if filename is a external JavaScript file
            fileref = document.createElement('script');
            fileref.setAttribute("type", "text/javascript");
            fileref.setAttribute("src", filename);
        } else if (filetype === "css") { //if filename is an external CSS file
            fileref = document.createElement("link");
            fileref.setAttribute("rel", "stylesheet");
            fileref.setAttribute("type", "text/css");
            fileref.setAttribute("href", filename);
        }
        if (typeof fileref !== "undefined") {
            document.getElementsByTagName("head")[0].appendChild(fileref);
        }
    }
    loadjscssfile('../js/custom_jquery.js?nocache=' + Math.random(), 'js');
    loadjscssfile('../js/jDashboard.js?nocache=' + Math.random(), 'js');
</script>