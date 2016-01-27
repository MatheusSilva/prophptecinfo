<?php
require_once "Time.php";
require_once "../lib/Upload.php";
use model\Time;
use lib\Upload;

$acao  = "";
$id    = "";
$token = "";
$p     = "";

if (isset($_REQUEST["a"]) && empty($_REQUEST["a"]) === false) {
    $acao  = $_REQUEST["a"];
}

if (isset($_REQUEST["id"]) && empty($_REQUEST["id"]) === false) {
    $id  = $_REQUEST["id"];
}

if (isset($_REQUEST["tk"]) && empty($_REQUEST["tk"]) === false) {
    $token  = $_REQUEST["tk"];
}

if (isset($_REQUEST["p"]) && empty($_REQUEST["p"]) === false) {
    $p  = $_REQUEST["p"];
}

header('Content-Type: application/json');

if (empty($acao)) {
    $time      = new time();
    $items   = $time->listarTudo();
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
    $time     = new time();
    $items  = $time->listarPorCodigo($id);
    
    if (!empty($items)) {
        echo json_encode($items);
    } else {
        $json["mensagem"] = "Codigo de time invalido";
        echo json_encode($json);
    }
} elseif ($acao == 2) {
    $time    = new time();
    $items = $time->listarPorNome($p);

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
    $foto                = $_FILES["txtFoto"];
    $nome                = $_REQUEST['txtNome'];
    $codigodivisao      = $_REQUEST['cmbDivisao'];
    $codigocategoria    = $_REQUEST['cmbCategoria'];
    $codigotecnico      = $_REQUEST['cmbTecnico'];
    $desempenhotime     = $_REQUEST['rDesempenhotime'];
    $comprarnovojogador = $_REQUEST['rComprarnovojogador'];
    
    $time = "";

    $capa = Upload::enviar($nome, $foto);

    if ($capa !== '0') {
        $objtime = new Time();
        $objtime->setNome($nome);
        $objtime->setCapa($capa);
        $objtime->setCodigoDivisao($codigodivisao);
        $objtime->setCodigoCategoria($codigocategoria);
        $objtime->setCodigoTecnico($codigotecnico);
        $objtime->setDesempenhotime($desempenhotime);
        $objtime->setComprarnovojogador($comprarnovojogador);

        if ($objtime->inserir($token)) {
            $time["mensagem"] = "time cadastrado com sucesso";
        } else {
            $time["mensagem"] = "Falha ao cadastrar time";
        }
    } else {
        $time["mensagem"] = "Problemas ao enviar imagem";
    }
    
    echo json_encode($time);
} elseif ($acao == 4) {
    $foto = "";

    if (isset($_FILES["txtFoto"]) && !empty($_FILES["txtFoto"])) {
        $foto           = $_FILES["txtFoto"];
    }

    $nome                = $_REQUEST['txtNome'];
    $codigodivisao      = $_REQUEST['cmbDivisao'];
    $codigocategoria    = $_REQUEST['cmbCategoria'];
    $codigotecnico      = $_REQUEST['cmbTecnico'];
    //$desempenhotime     = $_REQUEST['rDesempenhotime'];
    //$comprarnovojogador = $_REQUEST['rComprarnovojogador'];
    $capa = '';

    if (!empty($nome) && !empty($foto)) {
        $capa = Upload::enviar($nome, $foto);
    }
    
    $time = "";

    if ($capa != '0') {
        $objtime = new Time();
        $objtime->setCodigoTime($id);
        $objtime->setNome($nome);
        $objtime->setCapa($capa);
        $objtime->setCodigoDivisao($codigodivisao);
        $objtime->setCodigoCategoria($codigocategoria);
        $objtime->setCodigoTecnico($codigotecnico);
        //$objtime->setDesempenhotime($desempenhotime);
        //$objtime->setComprarnovojogador($comprarnovojogador);

        if ($objtime->alterar($token)) {
            $time["mensagem"] = "Time alterado com sucesso";
        } else {
            $time["mensagem"] = "Falha ao alterar time";
        }
    } else {
        $time["mensagem"] = "Problemas ao enviar imagem";
    }

    echo json_encode($time);
} elseif ($acao == 5) {
    $time    = "";
    $objtime = new time();
    $objtime->setCodigoTime($id);
    $retorno = $objtime->excluir($id, $token);
    
    if ($retorno === true) {
        $time["mensagem"] = "Time excluido com sucesso";
    } elseif ($retorno !== false) {
        $time["mensagem"] = $retorno;
    } else {
        $time["mensagem"] = "Falha ao excluir time";
    }

    echo json_encode($time);
}

$acao  = "";
$id    = "";
$token = "";
$p     = "";
