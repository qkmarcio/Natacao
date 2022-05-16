<?php

include '../controller/cConexao.php';
include '../controller/cAula.php';
include '../lib/Formatador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { // aqui é onde vai decorrer a chamada se houver um *request* POST
    $method = $_POST['action'];
    if (method_exists('vAula', $method)) {

        //set
        $col = new ColAula();
        $class = new vAula;
        $class->$method($_POST, $_FILES); //Faz a chamada da funcao
    } else {
        echo 'Metodo incorreto';
    }
}

class vAula {

    //#atribuir valores as propriedades da classe;

    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function get($prop) {
        return $this->$prop;
    }

    function vCadastro($dados, $files) {

        global $col;

        $col->set("aul_id", $dados['id']);
        $col->set("aul_nome", $dados['nome']);
        $col->set("aul_horario", $dados['horario']);
        $col->set("aul_dia_semana", $dados['dia_semana']);
        $col->set("aul_obs", $dados['obs']);
        $col->set("aul_comissao", $dados['comissao']);
        $col->set("aul_ativado", $dados['ativado']);
        $col->set("aul_prof_id", $dados['prof_id']);
        
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
            $where = ' order by aul_nome';
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

        $where = " where CONCAT(aul_nome,' ',aul_horario,' ',aul_dia_semana ) like '%" . $dados['where'] . "%'";

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
