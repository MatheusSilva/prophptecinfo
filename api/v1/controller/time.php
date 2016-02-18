<?php
require_once "../../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\model\Time;
use matheus\sistemaRest\api\v1\lib\Upload;

$acao  = "";
$id    = "";
$p     = "";
$objTime  = new time();

if (isset($_REQUEST["a"]) && empty($_REQUEST["a"]) === false) {
    $acao  = $_REQUEST["a"];
}

if (isset($_REQUEST["id"]) && empty($_REQUEST["id"]) === false) {
    $id  = $_REQUEST["id"];
}

if (isset($_REQUEST["tk"]) && empty($_REQUEST["tk"]) === false) {
    $objTime->setToken($_REQUEST["tk"]);
}

if (isset($_REQUEST["p"]) && empty($_REQUEST["p"]) === false) {
    $p  = $_REQUEST["p"];
}

header('Content-Type: application/json');

if (empty($acao)) {
    $items   = $objTime->listarTudo();
    $results = array();

    if (!empty($items)) {
        // get all results
        foreach ($items as $row) {
            $itemArray = array(
                'codigo' => $row['codigo_time'],
                'codigoDivisao' => $row['divisao_codigo_divisao'],
                'nome' => $row['nome'],
                'capa' => $row['capa'],
            );
            array_push($results, $itemArray);
        }

        $json  = "{\"times\":";
        $json .= json_encode($results);
        $json .= "}";
        echo $json;
    } else {
        $json["mensagem"] = "Nenhum time cadastrado";
        echo json_encode($json);
    }
} elseif ($acao == 1) {
    $items  = $objTime->listarPorCodigo($id);
    
    if (!empty($items)) {
        echo json_encode($items);
    } else {
        $json["mensagem"] = "Codigo de time invalido";
        echo json_encode($json);
    }
} elseif ($acao == 2) {
    $items = $objTime->listarPorNome($p);

    if (!empty($items)) {
        $json    = "{\"times\":";
        $json   .= json_encode($items);
        $json   .= "}";
        echo $json;
    } elseif (!empty($p)) {
        $json["mensagem"] = "Nenhum time encontrado com o termo buscado";
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhum time cadastrado";
        echo json_encode($json);
    }
} elseif ($acao == 3) {
    $foto               = $_FILES["txtFoto"];
    $nome               = $_POST['txtNome'];
    $codigodivisao      = $_POST['cmbDivisao'];
    $codigocategoria    = $_POST['cmbCategoria'];
    $codigotecnico      = $_POST['cmbTecnico'];
    $desempenhotime     = $_POST['rDesempenhotime'];
    $comprarnovojogador = $_POST['rComprarnovojogador'];
    
    $time = "";

    $capa = Upload::enviar($nome, $foto);

    if ($capa !== '0') {
        $objTime->setNome($nome);
        $objTime->setCapa($capa);
        $objTime->setCodigoDivisao($codigodivisao);
        $objTime->setCodigoCategoria($codigocategoria);
        $objTime->setCodigoTecnico($codigotecnico);
        $objTime->setDesempenhotime($desempenhotime);
        $objTime->setComprarnovojogador($comprarnovojogador);

        $retorno  = $objTime->inserir();
        $strErros = $objTime->getErros();

        if ($retorno === true) {
            $time["mensagem"] = "Time cadastrado com sucesso.";
        } elseif (empty($strErros) === false) {
            $time["mensagem"] = $strErros;
        } else {
            $time["mensagem"] = "Falha ao cadastrar time.";
        }
    } else {
        $time["mensagem"] = "Problemas ao enviar imagem.";
    }
    
    echo json_encode($time);
} elseif ($acao == 4) {
    $foto = "";
    
    if (isset($_FILES["txtFoto"]) && !empty($_FILES["txtFoto"])) {
        $foto           = $_FILES["txtFoto"];
    }
    
    $nome               = $_POST['txtNome'];
    $codigodivisao      = $_POST['cmbDivisao'];
    $codigocategoria    = $_POST['cmbCategoria'];
    $codigotecnico      = $_POST['cmbTecnico'];

    //$desempenhotime     = $_REQUEST['rDesempenhotime'];
    //$comprarnovojogador = $_REQUEST['rComprarnovojogador'];
    $capa = '';

    if (!empty($nome) && !empty($foto)) {
        $capa = Upload::enviar($nome, $foto);
    }
    
    $time = "";

    if ($capa != '0') {
        $objTime->setCodigoTime($id);
        $objTime->setNome($nome);
        $objTime->setCapa($capa);
        $objTime->setCodigoDivisao($codigodivisao);
        $objTime->setCodigoCategoria($codigocategoria);
        $objTime->setCodigoTecnico($codigotecnico);
        //$objTime->setDesempenhotime($desempenhotime);
        //$objTime->setComprarnovojogador($comprarnovojogador);

        $retorno  = $objTime->alterar();
        $strErros = $objTime->getErros();

        if ($retorno === true) {
            $time["mensagem"] = "Time alterado com sucesso.";
        } elseif (empty($strErros) === false) {
            $time["mensagem"] = $strErros;
        } else {
            $time["mensagem"] = "Falha ao alterar time.";
        }
    } else {
        $time["mensagem"] = "Problemas ao enviar imagem.";
    }

    echo json_encode($time);
} elseif ($acao == 5) {
    $time    = "";
    $objTime->setCodigoTime($id);
    $retorno = $objTime->excluir();
    $strErros = $objTime->getErros();
    
    if ($retorno === true) {
        $time["mensagem"] = "Time excluido com sucesso.";
    } elseif (empty($strErros) === false) {
        $time["mensagem"] = $strErros;
    } else {
        $time["mensagem"] = "Falha ao excluir time";
    }
    
    echo json_encode($time);
}

$acao  = "";
$id    = "";
$p     = "";
