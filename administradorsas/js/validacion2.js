// JavaScript Document

function check(k,name){
		if(k.value.length==0){
			alert("Lo Siento... " + name +" no puede estar en blanco");
			k.focus();
			return false;
		}else{
			return true;
		}
}
function checkCombo(c,name){
		if(c.value==0 || c.value=="NULL" || c.value==""){
			alert("Lo siento... debe indicar "+ name+ " para poder continuar");
			c.focus();
			return false;
		}else{
			return true;
		}
	}
/*function guardar_FichaPatronimica(){
 boolokay=false;
 if (confirm("�Esta seguro que desea continuar con el registro?")){
	 if(check(document.form.cedula, 'Cedula'))
	 if(check(document.form.paciente, 'Nombres'))
	 if(check(document.form.edad, 'Edad'))
	 if(checkCombo(document.form.religion,'Religion'))
	 if(checkCombo(document.form.ocupacion,'Ocupacion'))
	 boolokay=true;
 }
if(boolokay==true){
	 document.form.action='FichaPatronimica.php?guardar=1';
	 document.form.submit();
 }
}*/

function guardar_consultorio(){
 boolokay=false;
 if (confirm("�Esta seguro que desea continuar con el registro?")){
	 if(check(document.form.nombreconsultorio, 'Nombre del Consultorio'))
	 if(check(document.form.telefono1, 'Telefono 1'))
	 if(check(document.form.telefono2, 'Telefono 2'))
	 if(check(document.form.telefono3, 'Telefono 3'))
	 if(check(document.form.fax,'Fax'))
	 if(check(document.form.paginaweb, 'Pagina Web'))
	 if(check(document.form.email, 'Email'))
	 boolokay=true;
 }
 if(boolokay==true){
	 document.form.action='consultorio.php?guardar=1';
	 document.form.submit();
 }
}


function guardar_Evolucion(){
 boolokay=false; 
  if (document.form.evolucion.value){
	 if (confirm("�Esta seguro que desea continuar con el registro?")){
	  document.form.op.value=1;
	  document.form.action='index.php?guardar_evo=1';
	  document.form.submit();
	 }
  }else{
   alert('Debe escribir la evolucion...');
  }
}
function ver_pdf(){
  if (document.form.recipe1.value){
  document.form.op.value=4;
  document.form.action='index.php?sw=1';
  document.form.submit();
  }else{alert('Escriba una indicacion...');}
}
function guardar_Laboratorio(){
 boolokay=false;
 if(document.form.examen1.selectdIndex!=0 && document.form.valor.value){
	 if (confirm("�Esta seguro que desea continuar con el registro?")){
	  document.form.op.value=2;
	  document.form.action='index.php?guardar_lab=1';
	  document.form.submit();
	 }	
 }else{
  alert('Debe indicar el examen y valor...');
 }
}
function salir(){
 boolokay=false;
 
 if (confirm("�Esta seguro que desea salir del sistema?")){
  document.form.action='salir.php';
  document.form.submit();
 }	
}
function modificar_evo(ind,text){
 document.form.evolucion.value=text;
 document.form.codigo_evo.value=ind;
}
function eliminar_evo(ind){
 boolokay=false;
 if (confirm("�Esta seguro que desea eliminar el registro?")){
  document.form.op.value=1;
  document.form.codigo_evo.value=ind;
  document.form.action='index.php?eli_evo=1';
  document.form.submit();
 }
}
function eliminar_Laboratorio(ind){
 boolokay=false;
 if (confirm("�Esta seguro que desea eliminar el registro?")){
  document.form.op.value=2;
  document.form.elimnar_lab.value=ind;
  document.form.action='index.php?eliminar_lab=1';
  document.form.submit();
 }
}
function guardar_Radiologia(){
 boolokay=false;
 
 if (confirm("�Esta seguro que desea continuar con el registro?")){
  if(check(document.form.txtdescripcion, 'Descripcion'))
  if(checkCombo(document.form.examen,'Examen'))
  boolokay=true;
  if (boolokay==true){
   document.form.op.value=3;
   document.form.action='index.php?guardar_Rad=1';
   document.form.submit();
  }
 }	cipaciente
}
function eliminar_Radiologia(ind){
 boolokay=false;
 if (confirm("�Esta seguro que desea eliminar el registro?")){
  document.form.op.value=3;
  document.form.delete_rad.value=ind;
  document.form.action='index.php?eliminar_rad=1';
  document.form.submit();
 }
}
function buscar_usuario(){
 if(check(document.form.txtcedulaadmin, 'Cedula')){
  document.form.op.value=5;
  document.form.action='index.php';
  document.form.submit();
 }
}
function guardar_administrador(){
 boolokay=false;

 if (confirm("�Esta seguro que desea continuar con el registro?")){
  	
	if(check(document.form.txtcedulaadmin, 'Cedula'))
	if(check(document.form.txtloginadmin, 'login'))
	if(check(document.form.txtnombreape, 'nombre y apellido'))
	if(check(document.form.txtcontrasena, 'contrase�a'))
	if(check(document.form.txtvericontrasena, 'verificar contrase�a'))
	boolokay=true
	if(boolokay){
	  document.form.op.value=5;
	  document.form.action='index.php?guardar_admin=1';
	  document.form.submit();
	}
	
 }	
}
function ocultarvaloressi(){
	document.form.op.value=5;
	document.form.ocultarvalores.value=1;
	document.form.submit();
}
function ocultarvaloresno(){
	document.form.op.value=5;
	document.form.ocultarvalores.value=2;
	document.form.submit();
}

function guardar_componentes(){
 boolokay=false;
 if (confirm("�Esta seguro que desea continuar con el registro?")){
  	
	if(checkCombo(document.form.cbotipocomp,'Componente'))
	if(check(document.form.txtdescripcioncomp, 'Descripcion'))
	boolokay=true
	if(boolokay){
	  document.form.op.value=5;
	  document.form.action='index.php?guardar_comp=1';
	  document.form.submit();
	}
	
 }	
}
//***********************************medico***************************************
function guardar_medico(){
 boolokay=false;
 var validarcedula = new RegExp (/^[0-9]{5,9}$/);
 var validartele1 = new RegExp (/^\([0]{1}[1-9]{3}\)[0-9]{3}[-][0-9]{4}$/); 
 var validacorreo = new RegExp (/^[\w\.]+@([\w-]+\.)+[\w]{2,4}$/);
 var validarcampo = new RegExp (/^[a-zA-Z]{2,15}$/);

 if (confirm("�Esta seguro que desea continuar con el registro?")){
	 if(check(document.form.cimedico, 'C�dula de identidad'))
	 if(check(document.form.pnombre, 'Primer nombre'))
	 if(check(document.form.snombre, 'Segundo nombre'))
	 if(check(document.form.papellido, 'Primer apellido'))
	 if(check(document.form.sapellido,'Segundo apellido'))
	 if(check(document.form.tprincipal, 'Telefono principal'))
	 if(check(document.form.tcelular, 'Telefono celular'))
	 if(check(document.form.beeper, 'N�mero de beeper'))
	 if(checkCombo(document.form.especialidad,'Especialidad'))
	 if(check(document.form.nrocolegiado, 'N�mero de colegiado'))
	 if(check(document.form.fnacimiento, 'Fecha de nacimiento'))
	 if(check(document.form.emailm, 'Correo electronico'))
	 
	 if (!document.form.cimedico.value.match(validarcedula)){   
		alert('Error: Debe ingresar un numero de cedula valido... ver el ejemplo');
		document.form.cimedico.focus();
		return false;
	 }else if (!document.form.pnombre.value.match(validarcampo)){   
		alert('Error: Debe ingresar un Nombre valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.pnombre.focus();
		return false;
	 }else if (!document.form.snombre.value.match(validarcampo)) {
	 	alert('Error: Debe ingresar un Nombre valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.snombre.focus();
		return false;
	 }else if (!document.form.papellido.value.match(validarcampo)) {
	 	alert('Error: Debe ingresar un Apellido valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.papellido.focus();
		return false;
	 }else if (!document.form.sapellido.value.match(validarcampo)) {
	 	alert('Error: Debe ingresar un Apellido valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.sapellido.focus();
		return false;
	 }else if (!document.form.tprincipal.value.match(validartele1)) {
	 	alert('Error: Debe ingresar un numero de telefono principal valido...');
		document.form.tprincipal.focus();
		return false;
	 }else if (!document.form.tcelular.value.match(validartele1)){
	 	alert('Error: Debe ingresar un numero de telefono celular valido...');
		document.form.tcelular.focus();
		return false;
	 }else if (!document.form.emailm.value.match(validacorreo)){
	 	alert('Error: Debe ingresar un correo electronico valido...');
		document.form.emailm.focus();
		return false;
	 }else{
		boolokay=true;
	 }

 	 if(boolokay==true){
	 document.form.action='medico.php?guardar=1';
	 document.form.submit();
 	 }
 }
}function modificar_medico(ind){
	document.form.codMedico.value=ind;
	document.form.action='medico.php?mostrar=1';
	document.form.submit();
 
}
function eliminar_medico(ind){
 boolokay=false;
 if (confirm("�Esta seguro que desea eliminar el registro?")){
  document.form.codMedico.value=ind;
  document.form.action='medico.php?eli_medico=1';
  document.form.submit();
 }
}
//********************************************************************************

//*********************************paciente***************************************
function buscar_paciente(){
 if(check(document.form.cipaciente, 'Cedula')){
	document.form.action='paciente.php?buscar_pac=1';
	document.form.submit();
 }
}

function guardar_paciente(){
 boolokay=false;
 var validarcedula = new RegExp (/^[0-9]{5,9}$/);
 var validartele1 = new RegExp (/^\([0]{1}[1-9]{3}\)[0-9]{3}[-][0-9]{4}$/); 
 var validacorreo = new RegExp (/^[\w\.]+@([\w-]+\.)+[\w]{2,4}$/);
 var validarcampo = new RegExp (/^[a-zA-Z]{2,15}$/);
 var validarhijo = new RegExp (/^[0-9]{0,2}$/);

 if (confirm("�Esta seguro que desea continuar con el registro?")){
	 if(check(document.form.cipaciente, 'C�dula de identidad'))
	 if(check(document.form.pnombrepac, 'Primer nombre'))
	 if(check(document.form.papellidopac, 'Primer apellido'))
	 if(checkCombo(document.form.edocivil, 'Estado Civil'))
	 if(check(document.form.direccionpac, 'Direccion'))
	 if(check(document.form.thabitacionpac,'Telefono de habitacion'))
	 if(check(document.form.nmadre, 'Nombre de la Madre'))
	 if(check(document.form.npadre, 'Nombre del Padre'))
	 if(check(document.form.antecedentespac, 'Antecedentes'))
	 if(check(document.form.alergiaspac, 'Alergias'))
	 if(checkCombo(document.form.religion, 'Religion'))
	 if(check(document.form.ocupacion, 'Ocupacion'))
	 if(check(document.form.fnacimientopac, 'Fecha de nacimiento'))
	 if(check(document.form.nrohijopac, 'Numero de hijos'))
	 
	 if (!document.form.cipaciente.value.match(validarcedula)){   
		alert('Error: Debe ingresar un numero de cedula valido... ver el ejemplo');
		document.form.cipaciente.focus();
		return false;
	 }else if (!document.form.pnombrepac.value.match(validarcampo)){   
		alert('Error: Debe ingresar un Nombre valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.pnombrepac.focus();
		return false;
	 }else if (!document.form.papellidopac.value.match(validarcampo)) {
	 	alert('Error: Debe ingresar un Apellido valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.papellidopac.focus();
		return false;
	 }else if (!document.form.thabitacionpac.value.match(validartele1)) {
	 	alert('Error: Debe ingresar un numero de telefono de habitacion valido...');
		document.form.thabitacionpac.focus();
		return false;
	 }else if (!document.form.nmadre.value.match(validarcampo)){
	 	alert('Error: Debe ingresar el nombre de la madre valido...');
		document.form.nmadre.focus();
		return false;
	 }else if (!document.form.npadre.value.match(validarcampo)){
	 	alert('Error: Debe ingresar el nombre del padre valido...');
		document.form.npadre.focus();
		return false;
	 }else if (!document.form.nrohijopac.value.match(validarhijo)){
	 	alert('Error: Debe ingresar un numero de hijos valido...');
		document.form.nrohijopac.focus();
		return false;
	 }else{
		boolokay=true;
	 }	

	 if (document.form.snombrepac.value.length){
		 if (!document.form.snombrepac.value.match(validarcampo)) {
		 	alert('Error: Debe ingresar un Nombre valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
			document.form.snombrepac.focus();
			return false;
		 }else{
			boolokay=true;
		 }
	 }
	 if (document.form.sapellidopac.value.length){
		 if (!document.form.sapellidopac.value.match(validarcampo)) {
		 	alert('Error: Debe ingresar un Apellido valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
			document.form.sapellidopac.focus();
			return false;
		 }else{boolokay=true;}
	 }
	 if (document.form.tcelularpac.value.length){
		if (!document.form.tcelularpac.value.match(validartele1)){
		 	alert('Error: Debe ingresar un numero de telefono celular valido...');
			document.form.tcelularpac.focus();
			return false;
		}else{boolokay=true;}
	 }
	 if (document.form.ttrabajopac.value.length){
		if (!document.form.ttrabajopac.value.match(validartele1)){
		 	alert('Error: Debe ingresar un numero de telefono de trabajo valido...');
			document.form.ttrabajopac.focus();
			return false;
		}else{boolokay=true;}
	 }
	 if (document.form.emailpac.value.length){
		if (!document.form.emailpac.value.match(validacorreo)){
			alert('Error: Debe ingresar un correo electronico valido...');
			document.form.emailpac.focus();
			return false;
		}else{boolokay=true;}
	 }
				
			
	if(boolokay==true){
		document.form.action='paciente.php?guardar=1';
		document.form.submit();
	}
 }
}
//********************************************************************************
//******************************consulta******************************************
function buscar_consulta_paciente(){
	if(check(document.form.cipaciente, 'Cedula')){
		document.form.action='consulta.php?buscar_pac=1';
		document.form.codconsulta.value='';
		document.form.nombremed.value=0;
		document.form.motivoconsulta.value='';
		document.form.sintomas.value='';
		document.form.pesopac.value='';
		document.form.frecuenciacar.value='';
		document.form.frecuenciares.value='';
		document.form.submit();
	}
}


function guardar_consulta(){
	 boolokay=false;
	 var validarcedula = new RegExp (/^[0-9]{5,9}$/);
	 var validarpeso = new RegExp (/^[0-9]{0,3}\.[0-9]{0,3}$/); 

		 if (confirm("�Esta seguro que desea continuar con el registro?")){
			 if(check(document.form.cipaciente, 'C�dula de identidad'))
			 if(checkCombo(document.form.nombremed, 'Nombre del medico'))
			 if(check(document.form.motivoconsulta, 'Motivo de la consulta'))
			 if(check(document.form.sintomas, 'Alergias'))
			 
			 if (!document.form.cipaciente.value.match(validarcedula)){   
	  			alert('Error: Debe ingresar un numero de cedula valido... ver el ejemplo');
				document.form.cipaciente.focus();
				return false;
 			 }else{
				boolokay=true;
			 }	

			 if (document.form.pesopac.value.length){
				 if (!document.form.pesopac.value.match(validarpeso)) {
				 	alert('Error: Debe ingresar un peso valido... ver el ejemplo');
					document.form.pesopac.focus();
					return false;
				 }else{
					boolokay=true;
				 }
			 } 
			
			if(boolokay==true){
				document.form.action='consulta.php?guardar=1&buscar_pac=1';
				document.form.submit();
			}
		 }
}
function modificar_consulta(ind){
	document.form.codconsulta.value=ind;
	document.form.action='consulta.php?mostrar=1';
	document.form.submit();
 
}
function eliminar_consulta(ind){
 boolokay=false;
 if (confirm("�Esta seguro que desea eliminar el registro?")){
  document.form.codconsulta.value=ind;
  document.form.action='consulta.php?eliminar=1&buscar_pac=1';
  document.form.submit();
 }
}
function volver_consulta(ind){
  document.form.action='consulta.php?buscar_pac=1';
  document.form.submit();
}
//********************************************************************************
//*******************************Examen*******************************************
function guardar_examen(){
	 boolokay=false;

		 if (confirm("�Esta seguro que desea continuar con el registro?")){
			 if(checkCombo(document.form.nexamen, 'Nombre del examen'))
			 if(check(document.form.dexamen, 'Descripcion'))
		   	 boolokay=true;
		 
			
			if(boolokay==true){
				document.form.action='examen.php?guardar=1';
				document.form.submit();
			}
		 } 
}
function modificar_examen(ind){
	document.form.codexamen.value=ind;
	document.form.action='examen.php?mostrar=1';
	document.form.submit();
 
}
function eliminar_examen(ind){
	document.form.codexamen.value=ind;
	document.form.action='examen.php?eliminar=1';
	document.form.submit();
 
}
//********************************************************************************
//****************************Diagnostico consulta********************************
function guardar_diagnostico_consulta(){
	 boolokay=false;

		 if (confirm("�Esta seguro que desea continuar con el registro?")){
			 if(checkCombo(document.form.nomdiagnostico, 'Nombre del diagnostico'))
			 if(check(document.form.dediagnosticocon, 'Descripcion'))
		   	 boolokay=true;
		 
			
			if(boolokay==true){
				document.form.action='diagnostico_consulta.php?guardar=1';
				document.form.submit();
			}
		 } 
}
function modificar_diagnostico(ind){
	document.form.clvcodigo.value=ind;
	document.form.action='diagnostico_consulta.php?mostrar=1';
	document.form.submit();
 
}
function eliminar_diagnostico(ind){
	document.form.clvcodigo.value=ind;
	document.form.action='diagnostico_consulta.php?eliminar=1';
	document.form.submit();
 
}
//********************************************************************************
//****************************tratamiento consulta********************************
function guardar_tratamiento(){
	 boolokay=false;

		 if (confirm("�Esta seguro que desea continuar con el registro?")){
			if(checkCombo(document.form.vademecum, 'vademecum')) 
			if(check(document.form.observacionConsulta, 'Observaci�n'))
			if(check(document.form.posologiaConsulta, 'Posolog�a'))
		   	boolokay=true;
		 
			
			if(boolokay==true){
				document.form.action='tratamiento.php?guardar=1';
				document.form.submit();
			}
		 } 
}
function modificar_tratamiento(ind){
	document.form.clvcodigo.value=ind;
	document.form.action='tratamiento.php?mostrar=1';
	document.form.submit();
 
}
function eliminar_tratamiento(ind){
	document.form.clvcodigo.value=ind;
	document.form.action='tratamiento.php?eliminar=1';
	document.form.submit();
 
}
//********************************************************************************
//****************************Seguro**********************************************
function guardar_seguro(){
	 boolokay=false;
	var validarrif = new RegExp (/^[J,G]\-[0-9]{5,8}\-[0-9]$/);
	var validartele1 = new RegExp (/^\([0]{1}[1-9]{3}\)[0-9]{3}[-][0-9]{4}$/);
	var validarnombre = new RegExp (/^[a-zA-Z]{2,15}$/);
	var validacorreo = new RegExp (/^[\w\.]+@([\w-]+\.)+[\w]{2,4}$/);

		 if (confirm("�Esta seguro que desea continuar con el registro?")){
			if(check(document.form.nombreseg, 'Nombre del seguro')) 
			if(check(document.form.rifseg, 'RIF del seguro'))
			if(check(document.form.telefonopseg, 'Telefono principal'))
			if(check(document.form.personacontseg, 'Persona contacto'))
			if(check(document.form.direccionseg, 'Direccion'))
		   	boolokay=true;
		 	if (document.form.rifseg.value.length){
				if (!document.form.rifseg.value.match(validarrif)){   
		  			alert('Error: Debe ingresar un numero de Rif valido... ver el ejemplo');
					document.form.rifseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }
			}
			if (document.form.telefonopseg.value.length){
				if (!document.form.telefonopseg.value.match(validartele1)){   
		  			alert('Error: Debe ingresar un numero de telefono principal valido... ver el ejemplo');
					document.form.telefonopseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }	
			}
			if (document.form.telefonosseg.value.length){
				if (!document.form.telefonosseg.value.match(validartele1)){   
		  			alert('Error: Debe ingresar un numero de telefono secundario valido... ver el ejemplo');
					document.form.telefonosseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }
			}
			if (document.form.otelefonoseg.value.length){
				if (!document.form.otelefonoseg.value.match(validartele1)){   
		  			alert('Error: Debe ingresar un numero de otro telefono valido... ver el ejemplo');
					document.form.otelefonoseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }
			}
			if (document.form.faxseg.value.length){
				if (!document.form.faxseg.value.match(validartele1)){   
		  			alert('Error: Debe ingresar un numero de fax valido... ver el ejemplo');
					document.form.faxseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }
			}
			if (document.form.correoseg.value.length){
				if (!document.form.correoseg.value.match(validacorreo)){   
		  			alert('Error: Debe ingresar un correo valido... ver el ejemplo');
					document.form.correoseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }
			}

			if (document.form.personacontseg.value.length){
				if (!document.form.personacontseg.value.match(validarnombre)){   
		  			alert('Error: Debe ingresar un nombre de Persona contacto valido... ver el ejemplo');
					document.form.personacontseg.focus();
					return false;
	 			 }else{
					boolokay=true;
				 }
			}

			if(boolokay==true){
				document.form.action='seguro.php?guardar=1';
				document.form.submit();
			}
		 } 
}
function modificar_seguro(ind){
	document.form.clvcodigo.value=ind;
	document.form.action='tratamiento.php?mostrar=1';
	document.form.submit();
 
}
function eliminar_seguro(ind){
	document.form.clvcodigo.value=ind;
	document.form.action='tratamiento.php?eliminar=1';
	document.form.submit();
 
}
//********************************************************************************
/* Cambios Emperatriz*/
/* ************************************ Consultorio *****************************************/
function guardar_consultorio(ind){
alert (ind);
    boolokay=false;
    var validartele1 = new RegExp (/^\([0]{1}[1-9]{3}\)[0-9]{3}[-][0-9]{4}$/);  
     var validacorreo = new RegExp (/^[w.]+@([w-]+.)+[w]{2,4}$/); 
      if (confirm("�Esta seguro que desea continuar con el registro?")){ 
     if(check(document.form.strnom_consultorio, 'Nombre del Consultorio')) 
     if(check(document.form.strnom_responsable, 'Nombre del Responsable'))
     if(check(document.form.strtelf_uno_consultorio, 'Tel�fono Principal'))
      if (!document.form.strtelf_uno_consultorio.value.match(validartele1)){   
        alert('Error: Debe ingresar un numero de Telefono Principal v�lido... ver el ejemplo');
        document.form.strtelf_uno_consultorio.focus();
        boolokay=false;
         }
    else {boolokay=true;
    } 
        }
    if (document.form.strtelf_dos_consultorio.value.length){
         if (!document.form.strtelf_dos_consultorio.value.match(validartele1)) {
             alert('Error: Debe ingresar un numero de Telefono Secundario V�lido...ver el ejemplo ');
            document.form.strtelf_dos_consultorio.focus();
            boolokay=false;
         }else{
            boolokay=true;
         }
     }
    if (document.form.strtelf_tres_consultorio.value.length){
         if (!document.form.strtelf_tres_consultorio.value.match(validartele1)) {
             alert('Error: Debe ingresar un numero de Telefono  V�lido... ver el ejemplo');
            document.form.strtelf_tres_consultorio.focus();
            boolokay=false;
         }else{
            boolokay=true;
         }
     }
    if (document.form.strnro_fax.value.length){
         if (!document.form.strnro_fax.value.match(validartele1)) {
             alert('Error: Debe ingresar un numero de Fax V�lido... ver el ejemplo');
            document.form.strnro_fax.focus();
            boolokay=false;
         }else{
            boolokay=true;
         }
     }
     if (document.form.stremail.value.length){
         if (!document.form.stremail.value.match(validacorreo)) {
             alert('Error: Debe ingresar un Correo Electr�nico V�lido');
            document.form.stremail.focus();
            boolokay=false;
         }else{
            boolokay=true;
         }
     }
     
if(boolokay==true){
if (ind == "undefined" || ind == null)  { 
     document.form.action='consultorio.php?guardar=1'; 
     document.form.submit(); 
 }
else{
    document.form.codConsultorio.value=ind;
    document.form.action='consultorio.php?actualizar=1'; 
    document.form.submit();
 
}}
}

function modificar_consultorio(ind){ 
    document.form.codConsultorio.value=ind;
    document.form.action='consultorio.php?mostrar=1'; 
    document.form.submit();
  
}
function eliminar_consultorio(ind){
 boolokay=false; 
 if (confirm("�Esta seguro que desea eliminar el registro?")){ 
  document.form.codConsultorio.value=ind; 
  document.form.action='consultorio.php?eliminar=1'; 
  document.form.submit(); 
 }
}
/********************************************************************************************/
/* Cambios Emperatriz*/
//*****************************************************************************************
function buscarConsultorio(ind){
alert(document.form.getElementById.medicocita.value);
	document.medicocita.value=ind;
	document.form.action="cita.php";
	document.form.submit();
}
