<?php
namespace lib;

/**
* classe Conexao
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
abstract class Conexao
{
    private static $objConexao = null;

    public static function getConexao()
    {
        $strHost = "mysql:host=127.0.0.1;dbname=time";
        $strUsuario = "root";
        $strSenha = "";

        if (!isset(self::$objConexao)) {
            self::$objConexao = new \PDO(
                $strHost,
                $strUsuario,
                $strSenha,
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        }

        self::$objConexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$objConexao->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);

        return self::$objConexao;
    }
}
