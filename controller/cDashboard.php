<?php

Class cDashboard {

    public function __construct() {
        
    }

    public function getAllDashboard($o) {
        $query = "SELECT ROUND(sum(PTOTAL),0)TOTAL,ROUND(sum(CTOTAL),0)CUSTO,ROUND((sum(PTOTAL - CTOTAL) / sum(PTOTAL) * 100),2) MARGEM,COUNT(distinct(pedido)) PEDIDO,COUNT(distinct(fatura)) FATURA,COUNT(distinct(proid)) ITENS,COUNT(distinct(clienteid)) CLIENTE FROM SP_WEB_VENDAS_PERIODO($o->inicio,$o->final)";
        $query2 = "SELECT sum(c.lcob_valor_original) VALOR FROM tab_Lcobros c inner join tab_cobros r on c.lcob_cod_id=r.cob_id WHERE r.cob_data between $o->inicio and $o->final and r.cob_situacao = 'F'";
        $query3 = "select sum(p.pro_estoque_dep_prin * p.pro_custo_medio) ESTOQUE from tab_produto p where p.pro_estoque_dep_prin > 0";
        $query4 = "SELECT sum(rec_saldo) as A_RECEBER FROM TAB_RECEBER WHERE rec_situacao='A'";
        
        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        $result2 = ibase_query($con, $query2) or die(ibase_errmsg() . "<br>sql utilizado: " . $query2);
        $result3 = ibase_query($con, $query3) or die(ibase_errmsg() . "<br>sql utilizado: " . $query3);$result4 = ibase_query($con, $query4) or die(ibase_errmsg() . "<br>sql utilizado: " . $query4);
        $obj2 = ibase_fetch_object($result2);$obj3 = ibase_fetch_object($result3);$obj4 = ibase_fetch_object($result4);
        
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->FATURAMENTO = Formatador::convertFloatToGuarani($obj->TOTAL);
            $cls->COBROS = Formatador::convertFloatToGuarani($obj2->VALOR);
            $cls->ESTOQUE = Formatador::convertFloatToGuarani($obj3->ESTOQUE);
            $cls->A_RECEBER = Formatador::convertFloatToGuarani($obj4->A_RECEBER);
            $cls->FATURAS = $obj->FATURA;
            $cls->PEDIDOS = $obj->PEDIDO;
            $cls->ITENS = $obj->ITENS;
            $cls->CLIENTE = $obj->CLIENTE;
            $cls->TOTAL = $obj->TOTAL;
            $cls->MARGEM = Formatador::zeroEsquerda(ceil($obj->MARGEM), 2);
            $array[] = $cls;
        }

        return $array;
    }

    public function getTotalVenda($o) {
        $query = "select ROUND(sum(PTOTAL),0)TOTAL,ROUND(sum(CTOTAL),0)CUSTO,ROUND((sum(PTOTAL - CTOTAL) / sum(PTOTAL) * 100),2) MARGEM, count(distinct(PEDIDO)) PEDIDO,count(distinct(FATURA)) FATURA, count(distinct(PROID)) ITENS, count(distinct(CLIENTEID)) CLIENTE,
       VENDEDORID ID_VENDEDOR, VENDEDOR NOME_VENDEDOR,
       (select case when sum(DV.LMOV_TOTAL) is null then 0 else sum(DV.LMOV_TOTAL) end from TAB_LMOVTO DV where DV.LMOV_FUN_VENDEDOR_ID = VENDEDORID and DV.LMOV_DATA between $o->inicio and $o->final and DV.LMOV_TIPO = 'DV') DEVOLUCAO
        from SP_WEB_VENDAS_PERIODO($o->inicio,$o->final) group by VENDEDORID, VENDEDOR;";
        $total = $this->getAllDashboard($o);
        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->id = $obj->ID_VENDEDOR;
            $cls->nome = utf8_encode($obj->NOME_VENDEDOR);
            $cls->t_valor = $obj->TOTAL;
            $cls->comicion = round(($obj->TOTAL - $obj->DEVOLUCAO) * 0.005);
            $cls->sub_valor = $obj->TOTAL - $obj->DEVOLUCAO;
            $cls->t_custo = $obj->CUSTO;
            $cls->devolucao = $obj->DEVOLUCAO;
            $cls->t_lucro = $obj->TOTAL - $obj->CUSTO;
            $cls->m_lucro = Formatador::zeroEsquerda(ceil($obj->MARGEM), 2);
            $cls->t_vendas = Formatador::zeroEsquerda(ceil(($obj->TOTAL / $total[0]->TOTAL) * 100), 2);
            $array[] = $cls; // cada objeto téra o total, onde for usar o total basta pegar qualquer objeto(primeiro por exemplo)
        }
        return $array;
    }

    public function getConsultaSeparacaoPeriodo($o) {
        $query = "SELECT COUNT(sep_mov_cod) PEDIDOS,(SUM(tempo_total)/60) TEMPO ,SUM(cast (itens as integer)) ITENS,ROUND(SUM(cast (itens as integer))/(SUM(tempo_total)/60)) Item_Hora,
sep_fun_id_conf idConf,sep_fun_nome_conf Equipe FROM sp_web_conferencia_rank($o->inicio,$o->fim) where sep_fun_id_conf in(9,10,28) group BY sep_fun_id_conf,sep_fun_nome_conf order by Item_Hora DESC";
        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->pedidos = $obj->PEDIDOS;
            $cls->tempo = $obj->TEMPO;
            $cls->itens = $obj->ITENS;
            $cls->item_hora = $obj->ITEM_HORA;
            $cls->idConf = $obj->IDCONF;
            $cls->equipe = $obj->EQUIPE;
            $array[] = $cls; // cada objeto téra o total, onde for usar o total basta pegar qualquer objeto(primeiro por exemplo)
        }
        //var_dump($array);
        return $array;
    }

    public function getVentaTotalMesAno($inicio,$final) {
        $query = "select * FROM SP_WEB_VENDAS_TOTAIS_PERIODO($inicio,$final)";

        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->VALOR = $obj->VALOR;
            $cls->CUSTO = $obj->CUSTO;
            $cls->LUCRO = $obj->LUCRO;
            $cls->V_SUGERIDO = $obj->V_SUGERIDO;
            $cls->DESCUENTO = $obj->DESCUENTO;
            $array[] = $cls;
        }
        return $array;
    }

}
