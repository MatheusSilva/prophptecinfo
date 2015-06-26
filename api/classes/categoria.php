<?php
require "classeBase.php";

/**
* classe Categoria
*
* @author    Matheus Silva
* @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
*/
class Categoria extends classeBase
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

    function __construct()
    {
        require_once '../adm/classes/conexao.php';
    }
    
    /**
    * metodo acessor Get que retorna a informação da propriedade codigoCategoria
    *
    * @access    public
    * @return    integer Retorna o codigo da categoria 
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
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
    * @param     integer $codigoCategoria Armazena a senha atual
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
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
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
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
    * @param     string $nome Armazena a senha atual
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
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
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function inserir($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                return false;
            }//if ($this->tokenEhValido($token) === false) {
        
            $nome  = $this->getNome();
            $id    = $this->ultimoCodigo();

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
            $stmt->bindParam(":id",$id);
            $stmt->bindParam(":nome",$nome);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }//public function inserir()
	
    /**
    * metodo que tem função de fazer alteração do registro
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function alterar($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                return false;
            }//if ($this->tokenEhValido($token) === false) {

            $codigo  = $this->getCodigoCategoria();
            $nome    = $this->getNome();

            $sql  = "\n UPDATE categoria"; 
            $sql .= "\n SET nome = :nome";
            $sql .= "\n WHERE codigo_categoria = :id";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id",$codigo);
            $stmt->bindParam(":nome",$nome);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }//public function alterar($codigo)
	
    /**
    * metodo que tem função de fazer exclusão do registro
    *
    * @access    public
    * @return    boolean|integer retorna um valor indicando se tudo ocorreu bem ou não
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public function excluir($token)
    {
        try {
            if ($this->tokenEhValido($token) === false) {
                return false;
            }//if ($this->tokenEhValido($token) === false) {
            
            $codigo  = $this->getCodigoCategoria();
            $nome    = $this->getNome();

            $sql  = "\n DELETE FROM categoria";
            $sql .= "\n WHERE codigo_categoria = :id";

            $conexao = Conexao::getConexao();
            $conexao->beginTransaction();
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id",$codigo);
            $retorno = $stmt->execute();
            $conexao->commit();
            $conexao = null;
            return $retorno;
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }//public function excluir($codigo)
	
    /**
    * metodo que tem função de buscar o ultimo codigo da categoria
    *
    * @access    public
    * @return    integer retorna o ultimo codigo
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function ultimoCodigo()
    {
        try {
            $conexao = Conexao::getConexao();
            $sql  = "\n SELECT MAX(codigo_categoria) + 1 AS codigo";
            $sql .= "\n FROM categoria";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $retorno =  $stmt->fetch(PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno["codigo"];
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }//public static function ultimoCodigo()

    /**
    * metodo que tem função de buscar as informacoes da categoria por codigo
    *
    * @access    public
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarPorCodigo($codigo)
    {
        try {
            require_once '../adm/classes/conexao.php';
            $conexao = Conexao::getConexao();

            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n , nome";
            $sql .= "\n FROM categoria";
            $sql .= "\n WHERE codigo_categoria = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id",$codigo);
            $stmt->execute();
            $conexao = null;
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }		
    }//public static function listarPorCodigo($codigo)
	
    /**
    * metodo que tem função de buscar todas as categorias que tenham determinado padrao de nome
    *
    * @access    public
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarPorNome($nome)
    {
        try {
            require_once '../classes/conexao.php';
            $nome .= "%";
            $conexao = Conexao::getConexao();

            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n , nome";
            $sql .= "\n FROM categoria";
            $sql .= "\n WHERE nome LIKE :nome";


            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":nome",$nome);
            $stmt->execute();
            $conexao = null;
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }	
    }//public static function listarPorNome($nome)

    /**
    * metodo que tem função de buscar todas as categorias
    *
    * @access    public
    * @return    array retorna as informacoes
    * @author    Matheus Silva
    * @copyright © Copyright 2010-2015 Matheus Silva. Todos os direitos reservados.
    * @since     14/12/2010
    * @version   0.2
    */
    public static function listarTudo($strRequire = '../adm/classes/conexao.php')
    {
        require_once $strRequire;

        try {
            $conexao = Conexao::getConexao();

            $sql  = "\n SELECT codigo_categoria";
            $sql .= "\n , nome";
            $sql .= "\n FROM categoria";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $conexao = null;
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $conexao = null;	
            return $e->getMessage();
        }	
    }//public static function listarTudo()
    
    public static function listaCategoriaPorTime($strRequire = '../adm/classes/conexao.php', $intCodigo)
    {     
        try {
            $sql   = "\n SELECT c.codigo_categoria,c.nome";
            $sql  .= "\n FROM time.time AS t, time.categoria AS c";
            $sql  .= "\n WHERE  c.codigo_categoria = t.categoria_codigo_categoria";
            $sql  .= "\n AND t.codigo_time = :codigo";

            //require_once $strRequire;
            $conexao = Conexao::getConexao(); 		  
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":codigo", $intCodigo);
            $stmt->execute();
            $retorno =  $stmt->fetch(PDO::FETCH_ASSOC);
            $conexao = null;
            return $retorno;
        } catch (PDOException $e) {
            $conexao = null;
            return $e->getMessage();
        }
    }
}
