<?php
namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;

/**
* classe Divisao
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Divisao extends ClasseBase
{
    private $codigoDivisao;
    private $nome;

    public function __construct()
    {
    }

    public function getCodigoDivisao()
    {
        return $this->codigoDivisao;
    }

    public function setCodigoDivisao($codigo)
    {
        $this->codigoDivisao = $codigo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function inserir($token)
    {
        try {
            $retorno = true;

            if ($this->tokenEhValido($token) === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido($token) === false) {

            $nome  = $this->getNome();

            if (empty($nome)) {
                $this->setErro("Você deve preencher a divisão.");
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
    }

    /**
    * metodo que tem função de fazer validacao da restricao de integridade
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.1
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

    public function alterar($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo = $this->getCodigoDivisao();
            $nome   = $this->getNome();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao alterar divisão. Código inválido.");
                return 998;
            }

            if ($this->existeDivisao() != 1) {
                $this->setErro("Falha ao alterar divisão. Código inexistente.");
                return 997;
            }

            if (empty($nome)) {
                $this->setErro("Você deve preencher a divisão.");
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
    }

    /**
    * metodo que tem função de fazer validacao da restricao de integridade
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.1
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

    public function excluir($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo = $this->getCodigoDivisao();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao excluir divisão. Código inválido.");
                return 998;
            }

            if ($this->existeDivisao() != 1) {
                $this->setErro("Falha ao excluir divisão. Código inexistente.");
                return 997;
            }

            if ($this->validaFkDivisao()) {
                $this->setErro("Falha ao excluir divisão. Existem um ou mais times vinculados a esta divisão.");
                return 996;
            }

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
    }

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
    }
        
    public static function listarPorNome($nome)
    {
        try {
            $nome .= "%";
            $sql   = "\n SELECT codigo_divisao";
            $sql  .= "\n ,nome";
            $sql  .= "\n FROM divisao";
            $sql  .= "\n WHERE nome LIKE :nome";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 25);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }

    public static function listarTudo()
    {
        try {
            $sql   = "\n SELECT *";
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
    }
    
    public static function listaDivisaoPorTime($intCodigo)
    {
        try {
            $sql   = "\n SELECT d.codigo_divisao";
            $sql  .= "\n ,d.nome";
            $sql  .= "\n FROM time AS t";
            $sql  .= "\n ,divisao AS d";
            $sql  .= "\n WHERE  d.codigo_divisao = t.divisao_codigo_divisao";
            $sql  .= "\n AND t.codigo_time = :codigo";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":codigo", $intCodigo, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }
}
