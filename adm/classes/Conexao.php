<?php


/**
* classe Conexao
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
abstract class Conexao
{
	private static $objConexao = null;

	public static function  getConexao()
	{

        if (!isset(self::$objConexao)) {
            self::$objConexao = new \PDO(
            	'mysql:host=localhost;dbname=time'
				, 'root'
				, ''
				, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);
        }

		return self::$objConexao;
	}
}
