<?php
require_once "../../api/v1/lib/Login.php";
Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
