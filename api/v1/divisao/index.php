<?php

require_once "Divisao.php";

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
    $divisao = new divisao();
    $db      = new divisao();
    $items   = $db->listarTudo();
    $results = array();

    if (!empty($items)) {
        // get all results
        foreach($items as $row) {
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
        $json["mensagem"] = "Nenhum divisao cadastrada";
        echo json_encode($json);
    } 
} else if ($acao == 1) {
    $divisao = new divisao();
    $arrTodasDivisoes   = $divisao->listarTudo();
    $arrDivisaoTime   = $divisao->listaDivisaoPorTime(null,$id);
    $results = array();
    
    if (!empty($arrTodasDivisoes)) {
        // get all results
        foreach($arrTodasDivisoes as $valor) {
            
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
                'nome'   => "Nenhuma divisao cadastrada",
                'selected'   => true
        );
            
        array_push($results, $itemArray);

        $json = "{\"divisaos\":";
        $json .= json_encode($results);
        $json .= "}";
            
        echo $json;
    }
} else if ($acao == 2) {
    $divisao = new divisao();
    $items   = $divisao->listarPorCodigo($id);
    
    if (!empty($items)) {
        echo json_encode($items);
    } else { 
        $json["mensagem"] = "codigo divisao invalido";
        echo json_encode($json);
    }
} else if ($acao == 3) {
    $divisao = new divisao();
    $items   = $divisao->listarPorNome($p);
    
    if (!empty($items)) {
        $json = "{\"divisaos\":";
        $json .= json_encode($items);
        $json .= "}";
        echo $json;
    } else if(!empty($p)) {
        $json["mensagem"] = "Nenhuma divisao encontrada com o termo buscado";
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhuma divisao cadastrada";
        echo json_encode($json);
    }
} else if ($acao == 4) {
    $request_body = file_get_contents('php://input');
    $divisao    = json_decode($request_body, true);
    $objdivisao = new divisao();
    $objdivisao->setNome($divisao["txtNome"]);	

    if ($objdivisao->inserir($token)) {
        $divisao["mensagem"] = "divisao cadastrada com sucesso";	 	
    } else {
        $divisao["mensagem"] = "Falha ao cadastrar divisao";	
    }

    $json = json_encode($divisao);
    echo $json;
} else if ($acao == 5) {
    $request_body = file_get_contents('php://input');
    $divisao    = json_decode($request_body, true);
    $objdivisao = new divisao();
    $objdivisao->setCodigo_divisao($id);
    $objdivisao->setNome($divisao["txtNome"]);	


    if ($objdivisao->alterar($token)) {	
          $divisao["mensagem"] = "divisao atualizada com sucesso";	 	
    } else {
          $divisao["mensagem"] = "Falha ao atualizar divisao";	
    }

    $json = json_encode($divisao);
    echo $json;
} else if ($acao == 6) {
    $divisao    = "";
    $objdivisao = new divisao();
    $objdivisao->setCodigo_divisao($id);

    if ($objdivisao->validaFkDivisao($token)) {       
          $divisao["mensagem"] = "Falha ao excluir divisão. Existem um ou mais times vinculados a esta divisão.";        
    } else if ($objdivisao->excluir($token)) {	 	
          $divisao["mensagem"] = "divisao excluida com sucesso";	 	
    } else {
          $divisao["mensagem"] = "Falha ao excluir divisao";	
    }

    $json = json_encode($divisao);
    echo $json;
}

$acao  = "";
$id    = "";
$token = "";
$p     = "";