<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Cat&aacute;logo de Jogos</title>
		<link rel="stylesheet" type="text/css" href="../../css/layoutadm.css" />
		<script language="javascript" type="text/javascript" src="../../javascript/jquery-2.1.4.min.js"> </script>
		<script language="javascript" type="text/javascript" src="../../javascript/categoria.js"> </script>
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
				<h2>Excluir Dados de Categoria</h2>
				
				<?php
					$codigo = $_GET['codigo'];
					require_once('../classes/categoria.php');
					$dados = Categoria::listarPorCodigo($codigo);
				?>
				
				<div id="form">
					<table>
						<tr>
							<td>Nome:</td>
							<td>
								<input type="text" name="txtNome" id="txtNome" readonly=1 value="<?php echo $dados['nome']; ?>" />
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
								
								
								<input type="hidden" name="codigo" id="codigo"
										value="<?php echo $dados['codigo_categoria']; ?>" />
													
								<input id="btnExcluir" name="btnExcluir" type="button" value="Excluir" />			
							</td>
						</tr>
					</table>
				</div>
				
				<div id="mensagem" name="mensagem"></div>
				<!-- InstanceEndEditable -->
			</div>
			
			<div id="rodape">
				
			</div>       	
		</div>
	</body>
	<!-- InstanceEnd -->
</html>
