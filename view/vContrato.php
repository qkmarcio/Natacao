<?php

include '../controller/cConexao.php';
include '../controller/cContrato.php';
include '../controller/cMensalidade.php';
include '../lib/Formatador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { // verifica onde vai decorrer a chamada se houver um *request* POST
    $method = $_POST['action'];
    
    $function = $_POST['action'];
    
    /*if (method_exists('vContrato', $method)) {

        //set
        $con = new cConexao(); // Cria um novo objeto de conex�o com o BD.
        //$col->set("conn",  $con);
        
        $col = new ColContrato();
        $class = new vContrato();
        
        $colMens = new ColMensalidade();
        
        $class->$method($_POST, $_FILES); //Faz a chamada da funcao
        
        call_user_func($function, $_POST, $_FILES);
    } else {
        echo 'Metodo incorreto';
    }*/

    if (function_exists($function)) {

        //set
        $con = new cConexao(); // Cria um novo objeto de conex�o com o BD.
        $conectar = $con->conectar();
        
        $col = new ColContrato();
        //$class = new vContrato();
        
        $colMens = new ColMensalidade();
        
        //$class->$method($_POST, $_FILES); //Faz a chamada da funcao
        
        call_user_func($function, $_POST, $_FILES);
    } else {
        echo 'Metodo incorreto';
    }

}

//class vContrato {

    //#atribuir valores as propriedades da classe;

/*    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function get($prop) {
        return $this->$prop;
    }
*/
    function vCadastro($dados, $files) {

        global $col,$conectar;

        $col->set("con_id", $dados['id']);
        $col->set("con_vencimento", $dados['vencimento']);
        $col->set("con_valor", $dados['valor']);
        $col->set("con_meses", $dados['meses']);
        $col->set("con_obs", $dados['obs']);
        $col->set("con_ativado", $dados['ativado']);
        $col->set("con_email_notificacao", $dados['email_notificacao']);
        $col->set("con_data_cadastro", $dados['data_cadastro']);
        $col->set("alunos_id", $dados['alunos_id']);
        $col->set("modalidades_id", $dados['modalidades_id']);

        if ($dados['insert'] === "insert") {
            $result = $col->incluir($conectar);
            if($result){

                if($dados['meses'] >= 1){
                  $resMen = vInsertMensalidade($dados,$result);
                }
            }

            $msg = $result ? 'Registro(s) inserido(s) com sucesso' : 'Erro ao inserir o registro, tente novamente.';
        } else {
            $result = $col->alterar($conectar);

            $msg = $result ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';
        }

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

//header('Content-Type: application/json; charset=UTF-8');

            echo json_encode(array(
                "success" => true,
                "messages" => $msg,
                "dados" => $result
            ));
        }
    }

    function vListaAll($dados, $files) {
        global $col,$conectar;

        //$nome = $dados['nome'];
        if ($dados['where']) {
            $where = $dados['where'];
        } else {
            $where = ' order by con_id desc';
        }

        $col->set("sqlCampos", $where);

        $result = $col->getRegistros($conectar);

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vContrato.php');
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
        global $col,$conectar;

        $where = " where con_id like '%" . $dados['where'] . "%'";

        $col->set("sqlCampos", $where);

        $result = $col->getRegistros($conectar);

        $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

        //se houver um erro, retornar um cabe�alho especial, seguido por outro objeto JSON
        if ($result == false) {

            header('HTTP/1.1 500 Internal Server vContrato.php');
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
    
    function vInsertMensalidade($dados, $id) {
        global $col,$conectar,$colMens;
        

        $venc = Formatador::dateEmMysql($dados['vencimento']);
        $mesParc = Formatador::parcelas($dados['vencimento'],$dados['meses']);
        
            $colMens->set("men_status", $dados['ativado']);
            $colMens->set("men_valor", $dados['valor']);
            $colMens->set("contratos_id", $id);
    
            for($i = 1; $i < $mesParc;$i++){
                $colMens->set("men_vencimento", $mesParc[$i]);
                $parc = $colMens->incluirMensalidade($conectar);
            }
            
            return $parc;
    }

//}