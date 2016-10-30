class Categoria
{
    static formToJSON(form) 
    {
        var codigo = "", nome = "";

        if (form.codigo != undefined) {
            codigo = form.codigo.value;
        }

        if (form.txtNome != undefined) {
            nome = form.txtNome.value;
        }

        return JSON.stringify({
            "codigo": codigo,
            "txtNome": nome
        });
    }

    static detalhe(codigo)
    {
        var xhr = Ajax.createXHR();
        xhr.open("GET","http://localhost/sistemaRest/api/v1/categoria/"+codigo,true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onreadystatechange = function() {
            //Verificar pelo estado "4" de pronto.

            if (xhr.readyState == '4' && xhr.status == '200') {
                //Pegar dados da resposta json
                var data = JSON.parse(xhr.responseText);
                document.getElementById("codigo").value = data.codigo_categoria;
                document.getElementById("txtNome").value = data.nome;
            }
        }

        xhr.setRequestHeader('tk', Login.getCookie('token'));
        xhr.send();
    }

    static consultar(form)
    {
        var url = "http://localhost/sistemaRest/api/v1/categoria/";

        if (form != null && form.txtNome.value != undefined && form.txtNome.value != '') {
            url += "pesquisanome/"+form.txtNome.value;
        }

        var xhr = Ajax.createXHR();

        if(xhr != undefined){
            //Montar requisição
            xhr.open("GET", url, true);
            xhr.onload = function(e) {
                    //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    //Pegar dados da resposta json
                    var json = JSON.parse(xhr.responseText);
                    
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
            xhr.setRequestHeader('tk', Login.getCookie('token'));
            xhr.send(); 
        }
    }
    
    

    static confirmar(codigo)
    {
        var xhr = Ajax.createXHR();
        var ok = window.confirm("Voce tem certeza que deseja excluir?");

        if (ok) {
            document.getElementById("ajax-loader").style.display='block';	
            var mensagem = "";

            if (Login.getCookie('token') == "") {
                mensagem += "Token invalido";
            }

            if (codigo == "") {
                mensagem += "Código invalido";
            }
                    
            if (mensagem == "" && xhr != undefined) {
                xhr.open("DELETE","http://localhost/sistemaRest/api/v1/categoria/"+codigo,true);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhr.onreadystatechange = function() {
                    //Verificar pelo estado "4" de pronto.

                    if (xhr.readyState == '4' && xhr.status == '200') {
                        //Pegar dados da resposta json
                        document.getElementById("ajax-loader").style.display = 'none';
                        location.reload();
                        var json = JSON.parse(xhr.responseText);
                        alert(json.mensagem);
                    }
                }

                xhr.setRequestHeader('tk', Login.getCookie('token'));
                xhr.send(); 
            } else {
                alert(mensagem);
            }
       }
    }
            
    static cadastrar(form) 
    {
        document.getElementById("mensagem").innerHTML = "<br /><b>Aguarde...</b>";
        var xhr = Ajax.createXHR();
        var mensagem = "";

        if (form.txtNome.value == "") {
            mensagem += "<br /><b>Você não preencheu a categoria</b>";
        }

        if (Login.getCookie('token') == "") {
            mensagem += "Token invalido";
        }

        if (mensagem == "" && xhr != undefined) {
            xhr.open("POST","http://localhost/sistemaRest/api/v1/categoria/",true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.

                if (xhr.readyState == '4' && xhr.status == '200') {
                    //Pegar dados da resposta json
                    document.getElementById("txtNome").value = "";
                    var json = JSON.parse(xhr.responseText);
                    document.getElementById("mensagem").innerHTML = json.mensagem;
                }
            }

            xhr.setRequestHeader('tk', Login.getCookie('token'));
            xhr.send(Categoria.formToJSON(form));
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }

    static atualizar(form) 
    {
        document.getElementById("mensagem").innerHTML = "<br /><b>Aguarde...</b>";
        
        var codigo = form.codigo.value;
        var mensagem = "";

        if (Login.getCookie('token') == "") {
            mensagem += "Token invalido";
        }

        if (codigo == "" || codigo == undefined) {
            mensagem += "Código invalido";
        }
        
        if (document.getElementById("txtNome").value == "") {
            mensagem += "<br /><b>Você não preencheu a Categoria</b>";
        }
        
        var consulta = "";

        var xhr = Ajax.createXHR();

        if(mensagem == "" && xhr != undefined) {
            xhr.open("PUT","http://localhost/sistemaRest/api/v1/categoria/"+codigo,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.

                if (xhr.readyState == '4' && xhr.status == '200') {
                    //Pegar dados da resposta json
                    var json = JSON.parse(xhr.responseText);
                    document.getElementById("mensagem").innerHTML = json.mensagem;
                }
            }

            xhr.setRequestHeader('tk', Login.getCookie('token'));
            xhr.send(Categoria.formToJSON(form));
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }
}
