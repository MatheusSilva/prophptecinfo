let linkReq = '';

class Categoria
{
    static consultar(form)
    {
        var pesquisa = '';

        if (form != null && form.txtNome.value != undefined) {
            pesquisa = form.txtNome.value;
        }

        linkReq = Ajax.createXHR();
        if(linkReq != undefined){
            //Montar requisição
            linkReq.open("POST","http://localhost/sistemaRest/api/v1/categoria/index.php?a=3",true);
            linkReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            linkReq.onreadystatechange = function() {
                    //Verificar pelo estado "4" de pronto.
                if (linkReq.readyState == '4') {
                    //Pegar dados da resposta json
                    var json = JSON.parse(linkReq.responseText);
                    
                    // Pega a tabela.
                    var table = document.getElementById("tabela");
                    
                    // Limpa toda a INNER da tabela.
                    table.innerHTML = "";
                    
                    var len = 0;

                    if (json.categorias != null) {
                        len         = json.categorias.length;
                    }

                    var temRegistro = false;
                    
                    var strHTML     = '<table width="80%" class="lista">'
                                    +'<tr class="primeira_linha">'
                                    +'<td>C&oacute;digo</td>'
                                    +'<td>Nome</td>'
                                    +'<td>A&ccedil;&otilde;es</td>'
                                    +'</tr>';
                                    
                    for (var i=0; i < len; i++) {
                        var codigo    = json.categorias[i].codigo_categoria;
                        var nome      = json.categorias[i].nome;

                        if (i % 2 == 0) {
                            strHTML = strHTML + '<tr class="linha_par">';
                        } else {
                            strHTML = strHTML + '<tr class="linha_impar">';
                        }

                        var detalhes = "<a href=\"../consultas/detalhe.categoria.htm?codigo="
                        + codigo
                        + "\">[D]</a>";

                        var alterar = "<a href=\"../formularios/alterar.categoria.htm?codigo="
                        + codigo
                        + "\">[A]</a>";

                        var excluir = "<a href=\"javascript:Categoria.confirmar("
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
                        strHTML = json.mensagem;
                    }   

                    strHTML = strHTML + "</table>";

                    table.innerHTML = strHTML;
                }
            }

          //Enviar
          linkReq.send("p="+pesquisa); 
        }
    }
    
    static formToJSON(form) 
    {
        var codigo = "";

        if (form.codigo != undefined) {
            codigo = form.codigo.value;
        }


        return JSON.stringify({
            "codigo": codigo,
            "txtNome": form.txtNome.value
        });
    }

    static confirmar(codigo)
    {
        var ok = window.confirm("Voce tem certeza que deseja excluir?");

        if (ok) {	
            var mensagem = "";

            if (codigo == "") {
                mensagem += "Código invalido";
            } else {
                codigo = "&id="+codigo;
            }

            var token  = Login.getCookie('token');
            var consulta = "";

            if (token !== "") {
                consulta = "&tk="+token;
            }
                    
            if (mensagem == "") {
                linkReq.open("POST","http://localhost/sistemaRest/api/v1/categoria/index.php?a=6"+codigo+consulta,true);
                linkReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                linkReq.onreadystatechange = function() {
                    //Verificar pelo estado "4" de pronto.
                    if (linkReq.readyState == '4') {
                        //Pegar dados da resposta json
                        var json = JSON.parse(linkReq.responseText);
                        alert(json.mensagem);
                        location.reload();  
                    }
                }

                linkReq.send(); 
            } else {
                alert(mensagem);
            }
       }
    }

    static cadastrar(form) 
    {
        var mensagem = "";

        if (form.txtNome.value == "") {
            mensagem += "<br /><b>Você não preencheu a categoria</b>";
        }

        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }

        if (mensagem == "") {
            jQuery.ajax({
                type: 'POST',
                contentType: 'application/json',
                dataType: "json",
                url: 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=4'+consulta,
                data: Categoria.formToJSON(form),
                beforeSend: function() {
                    document.getElementById("mensagem").innerHTML = "<br /><b>Carregando...</b>";
                },
                success: function(data) {
                    document.getElementById("mensagem").innerHTML = data.mensagem;				
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    document.getElementById("mensagem").innerHTML = "<br /><b>Falha ao cadastrar categoria!</b>";	
                }
            }).done(function( data ) {
                document.getElementById("txtNome").value = "";	 	     	
            });
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }

    static atualizar(form) 
    {
        var codigo = form.codigo.value;
        var mensagem = "";

        if (codigo == "") {
            mensagem += "Código invalido";
        } else {
            codigo = "&id="+codigo;
        }
        
        if (document.getElementById("txtNome").value == "") {
            mensagem += "<br /><b>Você não preencheu a Categoria</b>";
        }

        var token  = Login.getCookie('token');
        var consulta = "";
        
        if (token !== "") {
            consulta = "&tk="+token;
        }

        if(mensagem == "") {
            jQuery.ajax({
                type: 'POST',
                contentType: 'application/json',
                dataType: "json",
                url: 'http://localhost/sistemaRest/api/v1/categoria/index.php?a=5'+codigo+consulta,
                data: Categoria.formToJSON(form),
                beforeSend: function(){
                    document.getElementById("mensagem").innerHTML = "<br /><b>Carregando...</b>";
                },
                success: function(data) {
                    document.getElementById("mensagem").innerHTML = "<br /><b>"+data.mensagem+"</br>";			
                },
                error: function(jqXHR, textStatus, errorThrown){
                    document.getElementById("mensagem").innerHTML = "<br /><b>Falha ao alterar categoria!</b>";
                }
            });
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }
}
