<?php
namespace matheus\sistemaRest\api\v1\lib;

use matheus\sistemaRest\api\v1\model\Torcedor;

/**
* classe Login
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
abstract class Login
{
    /**
    * metodo que faz uma criptografia customizada estatica
    *
    * @access    public
    * @return    string Retorna o conteudo criptografado
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function criptografiaEstatica(
        $strConteudo = '',
        $algCripto = 'sha256',
        $salt1 = 'Xr7zjx1D14E55qRxHDutiQZkhyhmnk78asy793',
        $salt2 = 'h17E66DHuiQZr7zj1Dkhyh7mnk8asyqRx84',
        $salt3 = 'x24D8X3gTlqS8xK2aQwWy9nmfr5sAoQsx62',
        $numIteracoes = 2,
        $numCaracterSaida = 64
    ) {
        if (
            trim($strConteudo) == '' 
            || trim($algCripto) == '' 
            || trim($salt1) == '' 
            || trim($salt2) == ''
            || trim($salt3) == ''
        ) {
            return '';
        }
        
        return hash_pbkdf2($algCripto, $salt2.$strConteudo.$salt1, $salt3, $numIteracoes, $numCaracterSaida);
    }//public static function criptografiaEstatica()

    /**
    * metodo que faz uma criptografia customizada randomica
    *
    * @access    public
    * @return    string Retorna o conteudo criptografado
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function criptografiaRandomica(
        $strConteudo = '',
        $algCripto = 'sha256',
        $salt1 = 'jcxzknhxjajdulHGHAQZkhyhmnk789553',
        $salt2 = '893343hjgsjhbjlAHLKJHIDJiertokrjtkr',
        $salt3 = 'x24D8X3gTlqS8xK2aQwWy9nmfr5sAoQsx62',
        $numIteracoes = 2,
        $numCaracterSaida = 64
    ) {
        $rand = uniqid(rand(), true);

        if (
            trim($strConteudo) == '' 
            || trim($algCripto) == '' 
            || trim($salt1) == '' 
            || trim($salt2) == ''
            || trim($salt3) == ''
        ) {
            return '';
        }
        
        return hash_pbkdf2($algCripto, $salt2.$rand.$strConteudo.$salt1, $salt3, $numIteracoes, $numCaracterSaida);
    }//public static function criptografiaRandomica()


    /**
    * metodo que busca o ip real do usuario
    *
    * @access    public
    * @return    string Retorna o ip do usuario
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function retornaIpUsuario()
    {
        $http_client_ip = "";
        $http_x_forwarded_for = "";

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $http_client_ip       = $_SERVER['HTTP_CLIENT_IP'];
        }//if (isset($_SERVER['HTTP_CLIENT_IP'])) {

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }//if (isset($_SERVER['HTTP_CLIENT_IP'])) {

        $remote_addr          = $_SERVER['REMOTE_ADDR'];
         
        /* verifica se o ip existe */
        if (!empty($http_client_ip)) {
            $ip = $http_client_ip;
            /* verifica se o acesso é de um servidor proxy */
        } elseif (!empty($http_x_forwarded_for)) {
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

        $sql   = "\n SELECT nome, login, otpsecret, otpAtivado";
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

            $userAgent  = $_SERVER['HTTP_USER_AGENT'];
            $ip         = self::retornaIpUsuario();
            $token = self::criptografiaRandomica($userAgent.$torcedor.$ip);

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":token", $token);
            $stmt->bindParam(":torcedor", $torcedor);
            $stmt->bindParam(":senha", $senha);
            $retornoUpdate = $stmt->execute();

            if ($retornoUpdate) {
                if (!isset($_SESSION)) {
                    session_start();
                }//if (!isset($_SESSION)) {
                
                $_SESSION['ip']               = self::criptografiaEstatica($ip);
                $_SESSION['agentUser']        = self::criptografiaEstatica($userAgent);
                $_SESSION['u']                = $retornoSelect['login'];
                $conexao = null;
                setcookie("token", $token, time()+900, "/");

                if ($retornoSelect['otpAtivado'] == 1) {
                    header('location:../paginas/valida.autenticacao2fatores.htm');
                } else if (empty($retornoSelect['otpsecret']) || $retornoSelect['otpAtivado'] != 1) {
                    $_SESSION['logado']           = 'ok';
                    header('location:../paginas/home.php');
                }
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
        || $_SESSION['agentUser'] != self::criptografiaEstatica($_SERVER['HTTP_USER_AGENT'])
        || $_SESSION['ip'] != self::criptografiaEstatica(self::retornaIpUsuario())
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
    * metodo que verifica se o usuario esta logado com duas etapas
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function verificarCom2Etapas()
    {
        if (!isset($_SESSION)) {
            session_start();
        }//if (!isset($_SESSION)) {
        
        if ($_SESSION['agentUser'] != self::criptografiaEstatica($_SERVER['HTTP_USER_AGENT'])
        || $_SESSION['ip'] != self::criptografiaEstatica(self::retornaIpUsuario())
        || !isset($_COOKIE['token'])) {
           return false;
        }

        return true;
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
