<?php
session_destroy();
error_reporting(0);
?>

<script>
	alert("¡Sesión cerrada!");
	window.location = 'login.php'
</script>