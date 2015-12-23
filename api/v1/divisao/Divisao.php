<?php

require_once "../lib/ClasseBase.php";

/**
* classe Divisao
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Divisao extends ClasseBase
{
    private $codigoDivisao;
    private $nome;

    function __construct()
    {
        require_once "../lib/Conexao.php";
    }

    public function getCodigo_divisao()
    {
        return $this->codigoDivisao;
    }

    public function setCodigo_divisao($codigo)
    {
        $this->codigoDivisao = $codigo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function inserir($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                    return false;
            }//if ($this->tokenEhValido($token) === false) {

            $nome  = $this->getNome();

            $sql   = "\n INSERT INTO divisao (";
            $sql  .= "\n nome";
            $sql  .= "\n ) VALUES (";
            $sql  .= "\n :nome";
            $sql  .= "\n )";

            $conexao = Conexao::getConexao(); 
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome",$nome);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }

    public function alterar($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                    return false;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo = $this->getcodigo_divisao();
            $nome   = $this->getNome();

            $sql   = "\n UPDATE divisao";
            $sql  .= "\n SET nome = :nome";
            $sql  .= "\n WHERE Codigo_divisao = :codigo";

            $conexao = Conexao::getConexao(); 
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome",$nome);
            $stmt->bindParam(":codigo",$codigo);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }

    public function excluir($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                    return false;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo = $this->getcodigo_divisao();

            $sql   = "\n DELETE"; 
            $sql  .= "\n FROM divisao";
            $sql  .= "\n WHERE codigo_divisao = :codigo";

            $conexao = Conexao::getConexao(); 
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo",$codigo);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }

    public static function listarPorCodigo($codigo)
    {
        try {
            $sql   = "\n SELECT codigo_divisao, nome";
            $sql  .= "\n FROM divisao";
            $sql  .= "\n WHERE codigo_divisao = :codigo";

            $conexao = Conexao::getConexao(); 		  
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo",$codigo);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }
        
    public static function listarPorNome($nome)
    {
        try {
            $nome .= "%";
            $sql   = "\n SELECT codigo_divisao, nome";
            $sql  .= "\n FROM divisao";
            $sql  .= "\n WHERE nome LIKE :nome";

            $conexao = Conexao::getConexao(); 		  
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome",$nome);
            $stmt->execute();
            $retorno =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }

    public static function listarTudo($strRequire = '../lib/Conexao.php')
    {     
        try {
            $sql   = "\n SELECT *";
            $sql  .= "\n FROM divisao";

            $conexao = Conexao::getConexao(); 		  
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $retorno =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }
    
    public static function listaDivisaoPorTime($strRequire = '../lib/Conexao.php', $intCodigo)
    {     
        try {
            $sql   = "\n SELECT d.codigo_divisao,d.nome";
            $sql  .= "\n FROM time.time AS t, time.divisao AS d";
            $sql  .= "\n WHERE  d.codigo_divisao = t.divisao_codigo_divisao";
            $sql  .= "\n AND t.codigo_time = :codigo";

            $conexao = Conexao::getConexao(); 		  
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $intCodigo);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }
}
