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
				<a href="logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				
				<h2>Alterar Dados de Time</h2>
				
				
					
				<form method="post" 
				action="../adaptadores/adaptador.time.php"
				name="frmCadastro"
				id="frmCadastro" enctype="multipart/form-data">
				
					<table>
						<tr>
							<td>Nome:</td>
							<td>
								<?php
									$nomeTime = "";

									if (isset($_REQUEST['codigo']) ) {
										$codigo = $_REQUEST['codigo'];
										require_once('../classes/time.php');
										$dados1 = Time :: listarPorCodigo($codigo);
										$nomeTime = $dados1["nomeTime"];	
									}

									echo "<input type=\"text\" name=\"txtNome\" id=\"txtNome\" value=\"$nomeTime\" />";
								?>
								
							</td>
						</tr>

						<tr>
							<tr>
								<td>Capa: </td>
								<td>
									<input type="file" name="txtFoto" id="txtFoto" />
								</td>
							</tr>

							<td>Divis&atilde;o: </td>
							
							<td>
								<select name="cmbDivisao" id="cmbDivisao">
									<!-- <option selected value="Selecione"></option> --> 
									<?php
									require_once('../classes/divisao.php');
									$vetor = Divisao :: listarTudo();
									
									foreach ($vetor as $dados) {
										$codigo_divisao = $dados['codigo_divisao'];
										$codigoDivisaoAntigo = ""; 
										$nome = $dados['nome'];

										if (isset($_REQUEST['codigo']) ) {
											$codigo = $_REQUEST['codigo'];
											require_once('../classes/time.php');
											$dados1 = Time :: listarPorCodigo($codigo);
											$codigoDivisaoAntigo = $dados1["codigoDivisao"];
										}

										if ($codigo_divisao === $codigoDivisaoAntigo) {
											echo "<option selected value=\"$codigo_divisao\">$nome</option>";
										} else {	
											echo "<option value=\"$codigo_divisao\">$nome</option>";
										}
									}
									?>

								</select>
							</td>
						</tr>
					
						<tr>
							<td>Categoria: </td>
							<td>
								<select name="cmbCategoria" id="cmbCategoria">
									<?php
									require_once('../classes/categoria.php');
									$vetor = Categoria :: listarTudo();
									
									foreach ($vetor as $dados) {
										$codigo_categoria = $dados['codigo_categoria'];
										$codigoCategoriaAntiga = ""; 
										$nome = $dados['nome'];

										if (isset($_REQUEST['codigo']) ) {
											$codigo = $_REQUEST['codigo'];
											require_once('../classes/time.php');
											$dados1 = Time :: listarPorCodigo($codigo);
											$codigoCategoriaAntiga = $dados1["codigoCategoria"];
										}

										if ($codigo_categoria === $codigoCategoriaAntiga) {
											echo "<option selected value=\"$codigo_categoria\">$nome</option>";
										} else {	
											echo "<option value=\"$codigo_categoria\">$nome</option>";
										}
									}

									?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td>Tecnico: </td>
							<td>
								<select name="cmbTecnico" id="cmbTecnico">
								<?php
									require_once('../classes/tecnico.php');
									$vetor = Tecnico :: listarTudo();
									
									foreach ($vetor as $dados) {
										$codigo_tecnico = $dados['codigo_tecnico'];
										$nome 			= $dados['nome'];
										$codigoTecnicoiaAntigo = ""; 

										if (isset($_REQUEST['codigo']) ) {
											$codigo = $_REQUEST['codigo'];
											require_once('../classes/time.php');
											$dados1 = Time :: listarPorCodigo($codigo);
											$codigoTecnicoiaAntigo = $dados1["codigoTecnico"];
										}

										if ($codigo_tecnico === $codigoTecnicoiaAntigo) {
											echo "<option selected value=\"$codigo_tecnico\">$nome</option>";
										} else {	
											echo "<option value=\"$codigo_tecnico\">$nome</option>";
										}
									}
								?>
								</select>
							</td>                             
						</tr>

						<tr>
							<td colspan="2">
								<input type="hidden" name="acao" value="2" />
								
								<?php
									if (isset($_REQUEST['codigo']) ) {
										$codigo = $_REQUEST['codigo'];
										require_once('../classes/time.php');
										$dados1 = Time :: listarPorCodigo($codigo);
										$codigotime = $dados1["codigotime"];	
										echo "<input type=\"hidden\" name=\"codigo\" value=\"$codigotime\" />";
									}
								?>

								<input type="submit" name="btnAlterar" 
									value="Alterar" id="btnAlterar" />
									
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
