$(document).ready(function(){
	
	/*Si la especialidad del alumno es diferente a las tres que se imparten en
	la FISS (Ingeniería del Software, Ingeniería de Computadores y
	Computación), dinámicamente se crea una caja de texto para que
	intruduzca la denominación de la especialidad*/

	var selected = false;
	$("#especialidad").on("change",function() {
		if((this.value == 4) && (selected == false))
		{
			$("<tr id='otraEsp'><td></td><td><input type='text' value='' name='otra'/></td></tr>").insertAfter("#trEsp");
			selected = true;
		}
		if(this.value != 4)
		{
			$("#otraEsp").remove();
			selected = false;
		}
	});
	
	
});