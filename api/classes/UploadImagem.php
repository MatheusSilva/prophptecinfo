<?php

namespace sistemaRest\api\classes;

/**
* classe UploadImagem
*
* @author    Matheus Silva
* @copyright © Copyright 2010 Matheus Silva. Todos os direitos reservados.
*/
abstract class UploadImagem extends Upload
{
	public static function validarTipo($tipo)
	{
		if ($tipo == 'images/bmp'
			|| $tipo=='images/jpeg'
			|| $tipo=='images/gif'
			|| $tipo=='images/png'
		) {
			return true;
		} else {
			return false;
		}	
	}
	
	public static function validarTamanho($tamanho)
	{
		if ($tamanho <= 512000) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function enviar($nome, $arquivo)
	{
		//faz upload para o servidor
		$extensao = substr($arquivo['name'], strlen($arquivo['name'])-4, 4);
		
		if (substr($extensao, 0, 1) !== '.') {
			$extensao = '.'.$extensao;
		}
		
		$nome = md5(uniqid($nome.rand(), true));
		$nome = trim(substr($nome, 13, 10));

		$caminho = "../adm/fotos/$nome$extensao";
                
		if ($arquivo['error'] == 0) {
			copy($arquivo['tmp_name'], $caminho);
			return $caminho;
		} else {
			return '0';	
		}
	}
}
