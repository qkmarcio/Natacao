<?php

/*
 * Autor: Marcio
 * Revisao: 0
 * Data: 13/04/2022
 *
 * Descricao: 
 * Controle de Acesso na tab_tipo_despesas
 */

class ColTipoDespesa {

    private $tipo_despesa_id;
    private $tipo_despesa_nome;
    private $tipo_despesa_obs;
    private $tipo_despesa_ativado;
    private $tipo_despesa_data_cadastro;
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
        $sql = "INSERT INTO tab_tipo_despesas (
            tipo_despesa_nome,
            tipo_despesa_obs,
            tipo_despesa_ativado,
            tipo_despesa_data_cadastro
            )VALUES(";
        $sql .= "'" . strtoupper(addslashes($this->tipo_despesa_nome)) . "',";
        $sql .= "'" . $this->tipo_despesa_obs . "',";
        $sql .= "'" . $this->tipo_despesa_ativado . "',";
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

        $sql = "UPDATE tab_tipo_despesas SET ";
        $sql .= "tipo_despesa_nome='" . strtoupper(addslashes($this->tipo_despesa_nome)) . "',";
        $sql .= "tipo_despesa_obs='" . $this->tipo_despesa_obs . "',";
        $sql .= "tipo_despesa_ativado='" . $this->tipo_despesa_ativado . "',";
        $sql .= "WHERE tipo_despesa_id=" . $this->tipo_despesa_id;

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
        $sql = "DELETE FROM tab_tipo_despesas WHERE tipo_despesa_id = " . $this->tipo_despesa_id;
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
        $sql = "SELECT * FROM tab_tipo_despesas " . $this->sqlCampos;
        //die($sql);
        $con->set("sql", $sql);
        $result = $con->execute($con->conectar());

        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();
            
            $cls->id = $obj->tipo_despesa_id;
            $cls->nome = $obj->tipo_despesa_nome;
            $cls->obs = $obj->tipo_despesa_obs;
            $cls->ativado = $obj->tipo_despesa_ativado;
            $cls->data_cadastro = $obj->tipo_despesa_data_cadastro;
            
            $conArry[] = $cls;
        }

        return $conArry;
    }

}
