<?php
   session_start();
   $_SESSION = array();
	session_destroy();
	if (!isset($_SESSION['NOMBRE_USUARIO'])) {
   		header("Location: ../../../../index.php");
 	}else{
 		echo "Error cerrando sesion";
 	}
?>
