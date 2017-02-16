<?php
    // so copiado e colado da técnico ajustar e incluir outros atributos

    //http://localhost/sistemaRest/api/v1/tecnico //retorna todos os dados
    //http://localhost/sistemaRest/api/v1/tecnico/1 //pega dados técnico por 
    
    use matheus\sistemaRest\api\v1\model\Tecnico;
    $objTecnico = new Tecnico();

    $this->get('/', function ($request, $response, $args) use ($objTecnico) {
        $objTecnico->setToken($request->getHeader('tk')[0]);

    	$items = $objTecnico->listarTudo();
        $results = array();
        $strErros = $objTecnico->getErros();

        if (is_array($items) && empty($items) !== true) {
            // get all results

            /*
            foreach ($items as $row) {
                $itemArray = array(
                    'codigo' => $row['codigo_tecnico'],
                    'nome' => $row['nome'],
                );
                array_push($results, $itemArray);
            }
            */

            $json  = "{\"tecnicos\":";
            $json .= json_encode($items);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
            $json = json_encode($json);
        } else {
            $json["mensagem"] = "Nenhum técnico cadastrado.";
            $json = json_encode($json);
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->write($json);
    });

    $this->get('/{id}', function ($request, $response, $args) use ($objTecnico) {
        $objTecnico->setToken($request->getHeader('tk')[0]);

        $items = $objTecnico->listarPorCodigo($args['id']);
        $strErros = $objTecnico->getErros();

        if (is_array($items) && empty($items) !== true) {
            $json = $items;
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $json["mensagem"] = "Codigo técnico inválido.";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->withJson($json);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->post('/', function ($request, $response, $args) use ($objTecnico) {
        $tecnico = $request->getParsedBody();

        $objTecnico->setToken($request->getHeader('tk')[0]);
        $objTecnico->setNome($tecnico["txtNome"]);

        $dia  = $tecnico["cmbDia"];
        $mes  = $tecnico["cmbMes"];
        $ano  = $tecnico["cmbAno"];
        $data = $dia."/".$mes."/".$ano;

        $objTecnico->setData($data);

        $boolRetorno = $objTecnico->inserir();
        $strErros = $objTecnico->getErros();
        
        if ($boolRetorno === true) {
            $tecnico["mensagem"] = "Técnico cadastrado com sucesso.";
        } elseif (!empty($strErros)) {
            $tecnico["mensagem"] = $strErros;
        } else {
            $tecnico["mensagem"] = "Falha ao cadastrar técnico.";
        }
        
        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($tecnico);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->put('/{id}', function ($request, $response, $args) use ($objTecnico) {
        $tecnico = $request->getParsedBody();

        $objTecnico->setCodigoTecnico(isset($args['id']) ? $args['id'] : '');
        $objTecnico->setToken($request->getHeader('tk')[0]);
        $objTecnico->setNome($tecnico["txtNome"]);

        $dia  = $tecnico["cmbDia"];
        $mes  = $tecnico["cmbMes"];
        $ano  = $tecnico["cmbAno"];
        $data = $dia."/".$mes."/".$ano;
        
        $objTecnico->setData($data);

        $boolRetorno = $objTecnico->alterar();
        $strErros = $objTecnico->getErros();

        if ($boolRetorno === true) {
            $tecnico["mensagem"] = "Técnico alterado com sucesso.";
        } elseif (!empty($strErros)) {
            $tecnico["mensagem"] = $strErros;
        } else {
            $tecnico["mensagem"] = "Falha ao atualizar técnico.";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($tecnico);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->delete('/{id}', function ($request, $response, $args) use ($objTecnico) {
        $tecnico = $request->getParsedBody();

        $objTecnico->setCodigoTecnico(isset($args['id']) ? $args['id'] : '');
        $objTecnico->setToken($request->getHeader('tk')[0]);

        $tecnico    = "";
        $boolRetorno = $objTecnico->excluir();
        $strErros = $objTecnico->getErros();

        if ($boolRetorno === true) {
            $tecnico["mensagem"] = "Técnico excluido com sucesso.";
        } elseif (!empty($strErros)) {
            $tecnico["mensagem"] = $strErros;
        } else {
            $tecnico["mensagem"] = "Falha ao excluir técnico.";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withJson($tecnico);//usar apenas quando a variavel é um array quando for json em forma de string usar write
    });

    $this->get('/tecnicotime/', function ($request, $response, $args) use ($objTecnico) {
        $objTecnico->setToken($request->getHeader('tk')[0]);

        $arrTodastecnicos   = $objTecnico->listarTudo();
        $arrtecnicoTime   = $objTecnico->listatecnicoPorTime(0, null);
        $results = array();
        $strErros = $objTecnico->getErros();

        if (is_array($arrTodastecnicos) && empty($arrTodastecnicos) !== true) {
            // get all results
            foreach ($arrTodastecnicos as $valor) {
                $boolSelected = false;
                $idtecnico = $valor['codigo_tecnico'];
                
                if (is_array($arrtecnicoTime) && empty($arrtecnicoTime) !== true && $idtecnico === $arrtecnicoTime['codigo_tecnico']) {
                    $boolSelected = true;
                }
                
                $itemArray = array(
                    'codigo' => $idtecnico,
                    'nome'   => $valor['nome'],
                    'selected'   => $boolSelected
                );
                
                array_push($results, $itemArray);
            }
            
            $json  = "{\"tecnicos\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $itemArray = array(
                    'codigo' => "",
                    'nome'   => "Nenhum técnico cadastrado.",
                    'selected'   => true
            );
                
            array_push($results, $itemArray);

            $json  = "{\"tecnicos\":";
            $json .= json_encode($results);
            $json .= "}";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });


    $this->get('/tecnicotime/{id}', function ($request, $response, $args) use ($objTecnico) {
        $objTecnico->setToken($request->getHeader('tk')[0]);

        $arrTodastecnicos   = $objTecnico->listarTudo();
        $arrtecnicoTime   = $objTecnico->listatecnicoPorTime($args['id'], null);
        $results = array();
        $strErros = $objTecnico->getErros();

        if (is_array($arrTodastecnicos) && empty($arrTodastecnicos) !== true) {
            // get all results
            foreach ($arrTodastecnicos as $valor) {
                $boolSelected = false;
                $idtecnico = $valor['codigo_tecnico'];
                
                if (is_array($arrtecnicoTime) && empty($arrtecnicoTime) !== true && $idtecnico === $arrtecnicoTime['codigo_tecnico']) {
                    $boolSelected = true;
                }
                
                $itemArray = array(
                    'codigo' => $idtecnico,
                    'nome'   => $valor['nome'],
                    'selected'   => $boolSelected
                );
                
                array_push($results, $itemArray);
            }
            
            $json  = "{\"tecnicos\":";
            $json .= json_encode($results);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
        } else {
            $itemArray = array(
                    'codigo' => "",
                    'nome'   => "Nenhum técnico cadastrado.",
                    'selected'   => true
            );
                
            array_push($results, $itemArray);

            $json  = "{\"tecnicos\":";
            $json .= json_encode($results);
            $json .= "}";
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });


    $this->get('/pesquisanome/{nome}', function ($request, $response, $args) use ($objTecnico) {
        $objTecnico->setToken($request->getHeader('tk')[0]);

        $items = $objTecnico->listarPorNome("%".$args['nome']);
        $strErros = $objTecnico->getErros();

        if (is_array($items) && empty($items) !== true) {
            $json  = "{\"tecnicos\":";
            $json .= json_encode($items);
            $json .= "}";
        } elseif (!empty($strErros)) {
            $json["mensagem"] = $strErros;
            $json = json_encode($json);
        } elseif (!empty($p)) {
            $json["mensagem"] = "Nenhum técnico encontrado com o termo buscado.";
            $json = json_encode($json);
        } else {
            $json["mensagem"] = "Nenhum técnico cadastrado.";
            $json = json_encode($json);
        }

        $status_code = 200;

        return $response->withStatus((int) $status_code)
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->write($json);//usar write quando for json em string quando for array usar withJson
    });

    