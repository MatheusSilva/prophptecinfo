<?php
/**
* classe divisaoRotas
*
* @author    Matheus Silva
* @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
*/
class divisaoRotas
{
    /**
    * metodo construtor da classe divisaoRotas
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
    * @since     27/05/2015
    * @version   0.1
    */
    function __construct($app)
    {
        $app->get('/divisao', function () use ($app) 
        {
            require_once 'classes/divisao.php';
            $divisao = new divisao();
            $db      = new divisao();
            $items   = $db->listarTudo();
            $results = array();

            if ($items) {
                // get all results
                foreach($items as $row) {
                    $itemArray = array(
                        'codigo' => $row['codigo_divisao'],
                        'nome'   => $row['nome'],
                    );
                    array_push($results, $itemArray);
                }
                
                $app->response()->header('Content-Type', 'application/json');
                $json = "{\"divisaos\":";
                $json .= json_encode($results);
                $json .= "}";

                echo $json;
            } else {
                $app->response()->status(500);
            }
        });

        // GET route
        $app->get('/divisao/:id', function ($id) use ($app) 
        {
            require_once 'classes/divisao.php';
            $divisao = new divisao();
            $items   = $divisao->listarPorCodigo($id);
            
            if ($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }
        });

        // GET route
        $app->get('/divisao/nome/:id', function ($id) use ($app) 
        {
            require_once 'classes/divisao.php';
            $divisao = new divisao();
            $items   = $divisao->listarPorNome($id);
            
            if ($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }
        });

        $app->post('/divisao/:token', function ($token) use ($app) 
        {
            require_once 'classes/divisao.php';	
            $divisao    = json_decode($app->request->getBody(), true);
            $objdivisao = new divisao();
            $objdivisao->setNome($divisao["txtNome"]);	

            if ($objdivisao->inserir($token)) {
                $divisao["mensagem"] = "divisao cadastrada com sucesso";	 	
            } else {
                $divisao["mensagem"] = "Falha ao cadastrar divisao";	
            }

            $json = json_encode($divisao);
            echo $json;
        });

        $app->put('/divisao/:id/:token', function ($id, $token) use ($app) 
        {
            require_once 'classes/divisao.php';	
            $divisao    = json_decode($app->request->getBody(), true);
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
        });

        $app->delete('/divisao/:id/:token', function ($id, $token) use ($app) 
        {
            require_once 'classes/divisao.php';	
            $divisao    = json_decode($app->request->getBody(), true);
            $objdivisao = new divisao();
            $objdivisao->setCodigo_divisao($id);

            if ($objdivisao->excluir($token)) {	 	
                  $divisao["mensagem"] = "divisao excluida com sucesso";	 	
            } else {
                  $divisao["mensagem"] = "Falha ao excluir divisao";	
            }

            $json = json_encode($divisao);
            echo $json;
        });
    }
}
