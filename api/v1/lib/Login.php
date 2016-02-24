<?php
namespace matheus\sistemaRest\api\v1\lib;

use matheus\sistemaRest\api\v1\model\Torcedor;

/**
* classe Login
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Login
{
    /**
    * metodo que busca o ip real do usuario
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function retornaIpUsuario()
    {
        $http_client_ip       = $_SERVER['HTTP_CLIENT_IP'];
        $http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote_addr          = $_SERVER['REMOTE_ADDR'];
         
        /* verifica se o ip existe */
        if(!empty($http_client_ip)){
            $ip = $http_client_ip;
            /* verifica se o acesso é de um servidor proxy */
        } elseif(!empty($http_x_forwarded_for)){
            $ip = $http_x_forwarded_for;
        } else {
            /* caso contrario pega o ip normal do usuario */
            $ip = $remote_addr;
        }

        return $ip;
    }//public static function retornaIpUsuario()

    /**
    * metodo que faz o login do usuario no sistema
    *
    * @access    public
    * @param     string $torcedor Armazena o login do torcedor
    * @param     string $senha Armazena a senha do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function entrar($torcedor, $senha)
    {
        require_once "Conexao.php";
        require_once "../../api/v1/torcedor/Torcedor.php";

        $objTorcedor = new Torcedor();

        $objTorcedor->setSenha($senha);
        $senha = $objTorcedor->getSenha();

        $sql   = "\n SELECT nome, login";
        $sql  .= "\n FROM torcedor";
        $sql  .= "\n WHERE login = :torcedor";
        $sql  .= "\n AND senha = :senha";
                  
        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":torcedor", $torcedor);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();
        $retornoSelect =  $stmt->fetch(\PDO::FETCH_ASSOC);
                
        if (empty($retornoSelect) === false) {
            $sql   = "\n UPDATE torcedor";
            $sql  .= "\n SET token   = :token";
            $sql  .= "\n WHERE login = :torcedor";
            $sql  .= "\n AND senha   = :senha";

            $salt1      = "jcxzknhxjajduhlJHDGHAQZkhyhmnk789553";
            $salt2      = "893343hjgsjhbjlAHLKJHIDJiertokrjtkr";
            $rand       = uniqid(rand(), true);
            $userAgent  = $_SERVER['HTTP_USER_AGENT'];
            $ip         = self::retornaIpUsuario();
            $token = hash('sha256', $userAgent.$salt2.$rand.$senha.$salt1.$ip);

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":token", $token);
            $stmt->bindParam(":torcedor", $torcedor);
            $stmt->bindParam(":senha", $senha);
            $retornoUpdate = $stmt->execute();

            if ($retornoUpdate) {
                if (!isset($_SESSION)) {
                    session_start();
                }//if (!isset($_SESSION)) {
                
                $_SESSION['ip']               = $ip;
                $_SESSION['agentUser']        = $userAgent;
                $_SESSION['logado']           = 'ok';
                $_SESSION['u']                = $retornoSelect['login'];
                $conexao = null;
                setcookie("token", $token, time()+900, "/");
                header('location:../paginas/home.php');
            } else {
                $msg = urlencode('Login falhou! Verifique seus dados');
                $conexao = null;
                header("location:../formularios/form.login.php?msg=$msg");
            }//if ($retornoUpdate) {
        } else {
            $conexao = null;
            $msg = urlencode('Login falhou! Verifique seus dados');
            header("location:../formularios/form.login.php?msg=$msg");
        }//if (empty($retornoSelect) === false) {
    }//public static function entrar($torcedor, $senha)
    
    /**
    * metodo que verifica se o usuario esta logado
    *
    * @access    public
    * @param     boolean $redirecionar Armazena uma flag que indica se tem que redicionar para outra pagina
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function verificar($redirecionar = true)
    {
        if (!isset($_SESSION)) {
            session_start();
        }//if (!isset($_SESSION)) {
        
        if (!isset($_SESSION['logado'])
        || $_SESSION['logado'] != 'ok'
        || $_SESSION['agentUser'] != $_SERVER['HTTP_USER_AGENT']
        || $_SESSION['ip'] != self::retornaIpUsuario()
        || !isset($_COOKIE['token'])) {
            self::sair($redirecionar);

            if ($redirecionar) {
                $msg = urlencode('Acesso restrito. Efetue login para continuar');
                header("location:../formularios/form.login.php?msg=$msg");
            }//if ($redirecionar) {
        } else {
            $token = $_COOKIE["token"];
            setcookie("token", $token, time()+900, "/");
        }
    }//public static function verificar($redirecionar = true)
    
    /**
    * metodo que faz o logout do usuario
    *
    * @access    public
    * @param     boolean $redirecionar indica se e para redirecionar para outra pagina ou nao ao fazer login
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function sair($redirecionar = true)
    {
        if (!isset($_SESSION)) {
            session_start();
        }//if (!isset($_SESSION)) {
            
        setcookie('token', null, -1, '/');
        
        $sql   = "\n UPDATE torcedor";
        $sql  .= "\n SET    token = :token";
        $sql  .= "\n WHERE  login = :torcedor";
        
        $token = "";
        
        require_once 'Conexao.php';
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindParam(":torcedor", $_SESSION['u']);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        $_SESSION['logado']    = '';
        $_SESSION['u']         = '';
        $_SESSION['agentUser'] = '';
        $_SESSION['ip']        = '';
        session_destroy();
        
        if ($redirecionar) {
            header('location:../../site/paginas/home.html');
        }//if ($redirecionar) {
    }//public static function sair($redirecionar = true)
}//class Login
