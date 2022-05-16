<?php

Class cFuncionario {

    public function __construct() {
        
    }

    public function getAllFuncionario($o) {
        $query = "SELECT * FROM TAB_FUNCIONARIO $o->campo";

        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();

            $array[] = $cls;
        }
        return $array;
    }

}
