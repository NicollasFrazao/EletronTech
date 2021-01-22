<script>
document.onkeydown = KeyCheck;
	function KeyCheck()
	{
	   var KeyID = event.keyCode;
	   switch(KeyID)
	   {
		  case 38:
			parent.perfilOPT.click();
			parent.perfil.focus();
		  break; 
		  case 40:
			parent.eventosOPT.click();
			parent.eventos.focus();
		  break;
		  default:
		  break;
	   }
	}
</script>