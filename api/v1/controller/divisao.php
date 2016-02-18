<?php
require_once "../../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\model\Divisao;

$acao       = "";
$id         = "";
$p          = "";
$objDivisao = new divisao();

if (isset($_REQUEST["a"]) && empty($_REQUEST["a"]) === false) {
    $acao  = $_REQUEST["a"];
}

if (isset($_REQUEST["id"]) && empty($_REQUEST["id"]) === false) {
    $id  = $_REQUEST["id"];
}

if (isset($_REQUEST["tk"]) && empty($_REQUEST["tk"]) === false) {
    $objDivisao->setToken($_REQUEST["tk"]);
}

if (isset($_REQUEST["p"]) && empty($_REQUEST["p"]) === false) {
    $p  = $_REQUEST["p"];
}

header('Content-Type: application/json');

if (empty($acao)) {
    $items   = $objDivisao->listarTudo();
    $results = array();

    if (!empty($items)) {
        // get all results
        foreach ($items as $row) {
            $itemArray = array(
                'codigo' => $row['codigo_divisao'],
                'nome'   => $row['nome'],
            );
            array_push($results, $itemArray);
        }
        
        $json = "{\"divisaos\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } else {
        $json["mensagem"] = "Nenhum divisão cadastrada.";
        echo json_encode($json);
    }
} elseif ($acao == 1) {
    $arrTodasDivisoes   = $objDivisao->listarTudo();
    $arrDivisaoTime   = $objDivisao->listaDivisaoPorTime($id, null);
    $results = array();
    
    if (!empty($arrTodasDivisoes)) {
        // get all results
        foreach ($arrTodasDivisoes as $valor) {
            $boolSelected = false;
            $idDivisao = $valor['codigo_divisao'];
            
            if ($arrDivisaoTime && $idDivisao === $arrDivisaoTime['codigo_divisao']) {
                $boolSelected = true;
            }
            
            $itemArray = array(
                'codigo' => $idDivisao,
                'nome'   => $valor['nome'],
                'selected'   => $boolSelected
            );
            
            array_push($results, $itemArray);
        }
        
        $json = "{\"divisaos\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } else {
        $itemArray = array(
                'codigo' => "",
                'nome'   => "Nenhuma divisão cadastrada.",
                'selected'   => true
        );
            
        array_push($results, $itemArray);

        $json = "{\"divisaos\":";
        $json .= json_encode($results);
        $json .= "}";
            
        echo $json;
    }
} elseif ($acao == 2) {
    $items   = $objDivisao->listarPorCodigo($id);
    
    if (!empty($items)) {
        echo json_encode($items);
    } else {
        $json["mensagem"] = "codigo divisão invalido.";
        echo json_encode($json);
    }
} elseif ($acao == 3) {
    $items   = $objDivisao->listarPorNome($p);
    
    if (!empty($items)) {
        $json = "{\"divisaos\":";
        $json .= json_encode($items);
        $json .= "}";
        echo $json;
    } elseif (!empty($p)) {
        $json["mensagem"] = "Nenhuma divisão encontrada com o termo buscado.";
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhuma divisão cadastrada.";
        echo json_encode($json);
    }
} elseif ($acao == 4) {
    $request_body = file_get_contents('php://input');
    $divisao    = json_decode($request_body, true);
    $objDivisao->setNome($divisao["txtNome"]);

    $boolRetorno = $objDivisao->inserir();
    $strErros    = $objDivisao->getErros();
    
    if ($boolRetorno === true) {
        $divisao["mensagem"] = "Divisão cadastrada com sucesso.";
    } elseif (!empty($strErros)) {
        $divisao["mensagem"] = $strErros;
    } else {
        $divisao["mensagem"] = "Falha ao cadastrar divisão.";
    }

    $json = json_encode($divisao);
    echo $json;
} elseif ($acao == 5) {
    $request_body = file_get_contents('php://input');
    $divisao    = json_decode($request_body, true);
    $objDivisao->setCodigoDivisao($id);
    $objDivisao->setNome($divisao["txtNome"]);

    $boolRetorno = $objDivisao->alterar();
    $strErros    = $objDivisao->getErros();

    if ($boolRetorno === true) {
        $divisao["mensagem"] = "Divisão alterada com sucesso.";
    } elseif (!empty($strErros)) {
        $divisao["mensagem"] = $strErros;
    } else {
        $divisao["mensagem"] = "Falha ao atualizar divisão.";
    }

    $json = json_encode($divisao);
    echo $json;
} elseif ($acao == 6) {
    $divisao    = "";
    $objDivisao->setCodigoDivisao($id);

    $boolRetorno = $objDivisao->excluir();
    $strErros    = $objDivisao->getErros();

    if ($boolRetorno === true) {
        $divisao["mensagem"] = "Divisão excluida com sucesso.";
    } elseif (!empty($strErros)) {
        $divisao["mensagem"] = $strErros;
    } else {
        $divisao["mensagem"] = "Falha ao excluir divisão.";
    }

    $json = json_encode($divisao);
    echo $json;
}

$acao  = "";
$id    = "";
$p     = "";
