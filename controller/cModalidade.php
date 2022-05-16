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

    public function incluir() {

        $con = new cConexao(); // Cria um novo objeto de conexão com o BD. 
        $con->conectar();
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

        $con->set("sql", $sql);

        if ($con->execute($con->conectar())) {
            $id = $con->ultimoId;
            return $id;
        } else {
            $this->erro = $con->erro;
            return false;
        }
    }

    public function alterar() {
        $con = new cConexao(); // Cria um novo objeto de conexão com o BD. 
        $con->conectar();

        $sql = "UPDATE tab_modalidades SET ";
        $sql .= "modalidade_nome='" . strtoupper(addslashes($this->modalidade_nome)) . "',";
        $sql .= "modalidade_obs='" . $this->modalidade_obs . "',";
        $sql .= "modalidade_ativado='" . $this->modalidade_ativado . "',";
        $sql .= "WHERE modalidade_id=" . $this->modalidade_id;

        $con->set("sql", $sql);
        if ($con->execute($con->conectar())) {
            return true;
        } else {
            $this->erro = $con->erro;
            return false;
        }
    }

    #remove o registro

    public function remover() {
        $con = new cConexao(); // Cria um novo objeto de conexão com o BD.
        $con->conectar();
        $sql = "DELETE FROM tab_modalidades WHERE modalidade_id = " . $this->modalidade_id;
        $con->set("sql", $sql);
        $resultado = $con->execute($con->conectar());
        if ($resultado) {
            return $con->execute($con->conectar());
        } else {
            return false;
        }
    }

    public function getRegistros() {
        $con = new cConexao(); // Cria um novo objeto de conexão com o BD.
        $con->conectar();
        $sql = "SELECT * FROM tab_modalidades " . $this->sqlCampos;
        //die($sql);
        $con->set("sql", $sql);
        $result = $con->execute($con->conectar());

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
