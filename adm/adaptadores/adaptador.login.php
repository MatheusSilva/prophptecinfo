<?php
require_once "../classes/Login.php";
Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
