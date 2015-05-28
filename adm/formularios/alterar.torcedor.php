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
				<h2>Alterar Dados de torcedor</h2>
				
				<?php
					$codigo = $_GET['codigo'];
					require_once('../classes/torcedor.php');
					$dados = Torcedor :: listarPorCodigo($codigo);
				?>
				
				<form method="post" 
					  action="../adaptadores/adaptador.torcedor.php"
					  name="frmCadastro"
					  id="frmCadastro">
					  
					<table>
						<tr>
							<td>Nome:</td>
							<td>
								<input type="text" name="txtNome" id="txtNome" value="<?php echo $dados['nome']; ?>" />
							</td>
						</tr>
						
						<tr>
							<td>Login:</td>
							<td>
								<input type="text" name="txtLogin" id="txtLogin" value="<?php echo $dados['login']; ?>" />
							</td>
						</tr>
						
						<tr>
							<td>Senha:</td>
							<td>
								<input type="password" name="txtSenha" id="txtSenha" value="" />
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
								<input type="hidden" name="acao" value="2" />
								<input type="hidden" name="codigo" value="<?php echo $dados['codigo_torcedor']; ?>" />                         
								<input type="submit" name="btnAlterar" value="Alterar" id="btnAlterar" /> 
								<input type="reset" name="btnLimpar" value="Limpar" id="btnLimpar" />
							</td>
						</tr>
						
					</table>
				</form>
				
				<!-- falta a senha--!>
				<?php
					if (isset($_GET['msg'])) {
						echo urldecode($_GET['msg']);
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
