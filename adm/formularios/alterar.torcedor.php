<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Cat&aacute;logo de Jogos</title>
		<link rel="stylesheet" type="text/css" href="../../css/layoutadm.css" />
	</head>
	
	<body>
		<div id="geral">
			<div id="cabecalho">
			</div>
			
			<header>
                <nav id="menu_superior">
                    <a href="../paginas/home.php">Home</a> ::
					<a href="../paginas/cadastros.php">Cadastros</a> ::
					<a href="../paginas/administrar.php">Administrar</a> ::
					<a href="../paginas/consultas.php">Consultas</a> ::
					<a href="logout.php">Sair</a>
                </nav>
            </header>
			
			<div id="conteudo">
				<h2 class="titulo">Alterar Dados de torcedor</h2>
				
				<?php
                    $codigo = $_GET['codigo'];
                    require_once "../../api/v1/torcedor/Torcedor.php";
                    $dados = Torcedor :: listarPorCodigo($codigo);
                ?>
				
				<form method="post" 
					  action="../adaptadores/adaptador.torcedor.php"
					  name="frmCadastro"
					  id="frmCadastro">
					  
					<table>
						<tr>
							<td>Nome:</td>
							<td>
								<input type="text" name="txtNome" id="txtNome" value="<?php echo $dados['nome']; ?>" />
							</td>
						</tr>
						
						<tr>
							<td>Login:</td>
							<td>
								<input
									type="text"
									name="txtLogin"
									id="txtLogin"
									value="<?php echo $dados['login']; ?>"
								/>
							</td>
						</tr>
						
						<tr>
							<td>Senha:</td>
							<td>
								<input type="password" name="txtSenha" id="txtSenha" value="" />
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
								<input type="hidden" name="acao" value="2" />
								<input
									type="hidden"
									name="codigo"
									value="<?php echo $dados['codigo_torcedor']; ?>"
								/>
								<input type="submit" name="btnAlterar" value="Alterar" id="btnAlterar" /> 
								<input type="reset" name="btnLimpar" value="Limpar" id="btnLimpar" />
							</td>
						</tr>
						
					</table>
				</form>
				
				<?php
                if (isset($_GET['msg'])) {
                    echo urldecode($_GET['msg']);
                }
                ?>
			</div>
			
			<footer id="rodape">
            </footer>     	
		</div>
	</body>
</html>
