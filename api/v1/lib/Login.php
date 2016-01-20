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
	    require_once "Conexao.php";
	    require_once "../../api/v1/torcedor/Torcedor.php";

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
	            if (!isset($_SESSION))  {
					session_start();
				}

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
	
	public static function verificar($redirecionar = true)
	{
		if (!isset($_SESSION))  {
			session_start();
		}
		
		if (!isset($_SESSION['logado']) 
		|| $_SESSION['logado'] != 'ok' 
		|| !isset($_COOKIE['token'])) {
			self::sair($redirecionar);

			if ($redirecionar) {
				$msg = urlencode('Acesso restrito. Efetue login para continuar');
				header("location:../formularios/form.login.php?msg=$msg");
			}

		} else {
			$token = $_COOKIE["token"];
			setcookie("token", $token, time()+900, "/");
		}
	}
	
	public static function sair($redirecionar = true)
	{
		if (!isset($_SESSION))  {
			session_start();
		}

		setcookie('token', null, -1, '/');
		$_SESSION['logado'] = '';
	    
        $sql   = "\n UPDATE torcedor";
        $sql  .= "\n SET    token = :token";
        $sql  .= "\n WHERE  login = :torcedor";
        
        $token = "h";
        
        require_once 'Conexao.php';
        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":torcedor", $_SESSION['u']);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        $conexao = null;
		session_destroy();

		if ($redirecionar) {
			header('location:../../site/paginas/home.php');
		}

	}
}