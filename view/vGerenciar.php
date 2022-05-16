<?php

include_once '../controller/cConexao.php';
include_once '../controller/cGerenciar.php';
include_once '../lib/Formatador.php';

//CONTROLLER PARA CONEXAO DO BANCO
$funcao = $_REQUEST['funcao'];                                                  //RECEBE O NOME DA FUNÇÃO
call_user_func($funcao);

function getListaCheques() {                                                    //FUNÇÃO PARA PEGAR O REMETENTE
    $col = new cGerenciar();                                                    //CHAMA A CONTROLLER

    $arrObj = $col->getAllCheques(getLista(1));                                            //BUSCA NA TABELA DE CHEQUE PELO NOME
    $arrObj1 = $col->getAllCheques(getLista(2));
    $arrObj2 = $col->getAllCheques(getLista(3));
    $arrObj3 = $col->getAllCheques(getLista(4));
    /*$arrObj4 = $col->getAllContaCobrar(getLista(5));
    $arrObj5 = $col->getAllContaCobrar(getLista(6));
    $arrObj6 = $col->getAllVenda(getLista(7));*/

    $result = array_merge(
            (array) $arrObj2, (array) $arrObj1, (array) $arrObj, (array) $arrObj3, (array) $arrObj4, (array) $arrObj5, (array) $arrObj6
    );
    echo json_encode($result);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getListaVendaDev() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cGerenciar();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getConsultaVendaPeriodo($obj);                                  //BUSCA NA TAB_EXPORTADOR PELO NOME

    for ($i = 0; $i < count($arrObj); $i++) {
        $c = new stdClass();
        $c->id = $arrObj[$i]->id;
        $c->nome = $arrObj[$i]->nome;
        $c->t_valor = $arrObj[$i]->t_valor;
        $c->t_custo = $arrObj[$i]->t_custo;
        $c->t_margen = $arrObj[$i]->t_margen;
        $c->devolucao = $arrObj[$i]->devolucao;
        $c->saldo = $arrObj[$i]->t_valor - $arrObj[$i]->devolucao;
        $array[] = $c;
    }
    echo json_encode($array);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}


function getListaVendaMargem() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cGerenciar();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getTotadeVenda($obj);                                  //BUSCA NA TAB_EXPORTADOR PELO NOME
    //$arrObj2 = $col->getTotadeVenda($obj);                                  //BUSCA NA TAB_EXPORTADOR PELO NOME
    $r = count($arrObj)-1;

    for ($i = 0; $i < count($arrObj); $i++) {
        $c = new stdClass();
        $c->id = $arrObj[$i]->id;
        $c->nome = $arrObj[$i]->nome;
        $c->t_valor = $arrObj[$i]->t_valor;
        $c->t_margenTvenda =ceil($arrObj[$i]->t_valor/$arrObj[$r]->t_venda*100) ;
        $c->t_lucro =$arrObj[$i]->t_margen;
        $c->t_devolucao =ceil($arrObj[$i]->t_devolucao) ;
        //$c->t_custo = $arrObj[$i]->t_custo;
        //$c->t_margen = ( $arrObj[$i]->id===24 ? 100 : Formatador::zeroEsquerda(ceil($arrObj[$i]->t_valor/$arrObj2->t_valor*100),2)); 
        //$c->devolucao = $arrObj[$i]->devolucao;
        //$c->saldo = $arrObj[$i]->t_valor - $arrObj[$i]->devolucao;
        $array[] = $c;
    }
    echo json_encode($array);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getListaVendaClietnte() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cGerenciar();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getConsultaVendaPeriodo($obj);                                  //BUSCA NA TAB_EXPORTADOR PELO NOME

    /* for ($i = 0; $i < count($arrObj); $i++) {
      $c = new stdClass();


      $c->id = $arrObj[$i]->id;
      $c->nome = $arrObj[$i]->nome;
      $c->venda = $arrObj[$i]->t_valor;
      $c->custo = $arrObj[$i]->t_custo;
      $c->margem = ceil($arrObj[$i]->t_margen);

      $array[] = $c;
      } */

    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getLista($p) {
    $d = date("Y-m-d");
    $i = new stdClass();
    if ($p == 1) {
        $i->campo = "sum(che_valor) valor_total , (select moe_sigla from tab_moeda where moe_id=che_moe_id) moeda";
        $i->campo2 = "che_antecipado = 'S' AND che_devuelto = 'N' GROUP by che_moe_id";
        $i->campo3 = 'Antecipado';
        $i->campo4 = 'CHEQUES';
    } elseif ($p == 2) {
        $i->campo = "sum(che_valor) valor_total , (select moe_sigla from tab_moeda where moe_id=che_moe_id) moeda";
        $i->campo2 = "che_antecipado = 'N' AND che_devuelto = 'N' and che_data_venc > current_date GROUP by che_moe_id";
        $i->campo3 = "A Vencer";
        $i->campo4 = 'CHEQUES';
    } elseif ($p == 3) {
        $i->campo = "sum(che_valor) valor_total , (select moe_sigla from tab_moeda where moe_id=che_moe_id) moeda";
        $i->campo2 = "che_antecipado = 'N' AND che_devuelto = 'N' and che_data_venc <= current_date GROUP by che_moe_id";
        $i->campo3 = 'Vencidos';
        $i->campo4 = 'CHEQUES';
    } elseif ($p == 4) {
        $i->campo = "sum(che_valor) valor_total , (select moe_sigla from tab_moeda where moe_id=che_moe_id) moeda";
        $i->campo2 = "che_devuelto = 'S' GROUP by che_moe_id";
        $i->campo3 = 'Devolvidos';
        $i->campo4 = 'CHEQUES';
    } elseif ($p == 5) {
        $i->campo = "sum(valor_total) as valor_total";
        $i->campo2 = "data_venc <= '$d'";
        $i->campo3 = 'Vencidas';
        $i->campo4 = 'CONTAS A RECEBER';
    } elseif ($p == 6) {
        $i->campo = "sum(valor_total) as valor_total";
        $i->campo2 = "data_venc > '$d'";
        $i->campo3 = "A Vencer";
        $i->campo4 = 'CONTAS A RECEBER';
    } elseif ($p == 7) {
        $i->campo = "sum(total) as valor_total";
        $i->campo2 = "cancelada is NULL AND (orcamento IS NULL or orcamento='N') AND data='$d'";
        $i->campo3 = "Faturas do Dia";
        $i->campo4 = 'VENDAS';
    }
    return $i;
}
