<?php

/* Este arquivo conecta um banco de dados MySQL
 * Na function conectar() apontar para qual servido você deseja se conectar
 * Autor: Marcio Souza
 * Revisao: 0
 * Data: 30/11/2016
 */
error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);

class cConexao {
 /*
      public $host = "sql470.main-hosting.eu";
      public $user = "u657536526_espacoaquatico";
      public $pass = "@Monalisa@036@";
      public $db = "u657536526_espacoaquatico";
*/     

    public $host = "127.0.0.1";
    public $user = "root";
    public $pass = "";
    public $db = "mos";
    public $port = 3306;
    public $ultimoId;
    public $erro;

    #conecta no banco de dados;

    function conectar() {

        @$conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db, $this->port);
        mysqli_set_charset(@$conn, "utf8");
        if (mysqli_connect_errno()) {
            echo "Nao foi possivel conectar ao banco MySQL cConexao.php na linha 27 : " . mysqli_connect_error();
            exit();
        }
        return $conn;
    }

    #executa funções no banco retorna como padrão um objeto a ser tratado;

    function execute($con) {
        $qry = mysqli_query($con, $this->sql);
        //echo 'erroooo'.mysqli_connect_errno();
        $this->erro = mysqli_error($con);

        $this->ultimoId = mysqli_insert_id($con);

        //retorna um true ou false
        return $qry;
    }

    #atribuir valores as propriedades da classe;	

    function set($prop, $value) {
        $this->$prop = $value;
    }

    function get($prop) {
        return $this->$prop;
    }

    /*   function conFirebird($charset = null, $buffers = null) {
      $servidor = '192.168.0.253:C:/Zingler/BD/PRODUCAO.FDB'; //Marcio

      $conn = ibase_connect($servidor, 'SYSDBA', 'Monalisa@721883', $charset, $buffers);
      if ($conn) {
      return $conn;
      } else {
      die('Erro ao conectar: ' . ibase_errmsg());
      }
      }
     */
}
