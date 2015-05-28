<?php
/**
* classe tecnicoRotas
*
* @author    Matheus Silva
* @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
*/
class tecnicoRotas
{
	/**
    * metodo construtor da classe tecnicoRotas
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
    * @since     27/05/2015
    * @version   0.1
    */
	function __construct($app)
	{
		$app->get('/tecnico', function () use ($app) {
    		require_once 'classes/tecnico.php';
		    $tecnico = new tecnico();
		    $db = new tecnico();
		    $items = $db->listarTudo();
		    $results = array();
		    
		    if($items) {
			// get all results
			foreach($items as $row) {
		
			    $itemArray = array(
				'codigo' => $row['codigo_tecnico'],
				'nome' => $row['nome'],
			    );
			    array_push($results, $itemArray);
			}
			$app->response()->header('Content-Type', 'application/json');
			$json = "{\"tecnicos\":";
			$json .= json_encode($results);
			$json .= "}";


			echo $json;
		    } else {
			$app->response()->status(500);
		    }
	
		});

		// GET route
		$app->get('/tecnico/:id', function ($id) use ($app) {
		    require_once 'classes/tecnico.php';
		$tecnico = new tecnico();
				//$tecnico->setNome($nome);
		    // GET with parameter
		    $db = new tecnico();
		    $items = $db->listarPorCodigo($id);
		    if($items) {
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode($items);
		    }
		    else {
			$app->response()->status(500);
		    }
	
		});

		// GET route
		$app->get('/tecnico/nome/:id', function ($id) use ($app) {
	
		    require_once 'classes/tecnico.php';
		$tecnico = new tecnico();
				//$tecnico->setNome($nome);
		    // GET with parameter
		    $db = new tecnico();
		    $items = $db->listarPorNome($id);
		    if($items) {
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode($items);
		    }
		    else {
			$app->response()->status(500);
		    }
	
		});

		$app->post('/tecnico', function () use ($app) {
		  require_once 'classes/tecnico.php';	
		  $tecnico    = json_decode($app->request->getBody(), true);
		  $objtecnico = new tecnico();
		  $objtecnico->setNome($tecnico["txtNome"]);	
		  
		  $dia  = $tecnico["cmbDia"];
		  $mes  = $tecnico["cmbMes"];
		  $ano  = $tecnico["cmbAno"];
		  $data = $dia."/".$mes."/".$ano;
		  $objtecnico->setData($data);

		  if($objtecnico->inserir()) {
		  	$tecnico["mensagem"] = "tecnico cadastrado com sucesso";	 	
		  } else {
		 	$tecnico["mensagem"] = "Falha ao cadastrar tecnico";	
		  }

		  $json = json_encode($tecnico);
		  echo $json;
		});

		$app->put('/tecnico/:id', function ($id) use ($app) {
		  require_once 'classes/tecnico.php';	
		  $tecnico    = json_decode($app->request->getBody(), true);
		  $objtecnico = new tecnico();
		  $objtecnico->setCodigoTecnico($id);
		  $objtecnico->setNome($tecnico["txtNome"]);	
		  

		  if($objtecnico->alterar()) {	 	
			$tecnico["mensagem"] = "tecnico atualizado com sucesso";	 	
		  } else {
		 	$tecnico["mensagem"] = "Falha ao atualizar tecnico";	
		  }

		  $json = json_encode($tecnico);
		  echo $json;

		});

		$app->delete('/tecnico/:id', function ($id) use ($app) {
		  require_once 'classes/tecnico.php';	
		  $tecnico    = json_decode($app->request->getBody(), true);
		  $objtecnico = new tecnico();
		  $objtecnico->setCodigoTecnico($id);

		  if ($objtecnico->excluir()) {	 	
		 	$tecnico["mensagem"] = "tecnico excluido com sucesso";	 	
		  } else {
		 	$tecnico["mensagem"] = "Falha ao excluir tecnico";	
		  }

		  $json = json_encode($tecnico);
		  echo $json;

		});
	}
}
