<?php

include_once '../controller/cConexao.php';
include_once '../controller/cDashboard.php';
include_once '../controller/cCliente.php';
include_once '../controller/cGerenciar.php';
include_once '../lib/Formatador.php';

//CONTROLLER PARA CONEXAO DO BANCO
$funcao = $_REQUEST['funcao'];                                                  //RECEBE O NOME DA FUNÇÃO
call_user_func($funcao);

function getListaDashboard() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cDashboard();                                                  //CHAMA A CONTROLLER
    $array = $col->getAllDashboard($obj);
    echo json_encode($array);
}

function getDashboardVentas() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cDashboard();                                                  //CHAMA A CONTROLLER
    $array = $col->getTotalVenda($obj);

    echo json_encode($array);
}

function getLCliente() {                                                   //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cCliente();                                                  //CHAMA A CONTROLLER
    $array = $col->getClientePorRota($obj);

    echo json_encode($array);
}

function getListaCheques() {                                                    //FUNÇÃO PARA PEGAR O REMETENTE
    $col = new cGerenciar();                                                    //CHAMA A CONTROLLER
    //$arrObj = $col->getAllCheques(getLista(1));                               //BUSCA NA TABELA DE CHEQUE PELO NOME
    $arrObj1 = $col->getAllCheques(getLista(2));
    $arrObj2 = $col->getAllCheques(getLista(3));
    $arrObj3 = $col->getAllCheques(getLista(4));
    $arrObj4 = $col->getAllContaCobrar(getLista(5));
    $arrObj5 = $col->getAllContaCobrar(getLista(6));
    $arrObj6 = $col->getAllContaCobrar(getLista(7));

    $result = array_merge(
            (array) $arrObj2, (array) $arrObj1, (array) $arrObj3, (array) $arrObj4, (array) $arrObj5, (array) $arrObj6
    );
    echo json_encode($result);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function agruparCheque($array) {
    $c = new stdClass();
    for ($i = 0; $i < count($array); $i++) {
        
    }
}

function getConsultaMestas() {
    $obj = (object) $_REQUEST['obj'];
    
    $b = getMestasMes("'".Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,12)."'","'".Formatador::dataRetornaUltimoDiaMes($obj->final,11)."'");
    $d = getMestasMes("'".Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,1)."'","'".Formatador::dataRetornaUltimoDiaMes($obj->final)."'");
    $a = getMestasMes($obj->inicio, $obj->final);
    
    $c = new stdClass();
    $Mes = $a[0]->VALOR;
    $DozeMesAntes = $b[0]->VALOR;
    $UmMesAntes = $d[0]->VALOR;

    $Result = $DozeMesAntes - $Mes;
    $Result1 = $UmMesAntes - $Mes;
    
    if ($DozeMesAntes > $Mes || $UmMesAntes > $Mes) {
        $c->venta = Formatador::MesAnoEmPortugues(Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,12)) . ' --- ' . round(($Mes * 100) / $DozeMesAntes) . '%';
        $c->meta = round(($Result * 100) / $DozeMesAntes) . '%';
        $c->MesAtual = Formatador::MesAnoEmPortugues(Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,1)) . ' --- ' . round(($Mes * 100) / $UmMesAntes) . '%';
        $c->UmMes = round(($Result1 * 100) / $UmMesAntes) . '%';
        $array[] = $c;
    } elseif ($DozeMesAntes == $Mes || $UmMesAntes == $Mes) {
        $c->venta = Formatador::MesAnoEmPortugues(Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,12)) . ' --- 100%';
        $c->meta = '';
        $c->MesAtual = Formatador::MesAnoEmPortugues(Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,1)) . ' --- 100%';
        $c->UmMes = '';
        $array[] = $c;
    } elseif ($DozeMesAntes < $Mes || $UmMesAntes < $Mes) {
        $b = $Mes - $DozeMesAntes;
        $a = $Mes - $UmMesAntes;
        $c->venta = Formatador::MesAnoEmPortugues(Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,12)) . ' --- 100%';
        $c->meta = round(($b * 100) / $Mes) . '%';
        $c->MesAtual = Formatador::MesAnoEmPortugues(Formatador::dataRetornaPrimeiroDiaMes($obj->inicio,1)) . ' --- 100%';
        $c->UmMes = round(($a * 100) / $Mes) . '%';
        $array[] = $c;
    }
    echo json_encode($array);
}

function getMestasMes($inicio, $final) {
    $col = new cDashboard();
    $r = $col->getVentaTotalMesAno($inicio, $final);
    return $r;
}

function getListaSeparacao() {                                                  //FUNÇÃO PARA PEGAR O REMETENTE
    $obj = (object) $_REQUEST['obj'];                                           //RECEBE O OBJETO DO AJAX
    $col = new cDashboard();                                                    //CHAMA A CONTROLLER
    $arrObj = $col->getConsultaSeparacaoPeriodo($obj);                          //BUSCA NA TAB_EXPORTADOR PELO NOME
    echo json_encode($arrObj);                                                  //RETORNA O ARRAY COM OS OBJETOS DO BANCO
}

function getLista($p) {
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
