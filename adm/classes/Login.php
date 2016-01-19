<?php

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
	    require_once "../classes/Conexao.php";
	    require_once "../classes/Torcedor.php";

	    $objTorcedor = new Torcedor();

	    $objTorcedor->setSenha($senha);
	    $senha = $objTorcedor->getSenha();

		$sql   = "\n SELECT nome, login";
		$sql  .= "\n FROM torcedor";
		$sql  .= "\n WHERE login = :torcedor";
		$sql  .= "\n AND senha = :senha";
				  
		$conexao = Conexao::getConexao(); 		  
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(":torcedor", $torcedor);
		$stmt->bindParam(":senha", $senha);
		$stmt->execute();
		$retornoSelect =  $stmt->fetch(\PDO::FETCH_ASSOC);
                
		if (empty($retornoSelect) === false) {
	        $sql   = "\n UPDATE torcedor";
	        $sql  .= "\n SET token   = :token";
	        $sql  .= "\n WHERE login = :torcedor";
	        $sql  .= "\n AND senha   = :senha";

	        $salt1 = "jcxzknhxjajduhlJHDGHAQZkhyhmnk789553";
	        $salt2 = "893343hjgsjhbjlAHLKJHIDJiertokrjtkr";
	        $rand = uniqid(rand(), true);

	        $token = hash('sha256', $salt1.$rand.$senha.$salt2);

	        $stmt = $conexao->prepare($sql);
	        $stmt->bindParam(":token", $token);
	        $stmt->bindParam(":torcedor", $torcedor);
	        $stmt->bindParam(":senha", $senha);
	        $retornoUpdate = $stmt->execute();
	        

	        if ($retornoUpdate) {
	            session_start();
	            $_SESSION['logado'] 	  	  = 'ok';
	            $_SESSION['u']                = $retornoSelect['login'];
	            $_SESSION['nomeTorcedor']     = $retornoSelect['nome'];
	            $conexao = null;
	            setcookie("token", $token, time()+900, "/");
	            header('location:../paginas/home.php');
	        } else {
	            $msg = urlencode('Login falhou! Verifique seus dados');
	            $conexao = null;
	            header("location:../formularios/form.login.php?msg=$msg");
	        }
		} else {
			$conexao = null;
			$msg = urlencode('Login falhou! Verifique seus dados');
			header("location:../formularios/form.login.php?msg=$msg");
		}
	}
	
	public static function verificar()
	{
		session_start();
		
		if (!isset($_SESSION['logado']) || $_SESSION['logado'] != 'ok') {
			$msg = urlencode('Acesso restrito. Efetue login para continuar');
			header("location:../formularios/form.login.php?msg=$msg");
		}
	}
	
	public static function sair()
	{
	    require_once "../classes/Conexao.php";
        $sql   = "\n UPDATE torcedor";
        $sql  .= "\n SET    token = :token";
        $sql  .= "\n WHERE  login = :torcedor";
        
        $token = "h";
        
        session_start();
        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":torcedor", $_SESSION['u']);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        $conexao = null;
		session_destroy();
		header('location:../../site/paginas/home.php');
	}
}