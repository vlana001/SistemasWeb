<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Restablecer contraseña</title>
		<link rel="stylesheet" type="text/css" href="../../estilos/stylesLogin.css">
		<meta name="author" content="Victor Lana">
		<meta name="description" content="Cambiar password">
		<meta name="keywords" content="Login, email, password">
		<meta charset="UTF-8">
	</head>

<?php
	session_start();
	
	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/
	
	/*Si el usuario esta logeado se le redirige a la pagina InsertarPregunta.php
	en caso contrario se le permite introducir la nueva contraseña*/
	if(!isset($_SESSION['user']))
	{
		if(isset($_GET['message1']))
		{
			$message = $_GET['message1'];	
		}
					
		//Obtenemos el token	
		$token = $_GET["token"];
		
		if(isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"]) && (strcmp($_GET["action"],"reset") == 0))
		{
			//Comprobamos si el token es valido: existe en la BD y no ha sido usado ni ha expirado
			include '../conn_DB.php';
			
			$query_user = "SELECT * FROM ResetPassword WHERE TOKEN='$token'";
			$result = $mysqli->query($query_user);
			$cont = mysqli_num_rows($result);
			
			if($cont == 1)//Existe token en la BD
			{
				//Token expirado
				//El token esta activo 24 horas
				$query_date = "SELECT CREATION_DATE FROM ResetPassword WHERE TOKEN='$token'";
				$result_date = $mysqli->query($query_date);
				$row = $result_date->fetch_row();
				
				$time_creation_token = strtotime($row[0]);
				$time_now = strtotime(date('Y-m-d H:i:s'));	
				
				$dif_hours = ($time_now - $time_creation_token)/(60*60);
				
				/*echo $time_creation_token . " ";
				echo $time_now . " ";
				echo $dif_hours ." ";
				echo intval($dif_hours);
				*/
				if($dif_hours >= 24)
					$expired = 1;
				else
					$expired = 0;
				
				//Token usado
				$query_used = "SELECT USED FROM ResetPassword WHERE TOKEN='$token'";
				$result_used = $mysqli->query($query_used);
				$row1 = $result_used->fetch_row();
				
				if($row1[0] == 0)
					$result_used = 0;
				else
					$result_used = 1;
				
				//Token no expirado ni usado
				if($result_used == 0 && $expired == 0)
				{ ?>
					<body>
						<h1 id="encabezado1">Restablezca la contraseña</h1>
						<form action="CambiarPassword.php" method="POST" id="login">
							<input type="hidden" name="token" value="<?php echo $token; ?>"></input>
							<table id="tabla1">
								<tr>
									<td colspan="2" id="thead"></td>
								</tr>
								<tr id="tm">
									<td colspan="2" id="tme"></tr>
								</td>
								<tr>
									<td colspan="2" style="padding-bottom: 1em; text-align: center">
										<?php 
												if($message == 3)
													$messagetoken ="Las contraseñas introducidas no coinciden";
												
												
												if($message == 5)
													$messagetoken ="La contraseña debe tener 6 caracteres o mas";

													
												if($message == 6)
													$messagetoken ="La repetición de la contraseña debe tener 6 caracteres o mas";
												
													
												if($message == 7)
													$messagetoken ="La contraseña y su repetición deben tener 6 caracteres o mas";
												
												echo "<span id='tmessageError'>" . $messagetoken . "</span>";
										?>
									</td>
								</tr>
								</tr>
									<td id="tdnombre">Contrase&ntilde;a:</td>
									<td><input type="password" id="input1" name="password" placeholder="contraseña"  maxlength="50"></td>
								</tr>
								<tr>
									<td>Repita la contrase&ntilde;a:</td>
									<td><input type="password"  id="input2" name="passwordr" placeholder="Repita la contraseña"  maxlength="50"></td>
								</tr>
								<tr>
									<td colspan="2" id="loginsubmit">
										<input type="submit" value="Cambiar" id="loginsubmitbtn">
									</td>
								</tr>
							</table>
						</form>
						</body>
						</html>
					<?php
				}else
				{
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/resetemailform.php?message1=1");
				}
			}else
			{
				header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/resetemailform.php?message1=2");
			}
		}else 
		{		if(isset($_GET["token"]))
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/resetemailform.php?message1=2");
				else
					header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/resetpassword/resetemailform.php");
		}
	}else 
	{
		header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/insertarPregunta.php");
	}	
?>