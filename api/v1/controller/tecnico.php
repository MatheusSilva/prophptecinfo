<?php
error_reporting(-1);
ini_set('display_errors', 'on');

require_once "../../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\model\Tecnico;

$objTecnico = new Tecnico();

$objTecnico->setToken(isset($_REQUEST['tk']) ? $_REQUEST['tk'] : '');
$acao = isset($_REQUEST['a']) ? $_REQUEST['a'] : 0;
$id   = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
$p    = isset($_REQUEST['p']) ? $_REQUEST['p'] : '';

header('Content-Type: application/json');

if ($acao == 0) {
    $items   = $objTecnico->listarTudo();
    $results = array();
    $strErros = $objTecnico->getErros();

    if (is_array($items) && empty($items) !== true) {
        // get all results
        foreach ($items as $row) {
            $itemArray = array(
                'codigo' => $row['codigo_tecnico'],
                'nome' => $row['nome'],
            );
            array_push($results, $itemArray);
        }
        
        $json  = "{\"tecnicos\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    }
} elseif ($acao == 1) {
    $arrTodosTecnico   = $objTecnico->listarTudo();
    $arrTecnicoTime   = $objTecnico->listaTecnicoPorTime($id, null);
    $results = array();
    $strErros = $objTecnico->getErros();
    
    if (is_array($arrTodosTecnico) && empty($arrTodosTecnico) !== true) {
        // get all results
        foreach ($arrTodosTecnico as $valor) {
            $boolSelected = false;
            $idDivisao = $valor['codigo_tecnico'];
            
            if (is_array($arrTecnicoTime) && empty($arrTecnicoTime) !== true && $idDivisao === $arrTecnicoTime['codigo_tecnico']) {
                $boolSelected = true;
            }
            
            $itemArray = array(
                'codigo' => $idDivisao,
                'nome'   => $valor['nome'],
                'selected'   => $boolSelected
            );
            
            array_push($results, $itemArray);
        }
        
        $json = "{\"tecnicos\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    } else {
        $itemArray = array(
                'codigo' => "",
                'nome'   => "Nenhum técnico cadastrado.",
                'selected'   => true
        );
            
        array_push($results, $itemArray);

        $json = "{\"tecnicos\":";
        $json .= json_encode($results);
        $json .= "}";
            
        echo $json;
    }
} elseif ($acao == 2) {
    $items = $objTecnico->listarPorCodigo($id);
    $strErros = $objTecnico->getErros();

    if (is_array($items) && empty($items) !== true) {
        echo json_encode($items);
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    }
} elseif ($acao == 3) {
    $items   = $objTecnico->listarPorNome($p);
    $strErros = $objTecnico->getErros();
    
    if (is_array($items) && empty($items) !== true) {
        $json = "{\"tecnicos\":";
        $json .= json_encode($items);
        $json .= "}";
        echo $json;
    } elseif (!empty($strErros)) {
        $json["mensagem"] = $strErros;
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhum técnico encontrado com o termo buscado.";
        echo json_encode($json);
    }
} elseif ($acao == 4) {
    $request_body = file_get_contents('php://input');
    $tecnico    = json_decode($request_body, true);
    $objTecnico->setNome($tecnico["txtNome"]);

    $dia  = $tecnico["cmbDia"];
    $mes  = $tecnico["cmbMes"];
    $ano  = $tecnico["cmbAno"];
    $data = $dia."/".$mes."/".$ano;
    $objTecnico->setData($data);

    $boolRetorno = $objTecnico->inserir();
    $strErros = $objTecnico->getErros();

    if ($boolRetorno === true) {
        $tecnico["mensagem"] = "Técnico cadastrado com sucesso.";
    } elseif (!empty($strErros)) {
        $tecnico["mensagem"] = $strErros;
    } else {
        $tecnico["mensagem"] = "Falha ao cadastrar técnico.";
    }

    $json = json_encode($tecnico);
    echo $json;
} elseif ($acao == 5) {
    $request_body = file_get_contents('php://input');
    $tecnico    = json_decode($request_body, true);
    $objTecnico->setCodigoTecnico($id);
    $objTecnico->setNome($tecnico["txtNome"]);

    $boolRetorno = $objTecnico->alterar();
    $strErros = $objTecnico->getErros();

    if ($boolRetorno === true) {
        $tecnico["mensagem"] = "Técnico alterado com sucesso.";
    } elseif (!empty($strErros)) {
        $tecnico["mensagem"] = $strErros;
    } else {
        $tecnico["mensagem"] = "Falha ao atualizar técnico.";
    }

    $json = json_encode($tecnico);
    echo $json;
} elseif ($acao == 6) {
    $tecnico    = "";
    $objTecnico->setCodigoTecnico($id);

    $boolRetorno = $objTecnico->excluir();
    $strErros = $objTecnico->getErros();

    if ($boolRetorno === true) {
        $tecnico["mensagem"] = "Técnico excluido com sucesso.";
    } elseif (!empty($strErros)) {
        $tecnico["mensagem"] = $strErros;
    } else {
        $tecnico["mensagem"] = "Falha ao excluir técnico.";
    }

    $json = json_encode($tecnico);
    echo $json;
}

$acao  = "";
$id    = "";
$p     = "";
