function limpacamposCadastro()
{
    document.getElementById("txtFoto").value = '';
    document.getElementById("txtNome").value = '';
    document.getElementById("cmbDivisao").options.length = 0;
    document.getElementById("cmbCategoria").options.length = 0;
    document.getElementById("cmbTecnico").options.length = 0;
    
    var rDesempenhotime = document.getElementsByName("rDesempenhotime");
    rDesempenhotime[0].checked = true;

    var rComprarnovojogador = document.getElementsByName("rComprarnovojogador");
    rComprarnovojogador[0].checked = true;

}

$(document).ready(function() 
{
    $("#btnConsultar").click(function() 
    {
        var pesquisa = '';

        if ($("#txtNome").val() != undefined) {
            pesquisa = $("#txtNome").val();
        }

        $.getJSON( "http://localhost/sistemaRest/api/v1/time/index.php?a=2", { p: pesquisa })
        .done(function( json ) 
        {
            var len         = 0;

            if (json.times != undefined) {
                var len     = json.times.length;
            }

            var strHTML = '<table width="80%" class="lista">'
                            + '<tr class="primeira_linha">'
                            + '<td>C&oacute;digo</td>'
                            + '<td>Nome</td>'
                            + '<td>A&ccedil;&otilde;es</td>'
                            + '</tr>';

            for (var i=0; i < len; i++) {
                var codigo    = json.times[i].codigo;
                var nome      = json.times[i].nome;

                if (i % 2 === 0) {
                    strHTML = strHTML + '<tr class="linha_par">';
                } else {
                    strHTML = strHTML + '<tr class="linha_impar">';
                }
                    var detalhes = "<a href=\"../consultas/detalhe.time.htm?codigo="
                    + codigo
                    + "\">[D]</a>";

                    var alterar = "<a href=\"../formularios/alterar.time.htm?codigo="
                    + codigo
                    + "\">[A]</a>";

                    var excluir = "<a href=\"javascript:confirmar("
                    + codigo
                    + ")\">[X]</a>";

                    var acao = detalhes+alterar+excluir;

                    strHTML = strHTML + "<td>"+codigo+"</td>"
                    + "<td>"+nome+"</td>"   
                    + "<td>"+acao+"</td>"   
                    + "</tr>";
            }

            strHTML = strHTML + "</table>";
            
            if (json.times == undefined && json.mensagem != undefined) {
                strHTML = "<p>"+json.mensagem+"</p>";
            }

            $("#tabela").html(strHTML);
        });

        return false;
    });

    $("#btnCadastrar").click(function() 
    {   
        var jForm = new FormData();

        jForm.append("txtFoto", $('#txtFoto').get(0).files[0]);
        jForm.append("txtNome", $('#txtNome').val());
        jForm.append("cmbDivisao", $('#cmbDivisao').val());
        jForm.append("cmbCategoria", $('#cmbCategoria').val());
        jForm.append("cmbTecnico", $('#cmbTecnico').val());
        jForm.append("rDesempenhotime", $("input[name=\"rDesempenhotime\"]:checked").val());
        jForm.append("rComprarnovojogador", $("input[name=\"rComprarnovojogador\"]:checked").val());

        var token  = getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
        
        $.ajax({
            url: 'http://localhost/sistemaRest/api/v1/time/index.php?a=3'+consulta,
            type: 'POST',
            data: jForm,
            dataType: 'json',
            mimeType: 'application/json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (returndata) {
                limpacamposCadastro();
                alert(returndata.mensagem);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Falha ao cadastrar time!");
            }
        });

        return false;
    });

    $("#btnAlterar").click(function() 
    {
        var codigo = $("#codigo").val();  

        if (codigo == "") {
            mensagem += "Código invalido";
        } else {
            codigo = "&id="+codigo;
        }
        
        var jForm = new FormData();

        jForm.append("codigo", codigo);
        jForm.append("txtFoto", $('#txtFoto').get(0).files[0]);
        jForm.append("txtNome", $('#txtNome').val());
        jForm.append("cmbDivisao", $('#cmbDivisao').val());
        jForm.append("cmbCategoria", $('#cmbCategoria').val());
        jForm.append("cmbTecnico", $('#cmbTecnico').val());
        jForm.append("rDesempenhotime", $("input[name=\"rDesempenhotime\"]:checked").val());
        jForm.append("rComprarnovojogador", $("input[name=\"rComprarnovojogador\"]:checked").val());

        var token  = getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
        
        $.ajax({
            url: 'http://localhost/sistemaRest/api/v1/time/index.php?a=4'+codigo+consulta,
            type: 'POST',
            data: jForm,
            dataType: 'json',
            mimeType: 'application/json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (returndata) {
                alert(returndata.mensagem);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Falha ao atualizar time!");
            }
        });

        return false;
    });
});
        
function confirmar(codigo)
{
    var ok = window.confirm("Voce tem certeza que deseja excluir?");

    if (ok) {	
        var mensagem = "";

        if (codigo == "") {
            mensagem += "Código invalido";
        } else {
            codigo = "&id="+codigo;
        }

        var token  = getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
  
        if (mensagem === "") {
            $.ajax({
                type: 'POST',
                contentType: 'application/json',
                dataType: "json",
                url: 'http://localhost/sistemaRest/api/v1/time/index.php?a=5'+codigo+consulta,
                success: function(data) {
                    alert(data.mensagem);
                    location.reload();				
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown.mensagem);	
                }
            });
        } else {
            alert(mensagem);
        } 
    }
}

function listaTodosTimes()
{
    $(document).ready(function() {
        $.getJSON( "http://localhost/sistemaRest/api/v1/time/index.php", function( json ) 
        {
            var len         = 0;

            if (json.times != undefined) {
                var len     = json.times.length;
            }

            var strHTML     = '<table width="80%" class="lista">'
                            + '<tr class="primeira_linha">'
                            + '<td>C&oacute;digo</td>'
                            + '<td>Nome</td>'
                            + '<td>A&ccedil;&otilde;es</td>'
                            + '</tr>';

            for (var i=0; i < len; i++) {
                var codigo   = json.times[i].codigo;
                var nome     = json.times[i].nome;

                if (i % 2 === 0) {
                    strHTML = strHTML + '<tr class="linha_par">';
                } else {
                    strHTML = strHTML + '<tr class="linha_impar">';
                }

                var detalhes = "<a href=\"../consultas/detalhe.time.htm?codigo="
                + codigo
                + "\">[D]</a>";

                var alterar = "<a href=\"../formularios/alterar.time.htm?codigo="
                + codigo
                + "\">[A]</a>";

                var excluir = "<a href=\"javascript:confirmar("
                + codigo
                + ")\">[X]</a>";

                var acao = detalhes+alterar+excluir;

                strHTML = strHTML + "<td>"+codigo+"</td>"
                + "<td>"+nome+"</td>"	
                + "<td>"+acao+"</td>"	
                + "</tr>";
            }
            
            strHTML = strHTML + "</table>";

            if (json.times == undefined && json.mensagem != undefined) {
                strHTML = "<p>"+json.mensagem+"</p>";
            }
            
            $("#tabela").html(strHTML);
        });
    });            
}

function listaNomePorCodigo(codigoParam)
{
    $(document).ready(function() 
    {
        $.ajax({
            type: 'GET',
            contentType: 'application/json',
            dataType: "json",
            url: 'http://localhost/sistemaRest/api/v1/time/index.php?a=1&id='+codigoParam,
            success: function(data) {			
                $("#txtNome").val(data.nomeTime);			
            },
            error: function(jqXHR, textStatus, errorThrown){
                $("#txtNome").val("Falha ao carregar nome!");	
            }
        });
    });
}

function carregaDivisao(codigo)
{
    $(document).ready(function()
    {
        $.getJSON( "http://localhost/sistemaRest/api/v1/divisao/index.php?a=1&id="+codigo, function( json )
        {
            var len         = json.divisaos.length;
            var temRegistro = false;
            var strHTML     = '';

            for (var i=0; i < len; i++) {
                var codigo  = json.divisaos[i].codigo;
                var nome    = json.divisaos[i].nome;
                
                if(json.divisaos[i].selected) {
                    strHTML =  strHTML + "<option selected=\"true\" value=\""+codigo+"\">"+nome+"</option>";   
                } else {
                    strHTML =  strHTML + "<option value=\""+codigo+"\">"+nome+"</option>";
                }

                temRegistro = true;	
            }

            if (temRegistro == false) {
                strHTML = "<option value=\"\">Nenhuma categoria cadastrada</option>";
            }  

            $("#cmbDivisao").html(strHTML);
        });
    });
}

function carregaCategoria(codigo)
{
    $(document).ready(function() 
    {
        $.getJSON( "http://localhost/sistemaRest/api/v1/categoria/index.php?a=1&id="+codigo, function( json ) 
        {
            var len         = json.categorias.length;
            var temRegistro = false;
            var strHTML     = '';

            for (var i=0; i < len; i++) {
                var codigo   = json.categorias[i].codigo;
                var nome     = json.categorias[i].nome;

                if(json.categorias[i].selected) {
                    strHTML =  strHTML + "<option selected=\"true\" value=\""+codigo+"\">"+nome+"</option>";
                } else {
                    strHTML =  strHTML + "<option value=\""+codigo+"\">"+nome+"</option>";
                }

                temRegistro = true;	
            }

            if (temRegistro  === false) {
                strHTML = "<option value=\"\">Nenhuma categoria cadastrada</option>";
            }   

            $("#cmbCategoria").html(strHTML);
        });
    });
}

function carregaTecnico(codigo)
{
    $(document).ready(function() 
    {
        $.getJSON( "http://localhost/sistemaRest/api/v1/tecnico/index.php?a=1&id="+codigo, function( json ) 
        {
            var len         = json.tecnicos.length;
            var temRegistro = false;
            var strHTML     = '';

            for (var i=0; i < len; i++) {
                var codigo   = json.tecnicos[i].codigo;
                var nome     = json.tecnicos[i].nome;

                if(json.tecnicos[i].selected) {
                    strHTML =  strHTML + "<option selected=\"true\" value=\""+codigo+"\">"+nome+"</option>";
                } else {
                    strHTML =  strHTML + "<option value=\""+codigo+"\">"+nome+"</option>";
                }

                temRegistro = true;	
            }

            if(temRegistro  === false) {
                strHTML = "<option value=\"\">Nenhuma tecnico cadastrado</option>";
            }   

            $("#cmbTecnico").html(strHTML);
        });
    });
}

function tudoParaDestino()
{
    var select  = document.getElementById("origem");
    var tamanho = select.options.length;
    var dhtml   = "";
    var valor   = "";
    var texto   = "";

    for (i=0; i< tamanho; i++) {
        valor = select.options[i].value;
        texto = select.options[i].text;	
        dhtml = dhtml + "\n<option value=\""+valor+"\">"+texto+"</option>";
    }

    document.getElementById("destino").innerHTML = dhtml;
}

function selecionadoParaDestino()
{
    var select  = document.getElementById("origem");
    var tamanho = select.options.length;
    var valor   = "";
    var texto   = "";
    var dhtml   = "";

    for (i=0; i < tamanho; i++) {
        if (select.options[i].selected === true) { 
            valor = select.options[i].value;
            texto = select.options[i].text;
            dhtml = dhtml + "\n<option value=\""+valor+"\">"+texto+"</option>";	
        }
    }

    document.getElementById("destino").innerHTML = dhtml;
}

function limpaDestino()
{
    document.getElementById("destino").innerHTML = "";
}

function limpaSelecionadosDestino()
{
    var select  = document.getElementById("destino");
    var tamanho = select.options.length;
    var dhtml   = "";
    var valor   = "";
    var texto   = "";

    for (i=0; i < tamanho; i++) {
        if ( select.options[i].selected !== true) {
            valor = select.options[i].value;
            texto = select.options[i].text;
            dhtml = dhtml + "\n<option value=\""+valor+"\">"+texto+"</option>";	
        }
    }

    document.getElementById("destino").innerHTML = dhtml;
}
