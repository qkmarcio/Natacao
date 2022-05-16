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
?>


<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <title>Cadastro de Foto</title>

        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="http://malsup.github.io/min/jquery.form.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <script type="text/javascript">

            // Quando carregado a página
            $(function ($) {

                $('#process-file-button').on('click', function (e) {
                    url = 'up.php';

                    var form = new FormData();
                    form.append("c..nome", "Anonimo");
                    form.append("c..idade", 17);
                    form.append("fileName", $("#file")[0].files[0]);
                    
                    
                    

                    
                    

    $.ajax({
        url: url, type: "POST", data: form, dataType: "json", async: false, cache: false,processData: false,
        contentType: false,
        success: function (php) {
            /*var responseText = JSON.parse(php.responseText);
             jsProfessor.msg = responseText;*/
            jsProfessor.msg = php.messages;
            retorno = php;
        },
        error: function (php) {
            var responseText = JSON.parse(php.responseText);
            jsProfessor.msg = responseText.messages;
            swal('Oops...', jsProfessor.msg, 'error');

            retorno = false;
        }
    });





//                    let files = new FormData(), // you can consider this as 'data bag'
//                            url = 'up.php';
//
//                  
//
//                    files.append('fileName', $('#file')[0].files[0]); // append selected file to the bag named 'file'

//                    $.ajax({
//                        type: 'post',
//                        url: url,
//                        processData: false,
//                        contentType: false,
//                        data: files,
//                        success: function (response) {
//                            console.log(response);
//                        },
//                        error: function (err) {
//                            console.log(err);
//                        }
//                    });
                });

            });

        </script>
    </head>

    <body>

        <div class="container">

            <h1>Cadastro de Foto</h1>

            <input type="file" id="file">
            <button id='process-file-button'>Process</button>

        </div>

    </body>
</html>