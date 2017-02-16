<?php
    //http://localhost/sistemaRest/api/v1/divisao //retorna todos os dados
    //http://localhost/sistemaRest/api/v1/divisao/1 //pega dados divisão por 
    
    use matheus\sistemaRest\api\v1\model\Divisao;
    $objDivisao = new Divisao();

    $this->get('/', function ($request, $response, $args) use ($objDivisao) {
        $objDivisao->setToken($request->getHeader('tk')[0]);

    	$items = $objDivisao->listarTudo();
        $results = array();
        $strErros = $objDivisao->getErros();

        if (is_array($items) && empty($items) !== true) {
            // get all results

            /*
            foreach ($items as $row) {
                $itemArray = array(
                    'codigo' => $row['codigo_divisao'],
                    'nome' => $row['nome'],
                );
                array_push($results, $itemArray);
            }*/

            $json  = "{\"divisaos\":";
            $json .= json_encode($items);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
            $json = json_encode($json);
        } else {
            $json["mensagem"] = "Nenhum divisão cadastrada";
            $json = json_encode($json);
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->write($json);
    });

    $this->get('/{id}', function ($request, $response, $args) use ($objDivisao) {
        $objDivisao->setToken($request->getHeader('tk')[0]);

        $items = $objDivisao->listarPorCodigo($args['id']);
        $strErros = $objDivisao->getErros();

        if (is_array($items) && empty($items) !== true) {
            $json = $items;
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $json["mensagem"] = "codigo divisão invalido";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->withJson($json);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->post('/', function ($request, $response, $args) use ($objDivisao) {
        $divisao = $request->getParsedBody();

        $objDivisao->setToken($request->getHeader('tk')[0]);
        $objDivisao->setNome($divisao["txtNome"]);

        $boolRetorno = $objDivisao->inserir();
        $strErros = $objDivisao->getErros();
        
        if ($boolRetorno === true) {
            $divisao["mensagem"] = "Divisão cadastrada com sucesso.";
        } elseif (!empty($strErros)) {
            $divisao["mensagem"] = $strErros;
        } else {
            $divisao["mensagem"] = "Falha ao cadastrar divisão.";
        }
        
        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($divisao);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->put('/{id}', function ($request, $response, $args) use ($objDivisao) {
        $divisao = $request->getParsedBody();

        $objDivisao->setCodigoDivisao(isset($args['id']) ? $args['id'] : '');
        $objDivisao->setToken($request->getHeader('tk')[0]);
        $objDivisao->setNome($divisao["txtNome"]);

        $boolRetorno = $objDivisao->alterar();
        $strErros = $objDivisao->getErros();

        if ($boolRetorno === true) {
            $divisao["mensagem"] = "Divisão alterada com sucesso.";
        } elseif (!empty($strErros)) {
            $divisao["mensagem"] = $strErros;
        } else {
            $divisao["mensagem"] = "Falha ao atualizar divisão";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($divisao);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->delete('/{id}', function ($request, $response, $args) use ($objDivisao) {
        $divisao = $request->getParsedBody();

        $objDivisao->setCodigoDivisao(isset($args['id']) ? $args['id'] : '');
        $objDivisao->setToken($request->getHeader('tk')[0]);

        $divisao    = "";
        $boolRetorno = $objDivisao->excluir();
        $strErros = $objDivisao->getErros();

        if ($boolRetorno === true) {
            $divisao["mensagem"] = "Divisão excluida com sucesso.";
        } elseif (!empty($strErros)) {
            $divisao["mensagem"] = $strErros;
        } else {
            $divisao["mensagem"] = "Falha ao excluir divisão";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($divisao);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->get('/divisaotime/', function ($request, $response, $args) use ($objDivisao) {
        $objDivisao->setToken($request->getHeader('tk')[0]);

        $arrTodasDivisaos   = $objDivisao->listarTudo();
        $arrDivisaoTime   = $objDivisao->listaDivisaoPorTime(0, null);
        $results = array();
        $strErros = $objDivisao->getErros();

        if (is_array($arrTodasDivisaos) && empty($arrTodasDivisaos) !== true) {
            // get all results
            foreach ($arrTodasDivisaos as $valor) {
                $boolSelected = false;
                $idDivisao = $valor['codigo_divisao'];
                
                if (is_array($arrDivisaoTime) && empty($arrDivisaoTime) !== true && $idDivisao === $arrDivisaoTime['codigo_divisao']) {
                    $boolSelected = true;
                }
                
                $itemArray = array(
                    'codigo' => $idDivisao,
                    'nome'   => $valor['nome'],
                    'selected'   => $boolSelected
                );
                
                array_push($results, $itemArray);
            }
            
            $json  = "{\"divisaos\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $itemArray = array(
                    'codigo' => "",
                    'nome'   => "Nenhuma divisão cadastrada",
                    'selected'   => true
            );
                
            array_push($results, $itemArray);

            $json  = "{\"divisaos\":";
            $json .= json_encode($results);
            $json .= "}";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });


    $this->get('/divisaotime/{id}', function ($request, $response, $args) use ($objDivisao) {
        $objDivisao->setToken($request->getHeader('tk')[0]);

        $arrTodasDivisaos   = $objDivisao->listarTudo();
        $arrDivisaoTime   = $objDivisao->listaDivisaoPorTime($args['id'], null);
        $results = array();
        $strErros = $objDivisao->getErros();

        if (is_array($arrTodasDivisaos) && empty($arrTodasDivisaos) !== true) {
            // get all results
            foreach ($arrTodasDivisaos as $valor) {
                $boolSelected = false;
                $idDivisao = $valor['codigo_divisao'];
                
                if (is_array($arrDivisaoTime) && empty($arrDivisaoTime) !== true && $idDivisao === $arrDivisaoTime['codigo_divisao']) {
                    $boolSelected = true;
                }
                
                $itemArray = array(
                    'codigo' => $idDivisao,
                    'nome'   => $valor['nome'],
                    'selected'   => $boolSelected
                );
                
                array_push($results, $itemArray);
            }
            
            $json  = "{\"divisaos\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $itemArray = array(
                    'codigo' => "",
                    'nome'   => "Nenhuma divisão cadastrada",
                    'selected'   => true
            );
                
            array_push($results, $itemArray);

            $json  = "{\"divisaos\":";
            $json .= json_encode($results);
            $json .= "}";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });


    $this->get('/pesquisanome/{nome}', function ($request, $response, $args) use ($objDivisao) {
        $objDivisao->setToken($request->getHeader('tk')[0]);

        $items = $objDivisao->listarPorNome("%".$args['nome']);
        $strErros = $objDivisao->getErros();

        if (is_array($items) && empty($items) !== true) {
            $json  = "{\"divisaos\":";
            $json .= json_encode($items);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
            $json = json_encode($json);
        } elseif (!empty($p)) {
            $json["mensagem"] = "Nenhum divisão encontrada com o termo buscado";
            $json = json_encode($json);
        } else {
            $json["mensagem"] = "Nenhum divisão cadastrada";
            $json = json_encode($json);
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });

    