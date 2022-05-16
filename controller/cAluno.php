<?php

/*
 * Autor: Marcio
 * Revisao: 0
 * Data: 13/04/2022
 *
 * Descricao: 
 * Controle de Acesso na tab_alunos
 */

class ColAluno {

    private $alu_id;
    private $alu_nome;
    private $alu_nascimento;
    private $alu_resposavel;
    private $alu_cep;
    private $alu_bairro;
    private $alu_endereco;
    private $alu_cidade;
    private $alu_cpf;
    private $alu_telefone;
    private $alu_celular;
    private $alu_sexo;
    private $alu_email;
    private $alu_email_recibo;
    private $alu_obs;
    private $alu_senha;
    private $alu_ativado;
    private $alu_foto;
    private $alu_data_cadastro;
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
        $sql = "INSERT INTO tab_alunos (
            alu_nome,
            alu_nascimento,
            alu_resposavel,
            alu_cep,
            alu_bairro,
            alu_endereco,
            alu_cidade,
            alu_cpf,
            alu_telefone,
            alu_celular,
            alu_sexo,
            alu_email,
            alu_email_recibo,
            alu_obs,
            alu_senha,
            alu_ativado,
            alu_foto,
            alu_data_cadastro
            )VALUES(";
        $sql .= "'" . strtoupper(addslashes($this->alu_nome)) . "',";
        $sql .= "'" . $this->alu_nascimento . "',";
        $sql .= "'" . strtoupper(addslashes($this->alu_resposavel)) . "',";
        $sql .= "'" . $this->alu_cep . "',";
        $sql .= "'" . strtoupper(addslashes($this->alu_bairro)) . "',";
        $sql .= "'" . strtoupper(addslashes($this->alu_endereco)) . "',";
        $sql .= "'" . strtoupper(addslashes($this->alu_cidade)) . "',";
        $sql .= "'" . $this->alu_cpf . "',";
        $sql .= "'" . $this->alu_telefone . "',";
        $sql .= "'" . $this->alu_celular . "',";
        $sql .= "'" . strtoupper(addslashes($this->alu_sexo)) . "',";
        $sql .= "'" . $this->alu_email . "',";
        $sql .= "'" . $this->alu_email_recibo . "',";
        $sql .= "'" . $this->alu_obs . "',";
        $sql .= "'" . $this->alu_senha . "',";
        $sql .= "'" . $this->alu_ativado . "',";
        $sql .= "'" . $this->alu_foto . "',";
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

        $sql = "UPDATE tab_alunos SET ";
        $sql .= "alu_nome='" . strtoupper(addslashes($this->alu_nome)) . "',";
        $sql .= "alu_nascimento='" . $this->alu_nascimento . "',";
        $sql .= "alu_resposavel='" . strtoupper(addslashes($this->alu_resposavel)) . "',";
        $sql .= "alu_cep='" . $this->alu_cep . "',";
        $sql .= "alu_bairro='" . strtoupper(addslashes($this->alu_bairro)) . "',";
        $sql .= "alu_endereco='" . strtoupper(addslashes($this->alu_endereco)) . "',";
        $sql .= "alu_cidade='" . strtoupper(addslashes($this->alu_cidade)) . "',";
        $sql .= "alu_cpf='" . $this->alu_cpf . "',";
        $sql .= "alu_telefone='" . $this->alu_telefone . "',";
        $sql .= "alu_celular='" . $this->alu_celular . "',";
        $sql .= "alu_sexo='" . strtoupper(addslashes($this->alu_sexo)) . "',";
        $sql .= "alu_email='" . $this->alu_email . "',";
        $sql .= "alu_email_recibo='" . $this->alu_email_recibo . "',";
        $sql .= "alu_obs='" . $this->alu_obs . "',";
        $sql .= "alu_senha='" . $this->alu_senha . "',";
        $sql .= "alu_ativado='" . $this->alu_ativado . "',";
        $sql .= "alu_foto='" . $this->alu_foto . "'";
        $sql .= "WHERE alu_id=" . $this->alu_id;

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
        $sql = "DELETE FROM tab_alunos WHERE alu_id = " . $this->alu_id;
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
        $sql = "SELECT * FROM tab_alunos " . $this->sqlCampos;
        //die($sql);
        $con->set("sql", $sql);
        $result = $con->execute($con->conectar());

        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();
            
            $cls->id = $obj->alu_id;
            $cls->nome = $obj->alu_nome;
            $cls->nascimento = $obj->alu_nascimento;
            $cls->resposavel = $obj->alu_resposavel;
            $cls->cep = $obj->alu_cep;
            $cls->bairro = $obj->alu_bairro;
            $cls->endereco = $obj->alu_endereco;
            $cls->cidade = $obj->alu_cidade;
            $cls->cpf = $obj->alu_cpf;
            $cls->telefone = $obj->alu_telefone;
            $cls->celular = $obj->alu_celular;
            $cls->sexo = $obj->alu_sexo;
            $cls->email = $obj->alu_email;
            $cls->email_recibo = $obj->alu_email_recibo;
            $cls->obs = $obj->alu_obs;
            $cls->senha = $obj->alu_senha;
            $cls->ativado = $obj->alu_ativado;
            $cls->foto = $obj->alu_foto;
            $cls->data_cadastro = $obj->alu_data_cadastro;
            
            $conArry[] = $cls;
        }

        return $conArry;
    }

}
