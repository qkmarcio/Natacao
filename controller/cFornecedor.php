<?php

Class cFornecedor {

    public function __construct() {
        
    }

    public function getAllFornecedor() {
        
        $obj = (object) $_REQUEST['obj'];
        
        $query = "SELECT * FROM FORNECEDOR";
        $c = new cConexao();

        $con = $c->conFirebird();

        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();

            $cls->idfornecedor = $obj->IDFORNECEDOR;
            $cls->tipo = $obj->TIPO;
            $cls->fornecedor = utf8_encode($obj->NOME);
            $cls->fantasia = utf8_encode($obj->NOME_FANTASIA);
            
            $array[] = $cls;
        }
        return $array;
    }
}
?>
