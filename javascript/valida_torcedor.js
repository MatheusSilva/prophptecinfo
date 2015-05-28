function valida(form)
{
	var strErro = "";

	if (form.txtNome.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu o Nome";
	}
	
	if (form.txtLogin.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu o Login";
	}
	
	if (form.txtSenha.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu a Senha";
	}

	if (form.txtSenha.value.length < 6) {
		strErro = strErro + "\na senha deve ter no minimo 6 caracteres";
	}
	
	if (form.txtConfSenha.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu a confirmacao da Senha";
	}

	if (form.txtConfSenha.value.length < 6) {
		strErro = strErro + "\na confirmacao da senha deve ter no minimo 6 caracteres";
	}
	
	if (form.txtConfSenha.value != form.txtSenha.value) {
		strErro = strErro + "\nAs senhas nao sao iguais";
	}

	if(strErro != "") {
		alert(strErro);
		return false;
	}
}
