<?php
require_once "../../api/v1/vendor/autoload.php";
use lib\Login;

Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
