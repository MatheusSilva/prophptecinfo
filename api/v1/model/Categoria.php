<?php
//declare(strict_types=1);//nao utilizar pois qualquer tipo de dados diferente vai parar a aplicação, validar dados pelo validator

namespace matheus\sistemaRest\api\v1\model;

use matheus\sistemaRest\api\v1\lib\ClasseBase;
use matheus\sistemaRest\api\v1\lib\Conexao;
use Respect\Validation\Validator as v;

/**
* classe Categoria
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
*/
class Categoria extends ClasseBase
{
    /**
    * @access private
    * @var integer Armazena o codigo da categoria
    */
    private $codigoCategoria;

    /**
    * @access private
    * @var string Armazena o nome da categoria
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
        $this->setCodigoCategoria(0);
    }//public function limpaPropriedades()
    
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
    public function getCodigoCategoria() : int
    {
        return $this->codigoCategoria;
    }//public function getCodigoCategoria() : int

    /**
    * metodo acessor Set que carrega informação na propriedade codigoCategoria
    *
    * @access    public
    * @param     integer $codigoCategoria Armazena o codigo atual
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function setCodigoCategoria(int $codigoCategoria)
    {
        $this->codigoCategoria = $codigoCategoria;
    }//public function setCodigoCategoria(int $codigoCategoria)

    /**
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome da categoria
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
    * @param     string $nome Armazena a nome atual
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
    * metodo que tem função de verificar se ja existe outra categoria com mesmo nome e id
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
            $sql  .= "\n FROM categoria AS cat";
            $sql  .= "\n WHERE cat.codigo_categoria = :id";
            $sql  .= "\n AND cat.nome = :nome";

            $stmt = Conexao::getConexao()->prepare($sql);
            $codigo  = $this->getCodigoCategoria();
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
    * metodo que tem função de verificar se ja existe outra categoria com mesmo nome
    *
    * @access    public
    * @return    boolean retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function validaNomeCategoria() : bool
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM categoria AS cat";
            $sql  .= "\n WHERE cat.nome = :nome";

            $stmt = Conexao::getConexao()->prepare($sql);
            $nome    = $this->getNome();
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($retorno["resultado"] != 1) {
                return true;
            }//if ($retorno["resultado"] != 1) {

            $this->setErro("Categoria duplicada, escolha outro nome.");
            return false;
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function validaNomeCategoria()
    
    /**
    * metodo que tem função de fazer gravação do registro
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
            $id    = null;
            
            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome da categoria deve ser alfanumérico de 2 a 30 caracteres.");
                return 998;
            }
            
            $retorno = $this->validaNomeCategoria();

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            $sql  = "\n INSERT INTO categoria (";
            $sql .= "\n   `codigo_categoria`";
            $sql .= "\n , `nome`";
            $sql .= "\n ) VALUES (";
            $sql .= "\n   :id";
            $sql .= "\n , :nome";
            $sql .= "\n )";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
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
    public function validaCodigoCategoria(int $codigo)
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
            $sql  .= "\n FROM categoria AS cat";
            $sql  .= "\n WHERE cat.codigo_categoria = :id";

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
    }//public function validaCodigoCategoria()

    /**
    * metodo que tem função de fazer alteração do registro
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
            $codigo  = $this->getCodigoCategoria();
            $nome    = $this->getNome();

            $retorno = $this->validaCodigoCategoria($codigo);

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            if ($this->existeNomeComEsseId() == true) {
                return true;
            }//if ($this->existeNomeComEsseId()) {

            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome da categoria deve ser alfanumérico de 2 a 30 caracteres.");
                return 996;
            }

            $retorno = $this->validaNomeCategoria();

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            $sql  = "\n UPDATE categoria";
            $sql .= "\n SET nome = :nome";
            $sql .= "\n WHERE codigo_categoria = :id";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
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
    }//public function alterar($codigo)

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
    public function validaFkCategoria()
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM categoria AS cat";
            $sql  .= "\n ,time AS tim";
            $sql  .= "\n WHERE tim.categoria_codigo_categoria = cat.codigo_categoria";
            $sql  .= "\n AND tim.categoria_codigo_categoria = :id";

            $codigo = $this->getCodigoCategoria();
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
    }//public function validaFkCategoria($codigo)
    
    /**
    * metodo que tem função de fazer exclusão do registro
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
            $codigo  = $this->getCodigoCategoria();
            $retorno = $this->validaCodigoCategoria($codigo);

            if ($retorno !== true) {
                return $retorno;
            }//if (!$retorno) {

            if ($this->validaFkCategoria()) {
                $this->setErro("Falha ao excluir categoria. Existem um ou mais times vinculados a esta categoria.");
                return 996;
            }//if ($this->validaFkCategoria()) {

            $sql  = "\n DELETE FROM categoria";
            $sql .= "\n WHERE codigo_categoria = :id";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
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
    * metodo que tem função de buscar as informacoes da categoria por codigo
    *
    * @access    public
    * @param     integer $codigo Armazena o codigo da categoria
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listarPorCodigo(int $codigo)
    {
        try {
            if ($this->validaCodigoCategoria($codigo) !== true) {
                return array();
            }//if (!$this->validaCodigoCategoria($codigo)) {

            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n ,nome";
            $sql .= "\n FROM categoria";
            $sql .= "\n WHERE codigo_categoria = :id";
             
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $codigo, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarPorCodigo(int $codigo)

    /**
    * metodo que tem função de buscar todas as categorias que tenham determinado padrao de nome
    *
    * @access    public
    * @param     string $nome Armazena o nome da categoria.
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


            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n ,nome";
            $sql .= "\n FROM categoria";

            if (!empty($nome)) {
                $sql .= "\n WHERE nome LIKE :nome";
            }//if (!empty($nome)) {

            $stmt = Conexao::getConexao()->prepare($sql);
            Conexao::fechaConexao();
            
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
    }//public function listarPorNome($nome)

    /**
    * metodo que tem função de buscar todas as categorias
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

            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n ,nome";
            $sql .= "\n FROM categoria";
            
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            $conexao = null;
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function listarTudo()

    /**
    * metodo que tem função de buscar a categoria por time
    *
    * @access    public
    * @param     integer $intCodigo Armazena o codigo do time
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2016 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function listaCategoriaPorTime(int $intCodigo)
    {
        try {
            if ($this->validaCodigoCategoria($intCodigo) !== true) {
                return array();
            }//if ($this->validaCodigoCategoria($intCodigo)) {

            $sql   = "\n SELECT c.codigo_categoria";
            $sql  .= "\n ,c.nome";
            $sql  .= "\n FROM time AS t";
            $sql  .= "\n ,categoria AS c";
            $sql  .= "\n WHERE  c.codigo_categoria = t.categoria_codigo_categoria";
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
    }//public function listaCategoriaPorTime($intCodigo)
}//class Categoria extends ClasseBase
