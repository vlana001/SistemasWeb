//Limpiar todos los campos del formulario al cargar la pagina
/*function clearForm(){
	var frm = document.getElementById("registro");
    for(i=0;i<frm.elements.length-1;i++)
	{	
		var elem =frm.elements[i].value="";
	}
}*/

//Ver valores
function vervalores(){
	var sAux="";
	var frm = document.getElementById("registro");
	for (i=0;i<frm.elements.length-1;i++)
	{
		sAux += frm.elements[i].name + "   :   ";
		sAux += frm.elements[i].value + "\n" ;
	}
	alert(sAux);
}

function verificar(){
	verNombre();
	//limpiar();
}

//Limpia mensajes anteriores
function limpiar(){
	var frm = document.getElementById("registro");
	frm.elements[0].style.border="";
	frm.elements[1].style.border="";
	frm.elements[2].style.border="";
	frm.elements[3].style.border="";
	//frm.elements[4].style.border="";
	
	document.getElementById('textCampos').innerHTML="";
	document.getElementById('textNombre').innerHTML="";
	document.getElementById('textCorreo').innerHTML="";
	document.getElementById('textPassword').innerHTML="";
	document.getElementById('textTelefono').innerHTML="";
	document.getElementById('textTamImagen').innerHTML="";
	document.getElementById('mensajeComprobar').innerHTML="";

	//document.getElementById('select_image').value="";
}

//Ningún campo obligatorio estará vacío
function verCamposObigatorios(){
	var ok = true;
	var frm = document.getElementById("registro");

	for(i=0;i<5;i++)
	{
		var elem =frm.elements[i].value;
		if(elem.length == 0)
		{
			frm.elements[i].style.border="0.2em solid red";
			var  texto = "No todos los campos obligatorios estan rellenos";
			document.getElementById('textCampos').innerHTML=texto;
			ok = false;
		}else
			comprobarMatriculado();
	}
}

//El nombre del alumno/a incluye nombre de pila y dos apellidos
function verNombre(){
var ok = true;
var frm = document.getElementById("registro");
var nombre = frm.elements[0].value;
var splNombre = nombre.split(" ");
var tam = splNombre.length;
	if(splNombre.length!=3)
	{
		var texto="Se deben introducir el nombre de pila y dos apellidos";
		document.getElementById('textNombre').innerHTML=texto;
		document.getElementById('textNombre').style.color="red";
		ok = false;
	}else
		verCorreo();
}

//El correo debe tener el formato de la UPV/EHU
function verCorreo(){
var ok = true;
var frm = document.getElementById("registro");
var str = frm.elements[1].value;
var patt = new RegExp(/^([a-z][a-z]*)[0-9]{3}@ikasle.ehu.(es|eus)$/g);
var res;
	if(!patt.test(str))
	{
		var texto="El correo debe tener el siguiente fomato: Inicial nombre + Primer apellido + 3 digitos + @ikasle.ehu. + es/eus";
		document.getElementById('textCorreo').innerHTML=texto;
		document.getElementById('textCorreo').style.color="red";
		ok = false;
	}else
	{ 	//Practica 6
		//res = comprobarMatriculado();
		//alert(res);
		verPassword();	
	}
}

//El Password tendrá al menos 6 caracteres
function verPassword(){
	var ok = true;
	var frm = document.getElementById("registro");
	var pass = frm.elements[2].value;
	if(pass.length<6)
	{
		var texto="El password tiene que tener al menos 6 caracteres";
		
		ok = false;
	}else //Si la contraseña tiene mas de 5 caracteres
	{
		var texto="";
		verTelefono();
	}
	
	document.getElementById('textPassword').innerHTML=texto;
	document.getElementById('textPassword').style.color="red";
}

//Comprueba el nivel de seguridad del password
function chkPasswordStrength(pass)
{
    var desc = new Array();
    desc[1] = "Password Muy Debil";//Very Weak
    desc[2] = "Password Debil";//Weak
    desc[3] = "Password Seguridad Media";//Medium
    desc[4] = "Password Segura";//Strong
    desc[5] = "Password Muy segura";//Very strong

    var score = 1;

    //if pass has both lower and uppercase characters give 1 point
    if ( ( pass.match(/[a-z]/) ) && ( pass.match(/[A-Z]/) ) ) score++;

    //if pass has at least one number give 1 point
    if (pass.match(/\d+/)) score++;

    //if pass has at least one special caracther give 1 point
    if ( pass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

    //if pass bigger than 12 characters give another 1 point
    if (pass.length > 12) score++;

    document.getElementById('textPassword').innerHTML = desc[score];
    document.getElementById('textPassword').style.color="green";
}

//El teléfono debe tener 9 dígitos
function verTelefono(){
	var ok = true;
	var frm = document.getElementById("registro");
	var tel = frm.elements[4].value;
	//var tel = document.getElementById('numTelefono').value;
	var pattern = new RegExp(/^[0-9]{9}/g);
	if(pattern.test(tel) == false)
	{
		var texto="Se debe introducir un numero de telefono correcto";
		document.getElementById('textTelefono').innerHTML=texto;
		document.getElementById('textTelefono').style.color="red";
		ok = false;
	}else
		verCamposObigatorios();
}

/*si el usuario selecciona una imagen cuando está realizando el registro,
se cree un elemento imagen en el formulario y se muestre en él la
imagen seleccionada en un tamaño razonable.
*/
function showImage(src, target) 
{
    var fr = new FileReader();
    fr.onload = function()
    {
  		target.src = fr.result;
    }
    
    file = src.files[0];

    //Comprobar tamaño de la imagen seleccionada
    if(file.size <= 1048576)//1 Mb
    {
    	fr.readAsDataURL(file);
    }else
    {
    	var texto="La imagen " + file.name + "es demasiado pesada: (" + file.size +" bytes)";
		document.getElementById('textTamImagen').innerHTML=texto;
		document.getElementById('textTamImagen').style.color="red";
    } 	
}

function putImage() 
{
    var src = document.getElementById("select_image");
    var target = document.getElementById("target");
    showImage(src, target);
}


//Practica Servicios Web
//Enviamos el email mediante ajax a usuarioSW.php
//Recibimos la respuesta mediante ajax de usuarioSW.php que la recibe del servicio web
function comprobarMatriculado()
{	
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function()
	{
		if(req.readyState == 4 && req.status == 200)
		{
			var res = req.responseText;
			var msg;
			//alert(req.responseText);
			if(res == "SI")
			{	//alert(req.responseText);
				
				msg = "Genial. Matriculado en Sistemas Web";
				verTicket();
			}	
			else
			{
				if (res == "NO")
					msg = "Error. No matriculado en Sistemas Web";
				else
					msg = "Algo no salio bien";	
			}		
			
				
			document.getElementById("mensajeComprobar").innerHTML = msg;
			
		}else if(req.readyState == 4 && req.status != 200)
		{
			alert("Error en la solicitud XMLHttpRequest");
		}
	}

	var email = document.getElementById("correoElectronico").value;
	
	var parametrosFormulario =  "correo=" + email;
	req.open("POST","http://vlana001sw.esy.es/SistemasWeb/Lab6/php/usuarioSW.php",true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-length", parametrosFormulario.length);
	req.setRequestHeader("Connection", "close");					
	req.send(parametrosFormulario);
	/*req.open("GET", "http://localhost/SistemasWeblocal/Lab6/php/usuarioSW.php?"+parametrosFormulario, true);
	req.send();
	*/
}

function comprobarPasswordList()
{
	var req = new XMLHttpRequest();


	req.onreadystatechange = function()
	{
		if(req.readyState == 4 && req.status == 200)
		{
			var res = req.responseText;
			var msg;

			if(res == "VALIDA")
			{
				msg = "Genial. Contraseña valida";
				vervalores(); //Si todos los datos se introducen correctamente se mostraran en un alert
				document.getElementById("registro").submit();//Se envia el formulario
			}
			else if (res == "INVALIDA")
				msg = "Error. Contraseña invalida";
			else
				msg = "Algo no salio bien";
				
			document.getElementById("textPassword").innerHTML = msg;
			
		}else if(req.readyState == 4 && req.status != 200)
		{
			alert("Error en la solicitud XMLHttpRequest");
		}
	}

	var pass = document.getElementById("password").value;
	
	var parametrosFormulario =  "password=" + pass;
	req.open("POST","http://vlana001sw.esy.es/SistemasWeb/Lab6/php/ComprobarContrasenaCliente.php",true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//req.setRequestHeader("Content-length", parametrosFormulario.length);
	//req.setRequestHeader("Connection", "close");					
	req.send(parametrosFormulario);
}



function verTicket()
{	
	var frm = document.getElementById("registro");
	var ticket = frm.elements[3].value;
	var pattern = new RegExp(/^[0-9]{4}/g);
	if(pattern.test(ticket) == false)
	{
		var texto="Se debe introducir un numero de ticket correcto";
		document.getElementById('textTicket').innerHTML=texto;
		document.getElementById('textTicket').style.color="red";
		ok = false;
	}else
		comprobarTicketList();

}

function comprobarTicketList()
{
	var req = new XMLHttpRequest();

	req.onreadystatechange = function()
	{
		if(req.readyState == 4 && req.status == 200)
		{
			var res = req.responseText;
			var msg;

			if(res == "AUTORIZADO")
			{
				msg="AUTORIZADO";
				comprobarPasswordList();
			}
			else if (res == "NOAUTORIZADO")
				msg = "USUARIO NO AUTORIZADO";
			else
				msg = "Algo no salio bien";
				
			document.getElementById("textTicket").innerHTML = msg;
			
		}else if(req.readyState == 4 && req.status != 200)
		{
			alert("Error en la solicitud XMLHttpRequest");
		}
	}

	var ticket = document.getElementById("ticket").value;
	
	var parametrosFormulario =  "ticket=" + ticket;
	/*req.open("POST","http://vlana001sw.esy.es/SistemasWeb/Lab6/php/ComprobarTicketCliente.php",true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-length", parametrosFormulario.length);
	req.setRequestHeader("Connection", "close");					
	req.send(parametrosFormulario);*/
	req.open("GET", "http://vlana001sw.esy.es/SistemasWeb/Lab6/php/ComprobarTicketCliente.php?"+parametrosFormulario, true);
	req.send();
}