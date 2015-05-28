<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tplgeral.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Cat&aacute;logo de times</title>
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
                <h2>Lista de Times</h2>
                <?php
					require_once('../../adm/classes/time.php');
					$vetor = Time :: listarTudo();
					if($vetor != 0)
						foreach($vetor as $dados){
							$codigo = $dados['codigo_time'];
							$nome = $dados['nome'];
							$capa = $dados['capa'];
							echo '<div class="cada_time">';
							$link = "<a href=\"detalhe.time.php?codigo=$codigo\">$nome</a>";
							echo '<table><tr><td>';
							echo "<img src=\"$capa\" class=\"miniatura\" alt=\"$nome\" /></td></tr>";
							echo "<tr><td>$link</td></tr></table>";
							echo '</div>';
						}
					else
						echo 'Nenhum time cadastrado';
				?>
                <!-- InstanceEndEditable -->
            </div>
        </div>
        <div id="rodape">
        	
        </div>       	
    </div>
</body>
<!-- InstanceEnd --></html>
