<?php
require_once('conexao.php');

/**
* classe Login
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Login
{
	public static function entrar($torcedor, $senha)
	{
		$senha = md5($senha);
		$sql   = "\n SELECT nome";
		$sql  .= "\n FROM torcedor";
		$sql  .= "\n WHERE login = :torcedor";
		$sql  .= "\n AND senha = :senha";
				  
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":torcedor", $torcedor);
		$stmt->bindParam(":senha", $senha);
		$stmt->execute();
		$retorno =  $stmt->fetch(PDO::FETCH_ASSOC);
		$conexao = null;
		
		if (empty($retorno) === false) {
			session_start();
			$_SESSION['logado'] 	  = 'ok';
			$_SESSION['nomeTorcedor'] = $retorno['nome'];
			header('location:../paginas/home.php');
		} else {
			$msg = urlencode('Login falhou! Verifique seus dados');
			header("location:../formularios/form.login.php?msg=$msg");
		}
	}
	
	public static function verificar()
	{
		session_start();
		
		if (!isset($_SESSION['logado']) || $_SESSION['logado'] != 'ok') {
			$msg= urlencode('Acesso restrito. Efetue login para continuar');
			header("location:../formularios/form.login.php?msg=$msg");
		}
	}
	
	public static function sair()
	{
		session_start();
		session_destroy();
		header('location:../../site/paginas/home.php');
	}
}