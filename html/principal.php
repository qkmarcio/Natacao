<!DOCTYPE html>
<html lang="en">
<head>
    <title id="Description">The Responsive Panel is collapsed when the owner's container width is less that the collapseBreakpoint property value and expanded when it is higher.</title>
    <link type="text/css" rel="Stylesheet" href="../jqwidgets-ver4.5.0/jqwidgets/styles/jqx.base.css" />
    <script type="text/javascript" src="../vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="../jqwidgets-ver4.5.0/jqwidgets/jqxresponsivepanel.js"></script>
    
   <style type="text/css">
            #jqxResponsivePanel, #content {
                float: left;
            }
            .jqx-rc-all {
                border-radius: 0px;
            }

        </style>
    </head>
    <body>
        <div id="ownerPanel" style="height: 800px; width:100%;" class="device-mobile-tablet">
            <div style="box-sizing: border-box; margin-bottom: 2px; width: 100%; padding: 10px 0 0 10px;">
                <div id="toggleResponsivePanel">
                </div>
            </div>
            <div id="jqxResponsivePanel">
                <div id="jqxMenu" style="border: none; visibility: hidden;">
                    <ul>
                        <li><a href="#">Cadastros</a></li>
                        <li><a href="#">Movimento</a></li>
                        <li><a href="#">Financiero</a>
                            <ul>
                                <li><a href="javascript:loadContent('#conteudo','gerenciar.php')">Gerenciar</a></li>
                                <li><a href="javascript:loadContent('#conteudo','html/folhadepago.php')">Folha de Pago</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
            <div id="content" >
                <div id="conteudo" style=" padding: 10px;" class="device-mobile-tablet-container">
                    <h4 style="text-align: center;">Bem Vindo MOS Plataforma</h4>
                </div>

            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#jqxMenu').jqxMenu({mode: 'horizontal', width: '100%'});
                $('#jqxMenu').css('visibility', 'visible');
                //$('#content').jqxPanel();
                $('#jqxResponsivePanel').jqxResponsivePanel({
                    width: '100%',
                    collapseBreakpoint: 700,
                    toggleButton: $('#toggleResponsivePanel'),
                    animationType: 'none',
                    autoClose: false
                });
                /*$('#jqxResponsivePanel').on('open expand close collapse', function (event) {
                 if (event.args.element)
                 return;
                 var collapsed = $('#jqxResponsivePanel').jqxResponsivePanel('isCollapsed');
                 var opened = $('#jqxResponsivePanel').jqxResponsivePanel('isOpened');
                 if (collapsed && !opened) {
                 $('#content').jqxPanel({ width: '100%' });
                 }
                 else if (collapsed && opened) {
                 $('#content').jqxPanel({ width: '100%' });
                 }
                 else if (!collapsed) {
                 $('#content').jqxPanel({ width: '100%' });
                 }
                 });*/
                //$('#content').jqxPanel({ width: '100%', height: '850px' });
            });
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
            //loadjscssfile('../js/jquery.shortcuts.min.js','js');
            //loadjscssfile('../js/jquery.meiomask.js','js');
            //loadjscssfile('../js/jquery.autocomplete.js','js'); // este plugin já esta incluido na UI-Jquery
            //loadjscssfile('../lib/jquery.validate.js','js');
            //loadjscssfile('../js/date.js','js');
            //loadjscssfile('../js/dataBr.js?nocache='+Math.random(),'js');        
            loadjscssfile('js/custom_jquery.js?nocache=' + Math.random(), 'js');
            setTimeout(function () {
                loadjscssfile('js/principal.js?nocache=' + Math.random(), 'js');
            }, 500);
        </script>
    </body>
</html>