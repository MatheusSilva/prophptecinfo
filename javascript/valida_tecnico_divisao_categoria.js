function valida(form)
{
	if (form.txtNome.value == "") {
		strErro = strErro + "\nVoce Nao Preencheu o Nome";
	}
	
	if (form.cmbDia.value == "Dia") {
		strErro = strErro + "\nVoce Nao Preencheu o Dia";
	}
	
	if (form.cmbMes.value == "Mes") {
		strErro = strErro + "\nVoce Nao Preencheu o Mes";
	}
	
	if (form.cmbAno.value == "Ano") {
		strErro = strErro + "\nVoce Nao Preencheu o Ano";
	}
	
	if (form.cmbDia.value == "31") {
		if (form.cmbMes.value == "04" 
		|| form.cmbMes.value  == "06" 
		|| form.cmbMes.value  == "09" 
		|| form.cmbMes.value  == "11") {
			strErro = strErro + "\no Mes que voce escolheu nao possui mais de 30 dias";
		}
	}
	 
	if ((form.cmbDia.value == "29") && (form.cmbMes.value == "02")) {
 		if ((form.cmbAno.value%4 != "0") || (form.cmbAno.value%100 != "0") || (form.cmbAno.value%400 != "0")) {
			strErro = strErro + "\nEste ano nao e bissexto";
		}
	}
	
	if ((form.cmbDia.value == "30") || (form.cmbDia.value == "31") && (form.cmbMes.value == "02")) {
		strErro = strErro + "\nfevereiro nao tem mais que 29 dias";
	}

	if(strErro != "") {
		alert(strErro);
		return false;
	}
}
