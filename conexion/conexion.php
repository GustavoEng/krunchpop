<?php 

	$servidor="localhost";
	$usuario="root";
	$pass="root";
	$bd="bd_pop";

	$conexion = mysqli_connect($servidor,$usuario,$pass,$bd) or die(mysqli_error());
	if($conexion){
		//echo "exito";
	}
	else{
		echo "fallo";
	}
 ?>