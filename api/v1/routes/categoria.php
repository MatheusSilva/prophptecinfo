<?php
    //http://localhost/sistemaRest/api/v1/categoria/057d01d5d593ffcfce32ce8d5730e595f60f38ba95c0433772e1e0645bc2ce5e //retorna todos os dados
    //http://localhost/sistemaRest/api/v1/categoria/057d01d5d593ffcfce32ce8d5730e595f60f38ba95c0433772e1e0645bc2ce5e/1 //pega dados categoria por 
    
    use matheus\sistemaRest\api\v1\model\Categoria;
    $objCategoria = new Categoria();

    $this->get('/{tk}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

    	$items = $objCategoria->listarTudo();
        $results = array();
        $strErros = $objCategoria->getErros();
        
        if (is_array($items) && empty($items) !== true) {
            // get all results
            foreach ($items as $row) {
                $itemArray = array(
                    'codigo' => $row['codigo_categoria'],
                    'nome' => $row['nome'],
                );
                array_push($results, $itemArray);
            }

            $json  = "{\"categorias\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
            $json = json_encode($json);
        } else {
            $json["mensagem"] = "Nenhum categoria cadastrada";
            $json = json_encode($json);
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->write($json);
    });

    $this->get('/{tk}/{id}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

        $items = $objCategoria->listarPorCodigo($args['id']);
        $strErros = $objCategoria->getErros();

        if (is_array($items) && empty($items) !== true) {
            $json = $items;
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $json["mensagem"] = "codigo categoria invalido";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->withJson($json);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->get('/{tk}/categoriatime/', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

        $arrTodasCategorias   = $objCategoria->listarTudo();
        $arrCategoriaTime   = $objCategoria->listaCategoriaPorTime(0, null);
        $results = array();
        $strErros = $objCategoria->getErros();

        if (is_array($arrTodasCategorias) && empty($arrTodasCategorias) !== true) {
            // get all results
            foreach ($arrTodasCategorias as $valor) {
                $boolSelected = false;
                $idDivisao = $valor['codigo_categoria'];
                
                if (is_array($arrCategoriaTime) && empty($arrCategoriaTime) !== true && $idDivisao === $arrCategoriaTime['codigo_categoria']) {
                    $boolSelected = true;
                }
                
                $itemArray = array(
                    'codigo' => $idDivisao,
                    'nome'   => $valor['nome'],
                    'selected'   => $boolSelected
                );
                
                array_push($results, $itemArray);
            }
            
            $json  = "{\"categorias\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $itemArray = array(
                    'codigo' => "",
                    'nome'   => "Nenhuma categoria cadastrada",
                    'selected'   => true
            );
                
            array_push($results, $itemArray);

            $json  = "{\"categorias\":";
            $json .= json_encode($results);
            $json .= "}";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });


    $this->get('/{tk}/categoriatime/{id}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

        $arrTodasCategorias   = $objCategoria->listarTudo();
        $arrCategoriaTime   = $objCategoria->listaCategoriaPorTime($args['id'], null);
        $results = array();
        $strErros = $objCategoria->getErros();

        if (is_array($arrTodasCategorias) && empty($arrTodasCategorias) !== true) {
            // get all results
            foreach ($arrTodasCategorias as $valor) {
                $boolSelected = false;
                $idDivisao = $valor['codigo_categoria'];
                
                if (is_array($arrCategoriaTime) && empty($arrCategoriaTime) !== true && $idDivisao === $arrCategoriaTime['codigo_categoria']) {
                    $boolSelected = true;
                }
                
                $itemArray = array(
                    'codigo' => $idDivisao,
                    'nome'   => $valor['nome'],
                    'selected'   => $boolSelected
                );
                
                array_push($results, $itemArray);
            }
            
            $json  = "{\"categorias\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $itemArray = array(
                    'codigo' => "",
                    'nome'   => "Nenhuma categoria cadastrada",
                    'selected'   => true
            );
                
            array_push($results, $itemArray);

            $json  = "{\"categorias\":";
            $json .= json_encode($results);
            $json .= "}";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });


    $this->get('/{tk}/pesquisanome/{nome}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

        $items = $objCategoria->listarPorNome($args['nome']);
        $strErros = $objCategoria->getErros();

        if (is_array($items) && empty($items) !== true) {
            $json  = "{\"categorias\":";
            $json .= json_encode($items);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
            $json = json_encode($json);
        } elseif (!empty($p)) {
            $json["mensagem"] = "Nenhum categoria encontrada com o termo buscado";
            $json = json_encode($json);
        } else {
            $json["mensagem"] = "Nenhum categoria cadastrada";
            $json = json_encode($json);
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });

    $this->post('/{tk}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

        //$request_body = file_get_contents('php://input');
        $categoria    = json_decode($request, true);

        $objCategoria->setNome($categoria["txtNome"]);

        $boolRetorno = $objCategoria->inserir();
        $strErros = $objCategoria->getErros();
        
        if ($boolRetorno === true) {
            $categoria["mensagem"] = "Categoria cadastrada com sucesso.";
        } elseif (!empty($strErros)) {
            $categoria["mensagem"] = $strErros;
        } else {
            $categoria["mensagem"] = "Falha ao cadastrar categoria.";
        }
        
        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($categoria);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->put('/{tk}/{id}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');
       
        //$request_body = file_get_contents('php://input');
        $categoria    = json_decode($request, true);

        $objCategoria->setCodigoCategoria($id);
        $objCategoria->setNome($categoria["txtNome"]);

        $boolRetorno = $objCategoria->alterar();
        $strErros = $objCategoria->getErros();

        if ($boolRetorno === true) {
            $categoria["mensagem"] = "Categoria alterada com sucesso.";
        } elseif (!empty($strErros)) {
            $categoria["mensagem"] = $strErros;
        } else {
            $categoria["mensagem"] = "Falha ao atualizar categoria";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($categoria);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->delete('/{tk}/{id}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken(isset($args['tk']) ? $args['tk'] : '');

        $categoria    = "";

        $objCategoria->setCodigoCategoria($args['id']);
        $boolRetorno = $objCategoria->excluir();
        $strErros = $objCategoria->getErros();

        if ($boolRetorno === true) {
            $categoria["mensagem"] = "Categoria excluida com sucesso.";
        } elseif (!empty($strErros)) {
            $categoria["mensagem"] = $strErros;
        } else {
            $categoria["mensagem"] = "Falha ao excluir categoria";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($categoria);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    }); 

    $this->any('/', function ($request, $response, $args) use ($objCategoria) {
            $arrJson["msg"] = "Token inválido";
            $status_code = 200;

            return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($arrJson);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->any('', function ($request, $response, $args) use ($objCategoria) {
            $arrJson["msg"] = "Token inválido";
            $status_code = 200;

            return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($arrJson);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });