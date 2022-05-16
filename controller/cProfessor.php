<?php

/*
 * Autor: Marcio
 * Revisao: 0
 * Data: 13/04/2022
 *
 * Descricao: 
 * Controle de Acesso na tab_professores
 */

class ColProfessor {

    private $prof_id;
    private $prof_nome;
    private $prof_nascimento;
    private $prof_cep;
    private $prof_bairro;
    private $prof_endereco;
    private $prof_cidade;
    private $prof_cpf;
    private $prof_telefone;
    private $prof_celular;
    private $prof_sexo;
    private $prof_email;
    private $prof_obs;
    private $prof_senha;
    private $prof_ativado;
    private $prof_comissao;
    private $prof_foto;
    private $prof_data_cadastro;
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
        $sql = "INSERT INTO tab_professores (
                prof_nome,
                prof_nascimento,
                prof_cep,
                prof_bairro,
                prof_endereco,
                prof_cidade,
                prof_cpf,
                prof_telefone,
                prof_celular,
                prof_sexo,
                prof_email,
                prof_obs,
                prof_senha,
                prof_ativado,
                prof_comissao,
                prof_foto,
                prof_data_cadastro
            )VALUES(";
        $sql .= "'" . strtoupper(addslashes($this->prof_nome)) . "',";
        $sql .= "'" . $this->prof_nascimento . "',";
        $sql .= "'" . $this->prof_cep . "',";
        $sql .= "'" . strtoupper(addslashes($this->prof_bairro)) . "',";
        $sql .= "'" . strtoupper(addslashes($this->prof_endereco)) . "',";
        $sql .= "'" . strtoupper(addslashes($this->prof_cidade)) . "',";
        $sql .= "'" . $this->prof_cpf . "',";
        $sql .= "'" . $this->prof_telefone . "',";
        $sql .= "'" . $this->prof_celular . "',";
        $sql .= "'" . strtoupper(addslashes($this->prof_sexo)) . "',";
        $sql .= "'" . $this->prof_email . "',";
        $sql .= "'" . strtoupper(addslashes($this->prof_obs)) . "',";
        $sql .= "'" . $this->prof_senha . "',";
        $sql .= "'" . $this->prof_ativado . "',";
        $sql .= ""  . Formatador::convertMoedaToFloat($this->prof_comissao) . ",";
        $sql .= "'" . $this->prof_foto . "',";
        $sql .= "CURRENT_TIMESTAMP";
        $sql .= ")";
//die($sql);
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

        $sql = "UPDATE tab_professores SET ";
        $sql .= "prof_nome='" . strtoupper(addslashes($this->prof_nome)) . "',";
        $sql .= "prof_nascimento='" . $this->prof_nascimento . "',";
        $sql .= "prof_cep='" . $this->prof_cep . "',";
        $sql .= "prof_bairro='" . strtoupper(addslashes($this->prof_bairro)) . "',";
        $sql .= "prof_endereco='" . strtoupper(addslashes($this->prof_endereco)) . "',";
        $sql .= "prof_cidade='" . strtoupper(addslashes($this->prof_cidade)) . "',";
        $sql .= "prof_cpf='" . $this->prof_cpf . "',";
        $sql .= "prof_telefone='" . $this->prof_telefone . "',";
        $sql .= "prof_celular='" . $this->prof_celular . "',";
        $sql .= "prof_sexo='" . strtoupper(addslashes($this->prof_sexo)) . "',";
        $sql .= "prof_email='" . $this->prof_email . "',";
        $sql .= "prof_obs='" . strtoupper(addslashes($this->prof_obs)) . "',";
        $sql .= "prof_senha='" . $this->prof_senha . "',";
        $sql .= "prof_ativado='" . $this->prof_ativado . "',";
        $sql .= "prof_comissao="  . Formatador::convertMoedaToFloat($this->prof_comissao) . ",";
        $sql .= "prof_foto='" . $this->prof_foto . "'";
        
        $sql .= "WHERE prof_id=" . $this->prof_id;

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
        $sql = "DELETE FROM tab_professores WHERE prof_id = " . $this->prof_id;
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
        $sql = "SELECT * FROM tab_professores " . $this->sqlCampos;
        $con->set("sql", $sql);
        $result = $con->execute($con->conectar());
        
        while ($obj = mysqli_fetch_object($result)) {
            $cls = new stdClass();
            $cls->id = $obj->prof_id;
            $cls->nome = $obj->prof_nome;
            $cls->nascimento = $obj->prof_nascimento;
            $cls->cep = $obj->prof_cep;
            $cls->bairro = $obj->prof_bairro;
            $cls->endereco = $obj->prof_endereco;
            $cls->cidade = $obj->prof_cidade;
            $cls->cpf = $obj->prof_cpf;
            $cls->telefone = $obj->prof_telefone;
            $cls->celular = $obj->prof_celular;
            $cls->sexo = $obj->prof_sexo;
            $cls->email = $obj->prof_email;
            $cls->obs = $obj->prof_obs;
            $cls->senha = $obj->prof_senha;
            $cls->ativado = $obj->prof_ativado;
            $cls->comissao = Formatador::convertFloatToMoeda($obj->prof_comissao);
            $cls->foto = $obj->prof_foto;
            $cls->data_cadastro = $obj->prof_data_cadastro;
            
            $conArry[] = $cls;
        }
        
        return $conArry;
    }
}
