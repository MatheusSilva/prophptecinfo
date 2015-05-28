function confirmar(codigo)
{
  var ok = window.confirm("Voce tem certeza que deseja excluir?");
  
  if (ok) {
  	location.href="../adaptadores/adaptador.time.php?acao=3&codigo=" + codigo;
  }
}