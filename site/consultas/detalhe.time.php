<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tplgeral.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Cat&aacute;logo de Times</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet" type="text/css" href="../../css/layoutgeral.css" />
<!-- InstanceEndEditable -->
</head>
<body>
	<div id="geral">
    	<div id="cabecalho">
        </div>
        <div id="menu_superior">
        	<a href="../paginas/home.php">Home</a> ::
            <a href="../../adm/formularios/cadastro.torcedor.php">Cadastrar-se</a> ::
            <a href="lista.time.php">Consultas</a> ::            
            <a href="../../adm/paginas/home.php">Entrar</a>
        </div>
        <div id="conteudo">
        	<div id="menu_lateral">
            
            </div>
            <div id="texto">
				<!-- InstanceBeginEditable name="conteudo" -->
				<h2>Detalhe de Time</h2>
                <?php
                	require_once('../../adm/classes/time.php');
					$codigo = $_GET['codigo'];
					$dados = Time :: listarPorCodigo($codigo);
					
					if($dados != 0){
						//$codigo_time = $dados['codigo_time'];
						$nome = $dados['nomeTime'];
						$codigo_tecnico = $dados['nomeTecnico'];
						$codigo_categoria = $dados['nomeCategoria'];
						$codigo_divisao = $dados['nomeDivisao'];
						$capa = $dados['capa'];
						
						echo '<div id="capa">';
						echo "<img src=\"$capa\" alt=\"$nome\" class=\"normal\" />";
						echo '</div>';
						
						echo "<span class=\"destaque\">Codigo time: </span> $codigo<br />";
						echo "<span class=\"destaque\">Capa: </span> $capa<br />";
						echo "<span class=\"destaque\">Nome: </span> $nome<br />";
						echo "<span class=\"destaque\">tecnico: </span> $codigo_tecnico <br />";
						echo "<span class=\"destaque\">Categoria: </span> $codigo_categoria<br />";
						echo "<span class=\"destaque\">Divisao: </span> $codigo_divisao";
					}else
						echo 'Time n&atilde;o encontrado';
				?>
                <!-- InstanceEndEditable -->
            </div>
        </div>
        <div id="rodape">
        	
        </div>       	
    </div>
</body>
<!-- InstanceEnd --></html>
