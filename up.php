<?php

var_dump($_POST);
if (isset($_FILES) && !empty($_FILES)) {
    $file = $_FILES['fileName'];
    $name = $file['name'];
    $path = $file['tmp_name'];


    var_dump($_POST);
    
    
    
  
    
//    if (!empty($_FILES['fileName']['tmp_name'])) {
//    $arquivo = new DOMDocument;
//    $arquivo->load($_FILES['fileName']['tmp_name']);
//
//    $linhas = $arquivo->getElementsByTagName("Row");
//    var_dump($_FILES);
//    $contLinha = 1;
//    foreach ($linhas as $linha) {
//        $cls= new stdClass();
//        if ($contLinha > 1) {
//            $cod = $linha->getElementsByTagName("Data")->item(0)->nodeValue;// coluna B cod interno
//            $qtd = $linha->getElementsByTagName("Data")->item(1)->nodeValue; //coluna A quantidade
//            $provedor = $linha->getElementsByTagName("Data")->item(4)->nodeValue; //coluna G Cod Fabricante
//            $marca = $linha->getElementsByTagName("Data")->item(5)->nodeValue; //coluna D Provedor
//            
//            //inserirDados($nome, $email);
//            $o =getPosicao($cod);
//            
//            
//            $posicao = ( $o->posicao === null ? "Sem Lugar " : $o->posicao);
//            $id = ( $o->idproduto===null ? "vazio" : $o->idproduto);
//            $qtd1 = ( $qtd==='vazio' ? "vazio" : $qtd);
//            $cod1 = ( $cod==='vazio' ? "Produto Novo" : $cod);
//            $marca1 = ( $marca==='vazio' ? "vazio" : $marca);
//            $provedor1 = ( $provedor==='vazio' ? "vazio" : $provedor);
//            $multiplo = ( $o->multiplo===null ? "1" : $o->multiplo);
//            $estoque = ( $o->estoque===null ? "0" : $o->estoque);
//            
//            $cls->qtd = $qtd1;
//            $cls->cod= $cod1;
//            $cls->posicao = $posicao;
//            $cls->marca=$marca1;
//            $cls->idcod=$id;
//            $cls->provedor=$provedor1;
//            $cls->multiplo=$multiplo;
//            $cls->estoque=$estoque;
//            $array[]= $cls;
//        }
//        $contLinha++;
//    }
//    echo json_encode($array);
}

