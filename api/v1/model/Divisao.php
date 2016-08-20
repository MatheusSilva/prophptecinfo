<?php
//declare(strict_types=1);//nao utilizar pois qualquer tipo de dados diferente vai parar a aplicação, validar dados pelo validator

namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;
use Respect\Validation\Validator as v;

/**
* classe Divisao
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Divisao extends ClasseBase
{
    /**
    * @access private
    * @var integer Armazena o codigo da divisão
    */
    private $codigoDivisao;

    /**
    * @access private
    * @var string Armazena o nome da divisão
    */
    private $nome;

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
        $this->setNome('');
        $this->setCodigoDivisao(0);
    }//public function limpaPropriedades()

    /**
    * metodo acessor Get que retorna a informação da propriedade codigoDivisao
    *
    * @access    public
    * @return    integer Retorna o codigo da divisao
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getCodigoDivisao() : int
    {
        return $this->codigoDivisao;
    }//public function getCodigoDivisao() : int

    /**
    * metodo acessor Set que carrega informação na propriedade codigoDivisao
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo atual
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoDivisao(int $codigo)
    {
        $this->codigoDivisao = $codigo;
    }//public function setCodigoDivisao(int $codigo)

    /**
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome da divisao
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
    * @param     string $nome Armazena o nome atual
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
    * metodo que tem função de verificar se ja existe outra divisao com mesmo nome e id
    *
    * @access    public
    * @return    boolean retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function existeNomeComEsseId() : bool
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM divisao AS dvi";
            $sql  .= "\n WHERE dvi.codigo_divisao = :id";
            $sql  .= "\n AND dvi.nome = :nome";

            $stmt = Conexao::getConexao()->prepare($sql);
            $codigo  = $this->getCodigoDivisao();
            $nome    = $this->getNome();
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($retorno["resultado"] == 1) {
                return true;
            }//if ($retorno["resultado"] != 1) {

            return false;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function existeNomeComEsseId() : bool

    /**
    * metodo que tem função de verificar se ja existe outra divisao com mesmo nome
    *
    * @access    public
    * @return    boolean retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function validaNomeDivisao() : bool
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM divisao AS dvi";
            $sql  .= "\n WHERE dvi.nome = :nome";

            $stmt = Conexao::getConexao()->prepare($sql);
            $nome    = $this->getNome();
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($retorno["resultado"] != 1) {
                return true;
            }//if ($retorno["resultado"] != 1) {

            $this->setErro("Divisão duplicada, escolha outro nome.");
            return false;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaNomeDivisao() : bool

    /**
    * metodo que tem função de inserir a divisão
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
            $retorno = true;
            
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $nome  = $this->getNome();
            
            if (!(v::alnum()->length(2, 25)->validate($nome))) {
                $this->setErro("O nome da divisão deve ser alfanumérico de 2 a 25 caracteres.");
                return 998;
            }
            
            $retorno = $this->validaNomeDivisao();

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            $sql   = "\n INSERT INTO divisao (";
            $sql  .= "\n nome";
            $sql  .= "\n ) VALUES (";
            $sql  .= "\n :nome";
            $sql  .= "\n )";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 25);
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
    }//public function inserir()

    /**
    * metodo que tem função de fazer validacao da restricao de integridade
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo da divisao
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function validaCodigoDivisao(int $codigo)
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            if (is_numeric($codigo) === false) {
                $this->setErro("Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {    

            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM divisao AS dv";
            $sql  .= "\n WHERE dv.codigo_divisao = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($retorno["resultado"] != 1) {
                $this->setErro("Código inexistente.");
                return 997;
            }

            return true;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaCodigoDivisao()

    /**
    * metodo que tem função de alterar a divisão
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
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $codigo  = $this->getCodigoDivisao();
            $nome    = $this->getNome();
            $retorno = $this->validaCodigoDivisao($codigo);

            if ($retorno !== true) {
                return $retorno;
            }//if ($retorno !== true) {

            if ($this->existeNomeComEsseId() == true) {
                return true;
            }//if ($this->existeNomeComEsseId()) {
                
            if (!(v::alnum()->length(2, 25)->validate($nome))) {
                $this->setErro("O nome da divisão deve ser alfanumérico de 2 a 25 caracteres.");
                return 996;
            }

            $retorno = $this->validaNomeDivisao();

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            $sql   = "\n UPDATE divisao";
            $sql  .= "\n SET nome = :nome";
            $sql  .= "\n WHERE Codigo_divisao = :codigo";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 25);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);
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
    }//public function alterar()

    /**
    * metodo que tem função de fazer validacao da restricao de integridade
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function validaFkDivisao()
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM divisao AS dv";
            $sql  .= "\n ,time AS tim";
            $sql  .= "\n WHERE tim.divisao_codigo_divisao = dv.codigo_divisao";
            $sql  .= "\n AND dv.codigo_divisao = :id";

            $codigoDivisao = $this->getCodigoDivisao();
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $codigoDivisao, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno["resultado"];
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaFkDivisao()

    /**
    * metodo que tem função de excluir a divisão
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function excluir()
    {
        try {
            $codigo = $this->getCodigoDivisao();
            $retorno = $this->validaCodigoDivisao($codigo);
            
            if ($retorno !== true) {
                return $retorno;
            }//if ($retorno !== true) {
                
            if ($this->validaFkDivisao()) {
                $this->setErro("Falha ao excluir divisão. Existem um ou mais times vinculados a esta divisão.");
                return 996;
            }//if ($this->validaFkDivisao()) {

            $sql   = "\n DELETE";
            $sql  .= "\n FROM divisao";
            $sql  .= "\n WHERE codigo_divisao = :codigo";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);
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
    }//public function excluir()

    /**
    * metodo que tem função de listar a divisão pelo código.
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo da divisão.
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listarPorCodigo(int $codigo)
    {
        try {
            $retorno = $this->validaCodigoDivisao($codigo);

            if ($retorno !== true) {
                return $retorno;
            }//if ($retorno !== true) {

            $sql   = "\n SELECT codigo_divisao";
            $sql  .= "\n ,nome";
            $sql  .= "\n FROM divisao";
            $sql  .= "\n WHERE codigo_divisao = :codigo";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarPorCodigo($codigo)
    
    /**
    * metodo que tem função de listar a divisão por nome.
    *
    * @access    public
    * @param     string $nome Armazena o nome da divisão.
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listarPorNome(string $nome)
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $sql   = "\n SELECT codigo_divisao";
            $sql  .= "\n ,nome";
            $sql  .= "\n FROM divisao";
            
            if (!empty($nome)) {
                $sql .= "\n WHERE nome LIKE :nome";
            }//if (!empty($nome)) {

            $stmt = Conexao::getConexao()->prepare($sql);
            
            if (!empty($nome)) {
                $nome = trim($nome)."%";
                $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 25);
            }//if (!empty($nome)) {

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarPorNome($codigo)

    /**
    * metodo que tem função de listar as divisoes.
    *
    * @access    public
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listarTudo()
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $sql   = "\n SELECT codigo_divisao";
            $sql  .= "\n ,nome";
            $sql  .= "\n FROM divisao";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarTudo()
    
    /**
    * metodo que tem função de listar a divisão pelo codigo do time.
    *
    * @access    public
    * @param     integer $intCodigoTime Armazena o codigo do time.
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listaDivisaoPorTime(int $intCodigoTime)
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            if (is_numeric($intCodigoTime) === false) {
                $this->setErro("Código inválido.");
                return array();
            }//if (is_numeric($codigo) === false) {
                
            $sql   = "\n SELECT d.codigo_divisao";
            $sql  .= "\n ,d.nome";
            $sql  .= "\n FROM time AS t";
            $sql  .= "\n ,divisao AS d";
            $sql  .= "\n WHERE  d.codigo_divisao = t.divisao_codigo_divisao";
            $sql  .= "\n AND t.codigo_time = :codigo";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":codigo", $intCodigoTime, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listaDivisaoPorTime($intCodigo)
}//class Divisao extends ClasseBase
