<?php
namespace lib;

use lib\Login;

class ClasseBase
{
    public function __construct()
    {
        require_once "Conexao.php";
        require_once "Login.php";
        Login::verificar(false);
    }
    
    public function tokenEhValido($strToken)
    {
        if (empty($strToken)) {
            return false;
        }

        $sql   = "\n SELECT 1";
        $sql  .= "\n FROM torcedor";
        $sql  .= "\n WHERE token = :token";

        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":token", $strToken);
        $stmt->execute();
        $retorno =  $stmt->fetch();
        $conexao = null;
        
        if (empty($retorno)) {
            return false;
        }//if (empty($retorno)) {

        return true;
    }
}
