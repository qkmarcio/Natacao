<?php

error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
# Função para converter de ISO para UTF8
/* function toUtf8(&$item, $key) {
  $item = iconv("iso-8859-1","utf-8",$item);
  } */
if (!isset($_SESSION)) session_start();

$idusuario = $_SESSION['usu_id'];
//$idusuario = $_SESSION['usu_id'];

require_once '../controller/cConexao.php';
require_once '../lib/Formatador.php';

$con = new cConexao(); // Cria um novo objeto de conexao com o BD. 



$sql = "select * from tab_menu";
/*$sql = "Select menu_nome, menu_ico, submenu_nome, submenu_url"
        . " From tab_submenu_usuario"
        . " INNER JOIN tab_submenu on tab_submenu_usuario.submenu_id = tab_submenu.submenu_id"
        . " INNER JOIN tab_menu on tab_submenu.menu_id = tab_menu.menu_id"
        . " WHERE tab_submenu_usuario.usu_id =$idusuario ORDER BY 1, 2";*/
$con->set("sql", $sql);
$resultado_assuntos = $con->execute($con->conectar());


while ($menu = mysqli_fetch_object($resultado_assuntos)) {
    
    //$linha_assunto_slug = url_slug($linha_assunto['nome_menu']);

    $linha_sem_filho = "<li><a href=\"#\"><i class=\"$menu->menu_ico\"></i>\"". utf8_decode($menu->nome_menu)."<span class=\"fa arrow\"></span></a>";

    $sql2 = "SELECT * FROM tab_submenu WHERE menu_id = $menu->menu_id"
    . " AND SUBMENU_ID IN (SELECT SUBMENU_ID FROM TAB_SUBMENU_USUARIO WHERE USU_ID=$idusuario)";

    $con->set("sql", $sql2);
    $submenu = $con->execute($con->conectar());


    $fieldinfo = mysqli_fetch_field($submenu);

    if ($fieldinfo->max_length > 0) {

        echo "<li>";
        echo "<a href=\"#\"><i class=\"$menu->menu_ico\"></i>$menu->menu_nome<span class=\"fa arrow\"></span></a>";
        echo "<ul class=\"nav nav-second-level\">";

        while ($submenu_nome = mysqli_fetch_object($submenu)) {
            echo "<li><a href=javascript:loadContent('#conteudo','". Formatador::tirarAcentos($menu->menu_nome)."/$submenu_nome->submenu_url')>$submenu_nome->submenu_nome</a></li>";
        }
        echo "</ul>";
        echo "</li>";
    } else {
       // echo $linha_sem_filho;
    }
}