<?php
//declare(strict_types=1);//nao utilizar pois qualquer tipo de dados diferente vai parar a aplicação, validar dados pelo validator

namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\Conexao;
use matheus\sistemaRest\api\v1\lib\Login;

//conflito de classes juntar esta classe ao outra , mesmo nome e mesmo namespace
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
    * @var string Armazena o email do torcedor
    */
    private $email;

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
        $this->limpaPropriedades();
    }//public function __construct()
    
    /**
    * metodo limpa todas as propriedades da classe
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     20/08/2016
    * @version   0.1
    */
    public function limpaPropriedades()
    {
        $this->setCodigoTorcedor(0);
        $this->setNome('');
        $this->setEmail('');
        $this->setLogin('');
        $this->setSenha('');
    }//public function limpaPropriedades()

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
    public function getCodigoTorcedor() : int
    {
        return $this->codigoTorcedor;
    }//public function getCodigoTorcedor() : int
    
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
    public function setCodigoTorcedor(int $codigo)
    {
        $this->codigoTorcedor = $codigo;
    }//public function setCodigoTorcedor(int $codigo)

    /**
    * metodo acessor Get que retorna a informação da propriedade email
    *
    * @access    public
    * @return    string Retorna o email do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     12/08/2016
    * @version   0.1
    */
    public function getEmail() : string
    {
        return $this->email;
    }//public function getEmail() : string
    
    /**
    * metodo acessor Set que carrega informação na propriedade email
    *
    * @access    public
    * @param     string $email Armazena o email do torcedor
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     12/08/2016
    * @version   0.1
    */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }//public function setEmail(string $email)
    
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
    public function getNome() : string
    {
        return $this->nome;
    }//public function getNome() : string
    
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
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }//public function setNome(string $nome)
    
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
    public function getLogin() : string
    {
        return $this->login;
    }//public function getLogin() : string
    
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
    public function setLogin(string $login)
    {
        $this->login = $login;
    }//public function setLogin(string $login)
    
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
    public function getSenha() : string
    {
        return $this->senha;
    }//public function getSenha() : string
    
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
    public function setSenha(string $senha)
    {
        $salt1 = "15353oiwHSDDKFJNGmfnsjfjqbhdgkjk";
        $salt2 = "NSBDFSDBFisoetiihskkdfgjfdkj56767";
        $salt3 = "zXCdsqGHiSpYxwHqJ8r7F21pFe93452";
        $this->senha =  Login::criptografiaEstatica($senha, 'sha512', $salt1, $salt2, $salt3, 4, 128);
    }//public function setSenha(string $senha)
    
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
            $nome   = $this->getNome();
            $login  = $this->getLogin();
            $senha  = $this->getSenha();
            $email  = $this->getEmail();
            
            $sql    = "\n INSERT INTO `torcedor`(";
            $sql   .= "\n nome";
            $sql   .= "\n ,login";
            $sql   .= "\n ,email";
            $sql   .= "\n ,senha";
            $sql   .= "\n ) VALUES (";
            $sql   .= "\n :nome";
            $sql   .= "\n ,:login";
            $sql   .= "\n ,:email";
            $sql   .= "\n ,:senha";
            $sql   .= "\n )";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":email", $email);
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
            $email  = $this->getEmail();
            
            $sql    = "\n UPDATE torcedor";
            $sql   .= "\n SET nome              = :nome";
            $sql   .= "\n ,login                = :login";
            $sql   .= "\n ,senha                = :senha";
            $sql   .= "\n ,email                = :email";
            $sql   .= "\n WHERE codigo_torcedor = :codigo";
                    
            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":senha", $senha);
            $stmt->bindParam(":email", $email);
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
    public function excluir(int $codigo)
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
    }//public function excluir(int $codigo)
    
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
    public static function listarPorCodigo(int $codigo)
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
    }//public static function listarPorCodigo(int $codigo)
    
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
    public static function listarPorNome(string $nome)
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
    }//public static function listarPorNome(string $nome)
    
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
    public static function listarPorLogin(string $login)
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
    }//public static function listarPorLogin(string $login)
    
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
