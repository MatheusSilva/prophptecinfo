<?php

$acao = $_REQUEST['acao'];
require_once "../../api/v1/torcedor/Torcedor.php";

use model\Torcedor;

if ($acao == 1) {

    // inserir
    $nome      = $_POST['txtNome'];
    $login      = $_POST['txtLogin'];
    $senha      = $_POST['txtSenha'];

    $torcedor = new Torcedor();
    $torcedor->setNome($nome);
    $torcedor->setLogin($login);
    $torcedor->setSenha($senha);

    if ($torcedor->inserir() == 1) {
        $msg = urlencode('Torcedor cadastrado com sucesso!');
    } else {
        $msg = urlencode('Problemas ao cadastrar torcedor!');
    }

    header("location:../formularios/cadastro.torcedor.php?msg=$msg");
} elseif ($acao == 2) {
    // alterar
    $codigo   = $_POST['codigo'];
    $senha    = $_POST['txtSenha'];
    $nome     = $_POST['txtNome'];
    $login    = $_POST['txtLogin'];

    $torcedor = new Torcedor();
    $torcedor->setCodigoTorcedor($codigo);
    $torcedor->setSenha($senha);
    $torcedor->setNome($nome);
    $torcedor->setLogin($login);

    if ($torcedor->alterar() == 1) {
        $msg = urlencode("Torcedor alterado com sucesso!");
    } else {
        $msg = urlencode("Problemas ao alterar torcedor!");
    }

    header("location:../admin/lista.torcedor.php?msg=$msg");
} elseif ($acao == 3) {
    // excluir
    $codigo   = $_GET['codigo'];
    $torcedor = new Torcedor();

    if ($torcedor->excluir($codigo) == 1) {
        $msg = urlencode('Torcedor excluido com sucesso!');
    } else {
        $msg = urlencode('Problemas ao excluir torcedor!');
    }

    header("location:../admin/lista.torcedor.php?msg=$msg");
}
