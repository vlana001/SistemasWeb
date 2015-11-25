<!DOCTYPE html>
<html lang="es">
<head>
	<title>Gestion preguntas</title>
	<link rel="stylesheet" type="text/css" href="../estilos/stylesLogin.css">
	<!-- Incluir libreria jquery, tarea opcional 2-->
	<script src="../js/jquery-1.11.3.min.js"></script>
	<meta name="author" content="Victor Lana">
	<meta name="description" content="Gestion de Preguntas">
	<meta name="keywords" content="Insertar, pregunta, respuesta">
	<meta charset="UTF-8">
</head>

<body>
	<!-- Utilizando Ajax: -->
	<!-- Insertar una nueva pregunta -->
	<!-- Al insertar una nueva pregunta informar sobre el error o la insercion correcta -->
	<!-- Visualizar las preguntas -->
	<!-- Visualizar el numero de preguntas insertadas por el usuario actual sobre el total -->
		<script type="text/javascript">

			function enviarPregunta()
			{
				var req = new XMLHttpRequest();

				req.onreadystatechange = function()
				{
					if(req.readyState == 4 && req.status == 200)
					{
						document.getElementById("mensaje").innerHTML = req.responseText;
					}else if(req.readyState == 4 && req.status != 200)
					{
						alert("Error en la solicitud XMLHttpRequest");
					}
				}

				var pregunta = document.getElementById("textarea1").value;
				var repuesta = document.getElementById("textarea2").value;
				var tematica = document.getElementById("textarea3").value;
				var complejidad = document.getElementById("select1").value;
				
				var parametrosFormulario =  "pregunta=" + pregunta + "&respuesta=" + repuesta + "&tematica=" + tematica + "&complejidad=" + complejidad;		
				req.open("POST","http://vlana001sw.esy.es/SistemasWeb/Lab5/php/InsertarPregunta.php",true);
				req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				req.setRequestHeader("Content-length", parametrosFormulario.length);
				req.setRequestHeader("Connection", "close");					
				req.send(parametrosFormulario);
			}

			function recibirPreguntas()
			{
				var req = new XMLHttpRequest();

				req.onreadystatechange = function()
				{
					if(req.readyState == 4 && req.status == 200)
					{
						document.getElementById("preguntasUsuario").innerHTML = req.responseText;

					}else if(req.readyState == 4 && req.status != 200)
					{
						alert("Error en la solicitud XMLHttpRequest");
					}
				}
				
				req.open("GET","http://vlana001sw.esy.es/SistemasWeb/Lab5/php/verPreguntasAJAX.php",true);
				req.send();
			}


			//Tarea opcional 1 
			function totalPreguntasJS()
			{
				var req = new XMLHttpRequest();

				req.onreadystatechange = function()
				{
					if(req.readyState == 4 && req.status == 200)
					{
						document.getElementById("totalPreguntas").innerHTML = req.responseText;
					}else if(req.readyState == 4 && req.status != 200)
					{
						alert("Error en la solicitud XMLHttpRequest");
					}
				}

				req.open("GET","http://vlana001sw.esy.es/SistemasWeb/Lab5/php/TotalPreguntas.php", true);
				req.send(null);
			}

			totalPreguntasJS();//Llamada a la funcion al cargar la pagina
			setInterval(function(){totalPreguntasJS();},5000);//Llamada a la funcion cada 5 segundos

			//Tarea opcional 2
			function totalPreguntasJQuery()
			{
				$.get("http://vlana001sw.esy.es/SistemasWeb/Lab5/php/TotalPreguntas.php", function(data){
					$("#totalPreguntasJQuery").text(data);
				});
			}

			$(document).ready(function()
			{			    	
				totalPreguntasJQuery(); //Llamada a la funcion al cargar la pagina 			
				setInterval(function(){ totalPreguntasJQuery();},5000);//Llamada a la funcion cada 5 segundos
			});
			
		</script>

	<?php 
		session_start();
	
		/*Si el usuario no esta logeado se le redirige a la pagina login.php
		 en caso contrario se le permite introducir una pregunta*/
		if(isset($_SESSION['user']))//cambiar
		{		
	?>
		<div style="text-align:right">
			<!-- Logout -->
			<a href=./logout.php id="linkLogout">Cerrar sesi&oacute;n</a>		
		</div>
		
		<!-- Total Preguntas -->
		<div id="preguntas">
			<label>Preguntas suyas sobre el total (JS):</label><label id="totalPreguntas" class="totalPreguntas"></label>
			<p><label>Preguntas suyas sobre el total (JQuery):</label><label id="totalPreguntasJQuery" class="totalPreguntas"></label></p>
		</div>
		
		<h1 id="encabezado1">Gestion Preguntas AJAX</h1>
		<form action="" method="POST" id="insertar">
			<table id="tabla1">
				<tr>
					<td colspan="2" id="thead"></td> 
				</tr>
				<tr>
					<td colspan="2" id="tme">
						<div id="mensaje"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" id="tme">
						<button type="button" id="button1" onclick="recibirPreguntas();">Ver Mis Preguntas</button>
					</td>
				</tr>
				<tr>
					<td id="fila1">Pregunta:</td> 
					<td><textarea id="textarea1" name="pregunta" rows="4" cols="50"id="texta1" maxlength="200"></textarea>
				</tr>
				<tr>
					<td id="fila1">Respuesta:</td>
					<td><textarea id="textarea2" name="respuesta" rows="4" cols="50" id="texta1" maxlength="150"></textarea>
				</tr>
				<tr>
					<td id="fila1">Tem&aacute;tica:</td>
					<td><textarea id="textarea3" name="tematica" rows="1" cols="50" id="texta1" maxlength="50"></textarea>
				</tr>
				<tr>
					<td id="fila1">Complejidad:</td>
					<td>
						<select name="complejidad" id="select1">
							<option value="0">Sin calificar</option>
						  	<option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						    <option value="5">5</option>
						</select> 
					</td>
				</tr>
				<tr>
					<!-- <td></td>-->
					<td colspan="2" id="loginsubmit">
						<button type="button" id="preguntasubmitbtn1" onclick="enviarPregunta();recibirPreguntas();">Guardar</button>
						<!--<input type="submit" value="Guardar y Preguntar" id="preguntasubmitbtn2">-->
					</td>
				</tr>
			</table>
		</form>
		<p id="preguntasUsuario"></p>
	<?php			
		}else
		{
			header("location: http://vlana001sw.esy.es/SistemasWeb/Lab5/php/login.php");
		}
	?>
</body>