function consultar()
{
    $.getJSON( "http://localhost/sistemaRest/api/categoria", function( json ) 
    {
        var len         = json.categorias.length;
        var temRegistro = false;
        
        var strHTML     = '<table width="80%" class="lista">'
                        +'<tr class="primeira_linha">'
                        +'<td>C&oacute;digo</td>'
                        +'<td>Nome</td>'
                        +'<td>A&ccedil;&otilde;es</td>'
                        +'</tr>';

        for (var i=0; i < len; i++) {
            var codigo    = json.categorias[i].codigo;
            var nome      = json.categorias[i].nome;

            if (i % 2 == 0) {
                strHTML = strHTML + '<tr class="linha_par">';
            } else {
                strHTML = strHTML + '<tr class="linha_impar">';
            }

            var detalhes = "<a href=\"../consultas/detalhe.categoria.php?codigo="
            + codigo
            + "\">[D]</a>";

            var alterar = "<a href=\"../formularios/alterar.categoria.htm?codigo="
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
            temRegistro = true;	
        }

        if(temRegistro  == false) {
            strHTML = "Nenhuma categoria cadastrada";
        }   

        strHTML = strHTML + "</table>";

        $("#tabela").html(strHTML);
    });
}

function formToJSON() 
{
    return JSON.stringify({
        "codigo": $("#codigo").val(),
	"txtNome": $("#txtNome").val()
    });
}

function confirmar(codigo)
{
    var ok = window.confirm("Voce tem certeza que deseja excluir?");

    if (ok) {	
        var mensagem = "";

        if (codigo == "") {
                mensagem += "Código invalido";
        }

        var token  = getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "/"+token;
        }
                
        if(mensagem == "") {
            $.ajax({
                type: 'DELETE',
                contentType: 'application/json',
                dataType: "json",
                url: 'http://localhost/sistemaRest/api/categoria/'+codigo+consulta,
                success: function(data) {
                  alert(data.mensagem);
                  location.reload();				
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert("Falha ao excluir categoria!");	
                }
            });
        } else {
            alert(mensagem);
        }
   }
}

$(document).ready(function() {
    $("#mensagem").html("");

    $("#btnConsultar").click(function() {
        consultar();
    });

    $("#btnCadastrar").click(function() {
        var mensagem = "";

        if ($("#txtNome").val() == "") {
            mensagem += "<br /><b>Você não preencheu a categoria</b>";
        }

        var token  = getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "/"+token;
        }

        if (mensagem == "") {
            $.ajax({
                type: 'POST',
                contentType: 'application/json',
                dataType: "json",
                url: 'http://localhost/sistemaRest/api/categoria'+consulta,
                data: formToJSON(),
                beforeSend: function(){
                  $("#mensagem").html("<br /><b>Carregando...</b>");
                },
                success: function(data) {
                  $("#mensagem").html(data.mensagem);				
                },
                error: function(jqXHR, textStatus, errorThrown){
                  $("#mensagem").html("<br /><b>Falha ao cadastrar categoria!</b>");	
                }
            }).done(function( data ) {
                $("#txtNome").val("");		 	     	
            });
        } else {
            $("#mensagem").html(mensagem);
        } 
    });

    $("#btnAtualizar").click(function() {
            var codigo = $("#codigo").val();
            var mensagem = "";

            if ($("#txtNome").val() == "") {
                mensagem += "<br /><b>Você não preencheu a Categoria</b>";
            }

            var token  = getCookie('token');
            var consulta = "";

            if (token !== "") {
                consulta = "/"+token;
            }

            if(mensagem == "") {
                $.ajax({
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: "json",
                    url: 'http://localhost/sistemaRest/api/categoria/'+codigo+consulta,
                    data: formToJSON(),
                    beforeSend: function(){
                      $("#mensagem").html("<br /><b>Carregando...</b>");
                    },
                    success: function(data) {
                      $("#mensagem").html("<br /><b>"+data.mensagem+"</br>");			
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                      $("#mensagem").html("<br /><b>Falha ao alterar categoria!</b>");	
                    }
                });
            } else {
                $("#mensagem").html(mensagem);
            } 
    });
});
