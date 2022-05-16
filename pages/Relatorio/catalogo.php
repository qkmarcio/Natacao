<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Catalogo MOS Plataforma</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">

</div>

<script>
    $(function () {
        //$( "input" ).checkboxradio();
        $("input").checkboxradio({
            icon: false
        });
// Evento Para Reimprimir um Mic
        $("#radio-1").click(function () {
            window.open("../Relatorios/Catalogo.php");
            /*aguarde.dialog('open');
             var obj= new Object();
             obj.MicSerie=$('input[name=group5]:checked').val(); 
             obj.MicNumero=$("#pMic").val();
             $.ajax({
             type: "POST",
             url: "../view/vMicDta.php",
             dataType:"json",
             data: {'obj': obj, 'funcao' : 'getMicId'},
             success: function(json){
             aguarde.dialog('close');
             window.open("../relatorios/impMicDta.php?id="+json.mic_id+"&impNome="+json.nome);},
             error: function(json){
             console.error(json);
             alert('Numero Não Localizado Para Esta Serie!');
             aguarde.dialog('close');
             }
             });*/
        });
    });


</script>
</head>
<body>
    <div class="widget">
        <fieldset>
            <h5>Selecione o Tipo de Catalogo</h5>
            <label for="radio-1">Completo</label>
            <input type="radio" name="radio-1" id="radio-1">
            <label for="radio-2">Promoção</label>
            <input type="radio" name="radio-1" id="radio-2">
            <label for="radio-3">Itens Selecionados</label>
            <input type="radio" name="radio-1" id="radio-3">
        </fieldset>
    </div>