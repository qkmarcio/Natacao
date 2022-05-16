<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MOS Plataforma</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">
    #login-alert {
        display: none;
    }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">MOS Plataforma</h3>
                    </div>
                    <div class="panel-body">
                        <div id="login-alert" class="alert alert-danger col-sm-12">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <span id="mensagem"></span>
                        </div>
                        <form role="form" class="col-sm-12">
                            <fieldset>
                                <div class="form-group">
                                    <input id="usuario" class="form-control" placeholder="Informe seu Login"
                                        name="usuario" type="usuario" autofocus>
                                </div>
                                <div class="form-group">
                                    <input id="senha" class="form-control" placeholder="Informe sua Senha" name="senha"
                                        type="password" value="">
                                </div>
                                <button type="button" class="btn btn-lg btn-success btn-block" name="btn-login"
                                    id="btn-login">
                                    Entrar
                                </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script>
    $('document').ready(function() {
        $('#usuario').on('keypress', function(e) {
            if (e.keyCode == 13) {
                $('#senha').focus();
            }
        });
        $('#senha').on('keypress', function(e) {
            if (e.keyCode == 13) {
                $("#btn-login").click();
            }
        });
        $("#btn-login").click(function() {
            var obj = new Object();
            obj.usuario = $("#usuario").val();
            obj.senha = $("#senha").val();

            $.ajax({
                type: 'POST',
                url: 'view/vUsuario.php',
                data: {
                    'obj': obj,
                    'funcao': 'logar'
                },
                /*faz um post passando um obj e chama uma funcao no php*/
                dataType: 'json',
                beforeSend: function() {
                    $("#btn-login").html('Validando ...');
                },
                success: function(response) {
                    if (response.success == true) {
                        $("#btn-login").html('Entrar');
                        $("#login-alert").css('display', 'none');
                        window.location.href = "pages/principal.php";
                    } else {

                        $("#btn-login").html('Entrar');
                        $("#login-alert").css('display', 'block')
                        $("#mensagem").html(
                            '<strong>Erro! </strong> Usuario ou Senha Invalidos');
                        resetarTudo();
                    }
                },
                error: function(response) {
                    $("#btn-login").html('Entrar');
                    $("#login-alert").css('display', 'block')
                    $("#mensagem").html(
                        '<strong>Erro! </strong> Usuario ou Senha Invalidos');
                    resetarTudo();
                    console.debug(response);
                }
            });
        });

        function resetarTudo() {
            $("#usuario").val('');
            $("#senha").val('');
            darFocus();
        }
        /* Esta funcao da focus no input numero  */
        function darFocus() {
            $('#usuario').focus();
        }
        $().ready(function() {
            $("#usuario").focus();
        });
    });
    </script>
</body>

</html>