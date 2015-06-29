<?php
namespace sistemaRest\api\classes;

/**
* classe Upload
*
* @author    Matheus Silva
* @copyright © Copyright 2010 Matheus Silva. Todos os direitos reservados.
*/
abstract class Upload
{

	public static abstract function validarTipo($tipo);
	
	public static abstract function validarTamanho($tamanho);
	
	public static abstract function enviar($nome, $arquivo);
}
