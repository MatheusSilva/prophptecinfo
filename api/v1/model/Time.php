<?php
namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;
use Respect\Validation\Validator as v;

/**
* classe Time
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Time extends ClasseBase
{
    /**
    * @access private
    * @var integer Armazena o codigo do time
    */
    private $codigoTime;

    /**
    * @access private
    * @var string Armazena o nome do time
    */
    private $nome;

    /**
    * @access private
    * @var integer Armazena o codigo da categoria
    */
    private $codigoCategoria;

    /**
    * @access private
    * @var integer Armazena o codigo da divisão
    */
    private $codigoDivisao;

    /**
    * @access private
    * @var integer Armazena o codigo da tecnico
    */
    private $codigoTecnico;

    /**
    * @access private
    * @var string Armazena a capa do time
    */
    private $capa;

    /**
    * @access private
    * @var string Armazena o desepenho do time
    */
    private $desempenhotime;

    /**
    * @access private
    * @var string Armazena um flag indicado se tem que comprar um novo jogador
    */
    private $comprarnovojogador;

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
    * metodo acessor Get que retorna a informação da propriedade codigoTime
    *
    * @access    public
    * @return    integer Retorna o codigo do time
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getCodigoTime()
    {
        return $this->codigoTime;
    }//public function getCodigoTime()

    /**
    * metodo acessor Set que carrega informação na propriedade codigoTime
    *
    * @access    public
    * @param     integer $codigoTime Armazena o codigo atual
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoTime($codigoTime)
    {
        $this->codigoTime = $codigoTime;
    }//public function setCodigoTime($codigoTime)

    /**
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome do time
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
    * @param     string $nome Armazena o nome do time
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
    * metodo acessor Get que retorna a informação da propriedade codigoCategoria
    *
    * @access    public
    * @return    integer Retorna o codigo da categoria
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getCodigoCategoria()
    {
        return $this->codigoCategoria;
    }//public function getCodigoCategoria()

    /**
    * metodo acessor Set que carrega informação na propriedade categoria
    *
    * @access    public
    * @param     string $codigoCategoria Armazena o codigo da categoria
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoCategoria($codigoCategoria)
    {
        $this->codigoCategoria = $codigoCategoria;
    }//public function setCodigoCategoria($codigoCategoria)

    /**
    * metodo acessor Get que retorna a informação da propriedade codigoDivisao
    *
    * @access    public
    * @return    integer Retorna o codigo da divisão
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
    * metodo acessor Set que carrega informação na propriedade divisão
    *
    * @access    public
    * @param     integer $codigoDivisao Armazena o codigo da divisão
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoDivisao($codigoDivisao)
    {
        $this->codigoDivisao = $codigoDivisao;
    }//public function setCodigoDivisao($codigoDivisao)

    /**
    * metodo acessor Get que retorna a informação da propriedade codigoTecnico
    *
    * @access    public
    * @return    integer Retorna o codigo do tecnico
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getCodigoTecnico()
    {
        return $this->codigoTecnico;
    }//public function getCodigoTecnico()

    /**
    * metodo acessor Set que carrega informação na propriedade tecnico
    *
    * @access    public
    * @param     integer $codigoTecnico Armazena o codigo do tecnico
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoTecnico($codigoTecnico)
    {
        $this->codigoTecnico = $codigoTecnico;
    }//public function setCodigoTecnico($codigoTecnico)

    /**
    * metodo acessor Get que retorna a informação da propriedade capa
    *
    * @access    public
    * @return    integer Retorna a capa do time
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getCapa()
    {
        return $this->capa;
    }//public function getCapa()

    /**
    * metodo acessor Set que carrega informação na propriedade capa
    *
    * @access    public
    * @param     string $capa Armazena a capa do time
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCapa($capa)
    {
        $this->capa = $capa;
    }//public function setCapa($capa)

    /**
    * metodo acessor Get que retorna a informação da propriedade desempenhotime
    *
    * @access    public
    * @return    string Retorna o desepenho do time
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getDesempenhotime()
    {
        return $this->desempenhotime;
    }//public function getDesempenhotime()

    /**
    * metodo acessor Set que carrega informação na propriedade desempenhotime
    *
    * @access    public
    * @param     string $desempenhotime Armazena o desepenho do time
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setDesempenhotime($desempenhotime)
    {
        $this->desempenhotime = $desempenhotime;
    }//public function setDesempenhotime($desempenhotime)

    /**
    * metodo acessor Get que retorna a informação da propriedade comprarnovojogador
    *
    * @access    public
    * @return    string Retorna a flag que indica se tem que comprar novo jogador
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getComprarnovojogador()
    {
        return $this->comprarnovojogador;
    }//public function getComprarnovojogador()

    /**
    * metodo acessor Set que carrega informação na propriedade comprarnovojogador
    *
    * @access    public
    * @param     string $comprarnovojogador Armazena a flag que indica se tem que comprar novo jogador
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setComprarnovojogador($comprarnovojogador)
    {
        $this->comprarnovojogador = $comprarnovojogador;
    }//public function setComprarnovojogador($comprarnovojogador)
        
    /**
    * metodo que tem função de inserir o time
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
            if ($this->tokenEhValido() !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() !== true) {
                
            $nome               = $this->getNome();
                
            if (!(v::alnum()->length(2, 35)->validate($nome))) {
                $this->setErro("O nome do time deve ser alfanumérico de 2 a 35 caracteres.");
                return 998;
            }

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
    }//public function inserir()
    

    /**
    * metodo que tem função de alterar o time
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
            if ($this->tokenEhValido() !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() !== true) {
            
            $codigo             = $this->getCodigoTime();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao atualizar time. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeTime($codigo) != 1) {
                $this->setErro("Falha ao atualizar time. Código inexistente.");
                return 997;
            }//if ($this->existeTime($codigo) != 1) {

            $nome               = $this->getNome();

            if (!(v::alnum()->length(2, 35)->validate($nome))) {
                $this->setErro("O nome do time deve ser alfanumérico de 2 a 35 caracteres.");
                return 996;
            }

            $codigo_divisao     = $this->getCodigoDivisao();
            $codigo_categoria   = $this->getCodigoCategoria();
            $codigo_tecnico     = $this->getCodigoTecnico();
            $capa               = $this->getCapa();

            $sql     = "\n UPDATE time";
            $sql    .= "\n SET nome                     = :nome";
            
            if (!empty($capa)) {
                $sql    .= "\n , capa 			    = :capa";
            }//if (!empty($capa)) {
            
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
            }//if (!empty($capa)) {
            
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
    }//public function alterar()
    
    /**
    * metodo que tem função de verificar se existe time
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo do time
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.1
    */
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
    }//public function existeTime($codigo)
    
    /**
    * metodo que tem função de excluir o time
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
            }//if ($this->tokenEhValido() !== true) {
            
            $codigo = $this->getCodigoTecnico();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao excluir time. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeTime($codigo) != 1) {
                $this->setErro("Falha ao excluir time. Código inexistente.");
                return 998;
            }//if ($this->existeTime($codigo) != 1) {

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
            }//if (!$retorno) {
            
            $conexao = null;
            return $retorno;
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function excluir($codigo)

    /**
    * metodo que tem função de listar todos os times.
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
    }//public static function listarTudo()
     
    /**
    * metodo que tem função de listar o time pelo código.
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo do time.
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
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

            $sql    .= "\n ,(CASE tim.desempenho_time";
            $sql    .= "\n     WHEN '1' THEN 'Ruim'";
            $sql    .= "\n     WHEN '2' THEN 'Regular'";
            $sql    .= "\n     WHEN '3' THEN 'Otimo'";
            $sql    .= "\n END) AS nomeDesempenhoTime";

            $sql    .= "\n ,(CASE tim.comprar_novo_jogador";
            $sql    .= "\n     WHEN '0' THEN 'Não'";
            $sql    .= "\n     WHEN '1' THEN 'Sim'";
            $sql    .= "\n END) AS NomeComprarNovoJogador";

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
    }//public static function listarPorCodigo($codigo)
    
    /**
    * metodo que tem função de listar o time por nome.
    *
    * @access    public
    * @param     string $nome Armazena o nome do time.
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarPorNome($nome)
    {
        try {
            //$nome = mb_substr(trim($nome),0,35,mb_detect_encoding($nome));

            $sql     = "\n SELECT codigo_time AS codigo";
            $sql    .= "\n ,nome AS nome";
            $sql    .= "\n FROM time";
            
            if (!empty($nome)) {
                $sql  .= "\n WHERE nome LIKE :nome";
            }//if (!empty($nome)) {

            $stmt = Conexao::getConexao()->prepare($sql);

            if (!empty($nome)) {
                $nome = trim($nome)."%";
                $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 35);
            }//if (!empty($nome)) {

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public static function listarPorNome($nome)
}//class Time extends ClasseBase
