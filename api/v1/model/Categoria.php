<?php
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

    }//public function __construct()
    
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
    * metodo acessor Set que carrega informação na propriedade codigoCategoria
    *
    * @access    public
    * @param     integer $codigoCategoria Armazena o codigo atual
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
    * metodo acessor Get que retorna a informação da propriedade nome
    *
    * @access    public
    * @return    string Retorna o nome da categoria
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
    * @param     string $nome Armazena a nome atual
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
    public function existeCategoria()
    {
        try {
            $sql   = "\n SELECT DISTINCT 1 AS resultado";
            $sql  .= "\n FROM categoria AS cat";
            $sql  .= "\n WHERE cat.codigo_categoria = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $this->getCodigoCategoria(), \PDO::PARAM_INT);
            $stmt->execute();
            $retorno =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $retorno["resultado"];
        } catch (\PDOException $e) {
            $fp = fopen('34hsGAxZSgdfwksz1356.log', 'a');
            fwrite($fp, $e);
            fclose($fp);
            return false;
        }
    }//public function existeCategoria()

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
            $retorno = true;

            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $codigo  = $this->getCodigoCategoria();
            $nome    = $this->getNome();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao alterar categoria. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeCategoria() != 1) {
                $this->setErro("Falha ao alterar categoria. Código inexistente.");
                return 997;
            }//if ($this->existeCategoria() != 1) {

            if (!(v::alnum()->length(2, 30)->validate($nome))) {
                $this->setErro("O nome da categoria deve ser alfanumérico de 2 a 30 caracteres.");
                return 996;
            }

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
            $sql  .= "\n AND cat.codigo_categoria = :id";

            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(":id", $this->getCodigoCategoria(), \PDO::PARAM_INT);
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
            if ($this->tokenEhValido() === false) {
                $this->setErro("Sua sessão expirou. Faça o login novamente.");
                return 999;
            }//if ($this->tokenEhValido() === false) {

            $codigo  = $this->getCodigoCategoria();

            if (is_numeric($codigo) === false) {
                $this->setErro("Falha ao excluir categoria. Código inválido.");
                return 998;
            }//if (is_numeric($codigo) === false) {

            if ($this->existeCategoria() != 1) {
                $this->setErro("Falha ao excluir categoria. Código inexistente.");
                return 997;
            }//if ($this->existeCategoria() != 1) {

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
    }//public function excluir($codigo)

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
    public static function listarPorCodigo($codigo)
    {
        try {
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
    }//public static function listarPorCodigo($codigo)

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
    public static function listarPorNome($nome)
    {
        try {
            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n ,nome";
            $sql .= "\n FROM categoria";
            $sql .= "\n WHERE nome LIKE :nome";

            $stmt = Conexao::getConexao()->prepare($sql);
            $nome .= "%";
            $stmt->bindParam(":nome", $nome, \PDO::PARAM_STR, 30);
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
    * metodo que tem função de buscar todas as categorias
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
    }//public static function listarTudo()

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
    public static function listaCategoriaPorTime($intCodigo)
    {
        try {
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
    }//public static function listaCategoriaPorTime($intCodigo)
}//class Categoria extends ClasseBase
