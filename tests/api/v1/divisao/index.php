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

    public function testTokenInvalidoAlterarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=5&tk=asdasd';
        $data = array('txtNome' => 'NBI');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Sua sessão expirou. Faça o login novamente.', $result["mensagem"]);
    }
    
    public function testNomeEmBrancoSalvarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=4&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array('txtNome' => '');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher a divisão.', $result["mensagem"]);
    }

    public function testNomeEmBrancoAlterarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=5&id=2&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array('txtNome' => '');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Você deve preencher a divisão.', $result["mensagem"]);
    }
    
    public function testNomeValidoSalvarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=4&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array('txtNome' => 'testephpunit');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Divisão cadastrada com sucesso.', $result["mensagem"]);
    }

    public function testNomeValidoAlterarDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=5&id=2&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Divisão alterada com sucesso.', $result["mensagem"]);
    }


    public function testAlterarDivisaoInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=5&id=999&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao alterar divisão. Código inexistente.', $result["mensagem"]);
    }


    public function testAlterarDivisaoInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=5&id=asds&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array('txtNome' => 'sub 25');
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao alterar divisão. Código inválido.', $result["mensagem"]);
    }

    public function testExcluirDivisaoInexistente()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=6&id=999&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir divisão. Código inexistente.', $result["mensagem"]);
    }

    public function testExcluirDivisaoInvalida()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=6&id=asds&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir divisão. Código inválido.', $result["mensagem"]);
    }

    public function testExcluirDivisaoVinculadaTime()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=6&id=2&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Falha ao excluir divisão. Existem um ou mais times vinculados a esta divisão.', $result["mensagem"]);
    }

    public function testExcluirDivisao()
    {
        $url = 'http://localhost/sistemaRest/api/v1/divisao/index.php?a=6&id=21&tk=83c7cf915afafa5c0679b5bc932a1c3d6f1c525c197f401c8fcef541b94d867e	';
        $data = array();
        $result = $this->api($url, $data, "POST");
        $this->assertEquals('Divisão excluida com sucesso.', $result["mensagem"]);
    }
}
