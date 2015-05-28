<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
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
				<a href="../formularios/logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<h2>Detalhe de Time</h2>
				<?php
					require_once('../classes/time.php');
					$codigo = $_GET['codigo'];
					$dados  = Time :: listarPorCodigo($codigo);
					
					if ($dados != 0) {
						$codigo 			= $dados['codigotime'];
						$nome 				= $dados['nomeTime'];
						$divisao 			= $dados['nomeDivisao'];
						$tecnico 			= $dados['nomeTecnico'];
						$categoria 			= $dados['nomeCategoria'];
						$desempenhotime 	= $dados['nomeDesempenhoTime'];
						$comprarnovojogador = $dados['NomeComprarNovoJogador'];
						
						echo "C&oacute;digo: $codigo <br/>";
						echo "Nome: $nome <br/>";
						echo "Tecnico: $tecnico <br/>";
						echo "Divisao: $divisao <br/>";
						echo "Categoria: $categoria <br/>";
						echo "Desempenho do time: $desempenhotime <br/>";
						echo "Comprar novos jogadores: $comprarnovojogador <br/>";
					} else {
						echo 'Time n&atilde;o encontrado';
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
