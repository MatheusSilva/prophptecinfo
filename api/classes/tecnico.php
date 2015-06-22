<?php

/**
* classe Tecnico
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Tecnico
{
	private $codigoTecnico;
	private $nome;
	private $data;

        function __construct() 
        {
            require_once '../adm/classes/conexao.php';
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
			
	public function inserir()
	{
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
	}
	
	public function alterar()
	{
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
	}
	
	public function excluir()
	{
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
	}
	
	public static function listarPorCodigo($codigo)
	{
		$sql   = "\n SELECT codigo_tecnico,nome,data_nascimento";
		$sql  .= "\n FROM tecnico";
		$sql  .= "\n WHERE codigo_tecnico = :codigo";
		
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":codigo",$codigo);
		$stmt->execute();
		$retorno =  $stmt->fetch(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;
	}
	
	public static function listarPorNome($nome)
	{
		$nome .= "%";
		$sql   = "\n SELECT *";
		$sql  .= "\n FROM tecnico";
		$sql  .= "\n WHERE nome LIKE :nome";
                
                require_once '../classes/conexao.php';
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":nome",$nome);
		$stmt->execute();
		$retorno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;
	}
	
	public static function listarTudo($strRequire = '../adm/classes/conexao.php')
	{ 
		$sql   = "\n SELECT *";
		$sql  .= "\n FROM tecnico";

                require_once $strRequire;
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->execute();
		$retorno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;
	}
}
	