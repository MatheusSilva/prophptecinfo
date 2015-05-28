<?php
require_once('conexao.php');

/**
* classe Torcedor
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Torcedor
{
	private $codigo_torcedor; 
	private $nome;
	private $login;		
	private $senha;	
	
	public function getCodigoTorcedor()
	{
		return $this->codigoTorcedor;
	}
	
	public function setCodigoTorcedor($codigo)
	{
		$this->codigoTorcedor = $codigo;
	}
	
	public function getNome()
	{
		return $this->nome;
	}
	
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	
	public function getLogin()
	{
		return $this->login;
	}
	
	public function setLogin($login)
	{
		$this->login = $login;
	}
	
	public function getSenha()
	{
		return $this->senha;
	}
	
	public function setSenha($senha)
	{
		$this->senha = md5($senha);
	}
	
	public function inserir()
	{
		$nome  = $this->getNome();
		$login = $this->getLogin();
		$senha = $this->getSenha();
		
		$sql    = "\n INSERT INTO `time`.`torcedor`(";
		$sql   .= "\n nome";
		$sql   .= "\n ,login";
		$sql   .= "\n ,senha";
		$sql   .= "\n ) VALUES (";
		$sql   .= "\n :nome";
		$sql   .= "\n ,:login";
		$sql   .= "\n ,:senha";
		$sql   .= "\n )";

		$conexao = Conexao::getConexao(); 
		$conexao->beginTransaction();
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->bindParam(":login", $login);
		$stmt->bindParam(":senha", $senha);
		$retorno = $stmt->execute();
		$conexao->commit();
		$conexao = null;
		return $retorno;
	}
	
	public function alterar()
	{
		$codigo = $this->getCodigoTorcedor();
		$nome   = $this->getNome();
		$login  = $this->getLogin();
		$senha  = $this->getSenha();
		
		$sql    = "\n UPDATE torcedor";
		$sql   .= "\n SET nome 			    = :nome";
		$sql   .= "\n ,login   			    = :login"; 
		$sql   .= "\n ,senha   			    = :senha";
		$sql   .= "\n WHERE codigo_torcedor = :codigo";
				
		$conexao = Conexao::getConexao(); 
		$conexao->beginTransaction();
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->bindParam(":login", $login);
		$stmt->bindParam(":senha", $senha);
		$stmt->bindParam(":codigo", $codigo);
		$retorno = $stmt->execute();
		$conexao->commit();
		$conexao = null;
		return $retorno;
	}
	
	public function excluir($codigo)
	{
		$sql     = "\n DELETE";
		$sql    .= "\n FROM torcedor";
		$sql    .= "\n WHERE codigo_torcedor = :codigo";
				
		$conexao = Conexao::getConexao(); 
		$conexao->beginTransaction();
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":codigo", $codigo);
		$retorno = $stmt->execute();
		$conexao->commit();
		$conexao = null;
		return $retorno;
	}
	
	public static function listarPorCodigo($codigo)
	{
		$sql     = "\n SELECT *";
		$sql    .= "\n FROM torcedor";
		$sql    .= "\n WHERE codigo_torcedor = :codigo";
				
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":codigo", $codigo);
		$stmt->execute();
		$retorno =  $stmt->fetch(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;
	}
	
	public static function listarPorNome($nome)
	{
		$sql     = "\n SELECT *";
		$sql    .= "\n FROM torcedor";
		$sql    .= "\n WHERE nome LIKE :nome";
		
		$nome .= "%";
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->execute();
		$retorno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;	

	}
	
	public static function listarPorLogin($login)
	{
		$sql     = "\n SELECT *"; 
		$sql    .= "\n FROM torcedor"; 
		$sql    .= "\n WHERE login LIKE :login";
		
		$login  .= "%";
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":login", $login);
		$stmt->execute();
		$retorno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;	
	}
	
	public static function listarTudo()
	{
		$sql     = "\n SELECT *";
		$sql    .= "\n FROM torcedor";
		
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->execute();
		$retorno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;	
	}
}
