<?php

include_once '../controller/cConexao.php';
include_once '../controller/cExpedicion.php';
include_once '../lib/Formatador.php';

//CONTROLLER PARA CONEXAO DO BANCO
$funcao = $_REQUEST['funcao'];                                                  //RECEBE O NOME DA FUNÇÃO
call_user_func($funcao);

function getVListaSepIS() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cExpedicion();                                                  //CHAMA A CONTROLLER
    $array = $col->getListaSepIS($obj);
    echo json_encode($array);
}
function getVListaSepRank() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cExpedicion();                                                  //CHAMA A CONTROLLER
    $a = $col->getListaSepRank($obj);
    $r = count($a)-1;
    for ($i = 0; $i < count($a); $i++) {
        $c = new stdClass();
        //$c->pedidos = $a[$i]->pedidos;
        $c->nome = $a[$i]->nome;
        $c->itens = $a[$i]->itens;
        $c->tempo = $a[$i]->tempo;
        $c->itens_hora = $a[$i]->itens_hora;
        $c->punto = round(($a[$i]->itens * 0.10) + $a[$i]->itens_hora);
        //$c->pedidos = round((($a[$i]->itens *100)/($a[$r]->t_itens)*) + $a[$i]->itens_hora) ;
        //$c->t_itens_hora = $a[$i]->ITENS_HORA;
        $array[] = $c;
    }
    
    echo json_encode($a);
}
function getVListaConfRank() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cExpedicion();                                                  //CHAMA A CONTROLLER
    $array = $col->getListaConfRank($obj);

    echo json_encode($array);
}

function getVListaEquipeRank() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cExpedicion();                                                  //CHAMA A CONTROLLER
    $array = $col->getListaEquipeRank($obj);

    echo json_encode($array);
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

function getListaSeparacao() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    //die('teste');
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cDashboard();                                                  //CHAMA A CONTROLLER
    $arrObj = $col->getConsultaSeparacaoPeriodo($obj);                                  //BUSCA NA TAB_EXPORTADOR PELO NOME
    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getLista($p) {
    //$d = date("Y-m-d");
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
        $i->campo = "sum(rec_saldo) as valor_total";
        $i->campo2 = "rec_data_venc <= current_date";
        $i->campo3 = 'Vencidas';
        $i->campo4 = 'CONTAS A RECEBER';
    } elseif ($p == 6) {
        $i->campo = "sum(rec_saldo) as valor_total";
        $i->campo2 = "rec_data_venc > current_date";
        $i->campo3 = "A Vencer";
        $i->campo4 = 'CONTAS A RECEBER';
    } elseif ($p == 7) {
        $i->campo = "sum(rec_saldo) as valor_total";
        $i->campo2 = "REC_DATA_EMIS = current_date";
        $i->campo3 = "Hoje";
        $i->campo4 = 'VENDAS';
    }
    return $i;
}