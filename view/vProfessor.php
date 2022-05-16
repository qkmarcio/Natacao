<?php

include '../controller/cConexao.php';
include '../controller/cProfessor.php';
include '../lib/Formatador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { // aqui é onde vai decorrer a chamada se houver um *request* POST
    $method = $_POST['action'];
    if (method_exists('vProfessor', $method)) {

        //set
        $col = new ColProfessor();
        $professor = new vProfessor;
        $professor->$method($_POST, $_FILES); //Faz a chamada da funcao
    } else {
        echo 'Metodo incorreto';
    }
}

class vProfessor {

    public $profPasta;

    //#atribuir valores as propriedades da classe;

    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function get($prop) {
        return $this->$prop;
    }

    function vCadastro($dados, $files) {

        global $col;

        $pasta = $dados['foto2'];

        if (isset($files['foto'])) {
            $pasta = $this->vVerificaFoto($files);
        }
        
        $col->set("prof_id", $dados['id']);
        $col->set("prof_nome", $dados['nome']);
        $col->set("prof_nascimento", $dados['nascimento']);
        $col->set("prof_cep", $dados['cep']);
        $col->set("prof_bairro", $dados['bairro']);
        $col->set("prof_endereco", $dados['endereco']);
        $col->set("prof_cidade", $dados['cidade']);
        $col->set("prof_cpf", $dados['cpf']);
        $col->set("prof_telefone", $dados['telefone']);
        $col->set("prof_celular", $dados['celular']);
        $col->set("prof_sexo", $dados['sexo']);
        $col->set("prof_email", $dados['email']);
        $col->set("prof_obs", $dados['obs']);
        $col->set("prof_senha", $dados['senha']);
        $col->set("prof_ativado", $dados['ativado']);
        $col->set("prof_comissao", $dados['comissao']);
        $col->set("prof_foto", $pasta);

        if ($dados['insert'] === "insert") {
            $result = $col->incluir();

            $msg = $result ? 'Registro(s) inserido(s) com sucesso' : 'Erro ao inserir o registro, tente novamente.';
        } else {
            $result = $col->alterar();

            $msg = $result ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';
        }

//se houver um erro, retornar um cabeçalho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vProfessor.php');
            header('Content-Type: application/json; charset=UTF-8');

            echo json_encode(array(
                "success" => false,
                "messages" => $msg,
                "dados" => $result
            ));
        } else {

//header('Content-Type: application/json; charset=UTF-8');

            echo json_encode(array(
                "success" => true,
                "messages" => $msg,
                "dados" => $result
            ));
        }
    }

    function vListaAll($dados, $files) {
        global $col;

        //$nome = $dados['nome'];
        if ($dados['where']) {
            $where = $dados['where'];
        } else {
            $where = ' order by prof_nome';
        }

        $col->set("sqlCampos", $where);

        $result = $col->getRegistros();

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabeçalho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vProfessor.php');
            header('Content-Type: application/json; charset=UTF-8');

            echo json_encode(array(
                "success" => false,
                "messages" => $msg,
                "dados" => $result
                
            ));
        } else {

            echo json_encode(array(
                "success" => true,
                "messages" => $msg,
                "dados" => $result,
                "total" => count($result)
            ));
        }
    }
    
    function vBuscaAll($dados, $files) {
        global $col;

        $where = " where CONCAT(prof_nome,' ',prof_nascimento ) like '%".$dados['where']."%'";
      

        $col->set("sqlCampos", $where);

        $result = $col->getRegistros();

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabeçalho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vProfessor.php');
            header('Content-Type: application/json; charset=UTF-8');

            echo json_encode(array(
                "success" => false,
                "messages" => $msg,
                "dados" => $result
                
            ));
        } else {

            echo json_encode(array(
                "success" => true,
                "messages" => $msg,
                "dados" => $result,
                "total" => count($result)
            ));
        }
    }

    private function vVerificaFoto($files) {

        //verifica se tem alguma foto
        if (isset($files['foto'])) {
            $arquivo = $files['foto'];

            if ($arquivo['error']) {

                die("Falha ao enviar arquivo");
            }
            if ($arquivo['siza'] > 2097152) {

                die("Arquivo muito grande!! Max: 2MB");
            }

            $pasta = "../Fotos/imgProfessor/";
            $nomeDoArquivo = $arquivo['name'];
            $novoNomeDoArquivo = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

            if ($extensao != "jpg" && $extensao != "png") {

                die("Tipode arquivo não aceito");
            }
            $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
            $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);
        }
        return $path;
    }

}
