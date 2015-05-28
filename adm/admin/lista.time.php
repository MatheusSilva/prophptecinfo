<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- InstanceBeginEditable name="doctitle" -->
		<title>Cat&aacute;logo de Jogos</title>
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="head" -->
		<link rel="stylesheet" type="text/css" href="../../css/layoutadm.css" />
		
		<script language="javascript" type="text/javascript">
			function confirmar(codigo)
			{
				var ok = window.confirm("Você tem certeza que deseja excluir?");
				
				if (ok)	{	
					location.href="../adaptadores/adaptador.time.php?acao=3&codigo=" + codigo;
				}
			}
		</script>
		<!-- InstanceEndEditable -->
	</head>
	
	<body>
		<div id="geral">
			<div id="cabecalho">
			</div>
			
			<div id="menu_superior">
				<a href="../paginas/home.php">Home</a> ::
				<a href="../paginas/cadastros.php">Cadastros</a> ::
				<a href="../paginas/administrar.php">Administrar</a> ::
				<a href="../paginas/consultas.php">Consultas</a> ::
				<a href="../formularios/logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<h2>Lista de Times</h2>
				<?php
					if (isset($_GET['msg'])) {
						echo urldecode($_GET['msg']);
					}
				?> 
				
				<table width="80%" class="lista">
					<tr class="primeira_linha">
						<td>C&oacute;digo</td>
						<td>Nome</td>
						<td>Divis&atilde;o:</td>
					</tr>
					<?php
						require_once('../classes/time.php');
						$vetor = Time::listarTudo();
						
						if ($vetor != 0) {
							// lista as times
							$linha = 0;
							
							foreach ($vetor as $info) { 								
								if (++$linha % 2 == 0) {
									echo '<tr class="linha_par">';
								} else {
									echo '<tr class="linha_impar">';								
								}
								
								$codigo   = $info['codigo_time'];
								$nome 	  = $info['nome'];
								//$codigo_divisao = $info['codigo_divisao'];
								echo "<td>$codigo</td>";
								echo "<td>$nome</td>";
								
								$detalhes = "<a href=\"../consultas/detalhe.time.php?codigo=$codigo\">[D]</a>";
								$alterar  = "<a href=\"../formularios/alterar.time.php?codigo=$codigo\">[A]</a>";
								$excluir  = "<a href=\"javascript:confirmar($codigo)\">[X]</a>";
								
								echo "<td>$detalhes $alterar $excluir</td>";
								echo '</tr>';
							}
						} else {
							echo 'Nenhuma time cadastrado';
						}	
					?>
				</table>
					
				<!-- InstanceEndEditable -->
			</div>
			
			<div id="rodape">
				
			</div>
			
		</div>
	</body>
	<!-- InstanceEnd -->
</html>
