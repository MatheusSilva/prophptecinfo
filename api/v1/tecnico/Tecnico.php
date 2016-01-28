<?php
namespace model;

use lib\ClasseBase;
use lib\Conexao;

require_once "../lib/ClasseBase.php";

/**
* classe Tecnico
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Tecnico extends ClasseBase
{
    private $codigoTecnico;
    private $nome;
    private $data;

    public function __construct()
    {
        require_once "../lib/Conexao.php";
    }

    public function getCodigoTecnico()
    {
        return $this->codigoTecnico;
    }

    public function setCodigoTecnico($codigoTecnico)
    {
        $this->codigoTecnico = $codigoTecnico;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function inserir($token)
    {
        try {
            $retorno = true;

            if ($this->tokenEhValido($token) !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido($token) === false) {

            $nome  = $this->getNome();
            $data  = $this->getData();

            if (empty($nome)) {
                $this->setErro("Você deve preencher o tecnico.");
                $retorno = 998;
            }

            if (empty($data) || mb_strlen($data, mb_detect_encoding($data)) !== 10 ) {
                $this->setErro("Você deve preencher a data.");
                $retorno = 997;
            }

            if ($retorno !== true) {
                return $retorno;
            }

            $sql   = "\n INSERT INTO tecnico(";
            $sql  .= "\n  nome";
            $sql  .= "\n ,data_nascimento";
            $sql  .= "\n ) VALUES (";
            $sql  .= "\n  :nome";
            $sql  .= "\n ,:data";
            $sql  .= "\n )";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
            $stmt->bindParam(":data", $data);
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

    public function alterar($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                return 999;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo = $this->getCodigoTecnico();
            $nome           = $this->getNome();

            $sql   = "\n UPDATE tecnico";
            $sql  .= "\n SET nome = :nome";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
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
    public function validaFkTecnico($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                return 999;
            }//if ($this->objClasseBase->tokenEhValido($token) === false) {

            $codigo  = $this->getCodigoTecnico();

            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM tecnico AS tec";
            $sql  .= "\n ,time AS tim";
            $sql  .= "\n WHERE tim.tecnico_codigo_tecnico = tec.codigo_tecnico";
            $sql  .= "\n AND tec.codigo_tecnico = :id";

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno["resultado"];
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaFkTecnico($codigo)


    public function excluir($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                return 999;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo = $this->getCodigoTecnico();
            $sql   = "\n DELETE";
            $sql  .= "\n FROM tecnico";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

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
            $sql   = "\n SELECT codigo_tecnico";
            $sql  .= "\n ,nome";
            $sql  .= "\n ,data_nascimento";
            $sql  .= "\n FROM tecnico";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
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

    public static function listarPorNome($nome)
    {
        try {
            $nome .= "%";
            $sql   = "\n SELECT codigo_tecnico";
            $sql  .= "\n ,nome";
            $sql  .= "\n FROM tecnico";
            $sql  .= "\n WHERE nome LIKE :nome";

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
            $stmt->execute();
            $retorno =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

    public static function listarTudo($strRequire = '../lib/Conexao.php')
    {
        try {
            $sql   = "\n SELECT *";
            $sql  .= "\n FROM tecnico";

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $retorno =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
    
    public static function listaTecnicoPorTime($intCodigo, $strRequire = '../lib/Conexao.php')
    {
        try {
            $sql   = "\n SELECT tec.codigo_tecnico";
            $sql  .= "\n ,tec.nome";
            $sql  .= "\n FROM time.time AS t";
            $sql  .= "\n ,time.tecnico AS tec";
            $sql  .= "\n WHERE  tec.codigo_tecnico = t.tecnico_codigo_tecnico";
            $sql  .= "\n AND t.codigo_time = :codigo";

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $intCodigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
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
