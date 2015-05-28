<?php
//adaptador.time.php

require_once('../classes/time.php');
require_once('../classes/uploadimagem.php');

$acao = $_REQUEST['acao'];

switch($acao) {
	case 1:
		$foto 			    = $_FILES['txtFoto'];
		$nome 			    = $_POST['txtNome'];
		$codigodivisao      = $_POST['cmbDivisao'];
		$codigocategoria    = $_POST['cmbCategoria'];
		$codigotecnico      = $_POST['cmbTecnico'];
		$desempenhotime     = $_POST['rDesempenhotime'];
		$comprarnovojogador = $_POST['rComprarnovojogador'];
		
		$capa = UploadImagem::enviar($nome, $foto);
		
		if($capa != '0') {
			$time = new Time();
			$time->setNome($nome);
			$time->setCapa($capa);
			$time->setCodigo_divisao($codigodivisao);
			$time->setCodigo_categoria($codigocategoria);
			$time->setCodigo_tecnico($codigotecnico);
			$time->setDesempenhotime($desempenhotime);
			$time->setComprarnovojogador($comprarnovojogador);
			
			//die($capa);
			if ($time->inserir() != 0) {
				$msg = urlencode('time cadastrado com sucesso!');
			} else {
				$msg = urlencode('Problemas ao cadastrar time!');
			}
			
		} else {
			$msg = urlencode('Problemas ao enviar imagem');
		}
		
		header("location:../formularios/cadastro.time.php?msg=$msg");
		break;

	 case 2:
		// alterar
		$foto      = $_FILES['txtFoto'];
		$codigo    = $_REQUEST['codigo'];
		$nome      = $_POST['txtNome'];
		$divisao   = $_POST['cmbDivisao'];
		$categoria = $_POST['cmbCategoria'];
		$tecnico   = $_POST['cmbTecnico'];
		$capa      = UploadImagem::enviar($nome, $foto);
		
		if ($capa != '0') {
			$time = new Time();
			$time->setCodigo_time($codigo);
			$time->setNome($nome);
			$time->setCapa($capa);
			$time->setCodigo_divisao($divisao);
			$time->setCodigo_categoria($categoria);
			$time->setCodigo_tecnico($tecnico);
			
			if ($time->alterar($codigo) == 1) {
				$msg = urlencode("time alterado com sucesso!");
			} else {
				$msg = urlencode("Problemas ao alterar time!");
			}
			
			header("location:../admin/lista.time.php?msg=$msg");	
		} else {
			$msg = urlencode('Problemas ao enviar imagem');
		}
			
		header("location:../formularios/alterar.time.php?msg=$msg");
		break;
		
		case 3:
		// excluir
		$codigo = $_GET['codigo'];
		$time 	= new Time();

		if ($time->excluir($codigo) == 1) {
			$msg = urlencode('Time excluido com sucesso!');
		} else {
			$msg = urlencode('Problemas ao excluir Time!');
		}
			
		header("location:../admin/lista.time.php?msg=$msg");
		break;
}
