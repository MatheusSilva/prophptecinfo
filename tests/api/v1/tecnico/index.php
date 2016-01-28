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
    
    public function testTokenInvalidoSalvarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=4&tk=asdasd';
        $data = array(
            'txtNome' => "NBI"
            ,'cmbDia' => ""
            ,'cmbMes' => ""
            ,'cmbAno' => ""
        );

        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }
    
    public function testNomeEmBrancoSalvarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=4&tk=60a84a43a8cdcaa1e5fa865c9ead3f12a9f737a1c29e6b1dee407dcf1863346b';
        $data = array(
            'txtNome' => ""
            ,'cmbDia' => ""
            ,'cmbMes' => ""
            ,'cmbAno' => ""
        );

        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher o tecnico.<br />Você deve preencher a data.', $result["mensagem"]);
    }
    
    public function testNomeValidoSalvarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=4&tk=60a84a43a8cdcaa1e5fa865c9ead3f12a9f737a1c29e6b1dee407dcf1863346b';
        $data = array(
            'txtNome' => 'testephpunit'
            ,'cmbDia' => 12
            ,'cmbMes' => 12
            ,'cmbAno' => 2012
        );

        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Tecnico cadastrado com sucesso.', $result["mensagem"]);
    }
}
