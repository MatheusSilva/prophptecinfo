<?php
require_once '../../../biblioteca/vendor/autoload.php';

use MatthiasMullie\Minify;

$basePathJs = "/var/www/html/sistemaRest/javascript/";

$minifier = new Minify\JS($basePathJs.'ajax.js');

$arrJs[] = $basePathJs.'valida_login.js';
$arrJs[] = $basePathJs.'categoria.js';
$arrJs[] = $basePathJs.'divisao.js';
$arrJs[] = $basePathJs.'tecnico.js';
$arrJs[] = $basePathJs.'time.js';

foreach ($arrJs as $val) {
    $minifier->add($val);
}

// save minified file to disk
$minifiedPathJs = $basePathJs.'scripts.min.js';
$minifier->minify($minifiedPathJs);
chmod($minifiedPathJs, 0777);

echo "arquivos unificados e minificados.";
