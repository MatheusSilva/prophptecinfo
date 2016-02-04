<?php
class TimeTest extends PHPUnit_Framework_TestCase
{
    private $token = "dc358110b62ae36c3ab26de9c1c6e9c5448b0e77ada20aa817727d8ada948bc9";
    
    private function api($url, $data = array(), $method = "POST")
    {
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        return $result;
    }
    
    public function testAlterarTimeValido()
    {
        $url = 'http://localhost/sistemaRest/api/v1/controller/time.php?a=4&id=2&tk='.$this->token;

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
        $url = 'http://localhost/sistemaRest/api/v1/controller/time.php?a=5&id=999&tk='.$this->token;
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir time. Código inexistente.', $result["mensagem"]);
    }

    public function testExcluirTimeInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/controller/time.php?a=5&id=asds&tk='.$this->token;
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir time. Código inválido.', $result["mensagem"]);
    }

    /*
    public function testExcluirTime()
    {
        $url = 'http://localhost/sistemaRest/api/v1/controller/time.php?a=5&id=1&tk='.$this->token;
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Time excluido com sucesso.', $result["mensagem"]);
    }
    */
}
