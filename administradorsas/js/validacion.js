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

function validarnumero(e)
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
else if ((("0123456789ve-").indexOf(keychar) > -1))
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

function entrar_sistema(a){
//alert(a);
	boolokay=false;
	  	if(check(document.form1.login_,'Usuario'))
  		if(check(document.form1.password_,'Contraseña'))
		document.form1.ano.value=a;
		boolokay=true
		if(boolokay){
			document.form1.action='validaringreso.php';
			document.form1.submit();
		}
		
	 	
}


//********************************************************************
//***************************usuario**********************************
function guardar_usuario(){  
    boolokay=false;  
         
    if (confirm("¿Esta seguro que desea continuar con el registro?")){   
    	if(check(document.form.login, 'Login de Usuario'))
    	//if(check(document.form.cedula, 'Cédula de Usuario'))   
    	if(check(document.form.contrasena, 'Contraseña del Usuario'))
    	if(check(document.form.nombre, 'Nombre del usuario'))  
    	if(check(document.form.apellido, 'Apellido del usuario'))  
    	
    	if(document.form.estatus.checked==true){
    		document.form.estatus.value=true;
    	}
    	if(document.form.cclave.checked==true){
    		document.form.cclave.value=true;
    	}
    	   
	     
	boolokay=true;    
     }    
              
	if(boolokay==true){ 
	     document.form.action='crearusuario.php?guardar=1';    
	     document.form.submit();    
	}   
}   
function modificar_usuario(ind){  
    document.form.codUsuario.value=ind; 
    document.form.action='usuario.php?mostrar=1';  
    document.form.submit(); 
   
}

function buscar_nombre_usuario(){      
	 boolokay=false;      
	     
	    if(check(document.form.login, 'Login'))
	    boolokay=true; 
	        
	if(boolokay==true){  
	     document.form.action='crearusuario.php?consultar=1';  
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
// *****************************************************
function guardar_permiso(ind){  
    boolokay=false;  
         
    if (confirm("¿Esta seguro que desea continuar con el registro?")){   
     if(checkCombo(document.form.clvgrupo_maestro, 'Grupo'))   
            if(checkCombo(document.form.clvmodulo_maestro, 'Módulo'))   
         boolokay=true;    
     }    
              
if(boolokay==true){   
if (!ind == "undefined" || ind == null || ind == "")  {    
     document.form.action='permiso.php?guardar=1';    
     document.form.submit();    
 }   
else{   
    document.form.codPermiso.value=ind;   
    document.form.action='permiso.php?actualizar=1';    
    document.form.submit();   
    
}}   
}   
function modificar_permiso(ind){  
    document.form.codPermiso.value=ind; 
    document.form.action='permiso.php?mostrar=1';  
    document.form.submit(); 
   
}

function consultar_permiso_grupo(){      
 boolokay=false;      
     
    if(checkCombo(document.form.clvgrupo_maestro, 'Grupo'))  
    boolokay=true; 
        
if(boolokay==true){  
     document.form.action='permiso.php?consultar=1';  
         document.form.submit(); 
}
}
function eliminar_permiso(ind){ 
 boolokay=false;  
 if (confirm("¿Esta seguro que desea eliminar el registro?")){  
  document.form.codPermiso.value=ind;  
  document.form.action='permiso.php?eliminar=1';  
  document.form.submit();  
 } 
}
function metodoClick(){
    document.form.chkAgregar.click(); 
document.form.chkModificar.click(); 
document.form.chkEliminar.click(); 
document.form.chkConsultar.click(); 
}

//*******************************************************
//******************cambio de clave**********************
function guardar_clave(){  
    boolokay=false;  
         
    if (confirm("¿Esta seguro que desea continuar con el registro?")){    
        if(check(document.form.strlogin, 'Login de Usuario'))  
    if(check(document.form.strclave, 'Nueva Clave del usuario'))  
    if(check(document.form.strclaveuno, 'Confirmación Nueva Clave del Usuario')) 
     boolokay=true; 
}   
              
if(boolokay==true){     
     document.form.action='cambiarclave.php?guardar=1';    
     document.form.submit();    
}
}
