<?php
namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\Conexao;
use matheus\sistemaRest\api\v1\lib\Login;

/**
* classe Torcedor
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Torcedor
{
    /**
    * @access private
    * @var integer Armazena o codigo do torcedor
    */
    private $codigoTorcedor;

    /**
    * @access private
    * @var string Armazena o nome do torcedor
    */
    private $nome;

    /**
    * @access private
    * @var string Armazena o login do torcedor
    */
    private $login;

    /**
    * @access private
    * @var string Armazena a senha do torcedor
    */
    private $senha;
    
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
        require_once "../../vendor/autoload.php";
    }//public function __construct()
    
    /**
    * metodo acessor Get que retorna a informação da propriedade codigoTorcedor
    *
    * @access    public
    * @return    integer Retorna o codigo do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getCodigoTorcedor()
    {
        return $this->codigoTorcedor;
    }//public function getCodigoTorcedor()
    
    /**
    * metodo acessor Set que carrega informação na propriedade codigoTorcedor
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoTorcedor($codigo)
    {
        $this->codigoTorcedor = $codigo;
    }//public function setCodigoTorcedor($codigo)
    
    /**
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getNome()
    {
        return $this->nome;
    }//public function getNome()
    
    /**
    * metodo acessor Set que carrega informação na propriedade nome
    *
    * @access    public
    * @param     string $nome Armazena o nome do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }//public function setNome($nome)
    
    /**
    * metodo acessor Get que retorna a informação da propriedade login
    *
    * @access    public
    * @return    string Retorna o login do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getLogin()
    {
        return $this->login;
    }//public function getLogin()
    
    /**
    * metodo acessor Set que carrega informação na propriedade login
    *
    * @access    public
    * @param     string $login Armazena o login do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setLogin($login)
    {
        $this->login = $login;
    }//public function setLogin($login)
    
    /**
    * metodo acessor Get que retorna a informação da propriedade senha
    *
    * @access    public
    * @return    string Retorna o senha do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getSenha()
    {
        return $this->senha;
    }//public function getSenha()
    
    /**
    * metodo acessor Set que carrega informação na propriedade senha
    *
    * @access    public
    * @param     string $senha Armazena a senha do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setSenha($senha)
    {
        $salt1 = "15353oiwHSDDKFJNGmfnsjfjqbhdgkjk";
        $salt2 = "NSBDFSDBFisoetiihskkdfgjfdkj56767";
        $salt3 = "zXCdsqGHiSpYxwHqJ8r7F21pFe93452";
        $this->senha =  Login::criptografiaEstatica($senha, 'sha512', $salt1, $salt2, $salt3, 4, 128);
    }//public function setSenha($senha)
    
    /**
    * metodo que tem função de inserir o torcedor
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function inserir()
    {
        try {
            $nome  = $this->getNome();
            $login = $this->getLogin();
            $senha = $this->getSenha();
            
            $sql    = "\n INSERT INTO `torcedor`(";
            $sql   .= "\n nome";
            $sql   .= "\n ,login";
            $sql   .= "\n ,senha";
            $sql   .= "\n ) VALUES (";
            $sql   .= "\n :nome";
            $sql   .= "\n ,:login";
            $sql   .= "\n ,:senha";
            $sql   .= "\n )";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":senha", $senha);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function inserir()
    
    /**
    * metodo que tem função de alterar o torcedor
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function alterar()
    {
        try {
            $codigo = $this->getCodigoTorcedor();
            $nome   = $this->getNome();
            $login  = $this->getLogin();
            $senha  = $this->getSenha();
            
            $sql    = "\n UPDATE torcedor";
            $sql   .= "\n SET nome 			    = :nome";
            $sql   .= "\n ,login   			    = :login";
            $sql   .= "\n ,senha   			    = :senha";
            $sql   .= "\n WHERE codigo_torcedor = :codigo";
                    
            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":senha", $senha);
            $stmt->bindParam(":codigo", $codigo);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function alterar()
    
    /**
    * metodo que tem função de excluir o torcedor
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo do torcedor
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function excluir($codigo)
    {
        try {
            $sql     = "\n DELETE";
            $sql    .= "\n FROM torcedor";
            $sql    .= "\n WHERE codigo_torcedor = :codigo";
                    
            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $codigo);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function excluir($codigo)
    
    /**
    * metodo que tem função de listar o torcedor por codigo
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo do torcedor
    * @return    array retorna todos os dados
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarPorCodigo($codigo)
    {
        try {
            $sql     = "\n SELECT codigo_torcedor";
            $sql    .= "\n ,nome";
            $sql    .= "\n ,login";
            $sql    .= "\n ,senha";
            $sql    .= "\n ,token";
            $sql    .= "\n FROM torcedor";
            $sql    .= "\n WHERE codigo_torcedor = :codigo";
                    
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":codigo", $codigo);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public static function listarPorCodigo($codigo)
    
    /**
    * metodo que tem função de listar o torcedor por nome
    *
    * @access    public
    * @param     string $nome Armazena o nome do torcedor
    * @return    array retorna todos os dados
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarPorNome($nome)
    {
        try {
            $sql     = "\n SELECT codigo_torcedor";
            $sql    .= "\n ,nome";
            $sql    .= "\n ,login";
            $sql    .= "\n ,senha";
            $sql    .= "\n ,token";
            $sql    .= "\n FROM torcedor";
            $sql    .= "\n WHERE nome LIKE :nome";
            
            $nome .= "%";
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public static function listarPorNome($nome)
    
    /**
    * metodo que tem função de listar o torcedor por login
    *
    * @access    public
    * @param     string $login Armazena o login do torcedor
    * @return    array retorna todos os dados
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarPorLogin($login)
    {
        try {
            $sql     = "\n SELECT codigo_torcedor";
            $sql    .= "\n ,nome";
            $sql    .= "\n ,login";
            $sql    .= "\n ,senha";
            $sql    .= "\n ,token";
            $sql    .= "\n FROM torcedor";
            $sql    .= "\n WHERE login LIKE :login";
            
            $login  .= "%";
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":login", $login);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public static function listarPorLogin($login)
    
    /**
    * metodo que tem função de listar todos os torcedores
    *
    * @access    public
    * @return    array retorna todos os dados
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarTudo()
    {
        try {
            $sql     = "\n SELECT codigo_torcedor";
            $sql    .= "\n ,nome";
            $sql    .= "\n ,login";
            $sql    .= "\n ,senha";
            $sql    .= "\n ,token";
            $sql    .= "\n FROM torcedor";
            
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public static function listarTudo()
}//class Torcedor
