<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cat&aacute;logo de Jogos</title>
        <link rel="stylesheet" type="text/css" href="../../css/layoutgeral.css" />
        <script language="javascript" type="text/javascript" src="../../javascript/jquery-2.1.4.min.js"></script>
        <script language="javascript" type="text/javascript" src="../../javascript/crypto.js"></script>
        <script language="javascript" type="text/javascript" src="../../javascript/valida_login.js"></script>
        <script language="javascript" type="text/javascript" src="../../javascript/time.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var dhtml = "";

                $.getJSON( "http://localhost/sistemaRest/api/time", function( json ) 
                {
                    var len         = json.times.length;
                    var temRegistro = false;

                    dhtml     = '<table>';

                    for (var i=0; i < len; i++) {
                        var codigo    = json.times[i].codigo;
                        var nome      = json.times[i].nome;
                        var capa      = json.times[i].capa;

                        dhtml = dhtml
                            +"<tr>"
                                +"<td>"
                                    +"<img src=\""+capa+"\"  class=\"miniatura\" alt="+nome+" />"
                                +"</td>"
                            +"</tr>"

                            +"<tr>"
                                +"<td>"
                                    +"<a href=\"../../adm/consultas/detalhe.time.htm?codigo="+codigo+"\">"+nome+"</a>"
                                +"</td>"
                            +"</tr>";

                        temRegistro = true;
                    }

                    if(temRegistro  === false) {
                        dhtml = "Nenhuma time cadastrado";
                    }

                    dhtml = dhtml + "</table>";
                    $("#times").html(dhtml);
                });
            });
        </script>
    </head>
    
    <body>
        <div id="geral">

            <div id="cabecalho">
            </div>

            <div id="menu_superior">
                <a href="../paginas/home.php">Home</a> ::
                <a href="../../adm/formularios/cadastro.torcedor.php">Cadastrar-se</a> ::
                <a href="lista.time.php">Consultas</a> ::            
                <a href="../../adm/paginas/home.php">Entrar</a>
            </div>

            <div id="conteudo">
                <div id="menu_lateral">
                </div>

                <div id="texto">
                    <h2>Lista de Times</h2>

                    <div class="cada_time">
                        <div id="times"></div>
                    </div>
                </div>
            </div>

            <div id="rodape">
            </div>     
            
        </div>
    </body>
    
</html>
