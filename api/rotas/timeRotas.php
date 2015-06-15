<?php
/**
* classe timeRotas
*
* @author    Matheus Silva
* @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
*/
class timeRotas
{
	/**
    * metodo construtor da classe timeRotas
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
    * @since     27/05/2015
    * @version   0.1
    */
	function __construct($app)
	{
		$app->get('/time', function () use ($app) {
    		require_once 'classes/time.php';
		    $db = new time();
		    $items = $db->listarTudo();
		    $results = array();
		    
		    if($items) {
			// get all results
			foreach($items as $row) {
		
			    $itemArray = array(
				'codigo' => $row['codigo_time'],
				'nome' => $row['nome'],
			    );
			    array_push($results, $itemArray);
			}
			$app->response()->header('Content-Type', 'application/json');
			$json = "{\"times\":";
			$json .= json_encode($results);
			$json .= "}";


			echo $json;
		    } else {
			$app->response()->status(500);
		    }
	
		});

		// GET route
		$app->get('/time/:id', function ($id) use ($app) {
		    require_once 'classes/time.php';
		$time = new time();
				//$time->setNome($nome);
		    // GET with parameter
		    $db = new time();
		    $items = $db->listarPorCodigo($id);
		    if($items) {
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode($items);
		    }
		    else {
			$app->response()->status(500);
		    }
	
		});

		$app->get('/time/nome/:id', function ($id) use ($app) {
		    require_once 'classes/time.php';
		    $db    = new time();
		    $items = $db->listarPorNome($id);
                    
		    if (empty($items) === false) {
			$app->response()->header('Content-Type', 'application/json');
                        $json = "{\"times\":";
                        $items[] = array("mensagem" => "");
			$json .= json_encode($items);
			$json .= "}";
			echo $json;
		    } else {
                        $app->response()->header('Content-Type', 'application/json');
                        $json = "{\"times\":";
                        $arr[] = array("mensagem" => "Nenhum time encontrado");
			$json .= json_encode($arr);
			$json .= "}";
			echo $json;
		    }
	
		});

		$app->post('/time', function () use ($app) {
                    require_once 'classes/uploadimagem.php';
                    require_once 'classes/time.php';	
                  
                    $time = array(
                        'txtFoto' => $_FILES["txtFoto"],
                        'txtNome' => $app->request->post('txtNome'),
                        'cmbDivisao' => $app->request->post('cmbDivisao'),
                        'cmbCategoria' => $app->request->post('cmbCategoria'),
                        'cmbTecnico' => $app->request->post('cmbTecnico'),
                        'rDesempenhotime' => $app->request->post('rDesempenhotime'),
                        'rComprarnovojogador' => $app->request->post('rComprarnovojogador'),
                    );
                   
                    $foto 		= $time['txtFoto'];
                    $nome 		= $time['txtNome'];
                    $codigodivisao      = $time['cmbDivisao'];
                    $codigocategoria    = $time['cmbCategoria'];
                    $codigotecnico      = $time['cmbTecnico'];
                    $desempenhotime     = $time['rDesempenhotime'];
                    $comprarnovojogador = $time['rComprarnovojogador'];

                    $capa = UploadImagem::enviar($nome, $foto);

                    if($capa != '0') {
                        $objtime = new Time();
                        $objtime->setNome($nome);
                        $objtime->setCapa($capa);
                        $objtime->setCodigo_divisao($codigodivisao);
                        $objtime->setCodigo_categoria($codigocategoria);
                        $objtime->setCodigo_tecnico($codigotecnico);
                        $objtime->setDesempenhotime($desempenhotime);
                        $objtime->setComprarnovojogador($comprarnovojogador);

                        //die($capa);
                        if ($objtime->inserir()) {
                            $time["mensagem"] = "time cadastrado com sucesso";
                        } else {
                            $time["mensagem"] = "Falha ao cadastrar time";
                        }

                    } else {
                        $time["mensagem"] = "Problemas ao enviar imagem";
                    }
		
                    $capa = json_encode($time);
                    echo $capa;
                    
		});

		$app->post('/time/atualizar/:id', function ($id) use ($app) {
                    require_once 'classes/uploadimagem.php';
                    require_once 'classes/time.php';	
                  
                    $time = array(
                        'codigo' => $app->request->post('codigo'),
                        'txtFoto' => $_FILES["txtFoto"],
                        'txtNome' => $app->request->post('txtNome'),
                        'cmbDivisao' => $app->request->post('cmbDivisao'),
                        'cmbCategoria' => $app->request->post('cmbCategoria'),
                        'cmbTecnico' => $app->request->post('cmbTecnico'),
                        'rDesempenhotime' => $app->request->post('rDesempenhotime'),
                        'rComprarnovojogador' => $app->request->post('rComprarnovojogador'),
                    );
                   
                    $codigo 		= $time['codigo'];
                    $foto 		= $time['txtFoto'];
                    $nome 		= $time['txtNome'];
                    $codigodivisao      = $time['cmbDivisao'];
                    $codigocategoria    = $time['cmbCategoria'];
                    $codigotecnico      = $time['cmbTecnico'];
                    //$desempenhotime     = $time['rDesempenhotime'];
                    //$comprarnovojogador = $time['rComprarnovojogador'];

                    $capa = UploadImagem::enviar($nome, $foto);

                    if($capa != '0') {
                        $objtime = new Time();
                        $objtime->setCodigo_time($codigo);
                        $objtime->setNome($nome);
                        $objtime->setCapa($capa);
                        $objtime->setCodigo_divisao($codigodivisao);
                        $objtime->setCodigo_categoria($codigocategoria);
                        $objtime->setCodigo_tecnico($codigotecnico);
                        //$objtime->setDesempenhotime($desempenhotime);
                        //$objtime->setComprarnovojogador($comprarnovojogador);

                        //die($capa);
                        if ($objtime->alterar()) {
                            $time["mensagem"] = "time alterado com sucesso";
                        } else {
                            $time["mensagem"] = "Falha ao alterar time";
                        }

                    } else {
                        $time["mensagem"] = "Problemas ao enviar imagem";
                    }
		
                    $capa = json_encode($time);
                    echo $capa;
		});

		$app->delete('/time/:id', function ($id) use ($app) {
		  require_once 'classes/time.php';	
		  $time    = json_decode($app->request->getBody(), true);
		  $objtime = new time();
		  $objtime->setCodigo_time($id);

		  if ($objtime->excluir($id)) {	 	
		 	$time["mensagem"] = "time excluido com sucesso";	 	
		  } else {
		 	$time["mensagem"] = "Falha ao excluir time";	
		  }

		  $json = json_encode($time);
		  echo $json;

		});
	}
}
