class Divisao
{
    static consultar(form)
    {
        var pesquisa = '';

        if (form != null && form.txtNome.value != undefined) {
            pesquisa = form.txtNome.value;
        }

        var xhr = Ajax.createXHR();

        if(xhr != undefined) {
            //Montar requisição
            xhr.open("POST","http://localhost/sistemaRest/api/v1/divisao/index.php?a=3",true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    //Pegar dados da resposta json
                    var json = JSON.parse(xhr.responseText);
                    
                    // Pega a tabela.
                    var table = document.getElementById("tabela");
                    
                    // Limpa toda a INNER da tabela.
                    table.innerHTML = "";
                    
                    var len = 0;

                    if (json.divisaos != null) {
                        len         = json.divisaos.length;
                    }

                    var temRegistro = false;
                    
                    var strHTML     = '<table width="80%" class="lista">'
                                    +'<tr class="primeira_linha">'
                                    +'<td>C&oacute;digo</td>'
                                    +'<td>Nome</td>'
                                    +'<td>A&ccedil;&otilde;es</td>'
                                    +'</tr>';
                                    
                    for (var i=0; i < len; i++) {
                        var codigo    = json.divisaos[i].codigo_divisao;
                        var nome      = json.divisaos[i].nome;

                        if (i % 2 == 0) {
                            strHTML = strHTML + '<tr class="linha_par">';
                        } else {
                            strHTML = strHTML + '<tr class="linha_impar">';
                        }

                        var detalhes = "<a href=\"../consultas/detalhe.divisao.htm?codigo="
                        + codigo
                        + "\">[D]</a>";

                        var alterar = "<a href=\"../formularios/alterar.divisao.htm?codigo="
                        + codigo
                        + "\">[A]</a>";

                        var excluir = "<a href=\"javascript:Divisao.confirmar("
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
            xhr.send("p="+pesquisa); 
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
        var xhr = Ajax.createXHR();
        var ok = window.confirm("Voce tem certeza que deseja excluir?");

        if (ok && xhr != undefined) {
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

            if(mensagem == "") {
                xhr.open("POST","http://localhost/sistemaRest/api/v1/divisao/index.php?a=6"+codigo+consulta,true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    //Verificar pelo estado "4" de pronto.
                    if (xhr.readyState == '4') {
                        //Pegar dados da resposta json
                        var json = JSON.parse(xhr.responseText);
                        alert(json.mensagem);
                        location.reload();  
                    }
                }

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
            mensagem += "<br /><b>Você não preencheu a divisao</b>";
        }

        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
                
        if (mensagem == "" && xhr != undefined) {
            xhr.open("POST","http://localhost/sistemaRest/api/v1/divisao/index.php?a=4"+consulta,true);
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

            xhr.send(Divisao.formToJSON(form));
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        }
    }

    static atualizar(form) 
    {
        document.getElementById("mensagem").innerHTML = "<br /><b>Aguarde...</b>";  
        var xhr = Ajax.createXHR();
        var codigo = document.getElementById("codigo").value;
        var mensagem = "";

        if (codigo == "") {
            mensagem += "Código invalido";
        } else {
            codigo = "&id="+codigo;
        }

        if (document.getElementById("txtNome").value == "") {
            mensagem += "<br /><b>Você não preencheu a divisao</b>";
        }

        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }

        if(mensagem == "" && xhr != undefined) {
            xhr.open("POST","http://localhost/sistemaRest/api/v1/divisao/index.php?a=5"+codigo+consulta,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.

                if (xhr.readyState == '4' && xhr.status == '200') {
                    //Pegar dados da resposta json
                    var json = JSON.parse(xhr.responseText);
                    document.getElementById("mensagem").innerHTML = "<br /><b>"+json.mensagem+"</b>";  
                }
            }

            xhr.send(Divisao.formToJSON(form));
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }
}
