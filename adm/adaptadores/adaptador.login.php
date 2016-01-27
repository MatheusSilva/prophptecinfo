<?php
require_once "../../api/v1/lib/Login.php";
use lib\Login;

Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
