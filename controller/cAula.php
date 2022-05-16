<?php

/*
 * Autor: Marcio
 * Revisao: 0
 * Data: 25/04/2022
 *
 * Descricao: 
 * Controle de Acesso na tab_aulas
 */

class ColAula {

    private $aul_id;
    private $aul_nome;
    private $aul_horario;
    private $aul_dia_semana;
    private $aul_obs;
    private $aul_comissao;
    private $aul_ativado;
    private $aul_prof_id;
    private $aul_data_cadastro;
    private $erro;
    private $sqlCampos;
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
        $sql = "INSERT INTO tab_aulas (
            aul_nome,
            aul_horario,
            aul_dia_semana,
            aul_obs,
            aul_comissao,
            aul_ativado,
            aul_prof_id,
            aul_data_cadastro
            )VALUES(";
        $sql .= "'" . strtoupper(addslashes($this->aul_nome)) . "',";
        $sql .= "'" . $this->aul_horario . "',";
        $sql .= "'" . strtoupper($this->aul_dia_semana) . "',";
        $sql .= "'" . strtoupper(addslashes($this->aul_obs)) . "',";
        $sql .= ""  . Formatador::convertMoedaToFloat($this->aul_comissao) . ",";
        $sql .= "'" . $this->aul_ativado . "',";
        $sql .= ""  . $this->aul_prof_id . ",";
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

        $sql = "UPDATE tab_aulas SET ";
        
        $sql .= "aul_nome='" . strtoupper(addslashes($this->aul_nome)) . "',";
        $sql .= "aul_horario='" . $this->aul_horario . "',";
        $sql .= "aul_dia_semana='" . strtoupper($this->aul_dia_semana) . "',";
        $sql .= "aul_obs='" . strtoupper(addslashes($this->aul_obs)) . "',";
        $sql .= "aul_comissao="  . Formatador::convertMoedaToFloat($this->aul_comissao) . ",";
        $sql .= "aul_ativado='" . $this->aul_ativado . "',";
        $sql .= "aul_prof_id="  . $this->aul_prof_id . "";
        
        $sql .= " WHERE aul_id=" . $this->aul_id;

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
        $sql = "DELETE FROM tab_aulas WHERE aul_id = " . $this->aul_id;
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
        $sql = "SELECT *, "
                . " (select prof_nome from tab_professores where prof_id=aul_prof_id) aul_prof_nome"
                . " FROM tab_aulas " . $this->sqlCampos;
        $con->set("sql", $sql);

        $result = $con->execute($con->conectar());

        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();
            $cls->id = $obj->aul_id;
            $cls->nome = $obj->aul_nome;
            $cls->horario = $obj->aul_horario;
            $cls->dia_semana = $obj->aul_dia_semana;
            $cls->obs = $obj->aul_obs;
            $cls->comissao = Formatador::convertFloatToMoeda($obj->aul_comissao);
            $cls->ativado = $obj->aul_ativado;
            $cls->prof_id = $obj->aul_prof_id;
            $cls->prof_nome = $obj->aul_prof_nome;
            $cls->data_cadastro = $obj->aul_data_cadastro;
            
            $conArry[] = $cls;
        }

        return $conArry;
    }

}
