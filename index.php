<?php
	//header("Location: Login.php");
?>
<script>
	var x = window.screen.width;
	
	if ((x <= 720) || (x >= 900 && x <= 1024) || (x >= 100 && x <= 240))
	{
		window.location.href = "mobile/";
	}
	else
	{
		window.location.href = "Login.php";
	}
</script>