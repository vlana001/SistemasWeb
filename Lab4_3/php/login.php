<?php
	session_start();
	
	/*Si el usuario esta logeado se le redirige a la pagina InsertarPregunta.php
	en caso contrario se le permite introducir sus credenciales*/
	if(!isset($_SESSION['user']))
	{
	?>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<html lang="es">
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="../estilos/stylesLogin.css">
		<meta name="author" content="Victor Lana">
		<meta name="description" content="Login">
		<meta name="keywords" content="Login, email">
		<meta charset="UTF-8">
	</head>
		
		<body>	
			<h1 id="encabezado1">Quiz</h1>
			<form action="./Login.php" method="POST" id="login">
			<table id="tabla1">
				<tr>
					<td colspan="2" id="thead"></td>
				</tr>
				<tr id="tm">
					<td colspan="2" id="tme">
						<?php $message=$_GET['message']; echo "<span id='tmessage'>" . $message . "</span>"; ?>
					</td>
				</tr>					
				<tr>
					<td id="tdnombre">Email:</td> 
					<td><input type="text" id="input1" name="email" autocomplete="on"  maxlength="50"></td>
				</tr>
				<tr>
					<td>Contrase&ntilde;a:</td>
					<td><input type="password"  id="input1" name="upassword"  maxlength="50"></td>
				</tr>
				<tr>
					<td colspan="2" id="loginsubmit">
					<input type="submit" value="Login" id="loginsubmitbtn">
					</td>
					
				<tr>
					<td colspan="2" id="linkregister">
					<?php 	
						//Si el usuario realiza un login incorrecto se le permite volver al Layout
						$message2 = $_GET['varLogin'];
						if($message2 == 1)
							echo "<a href=\"../layout.html\" id=\"link1\" >Volver a la p&aacute;gina de inicio</a>";
					?>
					</td>
				</tr>
				<tr>
					<td colspan="2" id ="linkregister">
					<a href="../registro.html" id="link1">Nuevo Usuario?<a>
					</td>
				</tr>	
			</table>				
			</form> 	
		</body>
	<?php
	}else 
	{
		header("location: http://vlana001sw.esy.es/SistemasWeb/Lab4_3/php/insertarPregunta.php?");//local
	}	
?>