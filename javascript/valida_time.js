function valida(form)
{
	var strErro = "";

	if (form.txtNome.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu o Nome";
	}

	if (form.txtFoto.value == "") {
		strErro = strErro + "\nVoce Nao selecionou uma foto";
	}

	if(strErro != "") {
		alert(strErro);
		return false;
	}
}
