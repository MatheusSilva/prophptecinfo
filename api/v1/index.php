<?php
error_reporting(-1);
ini_set('display_errors', 1);

session_start();// this MUST be called prior to any output including whitespaces and line breaks!

require_once '../../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/logs/app.log',
            //'level' => \Monolog\Logger::DEBUG,
        ],
    ],
]);

header('Content-Type: application/json');

$app->group('/categoria', function() {
    include_once 'routes/categoria.php';
});

$app->group('/divisao', function() {
    include_once 'routes/divisao.php';
});

$app->group('/tecnico', function() {
    include_once 'routes/tecnico.php';
});

$app->run();