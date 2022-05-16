<?php

/**
 * @author Marcio Oliveira de Souza
 * 
 * Formatador: Usado para formatacao de numeros, datas, etc.
 */
class Formatador {

    /**
     * ex: getMesExtenso(1) retorna Janeiro
     * @param int
     * @return String mes
     */
    public static function getMesExtenso($mes) {
        if ($mes == 1) {
            return 'JANEIRO';
        } else if ($mes == 2) {
            return 'FEVEREIRO';
        } else if ($mes == 3) {
            return 'MARÇO';
        } else if ($mes == 4) {
            return 'ABRIL';
        } else if ($mes == 5) {
            return 'MAIO';
        } else if ($mes == 6) {
            return 'JUNHO';
        } else if ($mes == 7) {
            return 'JULHO';
        } else if ($mes == 8) {
            return 'AGOSTO';
        } else if ($mes == 9) {
            return 'SETEMBRO';
        } else if ($mes == 10) {
            return 'OUTUBRO';
        } else if ($mes == 11) {
            return 'NOVEMBRO';
        } else if ($mes == 12) {
            return 'DEZEMBRO';
        }
    }

    /**
     * ex: getMesExtensoMinusculo(1) retorna Janeiro
     * @param int
     * @return String mes
     */
    public static function getMesExtensoMinusculo($mes) {
        if ($mes == 1) {
            return 'janeiro';
        } else if ($mes == 2) {
            return 'fevereiro';
        } else if ($mes == 3) {
            return 'março';
        } else if ($mes == 4) {
            return 'abril';
        } else if ($mes == 5) {
            return 'maio';
        } else if ($mes == 6) {
            return 'junho';
        } else if ($mes == 7) {
            return 'julho';
        } else if ($mes == 8) {
            return 'agosto';
        } else if ($mes == 9) {
            return 'setembro';
        } else if ($mes == 10) {
            return 'outubro';
        } else if ($mes == 11) {
            return 'novembro';
        } else if ($mes == 12) {
            return 'dezembro';
        }
    }

    /**
     * Função para transformar strings em Maiúscula ou Minúscula com acentos
     * $palavra = a string propriamente dita
     * $tp = tipo da conversão: 1 para maiúsculas e 0 para minúsculas
     * @param type $term
     * @param type $tp
     * @return type
     */
    public static function convertem($term, $tp) {
        if ($tp == "1")
            $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
        elseif ($tp == "0")
            $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
        return $palavra;
    }

    public static function tirarAcentos($str) {

        return strtr(utf8_decode($str), utf8_decode("ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ"), "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    }

    /**
     * Passe o valor tipo float
     * Receba o valor no padrao moeda brasileiro #.###,###
     * @param float
     * @return #.###,###
     */
    public static function convertFloatTokg($numero) {
        //numero é o valor a ser trabalhado
        //3 é a quantida de casas decimais
        //, é o separador decimal
        //. é o separador de milhar
        return number_format($numero, 3, ',', '.');
    }

    public static function getSeisDigitos($codigo) {

        $tam = strlen($codigo);

        for ($index = $tam; $index <= 5; $index++) {
            $codigo = '0' . $codigo;
        }

        return $codigo;
    }

    /**
     * Passe o valor tipo float
     * Receba o valor no padrao moeda brasileiro #.###,##
     * @param float
     * @return #.###,##
     */
    public static function convertFloatToMoeda($numero) {
        //numero é o valor a ser trabalhado
        //2 é a quantida de casas decimais
        //, é o separador decimal
        //. é o separador de milhar
        return number_format($numero, 2, ',', '.');
    }

    /**
     * Passe o valor tipo float
     * Receba o valor no padrao moeda GUARANI #.###
     * @param float
     * @return #.###
     */
    public static function convertFloatToGuarani($numero) {
        //numero é o valor a ser trabalhado
        //2 é a quantida de casas decimais
        //, é o separador decimal
        //. é o separador de milhar

        return number_format($numero, 0, ',', '.');
    }

    public static function formatMoney($number, $fractional = false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

    /**
     * Passe o valor no padrao moeda brasileiro #.###,##
     * Receba o valor float
     * @param moeda
     * @return ####.##
     */
    public static function convertMoedaToFloat($numero) {

        $valor = "";
        //verifica se existe virgula na string
        if (strpos($numero, ',')) {
            $source = array('.', ',');
            $replace = array('', '.');
            $valor = str_replace($source, $replace, $numero); //remove os pontos e substitui a virgula pelo ponto 
            return $valor; //retorna o valor formatado para gravar no banco        
        } else {
            return $numero; //retorna o proprio numero caso nao tenha virgula
        }
    }

    /**
     * Passe o string com " ou ' e scape para Mysql com /" ou /'
     * Receba a string  /" ou /'
     * @param string
     * @return /" ou /'
     */
    public static function scapeString($variavel) {

        $variavel = str_replace("'", "\'", $variavel);
        $variavel = str_replace('"', '\"', $variavel);

        return $variavel;
    }

    /**
     * Passe o string com carcter estranho e retorna certo para inserir no mysql
     * Receba a string  carcter estranho
     * @param string
     * @return certo para o Mysql
     */
    public static function caracterStranho($variavel) {
        $a = array(' ', ' ', '', '²', '°');
        $b = array(' ', ' ', ' ', ' ', ' ');

        return str_replace($a, $b, $variavel);
    }

    /**
     * Passe uma string para preencher um field de tamanho fixo     * 
     * @param $string
     * @param $limiteLinha
     * @return string para concatenar com a sua string
     */
    public static function preencherFinalDaLinha($string, $limiteLinha) {
        $finalLinha = "";
        $index = ($limiteLinha - strlen($string));
        while ($index > 0) {
            $finalLinha = $finalLinha . " *";
            $index = ($index - 2);
        }
        return $finalLinha;
    }

    /**
     * Passe um numero ex: 1, e passe quantos digitos desejar
     * digitos=2, saida == 01
     * @param numero pode ser string
     * @param int digitos
     * @return novo numero
     */
    public static function zeroEsquerda($numero, $digitos) {
        $tam = strlen($numero);
        for ($index = $tam; $index < $digitos; $index++) {
            $numero = '0' . $numero;
        }
        return $numero;
    }

    /**
     * Passe uma string ex: 'CHEQUE', e passe quantos Caracteres deseja ter na string
     * char=15, saida = 'CHEQUE         '
     * @param string
     * @param int caracteres
     * @return string
     */
    public static function espacoDireita($str, $int) {
        $tam = strlen($str);
        for ($index = $tam; $index < $int; $index++) {
            $str = $str . " ";
        }
        return $str;
    }

    /**
     * Passe um cpf sem mascara ex: 04107520960, saida == 041.075.209-60
     * @param numero pode ser string     
     * @return string com mascara
     */
    public static function criarMascaraCpf($numero) {
        $comeco = substr($numero, 0, -8) . ".";
        $comeco = $comeco . substr($numero, 3, -5) . ".";
        $comeco = $comeco . substr($numero, 6, -2) . "-" . substr($numero, -2);
        return $comeco;
    }

    public static function criarMascaraCnpj($numero) {
        return substr($numero, 0, -12) . "." . substr($numero, 2, -9) . "." . substr($numero, 5, -6) . "/" . substr($numero, 8, -2) . "-" . substr($numero, 12);
    }

    /**
     * Passe um campo com mascara ex: 2011-01-01, saida == 01/01/2011
     * @param string
     * @return string
     */
    public static function dateEmPortugues($dateSql) {
        $ano = substr($dateSql, 0, -6);
        $mes = substr($dateSql, 5, -3);
        $dia = substr($dateSql, 8);
        return $dia . "/" . $mes . "/" . $ano;
    }

    /**
     * Passe um campo com mascara ex: 01/01/2011, saida == 2011-01-01
     * @param string
     * @return string
     */
    public static function dateEmMysql($dateSql) {
        $ano = substr($dateSql, 6);
        $mes = substr($dateSql, 3, -5);
        $dia = substr($dateSql, 0, -8);
        return $ano . "-" . $mes . "-" . $dia;
    }

    /**
     * Passe um campo com mascara ex: 2011-01-01, saida == 01/2011
     * @param string
     * @return string
     */
    public static function MesAnoEmPortugues($dateSql) {
        $ano = substr($dateSql, 0, -6);
        $mes = substr($dateSql, 5, -3);
        return $mes . " / " . $ano . ' ';
    }

    /**
     * Passe um campo com mascara ex: 01/01/2011, saida = 2011-01-31 ou 2010-01-31
     * @param string
     * @return string
     */
    public static function dataRetornaUltimoDiaMes($dateSql, $m = 0) {
        
        $ano = substr($dateSql, 1, -7);
        $mes = substr($dateSql, 6, -4);
        $dia = substr($dateSql, 8);
        
//        if ($m == 12) {
//            $mes1 = mktime(23, 59, 59, $mes - $m, date("t"), $ano);
//        } else {
            $mes1 = mktime(23, 59, 59, $mes - $m, date('d')-date('j'), $ano);
//        }
        $r = date('Y-m-d', $mes1);
        return $r;
    }

    /**
     * Passe um campo com mascara ex: 01/01/2011, saida = 2011-01-01 ou 2010-01-01
     * @param string
     * @return string
     */
    public static function dataRetornaPrimeiroDiaMes($dateSql, $m = 0) {
        $ano = substr($dateSql, 1, -7);
        $mes = substr($dateSql, 6, -4);

        $mes1 = mktime(0, 0, 0, $mes - $m, 1, $ano);
        $r = date('Y-m-d', $mes1);

        return $r;
    }

    /**
     * Passe um campo com mascara ex: 2011-01-01, saida == 01/01/2011
     * @param string
     * @return string
     */
    public static function dateTimeEmPortugues($dateSql,$time = false) {
        $ano = substr($dateSql, 0, -15);
        $mes = substr($dateSql, 5, -12);
        $dia = substr($dateSql, 8, -9);
        $hora = substr($dateSql, 11);
        if($time){
            return $dia . "/" . $mes . "/" . $ano . " " . $hora;
        } else {
            return $dia . "/" . $mes . "/" . $ano;
        }
        
    }

    /**
     * Passe um campo com mascara ex: 031.716.658-16, saida == 03171665816
     * @param string     
     * @return novo string(numero)
     */
    public static function somenteNumeros($variavel) {
        $variavel = str_replace(".", "", $variavel);
        $variavel = str_replace("-", "", $variavel);
        $variavel = str_replace("/", "", $variavel);
        $variavel = str_replace(" ", "", $variavel);
        $variavel = str_replace(" ", "", $variavel);
        return $variavel;
    }

    public static function subDiaIntoDate($date, $days) {
        $thisyear = substr($date, 0, 4);
        $thismonth = substr($date, 5, 2);
        $thisday = substr($date, 8, 2);
        $nextdate = mktime(0, 0, 0, $thismonth, $thisday - $days, $thisyear);
        return strftime("%Y-%m-%d", $nextdate);
    }

    # Lê os aquivos blob do firebird e escreve a 1 linha do arquivo    

    public static function removeLinhaBlob($variavel) {
        $binfo = ibase_blob_info($variavel);
        $bopen = ibase_blob_open($variavel);
        $texto = nl2br(trim(ibase_blob_get($bopen, $binfo[0])));

        $linha = explode('<br />', $texto);
        $novo = $linha[0];
        return $novo;
    }

    public static function bloparatext($variavel) {
        $binfo = ibase_blob_info($variavel);
        $bopen = ibase_blob_open($variavel);
        $texto = ibase_blob_get($bopen, $binfo[0]);

        return $texto;
    }

    # Lê os aquivos blob do firebird e escreve a 1 linha do arquivo    

    public static function pegarLinha($variavel, $i) {
        $linha = nl2br($variavel);
        $linha1 = explode('<br />', $linha);
        $novo = $linha1[$i];
        return $novo;
    }

    function addDayIntoDate($date, $days) {
        $thisyear = substr($date, 0, 4);
        $thismonth = substr($date, 4, 2);
        $thisday = substr($date, 6, 2);
        $nextdate = mktime(0, 0, 0, $thismonth, $thisday + $days, $thisyear);
        return strftime("%Y%m%d", $nextdate);
    }

    function subDayIntoDate($date, $days) {
        $thisyear = substr($date, 0, 4);
        $thismonth = substr($date, 4, 2);
        $thisday = substr($date, 6, 2);
        $nextdate = mktime(0, 0, 0, $thismonth, $thisday - $days, $thisyear);
        return strftime("%Y%m%d", $nextdate);
    }

    /**
     * ex: 
     * $json1 = unirArray($json1,$json2);
     * $json1 = unirArray($json1,$json3);
     */
    public static function unirArray($ar1, $ar2) {
        for ($index = 0; $index < count($ar2); $index++) {
            $ar1[] = $ar2[$index];
        }
        return $ar1;
    }

}

?>
