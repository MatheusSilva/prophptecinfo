<?php
namespace lib;

use lib\Login;

class ClasseBase
{
    private $arrErro;

    public function __construct()
    {
        require_once "../vendor/autoload.php";
        Login::verificar(false);
    }
    
    public function getErros()
    {
        $strErros = "";

        if (is_array($this->arrErro) && !empty($this->arrErro)) {
            $boolPassou = false;
            foreach ($this->arrErro as $val) {
                if ($boolPassou) {
                    $strErros .= "<br />".$val;
                } else {
                    $strErros .= $val;
                    $boolPassou = true;
                }
            }
        }

        return $strErros;
    }

    public function setErro($strErro)
    {
        $this->arrErro[] = $strErro;
    }

    public function limpaErros()
    {
        $this->arrErro = array();
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
