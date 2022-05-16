<style type="text/css">
    /*    .jqx-progressbar-text{color: white}*/

</style>

<!--titulo-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Grafico de Venta</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!--conteudo-->
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div id="vendaInicio" style="float: left;margin-bottom: 10px"></div>
        </div>
        <div class="row">
            <div class="row">
                
            </div>
            <div class="col-lg-4">
                <div class="row"><h3 class="page-header">Rank de Venta</h3></div>
                <div id="rankVendedor" ></div>
            </div>
            <div class="col-lg-4">
                <div class="row"><h3 class="page-header">Rank de Ganancia</h3></div>
                <div id="rankLucro" ></div>
            </div>
            <div class="col-lg-4">
                <div class="row"><h3 class="page-header">Rank de Devolução</h3></div>
                <div id="rankDevolucao" ></div>
            </div>

        </div>
    </div>

    <!-- /.col-lg-12 -->
</div>


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
    loadjscssfile('../js/custom_jquery.js?nocache=' + Math.random(), 'js');
    loadjscssfile('../js/jRankVenda.js?nocache=' + Math.random(), 'js');
    
</script>
