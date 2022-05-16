<?php

include_once '../controller/cConexao.php';
include_once '../controller/cProduto.php';
include_once '../lib/Formatador.php';

//$c = new cConexao();                                                          //CONTROLLER PARA CONEXAO DO BANCO
$funcao = $_REQUEST['funcao'];                                              //RECEBE O NOME DA FUNÇÃO
call_user_func($funcao);

function getListaProduto() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                         //RECEBE O OBJETO DO AJAX
    $col = new cProduto();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getAllProduto();                                        //BUSCA NA TAB_EXPORTADOR PELO NOME

    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getListaProdutoCompra() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                         //RECEBE O OBJETO DO AJAX
    $col = new cProduto();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getAllProdutoCompra();                                        //BUSCA NA TAB_EXPORTADOR PELO NOME

    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getListaCatalogo() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $objj = (object) $_REQUEST['obj'];                                         //RECEBE O OBJETO DO AJAX
    $col = new cProduto();                                                  //CHAMA A CONTROLLER
    $colProduto = $col->getListaCatalogo();                                        //BUSCA NA TAB_EXPORTADOR PELO NOME

    $novo_campo = 1;
    $repete = 1;
    for ($index = 0; $index < count($colProduto); $index++) {
        $obj = $colProduto[$index];
        if ($index > 0) {
            $objAnterior = $obj = $colProduto[$index - 1];
            if ($obj->grupo == $objAnterior->grupo && $obj->sub_grupo == $objAnterior->sub_grupo) {
                if ($repete == 4) {
                    $novo_campo++;
                } else {
                    $repete++;
                }
                $obj->novo = $novo_campo;
            } else {
                $repete = 1;
                $novo_campo = 1;
                //$novo_campo++;
            }
        } else {
            $obj->novo = $novo_campo;
        }
    }
    echo json_encode($colProduto);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getItensVendido() {                                                    //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cProduto();                                                      //CHAMA A CONTROLLER
    $arrObj = $col->getListaItensVendido();                                     //BUSCA NA TAB_EXPORTADOR PELO NOME

    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}
?>