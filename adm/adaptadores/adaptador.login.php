<?php
namespace sistemaRest\adm\adaptadores;
use sistemaRest\adm\classes\Login;
require '../../biblioteca/SplClassLoader.php';
$classLoader = new \SplClassLoader('sistemaRest\adm\classes');
$classLoader->register();

Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
