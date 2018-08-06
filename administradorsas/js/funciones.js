// JavaScript Document
/*
 
 Este archivo de trabajar con la pagina de observacion 

*/
 function buscatelefonos(valores){
    var codigo = document.getElementById(valores).value;
	
	
	 _objetus=Ajax()
    _values_send="funcion=pt"
	
	//_URL_="../predio/combo.php?valor="+document.frmsolicitud.estado.value;
	_URL_="../paginas/funciones.php?valor="+codigo+"&objeto=telefonos";

    _objetus.open("GET",_URL_,true);
    _objetus.onreadystatechange=function() {
		
        if (_objetus.readyState==4)
        { 
              if(_objetus.status==200)
                {
			     
                 //target="municipio" 
				 document.getElementById('tabla').innerHTML=_objetus.responseText;
				
                 }
        }
	
	
	
   }
 
  _objetus.send(null);

   	return
 }
 
  
 function volver(para){
  location.href=para;
 }// fin de funcion
 
 function ir(){
	 
 valida = validaobservacion();	 
 
 if (valida){
  	var tamano = document.forms[0].elements.length;
    var size = (navegador()==1?tamano-2:tamano-1); 
	
	 
     var expe = document.frmobservacion.codexp.value;
	 var expabog = document.frmobservacion.codexpabg.value;
	 var ip= document.frmobservacion.ipcliente.value;
	 var idusuario =document.frmobservacion.usuario.value;
 	 var idcontacto =document.frmobservacion.contacto.value;
	  
	  valores = expe +","+expabog+","+document.frmobservacion.txtobservacion.value+","+document.frmobservacion.cbocontacto.value+","+document.frmobservacion.cboprioridad.value+","+idusuario+","+ip+","+idcontacto;
  // alert(valores);
	 _objetus=new Ajax()
    _values_send="funcion=pt"
	
	//_URL_="../predio/combo.php?valor="+document.frmsolicitud.estado.value;
	_URL_="../paginas/funciones.php?valor="+valores+"&objeto=registra";

    _objetus.open("GET",_URL_,true);
    _objetus.onreadystatechange=function() {
		
        if (_objetus.readyState==4)
        { 
              if(_objetus.status==200)
                {
			     
                 //target="municipio" 
				//document.getElementById('db').innerHTML=_objetus.responseText;
				alert('Observación Guardada');
  		       location.href='abogado.php?str_usuario='+document.frmobservacion.str_usuario.value;
				
                 }
        }
	
	
	
   }
 
  _objetus.send(null);

   	return
	   
 }// fin de valida
 }

 function Ajax(){ 
  var xmlhttp=false; 
  try { 
   // Creación del objeto ajax para navegadores diferentes a Explorer 
   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
  } catch (e) { 
   // o bien 
   try { 
     // Creación del objet ajax para Explorer 
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (E) { 
     xmlhttp = false; 
   } 
  } 

  if (!xmlhttp && typeof XMLHttpRequest!='undefined') { 
   xmlhttp = new XMLHttpRequest(); 
  } 
  return xmlhttp; 
} // fin de ajax


function navegador(){
var nom = navigator.appName;
//alert(nom);
 if (nom == "Microsoft Internet Explorer"){
   return 1
 }else if (nom == "Netscape"){
  // return document.write('Esteu utilitzant un navegador compatible o base de Netscape')
  return 2
 }
 else {
   //return document.write('<a href="http://www.mozilla.org/products/firefox/"MaRtInI Recomana</a>')}
   return 3
 }

}// fin de la function

function llenacontacto(){
     var dependencia=document.frmobservacion.cbodependenciaorigen.value; 
     var idcontacto =document.frmobservacion.contacto.value;
	
	valores = dependencia+","+idcontacto;
     _objetus=new Ajax()
    _values_send="funcion=pt"
	
	//_URL_="../predio/combo.php?valor="+document.frmsolicitud.estado.value;
	_URL_="../paginas/funciones.php?valor="+valores+"&objeto=contacto";

    _objetus.open("GET",_URL_,true);
    _objetus.onreadystatechange=function() {
		
		
        if (_objetus.readyState==4)
        { 
              if(_objetus.status==200)
                {
			     
                 //target="municipio" 
				 document.getElementById('tabla').innerHTML="";
				 document.getElementById('cbocontacto').innerHTML=_objetus.responseText;
				
                 }
        }
		
   }
 
  _objetus.send(null);

   	return
  
 }

function validaobservacion(){

if (document.getElementById('cbodependenciaorigen').value==0){
 alert('Seleccionar Dependencia de envio');
 document.getElementById('cbodependenciaorigen').focus();
 return (false);
}
if (document.getElementById('cbocontacto').value==0){
 alert('Seleccionar la persona responsable');
 document.frmobservacion.cbocontacto.focus();
 return (false);
}
if (document.frmobservacion.txtobservacion.value.length==0){
 alert('Agregar la Observación');
 document.frmobservacion.txtobservacion.focus();
 return (false);
}
if (document.frmobservacion.cboprioridad.value==0){
 alert('Seleccionar la Prioridad');
 document.frmobservacion.cboprioridad.focus();
 return (false);
}

return true;
}// fin de la funcion validaobservacion

 function llenarcombo_buscar(objeto,value){
	_objetus=new Ajax()
    _values_send="funcion=pt"
	
	var valores=document.getElementById('cbosistema').options[document.getElementById('cbosistema').selectedIndex].value;
	
	_URL_="../paginas/funciones.php?valor="+valores+"&objeto="+objeto+"&select="+value;
    _objetus.open("GET",_URL_,true);
    _objetus.onreadystatechange=function() {
		if (_objetus.readyState==1)
        { 
		 
	    document.getElementById(objeto).innerHTML='Cargando....';
		 
		}
		
        if (_objetus.readyState==4)
        { 
              if(_objetus.status==200)
                {
				 document.getElementById(objeto).innerHTML='';	
				 document.getElementById('cbogrupo').innerHTML=_objetus.responseText;
				
                 }
        }
		
   }
 
  _objetus.send(null);

   	return
	}

 function llenarcombo(objeto){
    _objetus=new Ajax()
    _values_send="funcion=pt"
	var valores=document.getElementById('cbosistema').value;
	//_URL_="../predio/combo.php?valor="+document.frmsolicitud.estado.value;
	
	if (valores == 0){
	 //document.getElementById('cbogrupo').value=0;	
	 var n=(document.getElementById('cbogrupo').options.length-1);
	
	 for (v=n; v >0; v--){
	  	  document.getElementById('cbogrupo').options[v]=null; 		
		  document.getElementById('cbogrupo').options[0]=new Option('Seleccione Grupo',0);
	 }
	}else{
	_URL_="../paginas/funciones.php?valor="+valores+"&objeto="+objeto;

    _objetus.open("GET",_URL_,true);
    _objetus.onreadystatechange=function() {
		if (_objetus.readyState==1)
        { 
		 
	    document.getElementById(objeto).innerHTML='Cargando....';
		 
		}
		
        if (_objetus.readyState==4)
        { 
              if(_objetus.status==200)
                {
				 document.getElementById(objeto).innerHTML='';	
				 document.getElementById('cbogrupo').innerHTML=_objetus.responseText;
				
                 }
        }
		
   }
 
  _objetus.send(null);

   	return
	}
 }// fin de llenar combo
 
 function dibujar(){
	 if (document.getElementById('cbo_status').value==21 || document.getElementById('cbo_status').value==22){
		_URL_="../paginas/funciones.php?objeto=dibujar";
	  _objetus=new Ajax()
    _values_send="funcion=pt"
    _objetus.open("GET",_URL_,true);
	
    _objetus.onreadystatechange=function() {
		if (_objetus.readyState==1)
        { 
		 
	    document.getElementById('dibujo').innerHTML='Cargando....';
		 
		}// fin 1
		
        if (_objetus.readyState==4)
        { 
              if(_objetus.status==200)
                {
				 document.getElementById('dibujo').innerHTML='';	
				 document.getElementById('dibujo').innerHTML=_objetus.responseText;
				
                 }
        }// fin 4
		
   }//fin read
 
   _objetus.send(null);

   	return
	 }else{
		  document.getElementById('dibujo').innerHTML='';
	 }
 }//fin de la funccion

function validacion(){
var boolokay;
 	if (document.getElementById('cbo_status').value==21 || document.getElementById('cbo_status').value==22){
			  if (document.getElementById('txtnreunion').value=='' || document.getElementById('txtnreunion').value==0 || document.getElementById('txtnreunion').value==null){
			    alert('Debe agregar el N° de Reunión');
				document.getElemntById('txtnreunion').focus();
				boolokay=false; 
			  }
			   if (document.getElementById('txtfreunion').value=='' || document.getElementById('txtfreunion').value==0 || document.getElementById('txtfreunion').value==null){
			    alert('Debe agregar la Fecha de Reunión');
				document.getElemntById('txtfreunion').focus(); 
				boolokay=false;
			  }
			  		boolokay=true;
			}
			
		return	boolokay;
}

