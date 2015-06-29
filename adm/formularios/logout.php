<?php
// logout.php
use sistemaRest\adm\classes\Login;

require '../../biblioteca/SplClassLoader.php';
$classLoader = new \SplClassLoader('sistemaRest\adm\classes');
$classLoader->register();
        
Login::sair();