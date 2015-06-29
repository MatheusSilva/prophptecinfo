<?php
require '../biblioteca/vendor/slim/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

$app->get('/', function () {
  echo "Index ";
});

require '../biblioteca/SplClassLoader.php';

$classLoader = new \SplClassLoader('sistemaRest\api\rotas');
$classLoader->register();

use sistemaRest\api\rotas\CategoriaRotas as sisApiRotCategoriaRotas;
$objCategoria = new sisApiRotCategoriaRotas($app);

use sistemaRest\api\rotas\DivisaoRotas as sisApiRotDivisaoRotas;
$objDivisao = new sisApiRotDivisaoRotas($app);

use sistemaRest\api\rotas\TecnicoRotas as sisApiRotTecnicoRotas;
$objTecnico = new sisApiRotTecnicoRotas($app);

use sistemaRest\api\rotas\TimeRotas as sisApiRotTimeRotas;
$objtimeRotas = new sisApiRotTimeRotas($app);

$app->run();
