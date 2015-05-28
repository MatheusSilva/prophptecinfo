<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/tpladmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
		<script language="javascript" type="text/javascript" src="../../javascript/valida_time.js"> </script>
		<!-- InstanceBeginEditable name="doctitle" -->
		<title>Cat&aacute;logo de times</title>
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
				<a href="../paginas/administrar.php">Administrar</a> ::
				<a href="../paginas/consultas.php">Consultas</a> ::
				<a href="logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<form method="post" action="../adaptadores/adaptador.time.php"
				name="frmCadastro" id="frmCadastro" enctype="multipart/form-data" onSubmit="return valida(this);">
					<table>
						<tr>
							<td width="251">Nome do Time: </td>
							<td width="242">
								<input type="text" name="txtNome" id="txtNome" />
							</td>
						</tr>

						<tr>
							<td>Capa: </td>
							<td>
								<input type="file" name="txtFoto" id="txtFoto" />
							</td>
						</tr>
						
						<tr>
							<td>Divis&atilde;o: </td>
							<td>
								<select name="cmbDivisao" id="cmbDivisao">
								 <?php
									require_once('../classes/divisao.php');
									$vetor = Divisao :: listarTudo();
									
									foreach ($vetor as $dados) {
										$codigo_divisao = $dados['codigo_divisao'];
										$nome = $dados['nome'];
										echo "<option value=\"$codigo_divisao\">$nome</option>";
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
										$nome 			  = $dados['nome'];
										echo "<option value=\"$codigo_categoria\">$nome</option>";
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
										echo "<option value=\"$codigo_tecnico\">$nome</option>";
									}
								?>
								  
								</select>
							</td>                             
						</tr>
						
						<tr> 
							<td>Desempenho do time:</td>
								
							<td>
								<input name="rDesempenhotime" type="radio" value="Otimo" checked/> <label>Otimo</label> 
								<input name="rDesempenhotime" type="radio" value="Bom"/> <label>Bom</label> 
								<input name="rDesempenhotime" type="radio" value="Ruim"/> <label>Ruim</label> 
							</td>  
						</tr>
				
						<tr> 
							<td> comprar novos jogadores:</td>
							<td>
								<input type="radio" name="rComprarnovojogador" value="Sim" checked/> <label>Sim</label>
								<input type="radio" name="rComprarnovojogador" value="Nao" /> <label>Não</label>
							</td>
						</tr>
						
						<tr>
							<td height="41" colspan="2">&nbsp;</td>    
						</tr>
						
						<tr>
							<td colspan="2">
								<input type="hidden" name="acao" value="1" />
								
								<input type="submit" name="btnCadastrar" id="btnCadastrar"
									value="Cadastrar" />
									
								<input type="reset" name="btnLimpar" id="btnLimpar"
									value="Limpar" />                                 
							</td>
						</tr>
						
					</table>
					
				</form>
				
				<?php
					if(isset($_GET['msg'])) {
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
