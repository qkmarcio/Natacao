<?php

Class cCliente {

    public function __construct() {
        
    }

    public function getAllCliente() {
        $query = "SELECT * FROM TAB_CLIENTE";
        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->id = $obj->CLI_ID;
            $cls->ativo = $obj->CLI_ATIVO;
            $cls->razao = utf8_encode($obj->CLI_RAZAO_SOCIAL);
            $cls->fantasia = utf8_encode($obj->CLI_FANTASIA);
            $cls->fun_id = $obj->CLI_FUN_ID;
            $array[] = $cls;
        }
        return $array;
    }
    
   public function getClientePorRota($o) {
        $query = "select * FROM sp_web_cliento_historico_geral($o->inicio,$o->final)";
        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->Vendedor = utf8_encode($obj->VENDEDOR);
            $cls->Idcliente = $obj->CLI_ID;
            $cls->Cliente = utf8_encode($obj->CLIENTE);
            $cls->t_valor = $obj->VALOR;
            $cls->Status = $obj->CLI_BLOQUEADO;
            $cls->CUSTO = $obj->CUSTO;
            $cls->LIMITI = $obj->LIMITI;
            $cls->VENCIDAS = $obj->VENCIDAS;
            $cls->T_FATURAS = $obj->VENCIDAS + $obj->VENCER ;
            $cls->LUCRO = $obj->LUCRO;
            $cls->VENCER = $obj->VENCER;
            $cls->CHEQUES = $obj->CHEQUES;
            $cls->DEV_CHEQUES = $obj->DEV_CHEQUES;
            $cls->DEV_CHEQUES_TODOS = $obj->DEV_CHEQUES_TODOS;
            $cls->DESCUENTO = $obj->DESCUENTO;
            $array[] = $cls;
        }
        return $array;
    }

}
?>