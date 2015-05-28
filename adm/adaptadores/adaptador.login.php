<?php
//adaptador.login.php

require_once('../classes/login.php');
Login::entrar($_POST['txtTorcedor'], $_POST['txtSenha']);
