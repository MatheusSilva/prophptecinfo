<?php
class RoutesTest extends PHPUnit_Framework_TestCase
{
    private function api($url, $data = array(), $method = "POST")
    {
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
        );
        
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        return $result;
    }
    
    public function testAlterarTimeValido()
    {
        $url = 'http://localhost/sistemaRest/api/v1/time/index.php?a=4&id=2&tk=f11110a5368ff2533af65741ef01d641833922f677fa3cd8c7218a11c15c4681';

        $data = array(
             'txtNome'      => 'Timeco alterado'
            ,'cmbDivisao'   => 22
            ,'cmbCategoria' => 1
            ,'cmbTecnico'   => 37
        );
        
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Time alterado com sucesso.', $result["mensagem"]);
    }

    public function testExcluirTimeInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/time/index.php?a=5&id=999&tk=f11110a5368ff2533af65741ef01d641833922f677fa3cd8c7218a11c15c4681';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir time. Código inexistente.', $result["mensagem"]);
    }

    public function testExcluirTimeInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/time/index.php?a=5&id=asds&tk=f11110a5368ff2533af65741ef01d641833922f677fa3cd8c7218a11c15c4681';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir time. Código inválido.', $result["mensagem"]);
    }

    /*
    public function testExcluirTime()
    {
        $url = 'http://localhost/sistemaRest/api/v1/time/index.php?a=5&id=1&tk=f11110a5368ff2533af65741ef01d641833922f677fa3cd8c7218a11c15c4681';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Time excluido com sucesso.', $result["mensagem"]);
    }
    */
}
