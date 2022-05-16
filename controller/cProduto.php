<?php

Class cProduto {

    public function __construct() {
        
    }

    public function getAllProduto() {
        
        $obj = (object) $_REQUEST['obj'];
        
        $query = "SELECT $obj->campo FROM PRODUTO $obj->where";
        $c = new cConexao();

        $con = $c->conFirebird();

        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();

            $cls->idproduto = $obj->IDPRODUTO;
            $cls->posicao = $obj->POSICAO;
            $cls->codigo = $obj->FABRICANTE;
            $cls->original = $obj->ORIGINAL;
            $cls->descricao = utf8_encode($obj->DESCRICAO);
            $cls->descricaoPy = utf8_encode($obj->DESCR02);
            $cls->descricaoCa = utf8_encode($obj->APLICACAO);
            $cls->marca = utf8_encode($obj->DESCRMARCA);
            $cls->venda = Formatador::convertFloatToGuarani($obj->VENDA_ATUAL);
            $cls->minimo = Formatador::convertFloatToGuarani($obj->PRECO_MINIMO);
            $cls->custo = Formatador::convertFloatToGuarani($obj->CUSTO_ANTERIOR);
            $cls->estoque = $obj->ESTOQUE_MENOS_SEP;
            $cls->v6meses = $obj->QTD_VENDIDA;
            
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getAllProdutoCompra() {
        
        $obj = (object) $_REQUEST['obj'];
        
        $query = "SELECT "
                . "DESCRFORNEC,COMPRA,NUMNOTA,DATA,FABRICANTE,DESCPRODUTO,QTD,VALOR,TOTAL,MOEDA,OUTRO_CUSTO,"
                . "(select cambio from compra c where idcompra=compra)"
                . " FROM LIST_COMPRA"
                . " where produto=$obj->id AND"
                ." CANCELADA='F' AND TRANSFERENCIA IS NULL AND TIPO_CODVENDADEV IS NULL order BY DATA DESC";
        $c = new cConexao();

        $con = $c->conFirebird();

        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();

            $cls->data = Formatador::dateEmPortugues($obj->DATA);
            $cls->codigo = $obj->FABRICANTE;
            $cls->compra = $obj->COMPRA;
            $cls->nota = $obj->NUMNOTA;
            $cls->qtd = $obj->QTD;
            $cls->moeda = $obj->MOEDA;
            $cls->descricao = utf8_encode($obj->DESCPRODUTO);
            $cls->fornecedor = utf8_encode($obj->DESCRFORNEC);
            $cls->custo = utf8_encode($obj->OUTRO_CUSTO);
            
            $cls->valor = Formatador::convertFloatToMoeda($obj->VALOR);
            $cls->total = Formatador::convertFloatToMoeda($obj->TOTAL);
            $cls->cambio = Formatador::convertFloatToGuarani($obj->CAMBIO);
            
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getListaCatalogo() {
        
        $obj = (object) $_REQUEST['obj'];
        
        $query = "select first 50 * from catalogogrupo";
        $c = new cConexao();

        $con = $c->conFirebirdNew();

        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();

            $cls->grupo = utf8_encode($obj->GRUPO);
            $cls->sub_grupo = utf8_encode($obj->SUB_GRUPO);
            $cls->codigo = $obj->CODIGO;
            
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getListaItensVendido() {
        
        //$obj = (object) $_REQUEST['obj'];
        $o = new stdClass();
        $o->inicio = '2018-01-01';
        $o->final = '2018-08-31';
        
        $query = "select first 50 * from listavendido('$o->inicio','$o->final') order by listavendido.total_venda desc";
        
        $t = $this->getVendaTotais($o);
        
        $c = new cConexao();
        $con = $c->conFirebird();

        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
                $cls->PRODUTO=$obj->PRODUTO;
                $cls->T_CUSTO=$obj->CUSTO;
                $cls->T_VENDA=$obj->TOTAL_VENDA;
                $cls->MARGEM=$obj->MARGEM;
                $cls->CODIGO=$obj->CODIGO;
                $cls->DESCRICAO=$obj->DESCRICAO;
                $cls->QTD_VENDA=$obj->QTD_VENDIDA;
                $cls->ESTOQUE=$obj->ESTOQUE;
                $cls->PEDIDO=$obj->PEDIDO;
                $cls->JAN=$obj->QTDE_JAN;$cls->JAN_MARGEM= $obj->QTDE_JAN == 0 ? 0 : round((($obj->QTDE_JAN*100)/$t->QTDE_JAN),2);
                $cls->FEV=$obj->QTDE_FEV;$cls->FEV_MARGEM= $obj->QTDE_FEV == 0 ? 0 : round((($obj->QTDE_FEV*100)/$t->QTDE_FEV),2);
                $cls->MAR=$obj->QTDE_MAR;$cls->MAR_MARGEM= $obj->QTDE_MAR == 0 ? 0 : round((($obj->QTDE_MAR*100)/$t->QTDE_MAR),2);
                $cls->ABR=$obj->QTDE_ABR;$cls->ABR_MARGEM= $obj->QTDE_ABR == 0 ? 0 : round((($obj->QTDE_ABR*100)/$t->QTDE_ABR),2);
                $cls->MAI=$obj->QTDE_MAI;$cls->MAI_MARGEM= $obj->QTDE_MAI == 0 ? 0 : round((($obj->QTDE_MAI*100)/$t->QTDE_JAN),2);
                $cls->JUN=$obj->QTDE_JUN;$cls->JUN_MARGEM= $obj->QTDE_JUN == 0 ? 0 : round((($obj->QTDE_JUN*100)/$t->QTDE_JUN),2);
                $cls->JUL=$obj->QTDE_JUL;$cls->JUL_MARGEM= $obj->QTDE_JUL == 0 ? 0 : round((($obj->QTDE_JUL*100)/$t->QTDE_JUL),2);
                $cls->AGO=$obj->QTDE_AGO;$cls->AGO_MARGEM= $obj->QTDE_AGO == 0 ? 0 : round((($obj->QTDE_AGO*100)/$t->QTDE_AGO),2);
                $cls->SET=$obj->QTDE_SET;$cls->SET_MARGEM= $obj->QTDE_SET == 0 ? 0 : round((($obj->QTDE_SET*100)/$t->QTDE_SET),2);
                $cls->OUT=$obj->QTDE_OUT;$cls->OUT_MARGEM= $obj->QTDE_OUT == 0 ? 0 : round((($obj->QTDE_OUT*100)/$t->QTDE_OUT),2);
                $cls->NOV=$obj->QTDE_NOV;$cls->NOV_MARGEM= $obj->QTDE_NOV == 0 ? 0 : round((($obj->QTDE_NOV*100)/$t->QTDE_NOV),2);
                $cls->DEZ=$obj->QTDE_DEZ;$cls->DEZ_MARGEM= $obj->QTDE_DEZ == 0 ? 0 : round((($obj->QTDE_DEZ*100)/$t->QTDE_DEZ),2);
            
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getVendaTotais($o) {
        
        
        $query = "select * from LISTAVENDIDOTOTAIS('$o->inicio','$o->final') ";
        //die($query);
        $c = new cConexao();

        $con = $c->conFirebird();

        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        
        while ($obj = ibase_fetch_object($result)) {
            $a = $obj;
        }
        return $a;
    }
}
?>
