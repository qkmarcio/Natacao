<?php
   include '../controller/cConexao.php';

if (!empty($_FILES['fileInput']['tmp_name'])) {
    $arquivo = new DOMDocument;
    $arquivo->load($_FILES['fileInput']['tmp_name']);

    $linhas = $arquivo->getElementsByTagName("Row");

    $contLinha = 1;
    foreach ($linhas as $linha) {
        $cls= new stdClass();
        if ($contLinha > 1) {
            $cod = $linha->getElementsByTagName("Data")->item(0)->nodeValue;// coluna B cod interno
            $qtd = $linha->getElementsByTagName("Data")->item(1)->nodeValue; //coluna A quantidade
            $provedor = $linha->getElementsByTagName("Data")->item(4)->nodeValue; //coluna G Cod Fabricante
            $marca = $linha->getElementsByTagName("Data")->item(5)->nodeValue; //coluna D Provedor
            
            //inserirDados($nome, $email);
            $o =getPosicao($cod);
            
            
            $posicao = ( $o->posicao === null ? "Sem Lugar " : $o->posicao);
            $id = ( $o->idproduto===null ? "vazio" : $o->idproduto);
            $qtd1 = ( $qtd==='vazio' ? "vazio" : $qtd);
            $cod1 = ( $cod==='vazio' ? "Produto Novo" : $cod);
            $marca1 = ( $marca==='vazio' ? "vazio" : $marca);
            $provedor1 = ( $provedor==='vazio' ? "vazio" : $provedor);
            $multiplo = ( $o->multiplo===null ? "1" : $o->multiplo);
            $estoque = ( $o->estoque===null ? "0" : $o->estoque);
            
            $cls->qtd = $qtd1;
            $cls->cod= $cod1;
            $cls->posicao = $posicao;
            $cls->marca=$marca1;
            $cls->idcod=$id;
            $cls->provedor=$provedor1;
            $cls->multiplo=$multiplo;
            $cls->estoque=$estoque;
            $array[]= $cls;
        }
        $contLinha++;
    }
    echo json_encode($array);
}

function getPosicao($o) {

    $query = "SELECT IDPRODUTO, POSICAO,VENDE_MULTIPLO_QTD,ESTOQUE_DEP_PRINC FROM PRODUTO WHERE FABRICANTE='$o'";

    $c = new cConexao();
    $con = $c->conFirebird();
    $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
    while ($obj = ibase_fetch_object($result)) {
        $cls = new stdClass();

        $cls->posicao = $obj->POSICAO;
        $cls->idproduto = $obj->IDPRODUTO;
        $cls->multiplo = $obj->VENDE_MULTIPLO_QTD;
        $cls->estoque = $obj->ESTOQUE_DEP_PRINC;
    }
    return @$cls;
}