<?php
    //http://localhost/sistemaRest/api/v1/categoria //retorna todos os dados
    //http://localhost/sistemaRest/api/v1/categoria/1 //pega dados categoria por 
    
    use matheus\sistemaRest\api\v1\model\Categoria;
    $objCategoria = new Categoria();

    $this->get('/', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken($request->getHeader('tk')[0]);

    	$items = $objCategoria->listarTudo();
        $results = array();
        $strErros = $objCategoria->getErros();

        if (is_array($items) && empty($items) !== true) {
            // get all results

            /*
            foreach ($items as $row) {
                $itemArray = array(
                    'codigo' => $row['codigo_categoria'],
                    'nome' => $row['nome'],
                );
                array_push($results, $itemArray);
            }*/

            $json  = "{\"categorias\":";
            $json .= json_encode($items);
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

    $this->get('/{id}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken($request->getHeader('tk')[0]);

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

    $this->post('/', function ($request, $response, $args) use ($objCategoria) {
        $categoria = $request->getParsedBody();

        $objCategoria->setToken($request->getHeader('tk')[0]);
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

    $this->put('/{id}', function ($request, $response, $args) use ($objCategoria) {
        $categoria = $request->getParsedBody();

        $objCategoria->setCodigoCategoria(isset($args['id']) ? $args['id'] : '');
        $objCategoria->setToken($request->getHeader('tk')[0]);
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

    $this->delete('/{id}', function ($request, $response, $args) use ($objCategoria) {
        $categoria = $request->getParsedBody();

        $objCategoria->setCodigoCategoria(isset($args['id']) ? $args['id'] : '');
        $objCategoria->setToken($request->getHeader('tk')[0]);

        $categoria    = "";
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

    $this->get('/categoriatime/', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken($request->getHeader('tk')[0]);

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


    $this->get('/categoriatime/{id}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken($request->getHeader('tk')[0]);

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


    $this->get('/pesquisanome/{nome}', function ($request, $response, $args) use ($objCategoria) {
        $objCategoria->setToken($request->getHeader('tk')[0]);

        $items = $objCategoria->listarPorNome("%".$args['nome']);
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

    