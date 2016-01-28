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
    
    public function testTokenInvalidoSalvarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=4&tk=asdasd';
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }
    
    public function testNomeEmBrancoSalvarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=4&tk=60a84a43a8cdcaa1e5fa865c9ead3f12a9f737a1c29e6b1dee407dcf1863346b';
        $data = array('txtNome' => '');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher a divisão.', $result["mensagem"]);
    }
    
    public function testNomeValidoSalvarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=4&tk=60a84a43a8cdcaa1e5fa865c9ead3f12a9f737a1c29e6b1dee407dcf1863346b';
        $data = array('txtNome' => 'testephpunit');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Divisao cadastrada com sucesso.', $result["mensagem"]);
    }
}
