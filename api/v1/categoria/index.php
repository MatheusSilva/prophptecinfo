<?php
require_once "Categoria.php";

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
    $objCategoria = new Categoria();
    $items = $objCategoria->listarTudo();
    $results = array();

    if (!empty($items)) {
        // get all results
        foreach($items as $row) {
            $itemArray = array(
                'codigo' => $row['codigo_categoria'],
                'nome' => $row['nome'],
            );
            array_push($results, $itemArray);
        }

        $json = "{\"categorias\":";
        $json .= json_encode($results);
        $json .= "}";

        echo $json;
    } else {
        $json["mensagem"] = "Nenhum categoria cadastrada";
        echo json_encode($json);
    }
} else if ($acao == 1) {
    $objCategoria = new Categoria();
    $arrTodasCategorias   = $objCategoria->listarTudo();
    $arrCategoriaTime   = $objCategoria->listaCategoriaPorTime(null,$id);
    $results = array();

    if (!empty($arrTodasCategorias)) {
        // get all results
        foreach($arrTodasCategorias as $valor) {
            
            $boolSelected = false;
            $idDivisao = $valor['codigo_categoria'];
            
            if ($arrCategoriaTime && $idDivisao === $arrCategoriaTime['codigo_categoria']) {
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
} else if ($acao == 2) {

    $objCategoria = new Categoria();
    $items = $objCategoria->listarPorCodigo($id);

    if (!empty($items)) {
        echo json_encode($items);
    } else { 
        $json["mensagem"] = "codigo categoria invalido";
        echo json_encode($json);
    }    
} else if ($acao == 3) {
    $request_body = file_get_contents('php://input');
    $json    = json_decode($request_body, true);
    
    if (isset($json["p"]) && !empty($json["p"])) {
        $p = $json["p"];
    }
    
    $objCategoria = new Categoria();
    $items = $objCategoria->listarPorNome($p);

    if (!empty($items)) {
        $json  = "{\"categorias\":";
        $json .= json_encode($items);
        $json .= "}";
        echo $json;
    } else if(!empty($p)) {
        $json["mensagem"] = "Nenhum categoria encontrada com o termo buscado";
        echo json_encode($json);
    } else {
        $json["mensagem"] = "Nenhum categoria cadastrada";
        echo json_encode($json);
    }
} else if ($acao == 4) {
    $request_body = file_get_contents('php://input');
    $categoria    = json_decode($request_body, true);
    $objCategoria = new Categoria();
    $objCategoria->setNome($categoria["txtNome"]);	

    if ($objCategoria->inserir($token)) {
        $categoria["mensagem"] = "Categoria cadastrada com sucesso";
    } else {
        $categoria["mensagem"] = "Falha ao cadastrar categoria";	
    }

    $json = json_encode($categoria);
    echo $json;
} else if ($acao == 5) {
    $request_body = file_get_contents('php://input');
    $categoria    = json_decode($request_body, true);

    $objCategoria = new Categoria();
    $objCategoria->setCodigoCategoria($id);
    $objCategoria->setNome($categoria["txtNome"]);	

    $boolRetorno = $objCategoria->alterar($token);

    if ($boolRetorno === true) {	 	
          $categoria["mensagem"] = "Categoria atualizada com sucesso";	 	
    } else if ($boolRetorno == 999) {      
          $categoria["mensagem"] = "Sua sessão expirou. Faça o login novamente.";      
    } else {
          $categoria["mensagem"] = "Falha ao atualizar categoria";	
    }

    $json = json_encode($categoria);
    echo $json;
} else if ($acao == 6) {
    $categoria    = "";
    $objCategoria = new Categoria();
    $objCategoria->setCodigoCategoria($id);

    if ($objCategoria->validaFkCategoria($token)) {       
          $categoria["mensagem"] = "Falha ao excluir categoria. Existem um ou mais times vinculados a esta categoria.";        
    } else if ($objCategoria->excluir($token)) {	 	
          $categoria["mensagem"] = "Categoria excluida com sucesso";	 	
    } else {
          $categoria["mensagem"] = "Falha ao excluir categoria";	
    }

    $json = json_encode($categoria);
    echo $json;
}

$acao  = "";
$id    = "";
$token = "";
$p     = "";