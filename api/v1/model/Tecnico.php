<?php
//declare(strict_types=1);//nao utilizar pois qualquer tipo de dados diferente vai parar a aplicação, validar dados pelo validator

namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;
use Respect\Validation\Validator as v;

/**
* classe Tecnico
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Tecnico extends ClasseBase
{
    /**
    * @access private
    * @var integer Armazena o codigo do tecnico
    */
    private $codigoTecnico;

    /**
    * @access private
    * @var integer Armazena o nome do tecnico
    */
    private $nome;

    /**
    * @access private
    * @var integer Armazena a data de nascimento do tecnico
    */
    private $data;

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
        $this->setData('');
        $this->setNome('');
        $this->setCodigoTecnico(0);
    }//public function limpaPropriedades()

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
    public function getCodigoTecnico() : int
    {
        return $this->codigoTecnico;
    }//public function getCodigoTecnico() : int

    /**
    * metodo acessor Set que carrega informação na propriedade codigoTecnico
    *
    * @access    public
    * @param     integer $codigoTecnico Armazena o codigo atual
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoTecnico(int $codigoTecnico)
    {
        $this->codigoTecnico = $codigoTecnico;
    }//public function setCodigoTecnico(int $codigoTecnico)

    /**
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome do tecnico
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
    * @param     integer $nome Armazena o nome atual
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
    * metodo acessor Get que retorna a informação da propriedade data
    *
    * @access    public
    * @return    string Retorna o data de nascimento do tecnico
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getData() : string
    {
        return $this->data;
    }//public function getData() : string

    /**
    * metodo acessor Set que carrega informação na propriedade data
    *
    * @access    public
    * @param     integer $data Armazena o data de nascimento do tecnico
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setData(string $data)
    {
        if (!empty($data)) {
            $data = explode('/', $data);
            $data = $data[2]."-".$data[1]."-".$data[0];
        }

        $this->data = $data;
    }//public function setData(string $data)

    /**
    * metodo que tem função de verificar se ja existe outro tecnico com mesmo nome e id
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
            $sql  .= "\n FROM tecnico AS tec";
            $sql  .= "\n WHERE tec.codigo_tecnico = :id";
            $sql  .= "\n AND tec.nome = :nome";
            $sql  .= "\n AND tec.data_nascimento = :data";

            $stmt = Conexao::getConexao()->prepare($sql);
            $codigo  = $this->getCodigoTecnico();
            $nome    = $this->getNome();
            $data    = $this->getData();

            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR);
            $stmt->bindParam(":data", $data);

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
    * metodo que tem função de verificar se ja existe outro tecnico com mesmo nome
    *
    * @access    public
    * @return    boolean retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function validaNomeTecnico() : bool
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM tecnico AS tec";
            $sql  .= "\n WHERE tec.nome = :nome";
            $sql  .= "\n AND tec.data_nascimento = :data";

            $stmt = Conexao::getConexao()->prepare($sql);
            $nome    = $this->getNome();
            $data    = $this->getData();
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR);
            $stmt->bindParam(":data", $data);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($retorno["resultado"] != 1) {
                return true;
            }//if ($retorno["resultado"] != 1) {

            $this->setErro("Técnico duplicado, escolha outro nome.");
            return false;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaNomeTecnico() : bool

    /**
    * metodo que tem função de inserir o tecnico
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
            $data  = $this->getData();

            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome do técnico deve ser alfanumérico de 2 a 30 caracteres.");
                return 998;
            }

            $retorno = $this->validaNomeTecnico();

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            if (!v::date('Y-m-d')->validate($data)) {
                $this->setErro("A data está inválida.");
                $retorno = 997;
            }//if (!v::date('Y-m-d')->validate($data)) {

            if ($retorno !== true) {
                return $retorno;
            }//if ($retorno !== true) {

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
    public function validaCodigoTecnico(int $codigo)
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
            $sql  .= "\n FROM tecnico AS tec";
            $sql  .= "\n WHERE tec.codigo_tecnico = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($retorno["resultado"] != true) {
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
    }//public function validaCodigoTecnico(int $codigo)

    /**
    * metodo que tem função de alterar o tecnico
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
            $codigo = $this->getCodigoTecnico();
            $nome   = $this->getNome();

            $retorno = $this->validaCodigoTecnico($codigo);

            if ($retorno !== true) {
                return $retorno;
            }//if ($retorno !== true) {

            if ($this->existeNomeComEsseId() == true) {
                return true;
            }//if ($this->existeNomeComEsseId()) {    
                
            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome do técnico deve ser alfanumérico de 2 a 30 caracteres.");
                return 996;
            }

            $retorno = $this->validaNomeTecnico();

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

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
    }//public function alterar()

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
    public function validaFkTecnico()
    {
        try {
            $codigo  = $this->getCodigoTecnico();

            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM tecnico AS tec";
            $sql  .= "\n ,time AS tim";
            $sql  .= "\n WHERE tim.tecnico_codigo_tecnico = tec.codigo_tecnico";
            $sql  .= "\n AND tec.codigo_tecnico = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno["resultado"];
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaFkTecnico()

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
    public function excluir()
    {
        try {
            $codigo = $this->getCodigoTecnico();
            $retorno = $this->validaCodigoTecnico($codigo);

            if ($retorno !== true) {
                return $retorno;
            }//if ($retorno !== true) {

            if ($this->validaFkTecnico()) {
                $this->setErro("Falha ao excluir técnico. Existem um ou mais times vinculados a este técnico.");
                return 996;
            }//if ($this->validaFkTecnico()) {

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
    }//public function excluir()

    /**
    * metodo que tem função de listar o tecnico pelo código.
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo da tecnico.
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listarPorCodigo(int $codigo)
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $sql   = "\n SELECT codigo_tecnico";
            $sql  .= "\n ,nome";
            $sql  .= "\n ,DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data_nascimento";
            $sql  .= "\n FROM tecnico";
            $sql  .= "\n WHERE codigo_tecnico = :codigo";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":codigo", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarPorCodigo(int $codigo)

    /**
    * metodo que tem função de listar o tecnico por nome.
    *
    * @access    public
    * @param     string $nome Armazena o nome do tecnico.
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

            $nome  = trim($nome."%");
            $sql   = "\n SELECT codigo_tecnico";
            $sql  .= "\n ,nome";
            $sql  .= "\n FROM tecnico";

            if (!empty($nome)) {
                $sql  .= "\n WHERE nome LIKE :nome";
            }//if (!empty($nome)) {

            $stmt = Conexao::getConexao()->prepare($sql);

            if (!empty($nome)) {
                $nome = trim($nome)."%";
                $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
            }//if (!empty($nome)) {

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarPorNome(string $nome)

    /**
    * metodo que tem função de listar todos os tecnicos.
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

            $sql   = "\n SELECT codigo_tecnico";
            $sql  .= "\n ,nome";
            $sql  .= "\n ,DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data_nascimento";
            $sql  .= "\n FROM tecnico";

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
    * metodo que tem função de listar todos os tecnicos por time.
    *
    * @access    public
    * @param     integer $intCodigo Armazena o codigo do time
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listaTecnicoPorTime(int $intCodigo)
    {
        try {
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return array();
            }//if ($this->tokenEhValido() === false) {

            $sql   = "\n SELECT tec.codigo_tecnico";
            $sql  .= "\n ,tec.nome";
            $sql  .= "\n FROM time AS t";
            $sql  .= "\n ,tecnico AS tec";
            $sql  .= "\n WHERE  tec.codigo_tecnico = t.tecnico_codigo_tecnico";
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
    }//public function listaTecnicoPorTime(int $intCodigo)
}
