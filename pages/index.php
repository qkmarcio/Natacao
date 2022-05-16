<?php
/*
 * Autor: Marcio Souza
 * Revisao: 0
 * Data: 12/04/2022
 * Arquivo principal do sistema, faz chamadas para todas as interfaces
 */
header('Content-type: text/html; charset=ISO-8859-1');
/* include "./funcoes/config.php";

  session_start(); // Inicia a session
  include "./funcoes/functions.php"; // arquivo de funções.
  session_checker(); // chama a função que verifica se a session iniciada da acesso à página.

  if ($_SESSION['nivel_usuario'] == 2){

  }ELSE{
  header ("Location:./404.php");
  }
 */
?>
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- ==== Document Title ==== -->
<title>MOS Plataforma</title>

<!-- ==== Document Meta ==== -->
<meta name="author" content="">
<meta name="description" content="">
<meta name="keywords" content="">

<!-- ==== Favicon ==== -->
<link rel="icon" href="favicon.png" type="image/png">

<!-- ==== Google Font ==== -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">

<!-- Stylesheets -->
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/bootstrap-icons-1.8.1/bootstrap-icons.css">
<link rel="stylesheet" href="../assets/css/bootstrap-table.min.css">
<link rel="stylesheet" href="../assets/css/all.css" >
<link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
<link rel="stylesheet" href="../assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="../assets/css/perfect-scrollbar.min.css">
<link rel="stylesheet" href="../assets/css/morris.min.css">
<link rel="stylesheet" href="../assets/css/select2.min.css">
<link rel="stylesheet" href="../assets/css/jquery-jvectormap.min.css">
<link rel="stylesheet" href="../assets/css/horizontal-timeline.min.css">
<link rel="stylesheet" href="../assets/css/weather-icons.min.css">
<link rel="stylesheet" href="../assets/css/dropzone.min.css">
<link rel="stylesheet" href="../assets/css/ion.rangeSlider.min.css">
<link rel="stylesheet" href="../assets/css/ion.rangeSlider.skinFlat.min.css">
<link rel="stylesheet" href="../assets/css/datatables.min.css">
<link rel="stylesheet" href="../assets/css/fullcalendar.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
assets/css/ion.rangeSlider.min.css.map

<!-- Page Level Stylesheets -->

<link rel="stylesheet" href="../assets/css/sweetalert.min.css">
<link rel="stylesheet" href="../assets/css/sweetalert-overrides.css">

<body>
    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Navbar Start -->
        <header class="navbar navbar-fixed">
            <!-- Navbar Header Start -->
            <div class="navbar--header">
                <!-- Logo Start 
                <a href="index.php" class="logo" >
                    <img src="../assets/img/logo.png" alt="">
                </a>
                <!-- Logo End -->

                <!-- Sidebar Toggle Button Start -->
                <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- Sidebar Toggle Button End -->
            </div>
            <!-- Navbar Header End -->

            <!-- Sidebar Toggle Button Start -->
            <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
                <i class="fa fa-bars"></i>
            </a>
            <!-- Sidebar Toggle Button End -->

            <div class="navbar--nav ml-auto" >
                <ul class="nav">
                    <!-- Nav User Start
                    <li class="nav-item dropdown nav--user online">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <img src="../assets/img/avatars/01_80x80.png" alt="" class="rounded-circle">
                            <span>Henry Foster</span>
                            <i class="fa fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="profile.html"><i class="far fa-user"></i>Perfil</a></li>
                            <li><a href="mailbox_inbox.html"><i class="far fa-envelope"></i>Inbox</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>Conf</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="lock-screen.html"><i class="fa fa-lock"></i>Lock Screen</a></li>
                            <li><a href="#"><i class="fa fa-power-off"></i>Sair</a></li>
                        </ul>
                    </li>
                    <!-- Nav User End -->
                </ul>
            </div>
        </header>
        <!-- Navbar End -->

        <!-- Sidebar Start -->
        <aside class="sidebar" data-trigger="scrollbar">
            <!-- Sidebar Navigation Start -->
            <div class="sidebar--nav" style="padding: 0;" >
                <ul>
                    <li>
                        <ul>
                            <li class="active" >
                                <a href="javascript:loadContent('#conteudo','index.php')">
                                    <i class="fa fa-home"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li style="display: none">
                                <a href="javascript:loadContent('#conteudo','Financeiro/Mensalidades.php')">
                                    <i class="fa fa-home"></i>
                                    <span>Mensalidades</span>
                                </a>
                            </li>
                            <li id="menuCadastro">
                                <a href="#">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Cadastros</span>
                                </a>

                                <ul>
                                    <li id="menuAlunos"><a href="javascript:loadContent('#conteudo','Cadastros/alunos.php')">Alunos</a></li>
                                    <li id="menuProfessores"><a href="javascript:loadContent('#conteudo','Cadastros/professores.php')">Professores</a></li>
                                    <li id="menuAulas"><a href="javascript:loadContent('#conteudo','Cadastros/aulas.php')">Aulas</a></li>
                                    <li id="menuModalidades"><a href="javascript:loadContent('#conteudo','Financeiro/modalidades.php')">Modalidades</a></li>
                                    <li id="menuContratos"><a href="javascript:loadContent('#conteudo','Financeiro/contratos.php')">Contratos</a></li>
                                </ul>

                            </li>
                            <!--<li id="menuFinanceiro">
                                <a href="#">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Financeiro</span>
                                </a>

                                <ul>
                                    <li id="menuReceitas"><a href="javascript:loadContent('#conteudo','Financeiro/receitas.php')">Receitas</a></li>
                                    <li id="menuReceitasTipo"><a href="javascript:loadContent('#conteudo','Financeiro/tipo_receitas.php')">Tipo Receitas</a></li>
                                    <li id="menuDespesas"><a href="javascript:loadContent('#conteudo','Financeiro/despesas.php')">Despesas</a></li>
                                    <li id="menuDespesasTipo"><a href="javascript:loadContent('#conteudo','Financeiro/tipo_despesas.php')">Tipo Despesas</a></li>
                                </ul>

                            </li>
                            <li id="menuRelatorios">
                                <a href="#">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Relatorios</span>
                                </a>

                                <ul>
                                    <li id="menuRelReceitas"><a href="javascript:loadContent('#conteudo','Financeiro/rel_receitas.php')">Receitas</a></li>
                                    <li id="menuRelDespesas"><a href="javascript:loadContent('#conteudo','Financeiro/rel_despesas.php')">Despesas</a></li>
                                    <li id="menuRelMensalidades"><a href="javascript:loadContent('#conteudo','Financeiro/rel_mensalidades.php')">Mensalidades</a></li>
                                </ul>

                            </li>
                            <li id="menuConfiguracao">
                                <a href="#">
                                    <i class="fab fa-wpforms"></i>
                                    <span>Configuração</span>
                                </a>

                                <ul>
                                    <li id="menuUsuarios"><a href="javascript:loadContent('#conteudo','Contas/modalidades.php')">Alunos</a></li>
                                    <li id="menuSistema"><a href="javascript:loadContent('#conteudo','Contas/modalidades.php')">Professores</a></li>
                                </ul>

                            </li>-->
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- Sidebar Navigation End -->

        </aside>
        <!-- Sidebar End -->
        <style type="text/css">
/*            footer{
                width: 100%;
                position: absolute;
                bottom: 0;
               
            }*/
        </style>

        <!-- Main Container Start -->
        <main id="conteudo" class="main--container">
            <!-- Page Header Start -->
            <!--<div id="conteudo"></div>-->
            
        </main>
        <!-- Main Container End -->
    </div>
    <!-- Wrapper End -->
    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-table.min.js"></script>
    <script src="../assets/js/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/jquery.sparkline.min.js"></script>
    <script src="../assets/js/raphael.min.js"></script>
    <script src="../assets/js/morris.min.js"></script>
    <script src="../assets/js/select2.min.js"></script>
    <script src="../assets/js/jquery-jvectormap.min.js"></script>
    <script src="../assets/js/jquery-jvectormap-world-mill.min.js"></script>
    <script src="../assets/js/horizontal-timeline.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="../assets/js/jquery.mask.js"></script>
    <script src="../assets/js/jquery.steps.min.js"></script>
    <script src="../assets/js/dropzone.min.js"></script>
    <script src="../assets/js/ion.rangeSlider.min.js"></script>
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/jquery.twbsPagination.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../assets/js/sweetalert.min.js"></script>
    <script src="../assets/js/sweetalert-init.js"></script>

    <script>
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

        function loadContent(id, pagina) {
            $(id).slideUp("slow", function () { //efeito de sobe e desce o footer
                //$("#carregando").dialog('open');
                $(this).load(pagina, function () {
                    //$("#carregando").dialog('close');
                    $(this).slideDown("slow");
                });
            });
        }

    </script>
    <!-- Page Level Scripts -->
</body>
</html>