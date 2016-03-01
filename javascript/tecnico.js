class Tecnico
{
    static valida()
    {
        var strErro = '';

        if (document.getElementById("txtNome").value == "") {
            strErro = strErro + "\nVocê não preencheu o nome.";
        }
        
        if (document.getElementById("cmbDia").value == "Dia") {
            strErro = strErro + "\nVocê não preencheu o dia.";
        }
        
        if (document.getElementById("cmbMes").value == "Mes") {
            strErro = strErro + "\nVocê não preencheu o mes.";
        }
        
        if (document.getElementById("cmbAno").value == "Ano") {
            strErro = strErro + "\nVocê não preencheu o ano.";
        }
        
        if (document.getElementById("cmbDia").value == "31") {
            if (document.getElementById("cmbMes").value == "04" 
            || document.getElementById("cmbMes").value  == "06" 
            || document.getElementById("cmbMes").value  == "09" 
            || document.getElementById("cmbMes").value  == "11") {
                strErro = strErro + "\no mês que você escolheu não possui mais de 30 dias.";
            }
        }
         
        if ((document.getElementById("cmbDia").value == "29") && (document.getElementById("cmbMes").value == "02")) {
            if ((document.getElementById("cmbAno").value%4 != "0") || (document.getElementById("cmbAno").value%100 != "0") || (document.getElementById("cmbAno").value%400 != "0")) {
                strErro = strErro + "\nEste ano não é bissexto.";
            }
        }
        
        if (document.getElementById("cmbDia").value > 29 && document.getElementById("cmbMes").value == "02") {
            strErro = strErro + "\nfevereiro não tem mais que 29 dias.";
        }

        if(strErro != "") {
            alert(strErro);
            return false;
        }
    }

    static consultar(form)
    {
        var pesquisa = '';

        if (form != null && form.txtNome.value != undefined) {
            pesquisa = form.txtNome.value;
        }

        var xhr = Ajax.createXHR();
        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
            
        if(xhr != undefined) {
            //Montar requisição
            xhr.open("POST","http://localhost/sistemaRest/api/v1/controller/tecnico.php?a=3"+consulta,true);
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

                    if (json.tecnicos != null) {
                        len         = json.tecnicos.length;
                    }

                    var temRegistro = false;
                    
                    var strHTML     = '<table width="80%" class="lista">'
                                    +'<tr class="primeira_linha">'
                                    +'<td>C&oacute;digo</td>'
                                    +'<td>Nome</td>'
                                    +'<td>A&ccedil;&otilde;es</td>'
                                    +'</tr>';
                                    
                    for (var i=0; i < len; i++) {
                        var codigo    = json.tecnicos[i].codigo_tecnico;
                        var nome      = json.tecnicos[i].nome;

                        if (i % 2 == 0) {
                            strHTML = strHTML + '<tr class="linha_par">';
                        } else {
                            strHTML = strHTML + '<tr class="linha_impar">';
                        }

                        var detalhes = "<a href=\"../consultas/detalhe.tecnico.htm?codigo="
                        + codigo
                        + "\">[D]</a>";

                        var alterar = "<a href=\"../formularios/alterar.tecnico.htm?codigo="
                        + codigo
                        + "\">[A]</a>";

                        var excluir = "<a href=\"javascript:Tecnico.confirmar("
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

            var jForm = new FormData();
            jForm.append('p', pesquisa);

            //Enviar
            xhr.send(jForm);
        }
    }
    
    static formToJSON(form) 
    {
        var codigo  = '';
        var txtNome = '';
        var cmbDia  = '';
        var cmbMes  = '';
        var cmbAno  = '';

        if (form.codigo != undefined) {
            codigo = form.codigo.value;
        }

        if (form.txtNome != undefined) {
            txtNome = form.txtNome.value;
        }

        if (form.cmbDia != undefined) {
            cmbDia = form.cmbDia.options[form.cmbDia.selectedIndex].value;
        }

        if (form.cmbMes != undefined) {
            cmbMes = form.cmbMes.options[form.cmbMes.selectedIndex].value;
        }

        if (form.cmbAno != undefined) {
            cmbAno = form.cmbAno.options[form.cmbAno.selectedIndex].value;
        }

        return JSON.stringify({
            "codigo":  codigo,
            "cmbDia":  cmbDia,
            "cmbMes":  cmbMes,
            "cmbAno":  cmbAno,
            "txtNome": txtNome
        });
    }

    static confirmar(codigo)
    {
        var xhr = Ajax.createXHR();
        var ok = window.confirm("Você tem certeza que deseja excluir?");

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
                xhr.open("GET","http://localhost/sistemaRest/api/v1/controller/tecnico.php?a=6"+codigo+consulta,true);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
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
        var xhr = Ajax.createXHR();

        if (Tecnico.valida() == false) {
            return false;
        }
        
        document.getElementById("mensagem").innerHTML = "<br /><b>Aguarde...</b>";
        var mensagem = "";

        if (form.txtNome.value == "") {
            mensagem += "<br /><b>Você não preencheu a técnico.</b>";
        }

        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
        
        if (mensagem == "" && xhr != undefined) {
            xhr.open("POST","http://localhost/sistemaRest/api/v1/controller/tecnico.php?a=4"+consulta,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    //Pegar dados da resposta json
                    document.getElementById("txtNome").value = "";
                    var json = JSON.parse(xhr.responseText);
                    document.getElementById("mensagem").innerHTML = "<br /><b>"+json.mensagem+"</b>";
                }
            }

            xhr.send(Tecnico.formToJSON(form));
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }

    static atualizar(form) 
    {
        document.getElementById("mensagem").innerHTML = "<br /><b>Aguarde...</b>";  
        var xhr = Ajax.createXHR();
        var codigo = form.codigo.value;
        var mensagem = "";

        if (codigo == "") {
            mensagem += "Código invalido";
        } else {
            codigo = "&id="+codigo;
        }


        if (form.txtNome.value == "") {
            mensagem += "<br /><b>Você não preencheu a técnico</b>";
        }
        
        var token  = Login.getCookie('token');
        
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }

        if(mensagem == "" && xhr != undefined) {
            xhr.open("POST","http://localhost/sistemaRest/api/v1/controller/tecnico.php?a=5"+codigo+consulta,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.

                if (xhr.readyState == '4' && xhr.status == '200') {
                    //Pegar dados da resposta json
                    var json = JSON.parse(xhr.responseText);
                    document.getElementById("mensagem").innerHTML = "<br /><b>"+json.mensagem+"</b>";  
                }
            }

            xhr.send(Tecnico.formToJSON(form));
        } else {
            document.getElementById("mensagem").innerHTML = mensagem;
        } 
    }
}