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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
        ); 
        
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        return $result;
    }
    
    public function testTokenInvalidoCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4&tk=asdasd';
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao cadastrar categoria', $result["mensagem"]);
    }
    
    public function testNomeEmBrancoCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4&tk=698dc19d489c4e4db73e28a713eab07be10adc3949ba59abbe56e057f20f883e';
        $data = array('txtNome' => '');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao cadastrar categoria', $result["mensagem"]);
    }
    
    public function testNomeValidoCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4&tk=698dc19d489c4e4db73e28a713eab07be10adc3949ba59abbe56e057f20f883e';
        $data = array('txtNome' => 'testephpunit');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Categoria cadastrada com sucesso', $result["mensagem"]);
    }
}
