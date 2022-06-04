<?php
header('Content-type: application/json');
ini_set('default_charset','utf-8');

include '../controller/cConexao.php';
include '../controller/cMensalidade.php';
include '../lib/Formatador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { // aqui � onde vai decorrer a chamada se houver um *request* POST

    $function = $_POST['action'];

    if (function_exists($function)) {

        //set
        $con = new cConexao(); // Cria um novo objeto de conex�o com o BD.
        $conectar = $con->conectar();

        $col = new ColMensalidade();

        call_user_func($function, $_POST, $_FILES);
    } else {
        echo 'Metodo incorreto';
    }

}


    function vCadastro($dados, $files) {

        global $col, $conectar;

        $col->set("men_id", $dados['id']);
        $col->set("men_vencimento", $dados['vencimento']);
        $col->set("men_data_pago", $dados['data_pago']);
        $col->set("men_status", $dados['status']);
        $col->set("men_valor", $dados['valor']);
        $col->set("men_valor_pago", $dados['valor_pago']);
        $col->set("men_saldo", $dados['saldo']);
        $col->set("men_data_cadastro", $dados['data_cadastro']);
        $col->set("contratos_id", $dados['contratos_id']);
             
        if ($dados['insert'] === "insert") {
            $result = $col->incluir($conectar);

            $msg = $result ? 'Registro(s) inserido(s) com sucesso' : 'Erro ao inserir o registro, tente novamente.';
        } else {
            $result = $col->alterar($conectar);

            $msg = $result ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';
        }

//se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vMensalidade.php');
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
        global $col, $conectar;

        //$nome = $dados['nome'];
        if ($dados['where']) {
            $where = $dados['where'];
        } else {
            $where = ' order by men_id';
        }

        $col->set("sqlCampos", $where);

        $result = $col->getRegistros($conectar);

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vMensalidade.php');
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
        global $col, $conectar;

        $where = " where modalidade_nome like '%" . $dados['where'] . "%'";

        $col->set("sqlCampos", $where);

        $result = $col->getRegistros($conectar);

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
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
    
    function vMensalidadeID($dados, $files) {
        global $col, $conectar;

        $col->set("men_id", $dados['id']);

        $result = $col->getMensalidadesId($conectar);

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vMensalidade.php');
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
    
    function vMensalidadeAlterar($dados, $files) {
        global $col, $conectar;

        $col->set("sqlCampos", $dados['sqlCampos']);
        $col->set("men_id", $dados['id']);

        $result = $col->alterarGenerico($conectar);

        $msg = $result ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vMensalidade.php');
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
                "dados" => $result
            ));
        }
    }
    
    function vMensalidadePagamento($dados, $files) {
        global $col, $conectar;

        //$col->set("sqlCampos", $dados['sqlCampos']);
        $col->set("men_id", $dados['id']);
        $col->set("men_status", $dados['men_status']);
        $col->set("men_data_pago", $dados['men_data_pago']);
        $col->set("men_valor_pago", $dados['men_valor_pago']);
        $col->set("men_pago_tipo", $dados['men_pago_tipo']);
        $col->set("men_pago_obs", $dados['men_pago_obs']);

        $result = $col->alterarPagamento($conectar);

        $msg = $result ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vMensalidade.php');
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
                "dados" => $result
            ));
        }
    }