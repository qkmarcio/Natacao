<?php

/*
 * Autor: Marcio
 * Revisao: 0
 * Data: 13/04/2022
 *
 * Descricao: 
 * Controle de Acesso na tab_modalidades
 */

class ColModalidade {

    private $modalidade_id;
    private $modalidade_nome;
    private $modalidade_obs;
    private $modalidade_ativado;
    private $modalidade_data_cadastro;
    private $erro;
    private $dica;

    //#atribuir valores as propriedades da classe;

    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function get($prop) {
        return $this->$prop;
    }

    public function incluir($mysqli) {

        $sql = "INSERT INTO tab_modalidades (
            modalidade_nome,
            modalidade_obs,
            modalidade_ativado,
            modalidade_data_cadastro
            )VALUES(";
        $sql .= "'" . strtoupper(addslashes($this->modalidade_nome)) . "',";
        $sql .= "'" . $this->modalidade_obs . "',";
        $sql .= "'" . $this->modalidade_ativado . "',";
        $sql .= "CURRENT_TIMESTAMP ";
        $sql .= ")";

        $result = $mysqli->query($sql);
        
        if($result){
            $this->dica = $mysqli->mysqli_insert_id($result);
            return true;
        }else{
            $this->erro = $mysqli->mysqli_error($result);
            return false;
        }
    }

    public function alterar($mysqli) {

        $sql = "UPDATE tab_modalidades SET ";
        $sql .= "modalidade_nome='" . strtoupper(addslashes($this->modalidade_nome)) . "',";
        $sql .= "modalidade_obs='" . $this->modalidade_obs . "',";
        $sql .= "modalidade_ativado='" . $this->modalidade_ativado . "',";
        $sql .= "WHERE modalidade_id=" . $this->modalidade_id;

        $result = $mysqli->query($sql);
        
        if($result){
            return true;
        }else{
            $this->erro = $mysqli->mysqli_error($result);
            return false;
        }
    }

    #remove o registro

    public function remover($mysqli) {

        $sql = "DELETE FROM tab_modalidades WHERE modalidade_id = " . $this->modalidade_id;
        $result = $mysqli->query($sql);
        
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function getRegistros($mysqli) {

        $sql = "SELECT * FROM tab_modalidades " . $this->sqlCampos;
        //die($sql);
        $result = $mysqli->query($sql);

        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();
            
            $cls->id = $obj->modalidade_id;
            $cls->nome = $obj->modalidade_nome;
            $cls->obs = $obj->modalidade_obs;
            $cls->ativado = $obj->modalidade_ativado;
            $cls->data_cadastro = $obj->modalidade_data_cadastro;
            
            $conArry[] = $cls;
        }

        return $conArry;
    }

}
