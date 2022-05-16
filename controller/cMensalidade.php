<?php

/*
 * Autor: Marcio
 * Revisao: 0
 * Data: 13/04/2022
 *
 * Descricao: 
 * Controle de Acesso na tab_mensalidade
 */

class ColMensalidade {

    private $men_id;
    private $men_vencimento;
    private $men_data_pago;
    private $men_status;
    private $men_valor;
    private $men_valor_pago;
    private $men_saldo;
    private $men_data_cadastro;
    private $men_pago_tipo;
    private $men_pago_obs;
    private $contratos_id;
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
        $sql = "INSERT INTO tab_mensalidades (
            men_vencimento,
            men_data_pago,
            men_status,
            men_valor,
            men_valor_pago,
            men_saldo,
            men_data_cadastro,
            contratos_id,
            men_pago_tipo,
            men_pago_obs
            )VALUES(";
        $sql .= "'" . $this->men_vencimento . "',";
        $sql .= "'" . $this->men_data_pago . "',";
        $sql .= "'" . $this->men_status . "',";
        $sql .= "" . Formatador::convertMoedaToFloat($this->men_valor) . ",";
        $sql .= "" . Formatador::convertMoedaToFloat($this->men_valor_pago) . ",";
        $sql .= "" . Formatador::convertMoedaToFloat($this->men_saldo) . ",";
        $sql .= "CURRENT_TIMESTAMP , ";
        $sql .= "" . $this->contratos_id . ",";
        $sql .= "'" . $this->men_pago_tipo . "',";
        $sql .= "'" . $this->men_pago_obs . "'";
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

        $sql = "UPDATE tab_mensalidades SET ";
        $sql .= "men_vencimento='" . $this->men_vencimento . "',";
        $sql .= "men_data_pago='" . $this->men_data_pago . "',";
        $sql .= "men_status='" . $this->men_status . "',";
        $sql .= "men_valor=" . Formatador::convertMoedaToFloat($this->men_valor) . ",";
        $sql .= "men_valor_pago=" . Formatador::convertMoedaToFloat($this->men_valor_pago) . ",";
        $sql .= "men_saldo=" . Formatador::convertMoedaToFloat($this->men_saldo) . ",";
        $sql .= "contratos_id=" . $this->contratos_id . ",";
        $sql .= "men_pago_tipo='" . $this->men_data_pago . "',";
        $sql .= "men_pago_obs='" . $this->men_data_pago . "'";
        $sql .= " WHERE men_id=" . $this->men_id;

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
        $sql = "DELETE FROM tab_mensalidades WHERE men_id = " . $this->men_id;
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
        $sql = "SELECT a.men_id, a.men_vencimento, coalesce(a.men_data_pago,'') men_data_pago, a.men_status, "
                . " a.men_valor,a.men_valor_pago,a.men_saldo,a.men_data_cadastro,a.contratos_id,"
                . " (select modalidade_nome from tab_modalidades where modalidade_id=a.mod_id ) modalidade_nome,"
                . " (select alu_nome from tab_alunos where alu_id=a.alu_id ) aluno_nome"
                . " FROM "
                . " (SELECT men_id, men_vencimento,men_data_pago,men_status,"
                . " men_valor,men_valor_pago,men_saldo,men_data_cadastro,contratos_id,"
                . " (select modalidades_id from tab_contratos where con_id=contratos_id) mod_id,"
                . " (select alunos_id from tab_contratos where con_id=contratos_id) alu_id "
                . " FROM tab_mensalidades " . $this->sqlCampos . " ) a";

        $con->set("sql", $sql);
        $result = $con->execute($con->conectar());

        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();

            $cls->id = $obj->men_id;
            $cls->vencimento = Formatador::dateEmPortugues($obj->men_vencimento);
            $cls->data_pago = Formatador::dateEmPortugues($obj->men_data_pago);
            $cls->status = $obj->men_status;
            $cls->valor = Formatador::convertFloatToMoeda($obj->men_valor);
            $cls->valor_pago = Formatador::convertFloatToMoeda($obj->men_valor_pago);
            $cls->saldo = Formatador::convertFloatToMoeda($obj->men_saldo);
            $cls->data_cadastro = Formatador::dateTimeEmPortugues($obj->mem_data_cadastro);
            $cls->contratos_id = $obj->contratos_id;
            $cls->modalidade_nome = $obj->modalidade_nome;
            $cls->aluno_nome = $obj->aluno_nome;

            $conArry[] = $cls;
        }

        return $conArry;
    }

    public function getMensalidadesId() {
        $con = new cConexao(); // Cria um novo objeto de conexão com o BD.
        $con->conectar();
        $sql = "Select * FROM tab_mensalidades WHERE men_id = " . $this->men_id;
        $con->set("sql", $sql);
        $result = $con->execute($con->conectar());

        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();

            $cls->id = $obj->men_id;
            $cls->vencimento = $obj->men_vencimento;
            $cls->data_pago = $obj->men_data_pago;
            $cls->status = $obj->men_status;
            $cls->valor = Formatador::convertFloatToMoeda($obj->men_valor);
            $cls->valor_pago = Formatador::convertFloatToMoeda($obj->men_valor_pago);
            $cls->saldo = Formatador::convertFloatToMoeda($obj->men_saldo);
            $cls->data_cadastro = Formatador::dateTimeEmPortugues($obj->mem_data_cadastro);
            $cls->contratos_id = $obj->contratos_id;

            $conArry[] = $cls;
        }

        return $conArry;
    }

    public function alterarGenerico() {
        $con = new cConexao(); // Cria um novo objeto de conexão com o BD. 
        $con->conectar();

        $sql = "UPDATE tab_mensalidades SET " . $this->sqlCampos;
        $sql .= " WHERE men_id=" . $this->men_id;
        die($sql);
        $con->set("sql", $sql);
        if ($con->execute($con->conectar())) {
            return true;
        } else {
            $this->erro = $con->erro;
            return false;
        }
    }

    public function alterarPagamento() {
        $con = new cConexao(); // Cria um novo objeto de conexão com o BD. 
        $con->conectar();

        $sql = "UPDATE tab_mensalidades SET ";
        $sql .= "men_status='" . $this->men_status . "',";
        $sql .= "men_data_pago='" . $this->men_data_pago . "',";
        $sql .= "men_valor_pago=" . Formatador::convertMoedaToFloat($this->men_valor_pago) . ",";
        $sql .= "men_pago_tipo='" . $this->men_pago_tipo . "',";
        $sql .= "men_pago_obs='" . $this->men_pago_obs . "'";
        $sql .= " WHERE men_id=" . $this->men_id;

        //die($sql);
        $con->set("sql", $sql);
        if ($con->execute($con->conectar())) {
            return true;
        } else {
            $this->erro = $con->erro;
            return false;
        }
    }

}
