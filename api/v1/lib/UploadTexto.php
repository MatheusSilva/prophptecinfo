<?php
namespace lib;

/**
* classe UploadTexto
*
* @author    Matheus Silva
* @copyright © Copyright 2010 Matheus Silva. Todos os direitos reservados.
*/
abstract class UploadTexto
{
    public static function validarTipo($tipo)
    {
        if ($tipo == 'application/msword'
            || $tipo == 'application/pdf'
            || $tipo == 'text/plain'
            || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function validarTamanho($tamanho)
    {
        if ($tamanho <= 409600) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function enviar($nome, $arquivo)
    {
        //faz upload para o servidor
        $extensao = substr($arquivo['name'], strlen($arquivo['name'])-4, 4);
        
        if (substr($extensao, 0, 1) !='.') {
            $extensao = '.'.$extensao;
        }
    
        $caminho = "../arquivos/textos/$nome$extensao";
        
        if ($arquivo['error'] == 0) {
            copy($arquivo['tmp_name'], $caminho);
            return $caminho;
        } else {
            return '0';
        }
    }
}
