<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ==== Document Title ==== -->
    <title>Espaco Aquatico Foz</title>

    <!-- ==== Document Meta ==== -->
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- ==== Favicon ==== -->
    <link rel="icon" href="favicon.png" type="image/png">

    <!-- ==== Google Font ==== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="assets/css/morris.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/jquery-jvectormap.min.css">
    <link rel="stylesheet" href="assets/css/horizontal-timeline.min.css">
    <link rel="stylesheet" href="assets/css/weather-icons.min.css">
    <link rel="stylesheet" href="assets/css/dropzone.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.skinFlat.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Page Level Stylesheets -->

</head>

<body>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Login Page Start -->
        <div class="m-account-w" data-bg-img="assets/img/account/wrapper-bg.jpg">
            <div class="m-account">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <!-- Login Content Start -->
                        <div class="m-account--content-w" data-bg-img="assets/img/account/content-bg.jpg">
                            <div class="m-account--content">
                                <!--<h2 class="h2">Don't have an account?</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <a href="register.html" class="btn btn-rounded">Register Now</a>-->
                            </div>
                        </div>
                        <!-- Login Content End -->
                    </div>

                    <div class="col-md-6">
                        <!-- Login Form Start -->
                        <div class="m-account--form-w">
                            <div class="m-account--form">
                                <!-- Logo Start -->
                                <div class="logo">
                                    <img src="assets/img/logo.png" alt="">
                                </div>
                                <!-- Logo End -->

                                <form action="#" method="post">
                                    <label class="m-account--title">Faça login na sua conta</label>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <i class="fas fa-user"></i>
                                            </div>

                                            <input type="text" name="username" placeholder="Username" class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <i class="fas fa-key"></i>
                                            </div>

                                            <input type="password" name="password" placeholder="Password" class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>

                                    <div class="m-account--actions">
                                       <!-- <a href="#" class="btn-link">Esqueceu a senha?</a>-->

                                        <button type="submit" class="btn btn-rounded btn-info">CONECTE-SE</button>
                                    </div>

                                    <!-- <div class="m-account--alt">
                                        <p><span>OU ENTRAR COM</span></p>

                                        <div class="btn-list">
                                            <a href="#" class="btn btn-rounded btn-warning">Facebook</a>
                                            <a href="#" class="btn btn-rounded btn-warning">Google</a>
                                        </div>
                                    </div>-->

                                    <div class="m-account--footer">
                                        <p>&copy; 2020 MARCIO O DE SOUZA</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Login Form End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Page End -->
    </div>
    <!-- Wrapper End -->

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/perfect-scrollbar.min.js"></script>
    <script src="assets/js/jquery.sparkline.min.js"></script>
    <script src="assets/js/raphael.min.js"></script>
    <script src="assets/js/morris.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/jquery-jvectormap.min.js"></script>
    <script src="assets/js/jquery-jvectormap-world-mill.min.js"></script>
    <script src="assets/js/horizontal-timeline.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/jquery.steps.min.js"></script>
    <script src="assets/js/dropzone.min.js"></script>
    <script src="assets/js/ion.rangeSlider.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Page Level Scripts -->

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