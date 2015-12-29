<?php
	session_start();
	
	/*Si el usuario esta logeado se le redirige a la pagina InsertarPregunta.php
	en caso contrario se le permite resetear la contraseña*/
	if(!isset($_SESSION['user']))
	{
	?>
	<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Reset password</title>
		<link rel="stylesheet" type="text/css" href="../../estilos/stylesLogin.css">
		<meta name="author" content="Victor Lana">
		<meta name="description" content="Reset password">
		<meta name="keywords" content="Reset, email, password">
		<meta charset="UTF-8">
	</head>
		
		<body>	
			<h1 id="encabezado1">Restablecimiento de contraseña</h1>
			<form action="./Resetpassword.php" method="POST" id="login">
				<table id="tabla1">
					<tr>
						<td colspan="2" id="thead"></td>
					</tr>
					<tr id="tm">
						<td colspan="2" id="tme">
							<?php 
							
								//ResetPassword.php
								$message=$_GET['message']; 
								$tipo=$_GET['tipo']; 
								
								if($tipo == "g")
									echo "<span id='tmessageCorrecto'>" . $message . "</span>"; 
								else
									echo "<span id='tmessageError'>" . $message . "</span>";
								
								//cambiarPassword.php
								$message1=$_GET['message1'];
	
								if($message1 == 1)
									echo "El token ha sido usado o ha expirado";
								
								if($message1 == 2)
									echo "El token no es válido";
								
							?>
						</td>
					</tr>					
					<tr>
						<td id="tdnombre">Email:</td> 
						<td><input type="text" id="input1" name="email" maxlength="50"></td>
					</tr>
					<tr>
						<td colspan="2" id="loginsubmit">
						<input type="submit" value="Enviar" id="loginsubmitbtn">
						</td>
					</tr>	
					<tr>
						<td colspan="2" id="linkregister">
							<a href="../../registro.html" id="link1">Volver a la p&aacute;gina de registro<a>
						</td>
					</tr>
				</table>				
			</form> 	
		</body>
	<?php
	}else 
	{
		header("location: http://vlana001sw.esy.es/SistemasWeb/Lab7/php/insertarPregunta.php?");//local
	}	
?>