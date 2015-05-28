function valida(form)
{
	if (form.txtTorcedor.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu o Login";
	}
	
	if (form.txtSenha.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu a Senha";
	}

	if(strErro != "") {
		alert(strErro);
		return false;
	}
}