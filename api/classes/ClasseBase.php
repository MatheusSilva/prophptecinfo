<?php
namespace sistemaRest\api\classes;
use sistemaRest\adm\classes\Conexao;

class ClasseBase
{
    function __construct() 
    {
        $classLoader = new \SplClassLoader('sistemaRest\adm\classes');
        $classLoader->register();
    }
    
    public function tokenEhValido($strToken)
    {
        $sql   = "\n SELECT 1";
        $sql  .= "\n FROM torcedor";
        $sql  .= "\n WHERE token = :token";

        $conexao = Conexao::getConexao(); 		  
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":token",$strToken);
        $stmt->execute();
        $retorno =  $stmt->fetch();
        $conexao = null;
        
        if (empty($retorno)) {
            return false;
        }//if (empty($retorno)) {
        
        return true;
    }
}