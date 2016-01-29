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
    
    public function testTokenInvalidoSalvarCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4&tk=asdasd';
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }

    public function testTokenInvalidoAlterarCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=5&tk=asdasd';
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }
    
    public function testNomeEmBrancoSalvarCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array('txtNome' => '');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher a categoria.', $result["mensagem"]);
    }

    public function testNomeEmBrancoAlterarCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=5&id=2&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array('txtNome' => '');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher a categoria.', $result["mensagem"]);
    }
    
    public function testNomeValidoSalvarCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array('txtNome' => 'testephpunit');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Categoria cadastrada com sucesso.', $result["mensagem"]);
    }

    public function testNomeValidoAlterarCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=5&id=2&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Categoria alterada com sucesso.', $result["mensagem"]);
    }


    public function testAlterarCategoriaInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=5&id=999&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao alterar categoria. Código inexistente.', $result["mensagem"]);
    }


    public function testAlterarCategoriaInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=5&id=asds&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao alterar categoria. Código inválido.', $result["mensagem"]);
    }

    public function testExcluirCategoriaInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=6&id=999&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir categoria. Código inexistente.', $result["mensagem"]);
    }

    public function testExcluirCategoriaInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=6&id=asds&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir categoria. Código inválido.', $result["mensagem"]);
    }

    public function testExcluirCategoriaVinculadaTime()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=6&id=1&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir categoria. Existem um ou mais times vinculados a esta categoria.', $result["mensagem"]);
    }

    public function testExcluirCategoria()
    {
        $url = 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=6&id=19&tk=87569b8c8e79c6a46ecb1421f7320943565578e3e7eac7c013c2639bc026a34e';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Categoria excluida com sucesso.', $result["mensagem"]);
    }
}
