$(document).ready(function() {
    $("#btnCadastrar").click(function() {   
              var jForm = new FormData();
              
               jForm.append("txtFoto", $('#txtFoto').get(0).files[0]);
               jForm.append("txtNome", $('#txtNome').val());
               jForm.append("cmbDivisao", $('#cmbDivisao').val());
               jForm.append("cmbCategoria", $('#cmbCategoria').val());
               jForm.append("cmbTecnico", $('#cmbTecnico').val());
               jForm.append("rDesempenhotime", $("input[name=\"rDesempenhotime\"]:checked").val());
               jForm.append("rComprarnovojogador", $("input[name=\"rComprarnovojogador\"]:checked").val());

              $.ajax({
                url: 'http://localhost/sistemaRest/api/time',
                type: 'POST',
                data: jForm,
                dataType: 'json',
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                success: function (returndata) {
                    alert(returndata.mensagem);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert("Falha ao cadastrar time!");
                }
              });

              return false;
    });
    
    $("#btnAlterar").click(function() {
            var codigo = $("#codigo").val();  
            var jForm = new FormData();
            
            jForm.append("codigo", codigo);
            jForm.append("txtFoto", $('#txtFoto').get(0).files[0]);
            jForm.append("txtNome", $('#txtNome').val());
            jForm.append("cmbDivisao", $('#cmbDivisao').val());
            jForm.append("cmbCategoria", $('#cmbCategoria').val());
            jForm.append("cmbTecnico", $('#cmbTecnico').val());
            jForm.append("rDesempenhotime", $("input[name=\"rDesempenhotime\"]:checked").val());
            jForm.append("rComprarnovojogador", $("input[name=\"rComprarnovojogador\"]:checked").val());

            $.ajax({
              url: 'http://localhost/sistemaRest/api/time/atualizar/'+codigo,
              type: 'POST',
              data: jForm,
              dataType: 'json',
              mimeType: 'multipart/form-data',
              contentType: false,
              cache: false,
              processData: false,
              success: function (returndata) {
                  alert(returndata.mensagem);
              },
              error: function(jqXHR, textStatus, errorThrown){
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
		}

		if(mensagem == "") {
			$.ajax({
			  type: 'DELETE',
			  contentType: 'application/json',
			  dataType: "json",
			  url: 'http://localhost/sistemaRest/api/time/'+codigo,
			  success: function(data) {
			    alert(data.mensagem);
			    location.reload();				
			  },
			  error: function(jqXHR, textStatus, errorThrown){
		 	    alert("Falha ao excluir time!");	
			  }
			});
		} else {
			alert(mensagem);
		} 
   }
}

function listaNomePorCodigo(codigoParam)
{
    $(document).ready(function() {
        $.ajax({
        type: 'GET',
        contentType: 'application/json',
        dataType: "json",
        url: 'http://localhost/sistemaRest/api/time/'+codigoParam,
        success: function(data) {			
          $("#txtNome").val(data.nomeTime);			
        },
        error: function(jqXHR, textStatus, errorThrown){
          $("#txtNome").val("Falha ao carregar nome!");	
        }
        });
    });
}


function carregaDivisao(codigoParam)
{
    $(document).ready(function() {
        $.getJSON( "http://localhost/sistemaRest/api/divisao", function( json ) {
                    var len               = json.divisaos.length;
                    var temRegistro	      = false;
                    var strHTML  	      = '';

                    for (var i=0; i < len; i++){
                      var codigo   = json.divisaos[i].codigo;
                      var nome     = json.divisaos[i].nome;
                      
                      if(codigoParam != codigo) {
                        strHTML =  strHTML + "<option value=\""+codigo+"\">"+nome+"</option>";
                      } else {
                        strHTML =  strHTML + "<option selected=\"true\" value=\""+codigo+"\">"+nome+"</option>";
                      }
                      
                      temRegistro = true;	
                    }

                    if(temRegistro  == false) {
                        strHTML = "<option value=\"\">Nenhuma categoria cadastrada</option>";
                    }   

                    $("#cmbDivisao").html(strHTML);
        });
    });
}



function carregaCategoria(codigoParam)
{
    $(document).ready(function() {
        $.getJSON( "http://localhost/sistemaRest/api/categoria", function( json ) {
                    var len               = json.categorias.length;
                    var temRegistro	      = false;
                    var strHTML  	      = '';

                    for (var i=0; i < len; i++){
                      var codigo   = json.categorias[i].codigo;
                      var nome     = json.categorias[i].nome;
                      
                      if(codigoParam != codigo) {
                        strHTML =  strHTML + "<option value=\""+codigo+"\">"+nome+"</option>";
                      } else {
                        strHTML =  strHTML + "<option selected=\"true\" value=\""+codigo+"\">"+nome+"</option>";
                      }
                      
                      temRegistro = true;	
                    }

                    if(temRegistro  == false) {
                        strHTML = "<option value=\"\">Nenhuma categoria cadastrada</option>";
                    }   

                    $("#cmbCategoria").html(strHTML);
        });
    });
}

function carregaTecnico(codigoParam)
{
    $(document).ready(function() {
        $.getJSON( "http://localhost/sistemaRest/api/tecnico", function( json ) {
                    var len               = json.tecnicos.length;
                    var temRegistro	      = false;
                    var strHTML  	      = '';

                    for (var i=0; i < len; i++){
                      var codigo   = json.tecnicos[i].codigo;
                      var nome     = json.tecnicos[i].nome;
                      
                      if(codigoParam != codigo) {
                        strHTML =  strHTML + "<option value=\""+codigo+"\">"+nome+"</option>";
                      } else {
                        strHTML =  strHTML + "<option selected=\"true\" value=\""+codigo+"\">"+nome+"</option>";
                      }
                      
                      temRegistro = true;	
                    }

                    if(temRegistro  == false) {
                        strHTML = "<option value=\"\">Nenhuma tecnico cadastrado</option>";
                    }   

                    $("#cmbTecnico").html(strHTML);
        });
    });
}

function tudoParaDestino()
{
	var select = document.getElementById("origem");
	var tamanho = select.options.length;
	var dhtml = "";
	var valor = "";
	var texto = "";

	for (i=0; i< tamanho; i++) {
		valor = select.options[i].value;
		texto = select.options[i].text;	
		dhtml = dhtml + "\n<option value=\""+valor+"\">"+texto+"</option>";
	}

	document.getElementById("destino").innerHTML = dhtml;
}

function selecionadoParaDestino()
{
	var select = document.getElementById("origem");
	var tamanho = select.options.length;
	var dhtml = "";
	var valor = "";
	var texto = "";

	for (i=0; i < tamanho; i++) {
		if (select.options[i].selected == true) { 
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
	var select = document.getElementById("destino");
	var tamanho = select.options.length;
	var dhtml = "";
	var valor = "";
	var texto = "";

	for (i=0; i < tamanho; i++) {
		if ( select.options[i].selected != true) {
			valor = select.options[i].value;
			texto = select.options[i].text;
			dhtml = dhtml + "\n<option value=\""+valor+"\">"+texto+"</option>";	
		}
	}

	document.getElementById("destino").innerHTML = dhtml;

}
