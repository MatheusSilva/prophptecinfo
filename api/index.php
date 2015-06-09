<?php
require '../biblioteca/vendor/slim/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

$app->get('/', function () {
  echo "Index ";
});

require_once 'rotas/categoriaRotas.php';
$objCategoria = new categoriaRotas($app);

require_once 'rotas/divisaoRotas.php';
$objDivisao = new divisaoRotas($app);

require_once 'rotas/tecnicoRotas.php';
$objTecnico = new tecnicoRotas($app);

require_once 'rotas/timeRotas.php';
$objtimeRotas = new timeRotas($app);

$app->run();
