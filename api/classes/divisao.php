<?php


/**
* classe Divisao
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Divisao
{
	private $codigoDivisao;
	private $nome;
	
        function __construct()
        {
            require_once '../adm/classes/conexao.php';
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
	
	public function inserir()
	{
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
	}
	
	public function alterar()
	{
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
	}
	
	public function excluir()
	{
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
	}
	
	public static function listarPorCodigo($codigo)
	{
		$sql   = "\n SELECT *";
		$sql  .= "\n FROM divisao";
		$sql  .= "\n WHERE codigo_divisao = :codigo";

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
		$sql  .= "\n FROM divisao";
		$sql  .= "\n WHERE nome LIKE :nome";

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
                require_once $strRequire;
                
		$sql   = "\n SELECT *";
		$sql  .= "\n FROM divisao";

		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->execute();
		$retorno =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conexao = null;
		return $retorno;		
	}
}
