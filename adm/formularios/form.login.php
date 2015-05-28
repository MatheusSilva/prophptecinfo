<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
		<script language="javascript" src="../../javascript/valida_login.js"> </script>
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
				<div id="menu_superior">
				<a href="../../site/paginas/home.php">Home</a> ::
            	<a href="../formularios/cadastro.torcedor.php">Cadastrar-se</a> ::
           	 	<a href="../../site/consultas/lista.time.php">Consultas</a> ::   
				 <a href="../../adm/paginas/home.php">Entrar</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<h2>Login</h2>
				
				<form method="post" 
				action="../adaptadores/adaptador.login.php"
				name="frmLogin"
				id="frmLogin" OnSubmit="valida(this);">
					<table>
						<tr>
							<td>Login:</td>
							<td>
								<input type="text" name="txtTorcedor" id="txtTorcedor" />
							</td>
						</tr>
						
						<tr>
							<td>Senha:</td>
							<td>
								<input type="password" name="txtSenha" id="txtSenha" />
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
								<input type="submit" name="btnAcessar" 
									value="Acessar" id="btnAcessar" />
									
								<input type="reset" name="btnLimpar"
									value="Limpar" id="btnLimpar" />
							</td>
						</tr>
					</table>
				</form>
				
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
