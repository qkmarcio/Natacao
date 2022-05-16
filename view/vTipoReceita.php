<?php

include '../controller/cConexao.php';
include '../controller/cTipoReceita.php';
include '../lib/Formatador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { // aqui é onde vai decorrer a chamada se houver um *request* POST
    $method = $_POST['action'];
    if (method_exists('vTipoReceita', $method)) {

        //set
        $col = new ColTipoReceita();
        $class = new vTipoReceita();
        $class->$method($_POST, $_FILES); //Faz a chamada da funcao
    } else {
        echo 'Metodo incorreto';
    }
}

class vTipoReceita {

    //#atribuir valores as propriedades da classe;

    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function get($prop) {
        return $this->$prop;
    }

    function vCadastro($dados, $files) {

        global $col;

        $col->set("tipo_receita_id", $dados['id']);
        $col->set("tipo_receita_nome", $dados['nome']);
        $col->set("tipo_receita_obs", $dados['obs']);
        $col->set("tipo_receita_ativado", $dados['ativado']);

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
            $where = ' order by tipo_receita_nome';
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

        $where = " where tipo_receita_nome like '%" . $dados['where'] . "%'";

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

}
