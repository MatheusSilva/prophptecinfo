<?php
error_reporting(-1);
require_once "../../vendor/autoload.php";
use matheus\sistemaRest\api\v1\lib\Login;

try {
	Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
} catch(Exception $e) {
	echo $e;
}