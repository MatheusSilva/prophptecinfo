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
        $app->get('/tecnico', function () use ($app) 
        {
            require_once 'classes/tecnico.php';
            $tecnico = new tecnico();
            $items   = $tecnico->listarTudo();
            $results = array();

            if ($items) {
                // get all results
                foreach($items as $row) {
                    $itemArray = array(
                        'codigo' => $row['codigo_tecnico'],
                        'nome' => $row['nome'],
                    );
                    array_push($results, $itemArray);
                }
                
                $app->response()->header('Content-Type', 'application/json');
                $json  = "{\"tecnicos\":";
                $json .= json_encode($results);
                $json .= "}";

                echo $json;
            } else {
                $app->response()->status(500);
            }
        });

        $app->get('/tecnicoTime/:id', function ($id) use ($app) 
        {
            require_once 'classes/tecnico.php';
            $objTecnico = new tecnico();
            $arrTodosTecnico   = $objTecnico->listarTudo();
            $arrTecnicoTime   = $objTecnico->listaTecnicoPorTime(null,$id);
            $results = array();
            
            if ($arrTodosTecnico) {
                // get all results
                foreach($arrTodosTecnico as $valor) {
                    
                    $boolSelected = false;
                    $idDivisao = $valor['codigo_tecnico'];
                    
                    if ($arrTecnicoTime && $idDivisao === $arrTecnicoTime['codigo_tecnico']) {
                        $boolSelected = true;
                    }
                    
                    $itemArray = array(
                        'codigo' => $idDivisao,
                        'nome'   => $valor['nome'],
                        'selected'   => $boolSelected
                    );
                    
                    array_push($results, $itemArray);
                }
                
                $app->response()->header('Content-Type', 'application/json');
                $json = "{\"tecnicos\":";
                $json .= json_encode($results);
                $json .= "}";

                echo $json;
            } else {
                $json = "{\"tecnicos\":";
                $json .= json_encode(array());
                $json .= "}";
            }     
        });
        
        // GET route
        $app->get('/tecnico/:id', function ($id) use ($app) 
        {
            require_once 'classes/tecnico.php';
            $tecnico = new tecnico();
            $items = $tecnico->listarPorCodigo($id);
            
            if ($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }
        });

        // GET route
        $app->get('/tecnico/nome/:id', function ($id) use ($app) 
        {
            require_once 'classes/tecnico.php';
            $tecnico = new tecnico();
            $items   = $tecnico->listarPorNome($id);
            
            if($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }
        });
        
        $app->post('/tecnico/:token', function ($token) use ($app)
        {
            require_once 'classes/tecnico.php';	
            $tecnico    = json_decode($app->request->getBody(), true);
            $objtecnico = new tecnico();
            $objtecnico->setNome($tecnico["txtNome"]);	

            $dia  = $tecnico["cmbDia"];
            $mes  = $tecnico["cmbMes"];
            $ano  = $tecnico["cmbAno"];
            $data = $dia."/".$mes."/".$ano;
            $objtecnico->setData($data);

            if ($objtecnico->inserir($token)) {
                $tecnico["mensagem"] = "tecnico cadastrado com sucesso";	 	
            } else {
                $tecnico["mensagem"] = "Falha ao cadastrar tecnico";	
            }

            $json = json_encode($tecnico);
            echo $json;
        });

        $app->put('/tecnico/:id/:token', function ($id, $token) use ($app)
        {
            require_once 'classes/tecnico.php';	
            $tecnico    = json_decode($app->request->getBody(), true);
            $objtecnico = new tecnico();
            $objtecnico->setCodigoTecnico($id);
            $objtecnico->setNome($tecnico["txtNome"]);	


            if ($objtecnico->alterar($token)) {	 	
                $tecnico["mensagem"] = "tecnico atualizado com sucesso";	 	
            } else {
                $tecnico["mensagem"] = "Falha ao atualizar tecnico";	
            }

            $json = json_encode($tecnico);
            echo $json;
        });

        $app->delete('/tecnico/:id/:token', function ($id, $token) use ($app)    
        {
            require_once 'classes/tecnico.php';	
            $tecnico    = json_decode($app->request->getBody(), true);
            $objtecnico = new tecnico();
            $objtecnico->setCodigoTecnico($id);

            if ($objtecnico->excluir($token)) {	 	
                $tecnico["mensagem"] = "tecnico excluido com sucesso";	 	
            } else {
                $tecnico["mensagem"] = "Falha ao excluir tecnico";	
            }

            $json = json_encode($tecnico);
            echo $json;
        });
    }
}
