<?php
    use sistemaRest\adm\classes\Login;
    require '../../biblioteca/SplClassLoader.php';
    $classLoader = new \SplClassLoader('sistemaRest\adm\classes');
    $classLoader->register();
    Login::verificar();
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
					<li><a href="../consultas/consulta.nometime.htm">Consultar Time por nome</a></li>
					<li><a href="../consultas/consulta.nometecnico.htm">Consultar Tecnico por nome</a></li>
					<li><a href="../consultas/consulta.nomecategoria.htm">Consultar categoria por nome</a></li>
					<li><a href="../consultas/consulta.nomedivisao.htm">Consultar divisao  por nome</a></li>
				</ul>
				<!-- InstanceEndEditable -->
			</div>
			
			<div id="rodape">
				
			</div>
		</div>
	</body>
	
	<!-- InstanceEnd -->
</html>
