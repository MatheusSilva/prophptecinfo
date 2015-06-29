<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- InstanceBeginEditable name="doctitle" -->
		<title>Cat&aacute;logo de Jogos</title>
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="head" -->
		<link rel="stylesheet" type="text/css" href="../../css/layoutadm.css" />
		<!-- InstanceEndEditable -->
	</head>
	
	<body>
		<div id="geral">
			<div id="cabecalho">
			</div>
			
			<div id="menu_superior">
				<a href="../paginas/home.php">Home</a> ::
				<a href="../paginas/cadastros.php">Cadastros</a> ::
				<a href="../paginas/consultas.php">Consultas</a> ::
				<a href="logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<h2>Detalhe de Torcedor</h2>
				<?php
					require_once('../classes/Torcedor.php');
					$codigo = $_GET['codigo'];
					$dados  = Torcedor::listarPorCodigo($codigo);
					
					if ($dados != 0) {
						$codigo_torcedor = $dados['codigo_torcedor'];
						$nome 			 = $dados['nome'];
						$login 		 	 = $dados['login'];
						echo "C&oacute;digo: $codigo_torcedor <br/>";
						echo "Nome: $nome <br/>";
						echo "Login: $login <br/>";
					} else {
						echo 'Login n&atilde;o encontrado';
					}	
				?>
				<!-- InstanceEndEditable -->
			</div>
			
			<div id="rodape">
				
			</div>       	
		</div>
	</body>
	<!-- InstanceEnd -->
</html>
