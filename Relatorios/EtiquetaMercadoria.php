<?php 
/*
THIS FILE IS FOR EXAMPLE PURPOSES ONLY
*/


include './server/Adl/Configuration.php';
include './server/Adl/Config/Parser.php';
include './server/Adl/Config/JasperServer.php';
include './server/Adl/Integration/RequestJasper.php';

# Recebe objeto e passa os valores para as variaveis abaixo #

//ini_set('memory_limit', '4095M');

    $jasper = new Adl\Integration\RequestJasper();
    /*
      To send output to browser
     */
   header('Content-type: application/pdf');
    $parametro = array("id" => $_GET['id']);
    if($_GET['rel']==1){
        echo $jasper->run('/reports/interactive/EtiquetaMercadoriaLogo','PDF',$parametro);
    }else{
        echo $jasper->run('/reports/interactive/EtiquetaMercadoria','PDF',$parametro);
//        echo $jasper->run('/reports/interactive/ZebraEtiqueta','PDF',$parametro);
    }
    //echo $jasper->run('/Reports/Catalogo', 'PDF');
    /*
      To Save content to a file in the disk
      The path where the file will be saved is registered into config/data.ini
     */
    //echo $jasper->run('/reports/interactive/ZebraEtiqueta','PDF',$parametro);
   // echo $jasper->run('/reports/samples/etiqueta_entrega_de_mercadoria','PDF',null);
    //echo $jasper->run('/reports/samples/'.$nome,'PDF',$parametro);

?>