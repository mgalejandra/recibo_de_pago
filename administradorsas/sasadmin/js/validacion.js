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

var nav4 = window.Event ? true : false;
function acceptNum(evt)
{
// NOTA: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
}

function validartelefono(e)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

// control keys
if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
     return true;  
else if ((("0123456789()-").indexOf(keychar) > -1))
   return true;
else
   return false;
}

function validarletra(e)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

// control keys
if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
     return true;  
else if ((("abcdefghijklmnñopqrstuvwxyz ").indexOf(keychar) > -1))
   return true;
else
   return false;
}

function validarEmail(txt,id)
{
	var b=/^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/;
    if (!b.test(txt))
    {
		document.getElementById(id).value = "";
		alert("Lo siento debe indicar un nombre de Email correcto");
		document.getElementById(id).focus();
    }   
}

function validarmonto(e)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

// control keys
if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
     return true;  
else if ((("0123456789.,").indexOf(keychar) > -1))
   return true;
else
   return false;
}

function validartelefono1(txt,id){
	var validartele1 = new RegExp (/^\([0]{1}[1-9]{3}\)[0-9]{3}[-][0-9]{4}$/);
    if (!validartele1.test(txt))
    {
		document.getElementById(id).value = "";
		alert("Lo siento debe indicar un numero de telefono correcto");
		document.getElementById(id).focus();
    }   
}

function validarrif(txt,id)
{
	var validarrif = new RegExp (/^[J,G,N]\-[0-9]{5,8}\-[0-9]$/);
    if (!validarrif.test(txt))
    {
		document.getElementById(id).value = "";
    	alert("Debe indicar un rif correcto ver ejemplo");
    	document.getElementById(id).focus();
    }   
}

function validarcedula(txt,id)
{
	var cedula = new RegExp (/^[0-9]{5,9}$/);
    if (!cedula.test(txt))
    {
		document.getElementById(id).value = "";
    	alert("Debe indicar un número de cédula correcto ver ejemplo");
    	document.getElementById(id).focus();
    }   
}

function entrar_sistema(){
	boolokay=false;
	  	if(check(document.ingreso.user,'Usuario'))
  		if(check(document.ingreso.clave,'Contraseña'))
		//if(checkCombo(document.ingreso.conlog, 'Consultorio'))
		boolokay=true
		if(boolokay){
			document.ingreso.action="validaringreso.php";
			document.ingreso.submit();
		}
		
	 	
}

//**************************************************************************************************
/*function guardar_consultorio(){
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
}*/
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
  document.form.action='creandopdf.php?sw=1';
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
	 
	 if(check(document.form.papellido, 'Primer apellido'))
	 
	 if(check(document.form.tprincipal, 'Telefono principal'))
	 if(check(document.form.tcelular, 'Telefono celular'))
	 if(check(document.form.beeper, 'N�mero de beeper'))
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
	 }else if (!document.form.papellido.value.match(validarcampo)) {
	 	alert('Error: Debe ingresar un Apellido valido... No debe contener caracteres especiales ni ser mayor a 15 letras');
		document.form.papellido.focus();
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
}
function modificar_medico(ind){
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
	 if (confirm("¿Esta seguro que desea continuar con el registro?")){
	     if(check(document.form.cipaciente, 'Cédula de identidad'))
	     if(check(document.form.pnombrepac, 'Primer nombre'))
	     if(check(document.form.papellidopac, 'Primer apellido'))
	     if(checkCombo(document.form.clvnacionalidad, 'Nacionalidad'))
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
	     boolokay=true;
	          
	 
	             
	    if(boolokay==true){
	        document.form.action='paciente.php?guardar=1';
	        document.form.submit();
	    }
	 }
	}
	function limpiar_paciente(){
	    document.form.action='paciente.php?limpiar=1';
	    document.form.submit();
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
	

		 if (confirm("¿Esta seguro que desea continuar con el registro?")){
			 if(check(document.form.cipaciente, 'Cédula de identidad'))
			 if(checkCombo(document.form.nombremed, 'Nombre del medico'))
			  if(checkCombo(document.form.clvtipoconsulta, 'Tipo de Consulta'))
			 if(check(document.form.motivoconsulta, 'Motivo de la consulta'))
			 if(check(document.form.sintomas, 'Sintomas'))
			 
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
 if (confirm("¿Esta seguro que desea eliminar el registro?")){
  document.form.codconsulta.value=ind;
  document.form.action='consulta.php?eliminar=1&buscar_pac=1';
  document.form.submit();
 }
}
function volver_consulta(ind){
  document.form.action='consulta.php?buscar_pac=1';
  document.form.submit();
}

function historia_pdf(){
 boolokay=false;      
     alert("paso");
    if(check(document.form.cipaciente, 'Cédula del Paciente'))
     boolokay=true; 
        
	if(boolokay==true){  
	     document.form.action='pdfHistoria.php';
	   document.form.submit();
	}
}
function validarvalor(txt,id){
	 var validarvalor = new RegExp (/^[0-9]{0,3}\.[0-9]{0,3}$/); 
   if (!validarvalor.test(txt))
   {
		document.getElementById(id).value = "";
		alert("Lo siento debe indicar un valor correcto");
		document.getElementById(id).focus();
   }   
}
//********************************************************************************
//*******************************Examen*******************************************
function guardar_examen(ind){
    boolokay=false;
      
     if (confirm("¿Esta seguro que desea continuar con el registro?")){ 
                 if(checkCombo(document.form.clvtipoexamen, 'Tipo de Examen'))
             if(check(document.form.dexamen, 'Descripcion'))
                boolokay=true;
             
         
     }     
if(boolokay==true){
     
if (!ind == "undefined" || ind == null || ind == "")  { 
     document.form.action='examen.php?guardar=1'; 
     document.form.submit(); 
 }
else{
    document.form.codexamen.value=ind;
    document.form.action='examen.php?actualizar=1'; 
    document.form.submit();
 
}}
}
 
function modificar_examen(ind){
    document.form.codexamen.value=ind;
    document.form.action='examen.php?mostrar=1';
    document.form.submit();
 
}
function eliminar_examen(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codexamen.value=ind;  
  document.form.action='examen.php?eliminar=1';  
  document.form.submit();  
 } 
}
function eliminar_examen_archivo(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codexamenarchivo.value=ind;  
  document.form.action='examen.php?eliminar_archivo=1&mostrar=1';  
  document.form.submit();  
 } 
}
//********************************************************************************
//****************************Diagnostico consulta********************************
function guardar_diagnostico_consulta(){
	 boolokay=false;

		 if (confirm("¿Esta seguro que desea continuar con el registro?")){
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

		 if (confirm("¿Esta seguro que desea continuar con el registro?")){
			if(checkCombo(document.form.vademecum, 'vademecum')) 
			if(check(document.form.observacionConsulta, 'Observación'))
			if(check(document.form.posologiaConsulta, 'Posología'))
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
function guardar_seguro(ind){ 
    boolokay=false; 
       
     if (confirm("¿Esta seguro que desea continuar con el registro?")){  
        if(check(document.form.strnom_seguro, 'Nombre del Seguro'))  
        if(check(document.form.strrif, 'Nro de Rif')) 
        if(check(document.form.strdir_seguro, 'Dirección'))
        if(check(document.form.strtelf_uno, 'Télefono Principal'))
        if(check(document.form.strnom_contacto, 'Nombre del Responsable')) 
        boolokay=true;  
        } 
     
      
if(boolokay==true){ 
if (!ind == "undefined" || ind == null || ind == "")  {  
     document.form.action='seguro.php?guardar=1';  
     document.form.submit();  
 } 
else{
 
    document.form.codSeguro.value=ind; 
    document.form.action='seguro.php?actualizar=1';  
    document.form.submit(); 
  
}} 
} 
 
function modificar_seguro(ind){  
    document.form.codSeguro.value=ind; 
    document.form.action='seguro.php?mostrar=1';  
    document.form.submit(); 
   
} 
function eliminar_seguro(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codSeguro.value=ind;  
  document.form.action='seguro.php?eliminar=1';  
  document.form.submit();  
 } 
}


//********************************************************************************
/* Cambios Emperatriz*/
//************************************* Consultorio ******************************
function guardar_consultorio(ind){
    boolokay=false;
      
 	if (confirm("¿Esta seguro que desea continuar con el registro?")){ 
		if(check(document.form.strnom_consultorio, 'Nombre del Consultorio')) 
		if(check(document.form.strnom_responsable, 'Nombre del Responsable'))
		if(check(document.form.strtelf_uno_consultorio, 'Teléfono Principal'))
		boolokay=true; 
 	}

     
if(boolokay==true){
if (!ind == "undefined" || ind == null || ind == "")  { 
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
 if (confirm("¿Esta seguro que desea eliminar el registro?")){ 
  document.form.codConsultorio.value=ind; 
  document.form.action='consultorio.php?eliminar=1'; 
  document.form.submit(); 
 }
}
//********************************************************************************
/* Cambios Emperatriz*/
//**************************************cita**************************************
function guardar_cita(){
	alert ("llego");
	 //boolokay=false;
	 /*var validarcedula = new RegExp (/^[0-9]{5,9}$/);

		 if (confirm("¿Esta seguro que desea continuar con el registro?")){
			if(check(document.form.citapaciente, 'Cedula de identidad')) 
			if(checkCombo(document.form.medicocita, 'Nombre del medico')) 
			if(checkCombo(document.form.diad, 'Dia(s) disponible(s)'))
			if(checkCombo(document.form.turno, 'Turno'))
			if(check(document.form.fcita, 'Fecha'))
			if (!document.form.citapaciente.value.match(validarcedula)){   
				alert('Error: Debe ingresar un numero de cedula valido... ver el ejemplo');
				document.form.citapaciente.focus();
				
			}else{
				boolokay=true;
			}
		 
			
			if(boolokay==true){
				document.form.action='cita.php?guardar=1&buscar_citapac=1';
				document.form.submit();
			}
		 } */
}
function modificar_cita(ind){
	document.form.codcita.value=ind;
	document.form.modreg.value=1;
	document.form.action='cita.php?mostrar=1'; 
	document.form.submit();
  
}
function eliminar_cita(ind){
	 boolokay=false; 
	 if (confirm("¿Esta seguro que desea eliminar el registro?")){ 
	  document.form.codcita.value=ind; 
	  document.form.action='cita.php?eliminar=1&buscar_citapac=1'; 
	  document.form.submit(); 
	 }
}
function buscar_cita_paciente(){
	if(check(document.form.citapaciente, 'Cedula de identidad')){
		document.form.action='cita.php?buscar_citapac=1';
		//document.form.medicocita.value=0;
		//document.form.nomconsultorio.value=0;
		document.form.diad.value=0;
		document.form.turno.value=0;
		document.form.hora.value='';
		document.form.fcita.value='';
		document.form.submit();
	}
}
//******************************pago**********************************************
function guardar_pago(){
	 boolokay=false;
	 for(i=0; i < document.form.tipopago.length; i++){
		if(document.form.tipopago[i].checked){
	        valorSeleccionado = document.form.tipopago[i].value;
		}
	 }

	
		 if (confirm("¿Esta seguro que desea continuar con el registro?")){
			 if (valorSeleccionado){
				 if(valorSeleccionado=="efe"){
					 if (document.form.txtefectivo.value==''){
						 alert("Lo Siento... Monto no puede estar en blanco");
						 document.form.txtefectivo.focus();
					 }else{var efectivo=1;boolokay=true;}
				 }
				 if(valorSeleccionado=="che"){
					 if (document.form.cbobanco.selectedIndex==0){
						 alert("Lo Siento... Nombre del Banco no puede estar en blanco");
						 document.form.cbobanco.focus();
					 }else if (document.form.txtcheque.value==''){
						 alert("Lo Siento... Numero de cheque no puede estar en blanco");
						 document.form.txtcheque.focus();
					 }else if(document.form.txtmontocheque.value==''){
						 alert("Lo Siento... Monto del cheque no puede estar en blanco");
						 document.form.txtmontocheque.focus();
					 }else{boolokay=true;}
				 }
				 if(valorSeleccionado=="tar"){
					 if (document.form.cbobanco.selectedIndex==0){
						 alert("Lo Siento... Nombre del Banco no puede estar en blanco");
						 document.form.cbobanco.focus();
					 }else if (document.form.txttarjeta.value==''){
						 alert("Lo Siento... Numero de tarjeta no puede estar en blanco");
						 document.form.txttarjeta.focus();
					 }else if(document.form.txtmontotarjeta.value==''){
						 alert("Lo Siento... Monto de la tarjeta no puede estar en blanco");
						 document.form.txtmontotarjeta.focus();
					 }else{boolokay=true;}
				 }
				 if(valorSeleccionado=="seg"){
					 if (document.form.cboseguro.selectedIndex==0){
						 alert("Lo Siento... Nombre del seguro no puede estar en blanco");
						 document.form.cboseguro.focus();
					 }else if(document.form.txtmontoseguro.value==''){
						 alert("Lo Siento... Monto del seguro no puede estar en blanco");
						 document.form.txtmontoseguro.focus();
					 }else{boolokay=true;}
				 }
				 
			 }else{
				 alert("Lo Siento... debe indicar un tipo de pago");
			 }
			
			if(boolokay==true){
				document.form.action='pago.php?guardar=1';
				document.form.submit();
			}
		 } 
}
function eliminar_pago(ind){
	 boolokay=false; 
	 if (confirm("¿Esta seguro que desea eliminar el registro?")){ 
	  document.form.codigo.value=ind; 
	  document.form.action='pago.php?eliminar=1'; 
	  document.form.submit(); 
	 }
}

function guardarmontomod(){
	boolokay=false;
	if(check(document.form.amonto, 'El ajuste del monto'))
		boolokay=true;
		if(boolokay==true){
			document.form.action='pago.php?guardarmonto=1';
			document.form.submit();
		}
}

function guardar_vademecum(ind){ 
    boolokay=false; 
       
     if (confirm("¿Esta seguro que desea continuar con el registro?")){  
        if(check(document.form.strnombre_generico, 'Nombre del Vademecum Generico'))  
        if(check(document.form.strnombre_comercial, 'Nombre del Vademecum Comercial')) 
        if(checkCombo(document.form.id_laboratorio_maestro, 'Laboratorio')) 
        boolokay=true;  
     } 
 
      
if(boolokay==true){ 
if (!ind == "undefined" || ind == null || ind == "")  {  
     document.form.action='vademecum.php?guardar=1';  
     document.form.submit();  
 } 
else{ 
    document.form.codVademecum.value=ind; 
    document.form.action='vademecum.php?actualizar=1';  
    document.form.submit(); 
  
}} 
} 
 
function modificar_vademecum(ind){  
    document.form.codVademecum.value=ind; 
    document.form.action='vademecum.php?mostrar=1';  
    document.form.submit(); 
   
} 
function eliminar_vademecum(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codVademecum.value=ind;  
  document.form.action='vademecum.php?eliminar=1';  
  document.form.submit();  
 }
function volver_vademecum(){ 
  document.form.action='vademecum.php'; 
  document.form.submit(); 
}
// *******************************************************************
function guardar_presentacion(ind){ 
    boolokay=false; 
       
     if (confirm("¿Esta seguro que desea continuar con el registro?")){  
        if(checkCombo(document.form.clvpresentacion_maestro, 'Presentación de la Medicina')) 
        if(check(document.form.intunidad_medida, 'Cantidad de la Medicina')) 
        if(checkCombo(document.form.clvunidad_maestro, 'Unidad de Medida de la Medicina')) 
        boolokay=true;  
     } 
 
      
if(boolokay==true){ 
if (!ind == "undefined" || ind == null || ind == "")  {  
     document.form.action='presentacion.php?guardar=1';  
     document.form.submit();  
 } 
else{ 
    document.form.codPresentacion.value=ind; 
    document.form.action='presentacion.php?actualizar=1';  
    document.form.submit(); 
  
}} 
} 
 
function modificar_presentacion(ind){  
    document.form.codPresentacion.value=ind; 
    document.form.action='presentacion.php?mostrar=1';  
    document.form.submit(); 
   
} 
function eliminar_presentacion(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codPresentacion.value=ind;  
  document.form.action='presentacion.php?eliminar=1';  
  document.form.submit();  
 }
 
}
}

function guardar_configuracion(ind){  
    boolokay=false;  
        
     if (confirm("¿Esta seguro que desea continuar con el registro?")){   
        if(checkCombo(document.form.codMedico, 'Médico'))  
        if(check(document.form.dblmonto, 'Costo de la Consulta'))  
       if(check(document.form.dbliva, 'Costo Actual del IVA'))  
        boolokay=true;   
     }  
  
       
if(boolokay==true){  
if (!ind == "undefined" || ind == null || ind == "")  {   
     document.form.action='configuracion.php?guardar=1';   
     document.form.submit();   
 }  
else{  
    document.form.codConfiguracion.value=ind;  
    document.form.action='configuracion.php?actualizar=1';   
    document.form.submit();  
   
}}  
}  
  
function modificar_configuracion(ind){   
    document.form.codConfiguracion.value=ind;  
    document.form.action='configuracion.php?mostrar=1';   
    document.form.submit();  
    
}  
function eliminar_configuracion(ind){  
 boolokay=false;   
 if (confirm("¿Esta seguro que desea eliminar el registro?")){   
  document.form.codConfiguracion.value=ind;   
  document.form.action='configuracion.php?eliminar=1';   
  document.form.submit();   
 } 
}
//***************************reporte******************************
function buscarcedulareporte(){
	if(check(document.form.cireporte, 'Cedula de identidad')){
		document.form.action='reporte.php?buscarcedular=1';
		document.form.submit();
	}
}
//****************************************************************
//*****************************maestro****************************
function guardar_maestro(ind){  
    boolokay=false;  
         if (document.form.chkPadre.checked==true){
            if(checkCombo(document.form.id_padre_maestro, 'Padre'))  
            if(check(document.form.strdescripcion, 'Descripción'))    
                boolokay=true;    
             }else{  
        if(check(document.form.strdescripcion, 'Descripción'))   
            boolokay=true;  
        }  
if(boolokay==true){   
if (!ind == "undefined" || ind == null || ind == "")  {    
     document.form.action='maestro.php?guardar=1';    
     document.form.submit();    
 }   
else{   
    document.form.codmaestro.value=ind;   
    document.form.action='maestro.php?actualizar=1';    
    document.form.submit();   
    
}}   
}   
function modificar_maestro(ind){  
    document.form.codmaestro.value=ind; 
    document.form.action='maestro.php?mostrar=1';  
    document.form.submit(); 
   
}

function consultar_maestro(){  
    document.form.action='maestro.php?consultar=1';  
    document.form.submit(); 
   
}
function eliminar_maestro(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codmaestro.value=ind;  
  document.form.action='maestro.php?eliminar=1';  
  document.form.submit();  
 } 
}
//********************************************************************
//***************************usuario**********************************
function guardar_usuario(ind){  
    boolokay=false;  
         
    if (confirm("¿Esta seguro que desea continuar con el registro?")){   
     	if(check(document.form.strcedula, 'Cédula de Usuario'))   
        if(check(document.form.strlogin, 'Login de Usuario'))   
        if(check(document.form.strnombre, 'Nombre del usuario'))  
    	if(check(document.form.strapellido, 'Apellido del usuario'))  
	if(check(document.form.strcorreo, 'Email del Usuario'))     
    	if(check(document.form.strclave, 'Clave del Usuario'))   
	     
	boolokay=true;    
     }    
              
if(boolokay==true){ 

if (!ind == "undefined" || ind == null || ind == "")  {
     alert ("prueba");      
     document.form.action='usuario.php?guardar=1';    
     document.form.submit();    
 }   
else{   
    document.form.codUsuario.value=ind;   
    document.form.action='usuario.php?actualizar=1';    
    document.form.submit();   
    
}}   
}   
function modificar_usuario(ind){  
    document.form.codUsuario.value=ind; 
    document.form.action='usuario.php?mostrar=1';  
    document.form.submit(); 
   
}

function consultar_usuario_cedula(){      
 boolokay=false;      
     
    if(check(document.form.strcedula, 'Cédula de Usuario'))
    boolokay=true; 
        
if(boolokay==true){  
     document.form.action='usuario.php?consultar=1';  
         document.form.submit(); 
}
}
function eliminar_usuario(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codUsuario.value=ind;  
  document.form.action='usuario.php?eliminar=1';  
  document.form.submit();  
 } 
}
//********************************************************************
//*****************************************************
function guardar_asignargrupo(ind){  
    boolokay=false;  
         
    if (confirm("¿Esta seguro que desea continuar con el registro?")){   
         if(checkCombo(document.form.clvgrupo_maestro, 'Grupo'))   
        boolokay=true;    
     }    
              
if(boolokay==true){    
     document.form.action='asignargrupo.php?guardar=1';    
     document.form.submit();    
 }    
}  

function consultar_asignargrupo(){  
    document.form.action='asignargrupo.php?consultar=1';  
    document.form.submit(); 
   
}

function eliminar_asignargrupo(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codUsuarioGrupo.value=ind;  
   document.form.action='usuario.php?regreso=1'; 
  document.form.submit(); 
 } 
}
function volver_usuario(){ 
  document.form.action='usuario.php?regreso=1'; 
  document.form.submit(); 
}
//*******************************************

function guardar_usuario(){
		
	 boolokay=false;
	/* var validarcedula = new RegExp (/^[0-9]{5,9}$/);
	 var validartele1 = new RegExp (/^\([0]{1}[1-9]{3}\)[0-9]{3}[-][0-9]{4}$/); 
	 var validacorreo = new RegExp (/^[\w\.]+@([\w-]+\.)+[\w]{2,4}$/);
	 var validarcampo = new RegExp (/^[a-zA-Z]{2,15}$/);*/

	 if (confirm("¿Esta seguro que desea continuar con el registro?")){
		 if(check(document.form.login, 'login'))
		 if(check(document.form.cedula, 'cedula'))
		 if(check(document.form.contrasena, 'Contrasena'))
		 if(check(document.form.nombre, 'nombre'))
		 if(check(document.form.apellido, 'apellido'))
		 if(check(document.form.correo, 'correo'))
		 
		 
 	 if(boolokay==true){
		 document.form.action='ingresarusuario.php?guardar=1';
		 document.form.submit();
 	 }
 }
			
}