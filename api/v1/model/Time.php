<?php
namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;

/**
* classe Time
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Time extends ClasseBase
{
    private $codigoTime;
    private $nome;
    private $codigoCategoria;
    private $codigoDivisao;
    private $codigoTecnico;
    private $capa;
    private $desempenhotime;
    private $comprarnovojogador;

    public function __construct()
    {
    }

    public function getDesempenhotime()
    {
        return $this->desempenhotime;
    }

    public function setDesempenhotime($desempenhotime)
    {
        $this->desempenhotime = $desempenhotime;
    }

    public function getComprarnovojogador()
    {
        return $this->comprarnovojogador;
    }

    public function setComprarnovojogador($comprarnovojogador)
    {
        $this->comprarnovojogador = $comprarnovojogador;
    }

    public function getCodigoTime()
    {
        return $this->codigoTime;
    }

    public function setCodigoTime($codigoTime)
    {
        $this->codigoTime = $codigoTime;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getCodigoCategoria()
    {
        return $this->codigoCategoria;
    }

    public function setCodigoCategoria($codigoCategoria)
    {
        $this->codigoCategoria = $codigoCategoria;
    }

    public function getCodigoDivisao()
    {
        return $this->codigoDivisao;
    }

    public function setCodigoDivisao($codigoDivisao)
    {
        $this->codigoDivisao = $codigoDivisao;
    }

    public function getCodigoTecnico()
    {
        return $this->codigoTecnico;
    }

    public function setCodigoTecnico($codigoTecnico)
    {
        $this->codigoTecnico = $codigoTecnico;
    }

    public function getCapa()
    {
        return $this->capa;
    }

    public function setCapa($capa)
    {
        $this->capa = $capa;
    }
        
    public function inserir($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }

            $nome               = $this->getNome();
            $capa               = $this->getCapa();
            $codigo_divisao     = $this->getCodigoDivisao();
            $codigo_categoria   = $this->getCodigoCategoria();
            $codigo_tecnico     = $this->getCodigoTecnico();
            $desempenhotime     = $this->getDesempenhotime();
            $comprarnovojogador = $this->getComprarnovojogador();

            $sql     = "\n INSERT INTO time(";
            $sql    .= "\n nome";
            $sql    .= "\n ,capa";
            $sql    .= "\n ,divisao_codigo_divisao";
            $sql    .= "\n ,categoria_codigo_categoria";
            $sql    .= "\n ,tecnico_codigo_tecnico";
            $sql    .= "\n ,desempenho_time";
            $sql    .= "\n ,comprar_novo_jogador";
            $sql    .= "\n ) VALUES (";
            $sql    .= "\n  :nome";
            $sql    .= "\n ,:capa";
            $sql    .= "\n ,:codigo_divisao";
            $sql    .= "\n ,:codigo_categoria";
            $sql    .= "\n ,:codigo_tecnico";
            $sql    .= "\n ,:desempenhotime";
            $sql    .= "\n ,:comprarnovojogador";
            $sql    .= "\n )";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 35);
            $stmt->bindParam(":capa", $capa, \PDO::PARAM_STR, 100);
            $stmt->bindParam(":codigo_divisao", $codigo_divisao, \PDO::PARAM_INT);
            $stmt->bindParam(":codigo_categoria", $codigo_categoria, \PDO::PARAM_INT);
            $stmt->bindParam(":codigo_tecnico", $codigo_tecnico, \PDO::PARAM_INT);
            $stmt->bindParam(":desempenhotime", $desempenhotime, \PDO::PARAM_STR, 5);
            $stmt->bindParam(":comprarnovojogador", $comprarnovojogador, \PDO::PARAM_STR, 3);
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
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }
            
            $codigo             = $this->getCodigoTime();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao atualizar time. Código inválido.");
                return 998;
            }

            if ($this->existeTime($codigo) != 1) {
                $this->setErro("Falha ao atualizar time. Código inexistente.");
                return 998;
            }

            $nome               = $this->getNome();
            $codigo_divisao     = $this->getCodigoDivisao();
            $codigo_categoria   = $this->getCodigoCategoria();
            $codigo_tecnico     = $this->getCodigoTecnico();
            $capa               = $this->getCapa();

            $sql     = "\n UPDATE time";
            $sql    .= "\n SET nome                     = :nome";
            
            if (!empty($capa)) {
                $sql    .= "\n , capa 			    = :capa";
            }
            
            $sql    .= "\n , divisao_codigo_divisao     = :codigo_divisao";
            $sql    .= "\n , categoria_codigo_categoria = :codigo_categoria";
            $sql    .= "\n , tecnico_codigo_tecnico     = :codigo_tecnico";
            $sql    .= "\n WHERE codigo_time            = :codigo_time";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 35);
            
            if (!empty($capa)) {
                $stmt->bindParam(":capa", $capa);
                $arrRetorno = self::listarPorCodigo($codigo);
                unlink("../".$arrRetorno["capa"], \PDO::PARAM_STR, 100);
            }
            
            $stmt->bindParam(":codigo_divisao", $codigo_divisao, \PDO::PARAM_INT);
            $stmt->bindParam(":codigo_categoria", $codigo_categoria, \PDO::PARAM_INT);
            $stmt->bindParam(":codigo_tecnico", $codigo_tecnico, \PDO::PARAM_INT);
            $stmt->bindParam(":codigo_time", $codigo, \PDO::PARAM_INT);
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
    
    public function existeTime($codigo)
    {
        try {
            $sql     = "\n SELECT DISTINCT 1 AS retorno";
            $sql    .= "\n FROM time";
            $sql    .= "\n WHERE codigo_time = :codigo";

            $conexao = Conexao::getConexao();
            $stmt    = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno["retorno"];
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }
    
    public function excluir($codigo, $token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }
            
            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao excluir time. Código inválido.");
                return 998;
            }

            if ($this->existeTime($codigo) != 1) {
                $this->setErro("Falha ao excluir time. Código inexistente.");
                return 998;
            }

            $arrRetorno = self::listarPorCodigo($codigo);
            unlink("../".$arrRetorno["capa"]);

            $sql     = "\n DELETE FROM time";
            $sql    .= "\n WHERE codigo_time = :codigo";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);

            $retorno = $stmt->execute();

            if (!$retorno) {
                $this->setErro("Não foi possivel excluir este time.");
                $retorno = false;
            } else {
                $conexao->commit();
            }
            
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

    public static function listarTudo()
    {
        try {
            $sql     = "\n SELECT codigo_time";
            $sql    .= "\n ,divisao_codigo_divisao";
            $sql    .= "\n ,nome";
            $sql    .= "\n ,capa";
            $sql    .= "\n FROM time";

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
            
    public static function listarPorCodigo($codigo)
    {
        try {
            $sql     = "\n SELECT tim.codigo_time AS codigotime";
            $sql    .= "\n ,tim.nome AS nomeTime";
            $sql    .= "\n ,tim.tecnico_codigo_tecnico AS codigoTecnico";
            $sql    .= "\n ,tim.capa";
            $sql    .= "\n ,dvi.codigo_divisao AS codigoDivisao";
            $sql    .= "\n ,dvi.nome AS nomeDivisao";
            $sql    .= "\n ,tec.nome AS nomeTecnico";
            $sql    .= "\n ,cat.codigo_categoria AS codigoCategoria";
            $sql    .= "\n ,cat.nome AS nomeCategoria";
            $sql    .= "\n ,tim.desempenho_time AS nomeDesempenhoTime";
            $sql    .= "\n ,tim.comprar_novo_jogador AS NomeComprarNovoJogador";
            $sql    .= "\n FROM time AS tim";
            $sql    .= "\n , divisao AS dvi";
            $sql    .= "\n , tecnico AS tec";
            $sql    .= "\n , categoria AS cat";
            $sql    .= "\n WHERE tim.divisao_codigo_divisao   = dvi.codigo_divisao";
            $sql    .= "\n AND tim.tecnico_codigo_tecnico     = tec.codigo_tecnico";
            $sql    .= "\n AND tim.categoria_codigo_categoria = cat.codigo_categoria";
            $sql    .= "\n AND tim.codigo_time 			 	  = :codigo";

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
            $sql     = "\n SELECT codigo_time AS codigo";
            $sql    .= "\n ,nome AS nome";
            $sql    .= "\n FROM time";

            if ($nome !== "listaTodosTimes") {
                $sql   .= "\n WHERE nome LIKE :nome";
                $nome   = $nome."%";
            }

            $stmt = Conexao::getConexao()->prepare($sql);

            if ($nome !== "listaTodosTimes") {
                $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 35);
            }

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }
}
