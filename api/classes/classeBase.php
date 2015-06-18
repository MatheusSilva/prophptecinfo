<?php

class classeBase
{
    public function tokenEhValido($strToken)
    {
        $sql   = "\n SELECT 1";
        $sql  .= "\n FROM torcedor";
        $sql  .= "\n WHERE token = :token";

        require_once '../adm/classes/conexao.php';
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