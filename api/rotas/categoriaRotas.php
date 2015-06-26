<?php
/**
* classe categoriaRotas
*
* @author    Matheus Silva
* @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
*/
class categoriaRotas
{
    /**
    * metodo construtor da classe categoriaRotas
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
    * @since     27/05/2015
    * @version   0.1
    */
    function __construct($app)
    {
        $app->get('/categoria', function () use ($app) 
        {
            $url = "cache/todasCategorias.json";
            $cacheFile = 'cache' . DIRECTORY_SEPARATOR . md5($url);
            $json = "";

            if (file_exists($cacheFile)) {
                $fh = fopen($cacheFile, 'r');
                $cacheTime = trim(fgets($fh));

                // if data was cached recently, return cached data
                if ($cacheTime > strtotime('-10 minutes')) {
                    $json = fread($fh, filesize ($cacheFile));
                } else {
                    fclose($fh);
                    unlink($cacheFile);
                }
            }//if (file_exists($cacheFile)) {

            if (empty($json)) {
                require_once 'classes/categoria.php';
                $objCategoria = new Categoria();
                $items = $objCategoria->listarTudo();
                $results = array();

                if ($items) {
                    // get all results
                    foreach($items as $row) {
                        $itemArray = array(
                            'codigo' => $row['codigo_categoria'],
                            'nome' => $row['nome'],
                        );
                        array_push($results, $itemArray);
                    }

                    $app->response()->header('Content-Type', 'application/json');
                    $json = "{\"categorias\":";
                    $json .= json_encode($results);
                    $json .= "}";

                    $fh = fopen($cacheFile, 'w');
                    fwrite($fh, time() . "\n");
                    fwrite($fh, $json);
                    fclose($fh);

                    echo $json;
                } else {
                    $app->response()->status(500);
                }
            } else {
                echo $json;
            }
        });

        $app->get('/categoriaTime/:id', function ($id) use ($app) 
        {
            require_once 'classes/categoria.php';
            $objCategoria = new Categoria();
            $arrTodasCategorias   = $objCategoria->listarTudo();
            $arrCategoriaTime   = $objCategoria->listaCategoriaPorTime(null,$id);
            $results = array();
            
            if ($arrTodasCategorias) {
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
                
                $app->response()->header('Content-Type', 'application/json');
                $json = "{\"categorias\":";
                $json .= json_encode($results);
                $json .= "}";

                echo $json;
            } else {
                $json = "{\"categorias\":";
                $json .= json_encode(array());
                $json .= "}";
            }     
        });
        
        // GET route
        $app->get('/categoria/:id', function ($id) use ($app) 
        {
            require_once 'classes/categoria.php';
            $objCategoria = new Categoria();
            $items = $objCategoria->listarPorCodigo($id);

            if($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }
        });

        // GET route
        $app->get('/categoria/nome/:id', function ($id) use ($app) 
        {
            require_once 'classes/categoria.php';
            $objCategoria = new Categoria();
            $items = $objCategoria->listarPorNome($id);

            if ($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }
        });

        $app->post('/categoria/:token', function ($token) use ($app) 
        {
            require_once 'classes/categoria.php';	
            $categoria    = json_decode($app->request->getBody(), true);
            $objCategoria = new Categoria();
            $objCategoria->setNome($categoria["txtNome"]);	

            if ($objCategoria->inserir($token)) {
                $categoria["mensagem"] = "Categoria cadastrada com sucesso";
            } else {
                $categoria["mensagem"] = "Falha ao cadastrar categoria";	
            }

            $json = json_encode($categoria);
            echo $json;
        });

        $app->put('/categoria/:id/:token', function ($id, $token) use ($app) 
        {
            require_once 'classes/categoria.php';
            $categoria    = json_decode($app->request->getBody(), true);
            $objCategoria = new Categoria();
            $objCategoria->setCodigoCategoria($id);
            $objCategoria->setNome($categoria["txtNome"]);	

            if ($objCategoria->alterar($token)) {	 	
                  $categoria["mensagem"] = "Categoria atualizada com sucesso";	 	
            } else {
                  $categoria["mensagem"] = "Falha ao atualizar categoria";	
            }

            $json = json_encode($categoria);
            echo $json;
        });

        $app->delete('/categoria/:id/:token', function ($id, $token) use ($app) 
        {
            require_once 'classes/categoria.php';	
            $categoria    = json_decode($app->request->getBody(), true);
            $objCategoria = new Categoria();
            $objCategoria->setCodigoCategoria($id);

            if ($objCategoria->excluir($token)) {	 	
                  $categoria["mensagem"] = "Categoria excluida com sucesso";	 	
            } else {
                  $categoria["mensagem"] = "Falha ao excluir categoria";	
            }

            $json = json_encode($categoria);
            echo $json;
        });
    }
}