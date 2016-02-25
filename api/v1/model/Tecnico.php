<?php
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

    }//public function __construct()

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
    * metodo acessor Set que carrega informação na propriedade codigoTecnico
    *
    * @access    public
    * @param     integer $codigoTecnico Armazena o codigo atual
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
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome do tecnico
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
    * @param     integer $nome Armazena o nome atual
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
    * metodo acessor Get que retorna a informação da propriedade data
    *
    * @access    public
    * @return    string Retorna o data de nascimento do tecnico
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function getData()
    {
        return $this->data;
    }//public function getData()

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
    public function setData($data)
    {
        $data = explode('/', $data);
        $data = $data[2]."-".$data[1]."-".$data[0];
        $this->data = $data;
    }//public function setData($data)

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

            if ($this->tokenEhValido() !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $nome  = $this->getNome();
            $data  = $this->getData();

            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome do técnico deve ser alfanumérico de 2 a 30 caracteres.");
                return 998;
            }

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
    * metodo que tem função de verificar se existe o tecnico
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.1
    */
    public function existeTecnico()
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM tecnico AS tec";
            $sql  .= "\n WHERE tec.codigo_tecnico = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $this->getCodigoTecnico(), \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno["resultado"];
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function existeTecnico()

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
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $codigo = $this->getCodigoTecnico();
            $nome   = $this->getNome();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao alterar técnico. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeTecnico() != 1) {
                $this->setErro("Falha ao alterar técnico. Código inexistente.");
                return 997;
            }//if ($this->existeTecnico() != 1) {
                
            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome do técnico deve ser alfanumérico de 2 a 30 caracteres.");
                return 996;
            }

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
    }//public function validaFkTecnico($codigo)

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
            if ($this->tokenEhValido() !== true) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $codigo = $this->getCodigoTecnico();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao excluir técnico. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeTecnico() != 1) {
                $this->setErro("Falha ao excluir técnico. Código inexistente.");
                return 997;
            }//if ($this->existeTecnico() != 1) {

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
    public static function listarPorCodigo($codigo)
    {
        try {
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
    }//public static function listarPorCodigo($codigo)

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
    public static function listarPorNome($nome)
    {
        try {
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
    }//public static function listarPorNome($nome)

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
    public static function listarTudo()
    {
        try {
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
    }//public static function listarTudo()
    
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
    public static function listaTecnicoPorTime($intCodigo)
    {
        try {
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
    }//public static function listaTecnicoPorTime($intCodigo)
}
