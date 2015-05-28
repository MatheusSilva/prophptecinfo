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
				<a href="../paginas/administrar.php">Administrar</a> :: 
				<a href="../paginas/consultas.php">Consultas</a> ::
				<a href="logout.php">Sair</a>
			</div>
			
			<div id="conteudo">
				<!-- InstanceBeginEditable name="conteudo" -->
				<table>
					<tr>
						<td>Nome do Jogo: </td>
						<td>
							<input type="text" name="txtNome" id="txtNome"/>
						</td>
					</tr>
				   
					<tr>
						<td>Ano: </td>
						<td>
							<input type="text" name="txtAno" id="txtAno" />
						</td>
					</tr>
				  
					<tr>
						<td>Capa: </td>
						<td>
							<input type="file" name="txtFoto" id="txtFoto" />
						</td>
					</tr>
					
					<tr>
						<td>g&ecirc;nero: </td>
						<td>
							<select name="cmbGenero" id="cmbGenero">
							<?php
								require_once('../classes/divisao.php');
								$vetor = Genero :: listartudo();
								
								foreach ($vetor as $dados) {
									$codigo = $dados['codigoGenero'];
									$nome = $dados['nome'];
									echo "<option value=\"$codigo\">$nome </option>";
								}
							?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>Clasifica&ccedil;&atilde;o </td>
						<td>
							<select name="cmbClassificacao" id="cmbClassificacao">
							
							</select>
						</td>
					</tr>
					 
					<tr>
						<td>Produtora: </td>
						<td>
							<select name="cmbProdutora" id="cmbProdutora">
							
							</select>
						</td>
					</tr>
					 
					<tr>
						<td colspan="2">Sinopse: </td>
					</tr>
					 
					<tr>
						<td colspan="2">
							<textarea name="txtSinopse" id="txtSinopse" cols="40">
							</textarea>
						</td>
					</tr>
					 
					<tr>
						<td colspan="2">
							<input type="hidden" name="acao" value="1" />
							<input type="submit" name="btnCadastrar" id="btnCadastrar" value="Cadastrar"/>
							<input type="reset" name="btnLimpar" id="btnLimpar" value="Limpar"/>
						</td>
					</tr>
						   
				 </table>
				<!-- InstanceEndEditable -->
			</div>
			
			<div id="rodape">
				
			</div>       	
		</div>
	</body>
	<!-- InstanceEnd -->
</html>
