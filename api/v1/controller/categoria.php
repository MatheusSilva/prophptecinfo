<?php
require_once "../../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\model\Categoria;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$acao         = "";
$id           = "";
$p            = "";

$objCategoria = new Categoria();

if (isset($_REQUEST["a"]) && empty($_REQUEST["a"]) === false) {
    $acao  = $_REQUEST["a"];
}

if (isset($_REQUEST["id"]) && empty($_REQUEST["id"]) === false) {
    $id  = $_REQUEST["id"];
}

if (isset($_REQUEST["tk"]) && empty($_REQUEST["tk"]) === false) {
    $objCategoria->setToken($_REQUEST["tk"]);
}

if (isset($_REQUEST["p"]) && empty($_REQUEST["p"]) === false) {
    $p  = $_REQUEST["p"];
}

header('Content-Type: application/json');

if (empty($acao)) {
    $items = $objCategoria->listarTudo();
    $results = array();
    $strErros = $objCategoria->getErros();
    
    if (is_array($items) && empty($items) !== true) {
        // get all results
        foreach ($items as $row) {
            $itemArray = array(
                'codigo' => $row['codigo_categoria'],
                'nome' => $row['nome'],
            );
            array_push($results, $itemArray);
        }

        $json  = "{\"categorias\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhum categoria cadastrada";
        echo json_encode($json);
    }
} elseif ($acao == 1) {
    $arrTodasCategorias   = $objCategoria->listarTudo();
    $arrCategoriaTime   = $objCategoria->listaCategoriaPorTime($id, null);
    $results = array();
    $strErros = $objCategoria->getErros();

    if (is_array($arrTodasCategorias) && empty($arrTodasCategorias) !== true) {
        // get all results
        foreach ($arrTodasCategorias as $valor) {
            $boolSelected = false;
            $idDivisao = $valor['codigo_categoria'];
            
            if (is_array($arrCategoriaTime) && empty($arrCategoriaTime) !== true && $idDivisao === $arrCategoriaTime['codigo_categoria']) {
                $boolSelected = true;
            }
            
            $itemArray = array(
                'codigo' => $idDivisao,
                'nome'   => $valor['nome'],
                'selected'   => $boolSelected
            );
            
            array_push($results, $itemArray);
        }
        
        $json = "{\"categorias\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    } else {
        $itemArray = array(
                'codigo' => "",
                'nome'   => "Nenhuma categoria cadastrada",
                'selected'   => true
        );
            
        array_push($results, $itemArray);

        $json = "{\"categorias\":";
        $json .= json_encode($results);
        $json .= "}";
            
        echo $json;
    }
} elseif ($acao == 2) {
    $items = $objCategoria->listarPorCodigo($id);
    $strErros = $objCategoria->getErros();

    if (is_array($items) && empty($items) !== true) {
        echo json_encode($items);
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    } else {
        $json["mensagem"] = "codigo categoria invalido";
        echo json_encode($json);
    }
} elseif ($acao == 3) {
    $request_body = file_get_contents('php://input');
    $json    = json_decode($request_body, true);
    
    if (isset($json["p"]) && !empty($json["p"])) {
        $p = $json["p"];
    }
    
    $items = $objCategoria->listarPorNome($p);
    $strErros = $objCategoria->getErros();

    if (is_array($items) && empty($items) !== true) {
        $json  = "{\"categorias\":";
        $json .= json_encode($items);
        $json .= "}";
        echo $json;
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    } elseif (!empty($p)) {
        $json["mensagem"] = "Nenhum categoria encontrada com o termo buscado";
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhum categoria cadastrada";
        echo json_encode($json);
    }
} elseif ($acao == 4) {
    $request_body = file_get_contents('php://input');
    $categoria    = json_decode($request_body, true);

    $objCategoria->setNome($categoria["txtNome"]);

    $boolRetorno = $objCategoria->inserir();
    $strErros = $objCategoria->getErros();
    
    if ($boolRetorno === true) {
        $categoria["mensagem"] = "Categoria cadastrada com sucesso.";
    } elseif (!empty($strErros)) {
        $categoria["mensagem"] = $strErros;
    } else {
        $categoria["mensagem"] = "Falha ao cadastrar categoria.";
    }

    $json = json_encode($categoria);
    echo $json;
} elseif ($acao == 5) {
    $request_body = file_get_contents('php://input');
    $categoria    = json_decode($request_body, true);

    $objCategoria->setCodigoCategoria($id);
    $objCategoria->setNome($categoria["txtNome"]);

    $boolRetorno = $objCategoria->alterar();
    $strErros = $objCategoria->getErros();

    if ($boolRetorno === true) {
        $categoria["mensagem"] = "Categoria alterada com sucesso.";
    } elseif (!empty($strErros)) {
        $categoria["mensagem"] = $strErros;
    } else {
        $categoria["mensagem"] = "Falha ao atualizar categoria";
    }

    $json = json_encode($categoria);
    echo $json;
} elseif ($acao == 6) {
    $categoria    = "";

    $objCategoria->setCodigoCategoria($id);
    $boolRetorno = $objCategoria->excluir();
    $strErros = $objCategoria->getErros();

    if ($boolRetorno === true) {
        $categoria["mensagem"] = "Categoria excluida com sucesso.";
    } elseif (!empty($strErros)) {
        $categoria["mensagem"] = $strErros;
    } else {
        $categoria["mensagem"] = "Falha ao excluir categoria";
    }

    $json = json_encode($categoria);
    echo $json;
}

$acao  = "";
$id    = "";
$p     = "";
