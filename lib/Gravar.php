<?php
/**
 * @author Maison K. Sakamoto <maison.sakamoto@gmail.com>
 * 
 * Gravar: Usado para gravar em arquivo txt.
 */
class Gravar{
        private $file;
        private $contexto;
        
        //Constructor define o nome do arquivo
        public function __construct($file) {
            $this->file = $file;      
            $this->contexto = fopen($this->file, "a");
            $this->fechar();
        }        
        
        //Fecha o arquivo
        private function fechar(){
            fclose($this->contexto);
        }
        
        //Deleta o arquivo antigo
        public function resetar($file) {
            @unlink($file);
        }
        
        //Escrever no arquivo
        public function escrever($string){
            //Abre o Arquivo somente escrita
            $this->contexto = fopen($this->file, "a");
            
            //grava a string no arquivo e retorna o tamanho do arquivo
            $r = fwrite($this->contexto, $string);
            $this->fechar();
            return $r;
        }
        
        public function getTexto(){
            //Abre o Arquivo somente leitura
            $this->contexto = fopen($this->file,'r');
            
            //Lê o arquivo
            $texto = fread($this->contexto, filesize($this->file));
            
            /*função nl2br (NEW LINHA TO BREAK) que transforma 
             * as quebras de linha em de um arquivo texto em etiquetas <br>*/
            return nl2br($texto);
        }
        
        public function isNull(){
            if(filesize($this->file)==0){
                return true;
            }
            else{
                return false;
            }
        }
        
        //Retorna o arquivo
        public function getArquivo(){
            return $this->file;
        }
    }
?>
