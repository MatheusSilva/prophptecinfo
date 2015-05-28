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
				var ok = window.confirm("Você tem certeza?");
				
				if (ok)	{	
					location.href="../adaptadores/adaptador.torcedor.php?acao=3&codigo=" + codigo;
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
				<a href="../paginas/consultas.php">Consultas</a> ::
				<a href="../formularios/logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<h2>Consulta por nome dos torcedores</h2>
				
				<form method="get" action="consulta.nometorcedor.php"
						name="frmConsulta" id="frmConsulta">
					Nome: <input type="text" name="txtNome" id="txtNome" />
					<input type="submit" name="btnConsultar" value="Consultar" />
				</form>
				
				<?php
					if (isset($_GET['msg'])) {
						echo urldecode($_GET['msg']);
					}	
				?>
				
				<table width="80%" class="lista">
					<tr class="primeira_linha">
						<td>C&oacute;digo</td>
						<td>Nome</td>
						<td>A&ccedil;&otilde;es</td>
					</tr>
					
					<?php
					if (isset($_GET['btnConsultar'])) {						
						require_once('../classes/torcedor.php');
						$vetor = Torcedor :: listarPorNome($_GET['txtNome']);
						
						if ($vetor != 0) {
							// lista os torcedores
							$linha = 0;
							
							foreach ($vetor as $info) {								
								if (++$linha % 2 == 0) {
									echo '<tr class="linha_par">';
								} else {
									echo '<tr class="linha_impar">';								
								}
								
								$codigo = $info['codigoTorcedor'];
								$nome 	= $info['nome'];
								echo "<td>$codigo</td>";
								echo "<td>$nome</td>";
								
								$detalhes = "<a href=\"../consultas/detalhe.torcedor.php?codigo=$codigo\">[D]</a>";
								$alterar = "<a href=\"../formularios/alterar.torcedor.php?codigo=$codigo\">[A]</a>";
								$excluir = "<a href=\"javascript:confirmar($codigo)\">[X]</a>";
								
								echo "<td>$detalhes $alterar $excluir</td>";
								echo '</tr>';
							}
						} else {
							echo 'Nenhum torcedor cadastrado';
						}	
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
