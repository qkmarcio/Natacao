<?php

include '../controller/cConexao.php';
include '../controller/cUsuario.php';

//set
$c = new cUsuario;

//route
$funcao = $_REQUEST['funcao'];                                              //RECEBE O NOME DA FUNÇÃO
call_user_func($funcao);

function logar() {
    $obj = (object) $_REQUEST['obj'];

    $conColl = new cUsuario();
    $conArray = $conColl->getLogar($obj->usuario, md5($obj->senha));

    $linha = mysqli_num_rows($conArray);
    if ($linha != 1) {
        $resultado["success"] = false;
        $resultado["errors"]["reason"] = "Usuario ou senha invalido(s)";
    } else {
        $resultado = mysqli_fetch_assoc($conArray);
        if (!isset($_SESSION))
            session_start();
        $_SESSION['usu_id'] = $resultado['usu_id'];
        $_SESSION['usu_login'] = $resultado['usu_login'];
        $_SESSION['usu_nome'] = $resultado['usu_nome'];
        $_SESSION['usu_status'] = $resultado['usu_status'];
        $_SESSION["conectado"] = 'sim';
        $resultado["success"] = true;
    }
    //$retorno = array('codigo' => 1, 'mensagem' => 'Logado com sucesso!');
    echo json_encode($resultado);
}

function insert() {
    $obj = (object) $_REQUEST['obj'];

    global $c;
    $c->set("usu_nome", $obj->usu_nome);
    $c->set("usu_login", $obj->usu_login);
    $c->set("usu_senha", $obj->usu_senha);

    $insert = $c->incluir();

    $msg = $insert ? 'Registro(s) inserido(s) com sucesso' : 'Erro ao inserir o registro, tente novamente.';

    $newData = $obj;
    $newData->id = $insert;

    echo json_encode(array(
        "success" => $insert,
        "message" => $msg,
        "data" => $newData
    ));
}

function update() {
    $obj = (object) $_REQUEST['obj'];

    global $c;
    $c->set("usu_id", $obj->usu_id);
    $c->set("usu_nome", $obj->usu_nome);
    $c->set("usu_login", $obj->usu_login);
    $c->set("usu_senha", $obj->usu_senha);

    $update = $c->alterar();

    $msg = $update ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';

    echo json_encode(array(
        "success" => $update,
        "message" => $msg,
        "data" => $update
    ));
}

function fetchAll() {
    global $c;
    $result = $c->getTodosRegistros();
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = array(
            'Id' => $row['usu_id'],
            'Nome' => $row['usu_nome'] ? $row['usu_nome'] : '',
            'Login' => $row['usu_login'] ? $row['usu_login'] : '',
        );
    }
    echo json_encode(array(
        "data" => $array,
        "success" => true,
        "total" => mysqli_num_rows($result)
    ));
}

function buscaId() {
    $obj = (object) $_REQUEST['obj'];

    global $c;
    $c->set("usu_id", $obj->usu_id);
    $rs = $c->getCadastroId();
    while ($row = mysqli_fetch_assoc($rs)) {
        $resultado[] = array(
            'usu_id' => $row['usu_id'],
            'usu_nome' => $row['usu_nome'],
            'usu_login' => $row['usu_login'],
            'usu_senha' => $row['usu_senha'],
            'usu_status' => $row['usu_status']
        );
    }
    echo json_encode(array(
        "data" => $resultado,
        "success" => true,
        "total" => mysqli_num_rows($rs)
    ));
}

function buscaNome() {
    $obj = (object) $_REQUEST['obj'];

    global $c;
    $c->set("usu_nome", $obj->letra);
    $rs = $c->getNomeAutocomplete();
    while ($row = mysqli_fetch_assoc($rs)) {
        $resultado[] = $row;
    }
    echo json_encode($resultado);
}
