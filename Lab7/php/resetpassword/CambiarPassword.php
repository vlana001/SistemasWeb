<?php 

	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/

	include '../conn_DB.php';
	
	$token = $_POST['token'];
	$password = $_POST['password'];
	$password2 = $_POST['passwordr'];
	
	$boolval = false;
	
	if(strlen($password) < 6)
	{
		$message1 = 5;
		$boolval = 1;
	}
	
	if(strlen($password2) < 6)
	{
		$message1 = 6;
		$boolval = 1;
	}
	
	if((strlen($password) < 6) && (strlen($password2) < 6))
	{
		$message1 = 7;
	}
	
	if($boolval == 1)
	{
		header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/cambiarpassword.php?token=$token&action=reset&message1=$message1");
	}else
	{

		//Si la contraseña y su repeticion son iguales actualizamos la contraseña de la BD	
		if(strcmp($password, $password2) == 0)
		{
			//Obtener el email correspondiente al token
			$query_email = "SELECT EMAIL FROM ResetPassword WHERE TOKEN='$token'";
			$result_email = $mysqli->query($query_email);
			$email = $result_email->fetch_row();
			
			//Actualizar contraseña
			$pass = sha1($password);
			$query_update = "UPDATE Usuario SET PASSWORD = '$pass' WHERE EMAIL='$email[0]'";
			$result1 = $mysqli->query($query_update);
	
			
			if (!$result1)//Update incorrecta
			{
				echo "Error al modificar la contraseña";
			}else
			{
				//Actualizar estado token
				$query_update = "UPDATE ResetPassword SET USED = '1' WHERE TOKEN='$token'";
				$result2 = $mysqli->query($query_update);
				if ($result2)
				{
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/login.php?message=Contraseña cambiada correctamente&tipo=g");
				}
			}
		}else
			header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/cambiarpassword.php?token=$token&action=reset&message1=3");
		
	}
?>