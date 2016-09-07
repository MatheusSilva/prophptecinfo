<?php
error_reporting(-1);
ini_set('display_errors', 'on');

require_once "../../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\model\Torcedor AS modTorcedor;
use matheus\sistemaRest\api\v1\lib\Login;

$objTorcedor = new modTorcedor();

$objTorcedor->setToken(isset($_REQUEST['tk']) ? $_REQUEST['tk'] : '');
$acao  = isset($_REQUEST['a']) ? $_REQUEST['a'] : 0;
$id    = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$key   = isset($_REQUEST['key']) ? $_REQUEST['key'] : '';

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
} elseif ($acao == 5) {
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
} elseif ($acao == 7) {
    $objTorcedor->setCodigoTorcedor($id);
    $arrDadosTorcedor = $objTorcedor->retornaDadosTorcedor();
    $strErros = $objTorcedor->getErros();

    if (is_array($arrDadosTorcedor) && empty($arrDadosTorcedor) !== true) {
        echo json_encode($arrDadosTorcedor);
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    }
} elseif ($acao == 8) {
    $request_body = file_get_contents('php://input');
    $torcedor    = json_decode($request_body, true);

    $objTorcedor->setCodigoTorcedor($torcedor["codigo"]);
    $objTorcedor->setNome($torcedor["txtNome"]);
    $objTorcedor->setEmail($torcedor["txtEmail"]);
    
    if (isset($torcedor["txtSenhaAtual"])) {
        $objTorcedor->setSenhaAtual($torcedor["txtSenhaAtual"]);
    }

    if (isset($torcedor["txtSenha"])) {
        $objTorcedor->setSenha($torcedor["txtSenha"]);
    }

    if (isset($torcedor["txtConfSenha"])) {
        $objTorcedor->setConfSenha($torcedor["txtConfSenha"]);
    }

    $boolRetorno = $objTorcedor->alterar();
    $strErros = $objTorcedor->getErros();

    $torcedor = "";

    if ($boolRetorno === true) {
        $torcedor["mensagem"] = "Torcedor alterado com sucesso.";
    } elseif (!empty($strErros)) {
        $torcedor["mensagem"] = $strErros;
    } else {
        $torcedor["mensagem"] = "Falha ao atualizar torcedor";
    }

    $json = json_encode($torcedor);
    echo $json;


}

$acao  = "";
