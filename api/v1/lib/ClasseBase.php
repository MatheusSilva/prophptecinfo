<?php


class ClasseBase
{
    function __construct() 
    {
	   require_once "../adm/classes/Conexao.php";
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