<?php
require_once('../classes/login.php');
Login :: verificar();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
		<!-- InstanceBeginEditable name="doctitle" -->
		<title>Cat&aacute;logo de Times</title>
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
				<a href="home.php">Home</a> ::
				<a href="cadastros.php">Cadastros</a> ::
				<a href="administrar.php">Administrar</a> ::
				<a href="consultas.php">Consultas</a> ::
				<a href="../formularios/logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<ul>
					<li><a href="../admin/lista.tecnico.htm">Adminsitrar Tecnico</a></li>
					<li><a href="../admin/lista.time.htm">Adminsitrar Time</a></li>
					<li><a href="../admin/lista.categoria.htm">Adminsitrar categoria</a></li>
					<li><a href="../admin/lista.divisao.htm">Adminsitrar divisao</a></li>
				</ul>
				<!-- InstanceEndEditable -->
			</div>
			
			<div id="rodape">
				
			</div>       	
		</div>
	</body>
	<!-- InstanceEnd -->
</html>
