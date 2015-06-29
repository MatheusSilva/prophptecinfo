<?php
namespace sistemaRest\api\rotas;
use sistemaRest\api\classes\Time as time;
use sistemaRest\api\classes\UploadImagem;

/**
* classe timeRotas
*
* @author    Matheus Silva
* @copyright © Copyright 2015 Matheus Silva. Todos os direitos reservados.
*/
class TimeRotas
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
        $classLoader = new \SplClassLoader('sistemaRest\api\classes');
        $classLoader->register();
        
        $app->get('/time', function () use ($app) 
        {
            $db      = new time();
            $items   = $db->listarTudo();
            $results = array();

            if ($items) {
                // get all results
                foreach($items as $row) {
                    $itemArray = array(
                        'codigo' => $row['codigo_time'],
                        'codigoDivisao' => $row['divisao_codigo_divisao'],
                        'nome' => $row['nome'],
                        'capa' => "../".$row['capa'],
                    );
                    array_push($results, $itemArray);
                }
                //os valores selecionados estao incorretos
                $app->response()->header('Content-Type', 'application/json');
                $json  = "{\"times\":";
                $json .= json_encode($results);
                $json .= "}";
                echo $json;
            } else {
                $results = array();
                $json  = "{\"times\":";
                $json .= json_encode($results);
                $json .= "}";
                echo $json;
            }
        });

        // GET route
        $app->get('/time/:id', function ($id) use ($app) 
        {
            $time = new time();
                        //$time->setNome($nome);
            // GET with parameter
            $db     = new time();
            $items  = $db->listarPorCodigo($id);
            
            if ($items) {
                $app->response()->header('Content-Type', 'application/json');
                echo json_encode($items);
            } else {
                $app->response()->status(500);
            }

        });

        $app->get('/time/nome/:id', function ($id) use ($app) 
        {
            $db    = new time();
            $items = $db->listarPorNome($id);

            if (empty($items) === false) {
                $app->response()->header('Content-Type', 'application/json');
                $json    = "{\"times\":";
                $items[] = array("mensagem" => "");
                $json   .= json_encode($items);
                $json   .= "}";
                echo $json;
            } else {
                $app->response()->header('Content-Type', 'application/json');
                $json  = "{\"times\":";
                $arr[] = array("mensagem" => "Nenhum time encontrado");
                $json .= json_encode($arr);
                $json .= "}";
                echo $json;
            }
        });

        $app->post('/time/:token', function ($token) use ($app) 
        {
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

            if ($capa !== '0') {
                $objtime = new Time();
                $objtime->setNome($nome);
                $objtime->setCapa($capa);
                $objtime->setCodigo_divisao($codigodivisao);
                $objtime->setCodigo_categoria($codigocategoria);
                $objtime->setCodigo_tecnico($codigotecnico);
                $objtime->setDesempenhotime($desempenhotime);
                $objtime->setComprarnovojogador($comprarnovojogador);

                if ($objtime->inserir($token)) {
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

        $app->post('/time/atualizar/:id/:token', function ($id, $token) use ($app) 
        {
            $txtFoto = '';
            
            if(array_key_exists('txtFoto', $_FILES)) {
                $txtFoto = $_FILES["txtFoto"];     
            }
            
            $time = array(
                'codigo' => $app->request->post('codigo'),
                'txtFoto' => $txtFoto,
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
            $capa = '';
            
            if (!empty($nome) && !empty($foto)) {
                $capa = UploadImagem::enviar($nome, $foto);
            }
            
            if ($capa != '0') {
                $objtime = new Time();
                $objtime->setCodigo_time($codigo);
                $objtime->setNome($nome);
                $objtime->setCapa($capa);
                $objtime->setCodigo_divisao($codigodivisao);
                $objtime->setCodigo_categoria($codigocategoria);
                $objtime->setCodigo_tecnico($codigotecnico);
                //$objtime->setDesempenhotime($desempenhotime);
                //$objtime->setComprarnovojogador($comprarnovojogador);

                if ($objtime->alterar($token)) {
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

        $app->post('/time/excluir/:id/:token', function ($id, $token) use ($app) 
        {
            $time    = json_decode($app->request->getBody(), true);
            $objtime = new time();
            $objtime->setCodigo_time($id);
            $retorno = $objtime->excluir($id, $token);
            
            if ($retorno === true) {	 	
                $time["mensagem"] = "Time excluido com sucesso";	 	
            } else if($retorno !== false) {
                $time["mensagem"] = $retorno;	
            } else {
                $time["mensagem"] = "Falha ao excluir time";	
            }

            $json = json_encode($time);
            echo $json;
        });
    }
}
