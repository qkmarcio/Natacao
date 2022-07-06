<?php

header('Content-type: application/json');
ini_set('default_charset', 'utf-8');

include '../controller/cConexao.php';
include '../controller/cAluno.php';
include '../lib/Formatador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { //  onde vai decorrer a chamada se houver um *request* POST

    $function = $_POST['action'];

    if (function_exists($function)) {

        //set
        $con = new cConexao(); // Cria um novo objeto de conexao com o BD.
        $conectar = $con->conectar();

        $col = new ColAluno();

        call_user_func($function, $_POST, $_FILES);
    } else {
        echo 'Metodo incorreto';
    }
}

function vCadastro($dados, $files)
{

    global $col, $conectar;

    $pasta = $dados['foto2'];

    if (isset($files['foto'])) {
        $pasta = vVerificaFoto($files);
    }

    $col->set("alu_id", $dados['id']);
    $col->set("alu_nome", $dados['nome']);
    $col->set("alu_nascimento", $dados['nascimento']);
    $col->set("alu_resposavel", $dados['resposavel']);
    $col->set("alu_cep", $dados['cep']);
    $col->set("alu_bairro", $dados['bairro']);
    $col->set("alu_endereco", $dados['endereco']);
    $col->set("alu_cidade", $dados['cidade']);
    $col->set("alu_cpf", $dados['cpf']);
    $col->set("alu_telefone", $dados['telefone']);
    $col->set("alu_celular", $dados['celular']);
    $col->set("alu_sexo", $dados['sexo']);
    $col->set("alu_email", $dados['email']);
    $col->set("alu_email_recibo", $dados['email_recibo']);
    $col->set("alu_obs", $dados['obs']);
    $col->set("alu_senha", $dados['senha']);
    $col->set("alu_ativado", $dados['ativado']);
    $col->set("alu_nivel_nome", $dados['nivel_nome']);
    $col->set("alu_nivel_id", $dados['nivel_id']);
    $col->set("alu_foto", $pasta);

    if ($dados['insert'] === "insert") {
        $result = $col->incluir($conectar);

        $msg = $result ? 'Registro(s) inserido(s) com sucesso' : 'Erro ao inserir o registro, tente novamente.';
    } else {
        $result = $col->alterar($conectar);
        $col->alterarNivelAlunoMens($conectar); //altera o nivel do aluno com mensalidade em aberto

        
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

function vListaAll($dados, $files)
{
    global $col, $conectar;

    if ($dados['where']) {
        $where = $dados['where'];
    } else {
        $where = ' order by alu_nome';
    }

    $col->set("sqlCampos", $where);

    $result = $col->getRegistros($conectar);

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

function vBuscaAll($dados, $files)
{
    global $col, $conectar;

    $where = " where CONCAT(alu_nome,' ',alu_nascimento,' ',alu_resposavel,' ',alu_cpf ) like '%" . $dados['where'] . "%'";

    $col->set("sqlCampos", $where);

    $result = $col->getRegistros($conectar);

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

function vVerificaFoto($files)
{

    if (isset($files['foto'])) {
        $arquivo = $files['foto'];

        if ($arquivo['error']) {

            die("Falha ao enviar arquivo");
        }
        if ($arquivo['siza'] > 2097152) {

            die("Arquivo muito grande!! Max: 2MB");
        }

        $pasta = "../Fotos/imgAluno/";
        $nomeDoArquivo = $arquivo['name'];
        $novoNomeDoArquivo = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

        if ($extensao != "jpg" && $extensao != "png") {

            die("Tipo de arquivo não aceito");
        }
        $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
        $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);
    }
    return $path;
}

function vAutocomplete($dados, $files)
{
    global $col, $conectar;

    $where = " where alu_ativado='1' and alu_nome like '%" . $dados['letra'] . "%' limit 10";

    $col->set("sqlCampos", $where);

    $result = $col->getRegistros($conectar);

    $msg = $result ? 'Registro(s) localizado(s) com sucesso' : 'Erro ao localizar registro, tente novamente.';

    //se houver um erro, retornar um cabecalho especial, seguido por outro objeto JSON
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