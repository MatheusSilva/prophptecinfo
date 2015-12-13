<?php

require_once "../lib/ClasseBase.php";

/**
* classe Tecnico
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Tecnico extends ClasseBase
{
    private $codigoTecnico;
    private $nome;
    private $data;

    function __construct() 
    { 
        require_once "../lib/Conexao.php";
    }

    public function getCodigoTecnico() 
    {
        return $this->codigoTecnico;
    }

    public function setCodigoTecnico($codigoTecnico) 
    {
        $this->codigoTecnico = $codigoTecnico;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function getData() 
    {
        return $this->data;
    }

    public function setData($data) 
    {
        $this->data = $data;
    }

    public function inserir($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                return false;
            }//if ($this->tokenEhValido($token) === false) {

            $nome  = $this->getNome();
            $data  = $this->getData();

            $sql   = "\n INSERT INTO tecnico(";
            $sql  .= "\n  nome";
            $sql  .= "\n ,data_nascimento";
            $sql  .= "\n ) VALUES (";
            $sql  .= "\n  :nome";
            $sql  .= "\n ,:data";
            $sql  .= "\n )";

            $conexao = Conexao::getConexao(); 
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome",$nome);
            $stmt->bindParam(":data",$data);
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
            if ($this->tokenEhValido($token) !== true) {
                return false;
            }//if ($this->tokenEhValido($token) === false) {
            
            $codigo = $this->getCodigoTecnico();
            $nome 		   = $this->getNome();

            $sql   = "\n UPDATE tecnico";
            $sql  .= "\n SET nome = :nome";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

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
            
            $codigo = $this->getCodigoTecnico();
            $sql   = "\n DELETE";
            $sql  .= "\n FROM tecnico";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

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
            $sql   = "\n SELECT codigo_tecnico,nome,data_nascimento";
            $sql  .= "\n FROM tecnico";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

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
            $sql   = "\n SELECT codigo_tecnico,nome";
            $sql  .= "\n FROM tecnico";
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
            $sql  .= "\n FROM tecnico";

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
    
    public static function listaTecnicoPorTime($strRequire = '../lib/Conexao.php', $intCodigo)
    {     
        try {
            $sql   = "\n SELECT tec.codigo_tecnico,tec.nome";
            $sql  .= "\n FROM time.time AS t, time.tecnico AS tec";
            $sql  .= "\n WHERE  tec.codigo_tecnico = t.tecnico_codigo_tecnico";
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
	