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
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }

    public function testTokenInvalidoAlterarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=5&tk=asdasd';
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }
    
    public function testNomeEmBrancoSalvarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=4&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher o técnico.<br />Você deve preencher a data.', $result["mensagem"]);
    }

    public function testNomeEmBrancoAlterarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=5&id=3&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher a técnico.', $result["mensagem"]);
    }
    
    public function testNomeValidoSalvarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=4&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7';
        $data = array(
            'txtNome' => 'testephpunit'
            ,'cmbDia' => 12
            ,'cmbMes' => 12
            ,'cmbAno' => 2012
        );

        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Técnico cadastrado com sucesso.', $result["mensagem"]);
    }

    public function testNomeValidoAlterarTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=5&id=3&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7  ';
        $data = array(
            'txtNome' => 'sub 26'
            ,'cmbDia' => 11
            ,'cmbMes' => 11
            ,'cmbAno' => 2011
        );
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Técnico alterado com sucesso.', $result["mensagem"]);
    }


    public function testAlterarTecnicoInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=5&id=999&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7    ';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao alterar técnico. Código inexistente.', $result["mensagem"]);
    }


    public function testAlterarTecnicoInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=5&id=asds&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7   ';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao alterar técnico. Código inválido.', $result["mensagem"]);
    }

    public function testExcluirTecnicoInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=6&id=999&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7    ';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir técnico. Código inexistente.', $result["mensagem"]);
    }

    public function testExcluirTecnicoInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=6&id=asds&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7   ';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir técnico. Código inválido.', $result["mensagem"]);
    }

    public function testExcluirTecnicoVinculadaTime()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=6&id=3&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7  ';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir técnico. Existem um ou mais times vinculados a este técnico.', $result["mensagem"]);
    }

    public function testExcluirTecnico()
    {
        $url = 'http://localhost/sistemaRest/api/v1/tecnico/index.php?a=6&id=36&tk=65189e519a39d4672511a210b49ad8f3bd99fe0eead3300459aa4b6fed327da7 ';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Técnico excluido com sucesso.', $result["mensagem"]);
    }
}
