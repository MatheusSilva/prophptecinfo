<?php

require_once "../lib/ClasseBase.php";

/**
* classe Time
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Time extends ClasseBase
{
    private $codigo_time;
    private $nome;
    private $codigo_categoria;
    private $codigo_divisao;
    private $codigo_tecnico;
    private $capa;
    private $desempenhotime;
    private $comprarnovojogador;

    function __construct() 
    {
        require_once "../lib/Conexao.php";
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

    public function getCodigo_time() 
    {
        return $this->codigo_time;
    }

    public function setCodigo_time($codigo_time) 
    {
        $this->codigo_time = $codigo_time;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function getCodigo_categoria() 
    {
        return $this->codigo_categoria;
    }

    public function setCodigo_categoria($codigo_categoria) 
    {
        $this->codigo_categoria = $codigo_categoria;
    }

    public function getCodigo_divisao() 
    {
        return $this->codigo_divisao;
    }

    public function setCodigo_divisao($codigo_divisao) 
    {
        $this->codigo_divisao = $codigo_divisao;
    }

    public function getCodigo_tecnico() 
    {
        return $this->codigo_tecnico;
    }

    public function setCodigo_tecnico($codigo_tecnico) 
    {
        $this->codigo_tecnico = $codigo_tecnico;
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
                return false;
            }//if ($this->tokenEhValido($token) === false) {

            $nome               = $this->getNome();
            $capa               = $this->getCapa(); 
            $codigo_divisao     = $this->getCodigo_divisao();
            $codigo_categoria   = $this->getCodigo_categoria();
            $codigo_tecnico     = $this->getCodigo_tecnico();
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
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":capa", $capa);
            $stmt->bindParam(":codigo_divisao", $codigo_divisao);
            $stmt->bindParam(":codigo_categoria", $codigo_categoria);
            $stmt->bindParam(":codigo_tecnico", $codigo_tecnico);
            $stmt->bindParam(":desempenhotime", $desempenhotime);
            $stmt->bindParam(":comprarnovojogador", $comprarnovojogador);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('mmhdjgdngsrekj.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return $e->getMessage();
        }
    }
	
    public function alterar($token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                return false;
            }//if ($this->tokenEhValido($token) === false) {

            $banco              = Conexao::getConexao();
            $codigo             = $this->getCodigo_time();
            $nome               = $this->getNome();
            $codigo_divisao     = $this->getCodigo_divisao();
            $codigo_categoria   = $this->getCodigo_categoria();
            $codigo_tecnico     = $this->getCodigo_tecnico();
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
            $stmt->bindParam(":nome", $nome);
            
            if (!empty($capa)) {
                $stmt->bindParam(":capa", $capa);
                $arrRetorno = self::listarPorCodigo($codigo);
                unlink("../".$arrRetorno["capa"]);
            }
            
            $stmt->bindParam(":codigo_divisao", $codigo_divisao);
            $stmt->bindParam(":codigo_categoria", $codigo_categoria);
            $stmt->bindParam(":codigo_tecnico", $codigo_tecnico);
            $stmt->bindParam(":codigo_time", $codigo);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }
    
    public function existeTime($codigo)
    {
        $sql     = "\n SELECT 1 as retorno";
        $sql    .= "\n FROM time";
        $sql    .= "\n WHERE codigo_time    = :codigo";

        $conexao = Conexao::getConexao(); 		  
        $stmt    = $conexao->prepare($sql);
        $stmt->bindParam(":codigo", $codigo);
        $stmt->execute();
        $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
        $conexao = null;
        
        if ($retorno["retorno"] == 1 ) {
            return true;
        }
        
        return false;
    }
    
    public function excluir($codigo, $token)
    {
        try {
            if ($this->tokenEhValido($token) !== true) {
                return "Você não esta logado.";
            }
            
            if ($this->existeTime($codigo) !== true) {
                return "O time que você esta tentando excluir não existe.";
            }

            $arrRetorno = self::listarPorCodigo($codigo);
            unlink("../".$arrRetorno["capa"]);

            $sql     = "\n DELETE FROM time"; 
            $sql    .= "\n WHERE codigo_time = :codigo";

            $conexao = Conexao::getConexao(); 
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $codigo);

            if (!$stmt->execute()) {
                $retorno = "Não foi possivel excluir este time.";
            } else {
                $conexao->commit();
            }
            
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }

    public static function listarTudo()
    {
        $sql     = "\n SELECT codigo_time,divisao_codigo_divisao,nome,capa ";
        $sql    .= "\n FROM time";

        $conexao = Conexao::getConexao(); 		  
        $stmt    = $conexao->prepare($sql);
        $stmt->execute();
        $retorno =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $conexao = null;
        return $retorno;
    }
        	
    public static function listarPorCodigo($codigo)
    {
        $sql     = "\n SELECT time.codigo_time AS codigotime";
        $sql    .= "\n ,time.nome AS nomeTime";
        $sql    .= "\n ,time.tecnico_codigo_tecnico AS codigoTecnico";
        $sql    .= "\n ,capa";
        $sql    .= "\n ,divisao.codigo_divisao AS codigoDivisao";
        $sql    .= "\n ,divisao.nome AS nomeDivisao";
        $sql    .= "\n ,tecnico.nome AS nomeTecnico";
        $sql    .= "\n ,categoria.codigo_categoria AS codigoCategoria";
        $sql    .= "\n ,categoria.nome AS nomeCategoria";
        $sql    .= "\n ,time.desempenho_time AS nomeDesempenhoTime";
        $sql    .= "\n ,time.comprar_novo_jogador AS NomeComprarNovoJogador";
        $sql    .= "\n FROM time";
        $sql    .= "\n , divisao";
        $sql    .= "\n , tecnico";
        $sql    .= "\n , categoria";
        $sql    .= "\n WHERE divisao_codigo_divisao   = codigo_divisao"; 
        $sql    .= "\n AND tecnico_codigo_tecnico     = codigo_tecnico"; 
        $sql    .= "\n AND categoria_codigo_categoria = codigo_categoria"; 
        $sql    .= "\n AND codigo_time 			 	  = :codigo";

        $conexao = Conexao::getConexao(); 		  
        $stmt    = $conexao->prepare($sql);
        $stmt->bindParam(":codigo", $codigo);
        $stmt->execute();
        $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
        $conexao = null;
        return $retorno;
    }
	
    public static function listarPorNome($nome)
    {
        $sql     = "\n SELECT time.codigo_time AS codigo,time.nome AS nome";
        $sql    .= "\n FROM time"; 

        if ($nome !== "listaTodosTimes") {
            $sql    .= "\n WHERE nome LIKE :nome";
            $nome   = $nome."%";
        }

        $conexao = Conexao::getConexao(); 		  
        $stmt    = $conexao->prepare($sql);

        if ($nome !== "listaTodosTimes") {
            $stmt->bindParam(":nome", $nome);
        }

        $stmt->execute();
        $retorno =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $conexao = null;
        return $retorno;
    }
}
