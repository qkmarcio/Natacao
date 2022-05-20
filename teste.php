<?php
//$banco = "mos";
//$usuario = "root";
//$senha = "";
//$hostname = "localhost";
//$port = 3306;
//
//$con = mysqli_connect($hostname, $usuario, $senha, $banco) ;
//
//    echo($con);
//
//$con=@mysqli_connect($hostname, $usuario, $senha, $banco) or die("Não foi possível conectar ao banco MySQL : cConexao.php na linha 9 -> ".mysqli_connect_error())
/*
  $conn = mysqli_connect($hostname,$usuario,$senha);



  mysqli_select_db($conn,$banco) or die( "Não foi possível conectar ao banco MySQL");
  if (!$conn) {echo "Não foi possível conectar ao banco MySQL."; exit;}
  else {echo "Parabéns!! A conexão ao banco de dados ocorreu normalmente!.";}
  mysqli_close($conn);
 */

function parcelas($data, $numero = 12)
{
    $parc = array();
    $parc[] = $data;
    list($ano, $mes, $dia) = explode("-", $data);
    for($i = 1; $i < $numero;$i++)
    {
        $mes++;
        if ((int)$mes == 13)
        {
            $ano++;
            $mes = 1;
        }
        $tira = $dia;
        while (!checkdate($mes, $tira, $ano))
        {
            $tira--;
        }
        $parc[] = sprintf("%02d-%02d-%02d", $ano, $mes, $tira);
    }
    return $parc;
}


$data = "2022-05-05";

var_dump(parcelas($data, 12));

?>

