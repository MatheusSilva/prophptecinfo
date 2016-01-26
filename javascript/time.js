class Time
{
    static valida(form)
    {
        var strErro = "";

        if (document.getElementById("txtNome").value == "") {
            strErro = strErro + "\nVoce Nao Preencheu o Nome";
        }

        if (document.getElementById("txtFoto").value == "") {
            strErro = strErro + "\nVoce Nao selecionou uma foto";
        }

        if(strErro != "") {
            alert(strErro);
            return false;
        }
    }

    static limpacamposCadastro()
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

    static consultar(form)
    {
        var pesquisa = '';

        if (form != null && form.txtNome.value != undefined) {
            pesquisa = form.txtNome.value;
        }

        var xhr = Ajax.createXHR();
        if (xhr != undefined) {
            //Montar requisição
            xhr.open("GET","http://localhost/sistemaRest/api/v1/time/index.php?a=2",true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
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

                    if (json.times != null) {
                        len         = json.times.length;
                    }

                    var temRegistro = false;
                    
                    var strHTML     = '<table width="80%" class="lista">'
                                    +'<tr class="primeira_linha">'
                                    +'<td>C&oacute;digo</td>'
                                    +'<td>Nome</td>'
                                    +'<td>A&ccedil;&otilde;es</td>'
                                    +'</tr>';
                                    
                    for (var i=0; i < len; i++) {
                        var codigo    = json.times[i].codigo;
                        var nome      = json.times[i].nome;

                        if (i % 2 == 0) {
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

                        var excluir = "<a href=\"javascript:Time.confirmar("
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
    
    static cadastrar(form) 
    {
        if (Time.valida() == false) {
            return false;
        }

        var jForm = new FormData();

        var e = document.getElementById("cmbDivisao");
        var cmbDivisao = e.options[e.selectedIndex].value;

        var e = document.getElementById("cmbCategoria");
        var cmbCategoria = e.options[e.selectedIndex].value;

        var e = document.getElementById("cmbTecnico");
        var cmbTecnico = e.options[e.selectedIndex].value;

        jForm.append("txtFoto", jQuery('#txtFoto').get(0).files[0]);
        jForm.append("txtNome", document.getElementById("txtNome").value);
        jForm.append("cmbDivisao", cmbDivisao);
        jForm.append("cmbCategoria", cmbCategoria);
        jForm.append("cmbTecnico", cmbTecnico);
        jForm.append("rDesempenhotime", document.querySelector('input[name="rDesempenhotime"]:checked').value);
        jForm.append("rComprarnovojogador", document.querySelector('input[name="rComprarnovojogador"]:checked').value);


        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
        
        jQuery.ajax({
            url: 'http://localhost/sistemaRest/api/v1/time/index.php?a=3'+consulta,
            type: 'POST',
            data: jForm,
            dataType: 'json',
            mimeType: 'application/json',
            contentType: false,
            cache: false,
            processData: false
        }).always(function(returndata) {
            limpacamposCadastro();
            alert(returndata.mensagem);
            location.reload();
        });

        return false;
    }

    static atualizar(form)
    {
        var codigo = document.getElementById("codigo").value;  

        if (codigo == "") {
            mensagem += "Código invalido";
        } else {
            codigo = "&id="+codigo;
        }
        
        var jForm = new FormData();

        var e = document.getElementById("cmbDivisao");
        var cmbDivisao = e.options[e.selectedIndex].value;

        var e = document.getElementById("cmbCategoria");
        var cmbCategoria = e.options[e.selectedIndex].value;

        var e = document.getElementById("cmbTecnico");
        var cmbTecnico = e.options[e.selectedIndex].value;


        jForm.append("codigo", codigo);
        jForm.append("txtFoto", jQuery('#txtFoto').get(0).files[0]);
        jForm.append("txtNome", document.getElementById("txtNome").value);
        jForm.append("cmbDivisao", cmbDivisao);
        jForm.append("cmbCategoria", cmbCategoria);
        jForm.append("cmbTecnico", cmbTecnico);
        jForm.append("rDesempenhotime", document.querySelector('input[name="rDesempenhotime"]:checked').value);
        jForm.append("rComprarnovojogador", document.querySelector('input[name="rComprarnovojogador"]:checked').value);

        var token  = Login.getCookie('token');
        var consulta = "";

        if (token !== "") {
            consulta = "&tk="+token;
        }
        
        var jqxhr = jQuery.ajax({
            url: 'http://localhost/sistemaRest/api/v1/time/index.php?a=4'+codigo+consulta,
            type: 'POST',
            data: jForm,
            dataType: 'json',
            mimeType: 'application/json',
            contentType: false,
            cache: false,
            processData: false
        });

        jqxhr.always(function (returndata) {
            alert(returndata.mensagem);
        });

        jqxhr.fail(function( jqXHR, textStatus ) {
            alert("Falha ao atualizar time!");
        });

        return false;
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
      
            if (mensagem === "" && xhr != undefined) {
                xhr.open("GET","http://localhost/sistemaRest/api/v1/time/index.php?a=5"+codigo+consulta,true);
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

    static listaTodosTimes()
    {
        var xhr = Ajax.createXHR();

        if(xhr != undefined) {
            //Montar requisição
            xhr.open("GET","http://localhost/sistemaRest/api/v1/time/index.php",true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {

                    //Pegar dados da resposta json
                    var json = JSON.parse(xhr.responseText);


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

                        var excluir = "<a href=\"javascript:Time.confirmar("
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
                    
                    document.getElementById("tabela").innerHTML = strHTML;
                }
            }

            xhr.send();
        }
    }

    static listaNomePorCodigo(codigoParam)
    {
        var xhr = Ajax.createXHR();

        if(xhr != undefined) {
            //Montar requisição
            xhr.open("GET","http://localhost/sistemaRest/api/v1/time/index.php?a=1&id="+codigoParam,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    //Pegar dados da resposta json
                    var data = JSON.parse(xhr.responseText);
                    document.getElementById("txtNome").value = data.nomeTime;
                }
            }

            xhr.send();
        }
    }

    static carregaDivisao(codigo)
    {
        var xhr = Ajax.createXHR();

        if(xhr != undefined) {
            //Montar requisição

            if (codigo != undefined) {
                codigo = "&id="+codigo;
            } else {
                codigo = "";
            }

            xhr.open("POST","http://localhost/sistemaRest/api/v1/divisao/index.php?a=1"+codigo,true);
            //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    var json = JSON.parse(xhr.responseText);
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

                    document.getElementById("cmbDivisao").innerHTML = strHTML;
                }
            }

            xhr.send(); 
        }     
    }

    static carregaCategoria(codigo)
    {
        var xhr = Ajax.createXHR();

        if(xhr != undefined) {
            if (codigo != undefined) {
                codigo = "&id="+codigo;
            } else {
                codigo = "";
            }

            //Montar requisição
            xhr.open("GET","http://localhost/sistemaRest/api/v1/categoria/index.php?a=1"+codigo,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    var json = JSON.parse(xhr.responseText);    
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

                    document.getElementById("cmbCategoria").innerHTML = strHTML;
                }
            }

            xhr.send(); 
        }
    }

    static carregaTecnico(codigo)
    {
        var xhr = Ajax.createXHR();

        if(xhr != undefined) {
            if (codigo != undefined) {
                codigo = "&id="+codigo;
            } else {
                codigo = "";
            }

            //Montar requisição
            xhr.open("GET","http://localhost/sistemaRest/api/v1/tecnico/index.php?a=1"+codigo,true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onreadystatechange = function() {
                //Verificar pelo estado "4" de pronto.
                if (xhr.readyState == '4') {
                    var json = JSON.parse(xhr.responseText);
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

                    document.getElementById("cmbTecnico").innerHTML = strHTML;
                }
            }

            xhr.send();
        }
    }

    static tudoParaDestino()
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

    static selecionadoParaDestino()
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

    static limpaDestino()
    {
        document.getElementById("destino").innerHTML = "";
    }

    static limpaSelecionadosDestino()
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

}