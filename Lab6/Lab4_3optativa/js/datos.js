
function loadXMLfile(file) 
{
	var xml;
	var aux;
	
	if (window.XMLHttpRequest)
	{
		xml = new window.XMLHttpRequest();
		
		xml.open("GET", file, false);
		xml.send(null);
		aux =  xml.responseXML;
	}else
	{
		alert("Error al cargar el documento XML");
		document.getElementById("mensaje").innerHTML="Error al cargar el documento XML";
		aux = null;
	}
	
	return aux;
	
}


function data()
{
	
	var xml = loadXMLfile('./xml/usuarios.xml');

	if (xml != null)
	{
		var usuarios = xml.getElementsByTagName("usuarios")[0].getElementsByTagName("usuario");
		
		var encontrado = false;
		var correo = document.getElementById("correo").value;
		
		
		if(correo == "")
		{
			document.getElementById("mensaje").innerHTML="Inserte el email";
			
		}else
		{
			document.getElementById("mensaje").innerHTML="";
			
			for (var cont = 0; cont < usuarios.length; cont++)
			{
				var aux = usuarios[cont].getElementsByTagName("email")[0].childNodes[0].nodeValue;
				
				if(aux.valueOf() == correo.valueOf())
				{
					encontrado = true;
					
					document.getElementById("nombre").innerHTML = usuarios[cont].getElementsByTagName("nombre")[0].childNodes[0].nodeValue;
					document.getElementById("apellido1").innerHTML = usuarios[cont].getElementsByTagName("apellido1")[0].childNodes[0].nodeValue;
					document.getElementById("apellido2").innerHTML = usuarios[cont].getElementsByTagName("apellido2")[0].childNodes[0].nodeValue;
					document.getElementById("telefono").innerHTML = usuarios[cont].getElementsByTagName("telefono")[0].childNodes[0].nodeValue;
				}
	
			}
			if(encontrado == false)
			{
				document.getElementById("nombre").innerHTML = "";
				document.getElementById("apellido1").innerHTML = "";	
				document.getElementById("apellido2").innerHTML = "";
				document.getElementById("telefono").innerHTML = "";
				document.getElementById("correo").innerHTML = "";
				document.getElementById("mensaje").innerHTML="El usuario no existe";
			}

		}
	}
	
}