<?php 

	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/

	include '../conn_DB.php';

	$emailreset = $_POST[email];
	
	if(empty($emailreset))//Email vacio
	{
		$emailMessage = "Inserte una dirección de correo";
	}
	else //Email insertado
	{ 	
		$pattern_email = "/^([a-z][a-z]*)[0-9]{3}@ikasle.ehu.(es|eus)$/";
		$email_ok = filter_var($emailreset, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$pattern_email)));
		
		if($email_ok === false)
		{
			//Email formato no valido
			$emailMessage = "Email con formato no valido";
		}
		else //Email formato valido
		{
			$result;
			$query_user = "SELECT * FROM Usuario WHERE EMAIL='$emailreset'";
			$result = $mysqli->query($query_user);
			$cont = mysqli_num_rows($result);
			
			
			if($cont == 1)//Existe email en la BD
			{
				//Creamos un token hasta que se cree un token que no exista en la bd
				do{
					$token = sha1(uniqid($emailreset, true));
					
					$query_user = "SELECT * FROM ResetPassword WHERE TOKEN='$token'";
					$result = $mysqli->query($query_user);
					$cont = mysqli_num_rows($result);
					
				}while($cont == 1);

				$to = $emailreset;
				$subject = "Restablezca su password";
				$from = 'no-reply@sw.com';
				$body='Hola, <br/>Su email es '.$emailreset.' <br>Haz click aqui para restablecer su contrase&ntilde;a&nbsp;<a href="http://localhost/SistemasWeblocal/Lab7/php/resetpassword/cambiarpassword.php?token='.$token.'&action=reset">Restablecer contrase&ntilde;a</a>
				           <br/><br/>Este link estara activo durante 24 horas<br/>Victor</br>';
				$headers = "From: " . strip_tags($from) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
				//Guardar en la BD
				$query_reset = "INSERT INTO ResetPassword(EMAIL, TOKEN, CREATION_DATE, USED) VALUES ('$emailreset', '$token', now(), '0')";
				$result1 = $mysqli->query($query_reset);		
				
				if ($result1)//Inserccion incorrecta
				{ 
					//Enviar email
					if (mail($to,$subject,$body,$headers) === true); 
					{
						$emailMessage = "Se ha enviado un email a " . $emailreset;
						$tipo = "g";
					}
				}
				
			}else //El correo no esta en la BD
			{			
				$emailMessage = "El email " . $emailreset . " no figura en nuestros registros";
			}
		}
	}
	
	$mysqli->close();
	header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/resetemailform.php?message=$emailMessage&tipo=$tipo");
?>