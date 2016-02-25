<?php
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

    }//public function __construct()

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
    public function getCodigoDivisao()
    {
        return $this->codigoDivisao;
    }//public function getCodigoDivisao()

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
    public function setCodigoDivisao($codigo)
    {
        $this->codigoDivisao = $codigo;
    }//public function setCodigoDivisao($codigo)

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
    public function getNome()
    {
        return $this->nome;
    }//public function getNome()

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
    public function setNome($nome)
    {
        $this->nome = $nome;
    }//public function setNome($nome)

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
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function existeDivisao()
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM divisao AS dv";
            $sql  .= "\n WHERE dv.codigo_divisao = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $this->getCodigoDivisao(), \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno["resultado"];
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function existeDivisao()

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

            $codigo = $this->getCodigoDivisao();
            $nome   = $this->getNome();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao alterar divisão. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeDivisao() != 1) {
                $this->setErro("Falha ao alterar divisão. Código inexistente.");
                return 997;
            }//if ($this->existeDivisao() != 1) {

            if (!(v::alnum()->length(2, 25)->validate($nome))) {
                $this->setErro("O nome da divisão deve ser alfanumérico de 2 a 25 caracteres.");
                return 996;
            }

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

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $this->getCodigoDivisao(), \PDO::PARAM_INT);
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
            if ($this->tokenEhValido() !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $codigo = $this->getCodigoDivisao();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao excluir divisão. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeDivisao() != 1) {
                $this->setErro("Falha ao excluir divisão. Código inexistente.");
                return 997;
            }//if ($this->existeDivisao() != 1) {

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
    public static function listarPorCodigo($codigo)
    {
        try {
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
    }//public static function listarPorCodigo($codigo)
    
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
    public static function listarPorNome($nome)
    {
        try {
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
    }//public static function listarPorNome($codigo)

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
    public static function listarTudo()
    {
        try {
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
    }//public static function listarTudo()
    
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
    public static function listaDivisaoPorTime($intCodigoTime)
    {
        try {
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
    }//public static function listaDivisaoPorTime($intCodigo)
}//class Divisao extends ClasseBase
