<?php
require_once "../../vendor/autoload.php";

use MatthiasMullie\Minify;

$basePathJs     = "/var/www/html/sistemaRest/javascript/";
$minifiedPathJs = $basePathJs.'scripts.min.js';

$minifier = new Minify\JS($basePathJs.'ajax.js');
$minifier->add($basePathJs.'valida_login.js');
$minifier->add($basePathJs.'categoria.js');
$minifier->add($basePathJs.'divisao.js');
$minifier->add($basePathJs.'tecnico.js');
$minifier->add($basePathJs.'time.js');
$minifier->minify($minifiedPathJs);
chmod($minifiedPathJs, 0777);
echo "arquivos unificados e minificados.";
