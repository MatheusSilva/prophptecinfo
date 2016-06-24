<?php
namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;
use Respect\Validation\Validator as v;
use Otp\Otp;
use Otp\GoogleAuthenticator;
use Base32\Base32;

/**
* classe Tecnico
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Torcedor extends ClasseBase
{
    /**
    * metodo constutor
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function __construct()
    {

    }//public function __construct()

    /**
    * metodo que tem função de excluir o tecnico
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function desativarAutenticacao2fatores()
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $sql   = "\n UPDATE torcedor";
            $sql  .= "\n SET otpsecret = :otpsecret";
            $sql  .= "\n ,otpativado = :otpativado";
            $sql  .= "\n WHERE token = :token";

            $token = $this->getToken();
            $otpsecret = "";
            $otpAtivado = 0;

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":token", $token, \PDO::PARAM_INT);
            $stmt->bindParam(":otpsecret", $otpsecret, \PDO::PARAM_STR);
            $stmt->bindParam(":otpativado", $otpAtivado, \PDO::PARAM_INT);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function desativarAutenticacao2fatores()

    /**
    * metodo que tem função de excluir o tecnico
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function ativarAutenticacao2fatores()
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $secret = GoogleAuthenticator::generateRandom();
                
            $sql   = "\n UPDATE torcedor";
            $sql  .= "\n SET otpsecret = :otpsecret";
            $sql  .= "\n WHERE token = :token";

            $token = $this->getToken();

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":token", $token, \PDO::PARAM_INT);
            $stmt->bindParam(":otpsecret", $secret, \PDO::PARAM_STR);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function desativarAutenticacao2fatores()

    /**
    * metodo que tem função de verificar se autenticação 2 fatores esta ativa
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function tokenAutenticacao2fatores()
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {
    
            $sql   = "\n SELECT otpsecret, otpAtivado";
            $sql  .= "\n FROM torcedor";
            $sql  .= "\n WHERE token = :token";

            $token = $this->getToken();
            $otpsecret = "";

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":token", $token, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function desativarAutenticacao2fatores()


    /**
    * metodo que tem função de verificar se autenticação 2 fatores esta ativa
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function retornaBase64ImgAutenticacao2fatores()
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {
    
            $secret = $this->tokenAutenticacao2fatores();

            if (empty($secret["otpsecret"])) {
                return '';
            }

            $secret = trim($secret["otpsecret"]);

            $otp = new Otp();
            return GoogleAuthenticator::getQrCodeUrl('totp', 'sistemaRest', $secret);
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function desativarAutenticacao2fatores()


    /**
    * metodo que tem função de verificar se autenticação 2 fatores esta ativa
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function tokenAutenticacao2fatoresEhValido($key)
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {
        
            $key = preg_replace('/[^0-9]/', '', $key);
    
            // Standard is 6 for keys, but can be changed with setDigits on $otp
            if (strlen($key) == 6) {
                $secret = $this->tokenAutenticacao2fatores();

                if (empty($secret["otpsecret"])) {
                    return 2; // nao verifica o token de autenticacao 2 fatores e valido pois o mesmo nao existe
                }
                
                $secret = trim($secret["otpsecret"]);
                
                $key = (int) $key;
                
                $otp = new Otp();
                
                if ($otp->checkTotp(Base32::decode($secret), $key)) {
                    return 1;
                    //o token de autenticacao 2 fatores esta incorreto 
                } else {
                    return 0;
                }
            } else {
                return 3; //tamanho do token de autenticacao 2 fatores esta incorreto
            }

        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function desativarAutenticacao2fatores()


    /**
    * metodo que tem função de verificar se autenticação 2 fatores esta ativa
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setTokenAutenticacao2fatoresAtivado()
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $otpAtivado = "1";
                
            $sql   = "\n UPDATE torcedor";
            $sql  .= "\n SET otpativado = :otpativado";
            $sql  .= "\n WHERE token = :token";

            $token = $this->getToken();

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":token", $token, \PDO::PARAM_INT);
            $stmt->bindParam(":otpativado", $otpAtivado, \PDO::PARAM_STR);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }
}
