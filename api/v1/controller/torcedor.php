<?php
error_reporting(-1);
ini_set('display_errors', 'on');

require_once "../../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\model\Torcedor;
use matheus\sistemaRest\api\v1\lib\Login;

$acao        = "";
$key         = "";
$objTorcedor = new torcedor();

if (isset($_REQUEST["a"]) && empty($_REQUEST["a"]) === false) {
    $acao  = $_REQUEST["a"];
}

if (isset($_REQUEST["tk"]) && empty($_REQUEST["tk"]) === false) {
    $objTorcedor->setToken($_REQUEST["tk"]);
}

if (isset($_REQUEST["key"]) && empty($_REQUEST["key"]) === false) {
    $key = $_REQUEST["key"];
}

header('Content-Type: application/json');

if ($acao == 1) {
    $torcedor    = "";

    $boolRetorno = $objTorcedor->ativarAutenticacao2fatores();
    $strErros = $objTorcedor->getErros();

    if ($boolRetorno === true) {
        $imgbase64["imgbase64"] = $objTorcedor->retornaBase64ImgAutenticacao2fatores();
        $torcedor  = "{\"torcedor\":";//[{
        $torcedor .= json_encode($imgbase64);
        $torcedor .= "}";
    } elseif (!empty($strErros)) {
        $torcedor["mensagem"] = $strErros;
        $torcedor = json_encode($torcedor);
    } else {
        $torcedor["mensagem"] = "Falha ao desativar autenticação 2 fatores.";
        $torcedor = json_encode($torcedor);
    }

    echo $torcedor;
} elseif ($acao == 2) {
    $torcedor    = "";

    $boolRetorno = $objTorcedor->desativarAutenticacao2fatores();
    $strErros = $objTorcedor->getErros();

    if ($boolRetorno === true) {
        $torcedor["mensagem"] = "Autenticação 2 fatores desativada com sucesso.";
    } elseif (!empty($strErros)) {
        $torcedor["mensagem"] = $strErros;
    } else {
        $torcedor["mensagem"] = "Falha ao desativar autenticação 2 fatores.";
    }

    $json = json_encode($torcedor);
    echo $json;
} elseif ($acao == 3) {
    $torcedor    = "";

    $boolRetorno = $objTorcedor->tokenAutenticacao2fatoresEhValido($key);
    $strErros = $objTorcedor->getErros();

    if (Login::verificarCom2Etapas() == true && $boolRetorno == 1) {
        $torcedor["resultado"] = 1;
        $_SESSION['logado']    = 'ok';
        $objTorcedor->setTokenAutenticacao2fatoresAtivado();
    } elseif (!empty($strErros)) {
        $torcedor["mensagem"] = $strErros;
    } else {
        $torcedor["resultado"] = 0;
    }

    $json = json_encode($torcedor);
    echo $json;
} elseif ($acao == 4) {
    $torcedor    = "";
    
    $tokenAutenticacao2fatores = $objTorcedor->tokenAutenticacao2fatores();
    $strErros = $objTorcedor->getErros();

    if (!empty($tokenAutenticacao2fatores["otpsecret"]) && $tokenAutenticacao2fatores["otpAtivado"] != 1) {
        $torcedor["resultado"] = 2;
    }else if (!empty($tokenAutenticacao2fatores["otpsecret"]) && $tokenAutenticacao2fatores["otpAtivado"] == 1) {
        $torcedor["resultado"] = 1;
    } elseif (!empty($strErros)) {
        $torcedor["mensagem"] = $strErros;
    }  else {
        $torcedor["resultado"] = 0;
    }

    $json = json_encode($torcedor);
    echo $json;
} else if ($acao == 5) {
    $imgbase64["imgbase64"] = $objTorcedor->retornaBase64ImgAutenticacao2fatores();
    $torcedor  = "{\"torcedor\":";//[{
    $torcedor .= json_encode($imgbase64);
    $torcedor .= "}";
    echo $torcedor;
} elseif ($acao == 6) {
    $torcedor    = "";

    $boolRetorno = $objTorcedor->tokenAutenticacao2fatoresEhValido($key);
    $strErros = $objTorcedor->getErros();

    if (Login::verificarCom2Etapas() == true && $boolRetorno == 1) {
        $torcedor["resultado"] = 1;
        $_SESSION['logado']    = 'ok';
        $objTorcedor->setTokenAutenticacao2fatoresAtivado();
    } elseif (!empty($strErros)) {
        $torcedor["mensagem"] = $strErros;
    } else {
        $torcedor["resultado"] = 0;
    }

    $json = json_encode($torcedor);
    echo $json;
}

$acao  = "";