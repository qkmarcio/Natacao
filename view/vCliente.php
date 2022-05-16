<?php

include_once '../controller/cConexao.php';
include_once '../controller/cCliente.php';
include_once '../lib/Formatador.php';

//$c = new cConexao();                                                          //CONTROLLER PARA CONEXAO DO BANCO
$funcao = $_REQUEST['funcao'];                                              //RECEBE O NOME DA FUNÇÃO
call_user_func($funcao);
/*
function getListaCheque() {                                                     //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new ColGerenciar();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getConsultaCheques();                                       //BUSCA NA TAB_EXPORTADOR PELO NOME
    $tguarani = 0;$treal = 0;$tdolar = 0;
    for ($i = 0; $i < count($arrObj); $i++) {
        $tvalor = new stdClass();
        
        if($arrObj[$i]->moeda=='G'){
         $tguarani += $arrObj[$i]->valor;   
        }
        if($arrObj[$i]->moeda=='R'){
         $treal += $arrObj[$i]->valor;   
        }if($arrObj[$i]->moeda=='D'){
         $tdolar += $arrObj[$i]->valor;   
        }   
    }
    $tvalor->tguarani = number_format($tguarani,0,",",".");
    $tvalor->treal = number_format($treal, 2, ',', '.');
    $tvalor->tdolar = number_format($tdolar, 2, ',', '.');
    $ary = $tvalor;
    //var_dump($arrObj);
    echo json_encode($arrObj);
    /*echo json_encode(array(
        "obj" =>    $arrObj,
        "vtotal" => $ary
   ));                                                     //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}*/

function getListaCliente() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                         //RECEBE O OBJETO DO AJAX
    $col = new cCliente();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getAllCliente();                                        //BUSCA NA TAB_EXPORTADOR PELO NOME
    
    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}


?>
