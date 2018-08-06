function validarLogin(){
  var numero = window.document.getElementById("numero").value;
  var clave = window.document.getElementById("clave").value;
  var codigo = window.document.getElementById("codigo").value;
  if(numero == null || numero == "" || numero.length != 7){
    alert("Debe ingresar un número de siete dígitos");
    window.document.getElementById("numero").focus();
    return false;
  }
  if(clave == null || clave == "" || clave.length < 4 || clave.length > 8 || !onlyNumbers(clave)){
    alert("Debe ingresar una clave válida");
    window.document.getElementById("clave").focus();
    return false;
  }
  if(codigo == null || codigo == "" ){
    alert("Debe ingresar un código válido");
    window.document.getElementById("codigo").focus();
    return false;
  }  
  window.document.getElementById("Input").disabled = true;
  window.document.getElementById("loginForm").submit();
  return true;
}
function checkNumero(){  
  if (event.keyCode >= 48 && event.keyCode <= 57){
    event.returnValue = true;
  }
  else{
    event.returnValue = false;
  }
}

function quitarCaracteres (inputString, removeChar) {

  var returnString = inputString;

  if (removeChar.length) {

    while('' + returnString.charAt(0) == removeChar) {

      returnString = returnString.substring(1,returnString.length);

    }

    while('' + returnString.charAt(returnString.length - 1) == removeChar) {

      returnString = returnString.substring(0,returnString.length - 1);

    }

  }

  return returnString;

}



function removeLeadingAndTrailingChar (inputString, removeChar) {

	var returnString = inputString;

	if (removeChar.length) {

	  while(''+returnString.charAt(0)==removeChar) {

		  returnString=returnString.substring(1,returnString.length);

		}

		while(''+returnString.charAt(returnString.length-1)==removeChar) {

	    returnString=returnString.substring(0,returnString.length-1);

	  }

	}

	return returnString;

}



function trimSpaces(inputString) {

	return removeLeadingAndTrailingChar(inputString,' ');

}



function onlyNumbers(inputString) {

  var searchForNumbers = /\D/

  return (!searchForNumbers.test(inputString));

} 

function emailCheck (emailStr) {

/* The following variable tells the rest of the function whether or not
to verify that the address ends in a two-letter country or well-known
TLD.  1 means check it, 0 means don't. */

var checkTLD=1;

/* The following is the list of known TLDs that an e-mail address must end with. */

var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;

/* The following pattern is used to check if the entered e-mail address
fits the user@domain format.  It also is used to separate the username
from the domain. */

var emailPat=/^(.+)@(.+)$/;

/* The following string represents the pattern for matching all special
characters.  We don't want to allow special characters in the address. 
These characters include ( ) < > @ , ; : \ " . [ ] */

var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";

/* The following string represents the range of characters allowed in a 
username or domainname.  It really states which chars aren't allowed.*/

var validChars="\[^\\s" + specialChars + "\]";

/* The following pattern applies if the "user" is a quoted string (in
which case, there are no rules about which characters are allowed
and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
is a legal e-mail address. */

var quotedUser="(\"[^\"]*\")";

/* The following pattern applies for domains that are IP addresses,
rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
e-mail address. NOTE: The square brackets are required. */

var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;

/* The following string represents an atom (basically a series of non-special characters.) */

var atom=validChars + '+';

/* The following string represents one word in the typical username.
For example, in john.doe@somewhere.com, john and doe are words.
Basically, a word is either an atom or quoted string. */

var word="(" + atom + "|" + quotedUser + ")";

// The following pattern describes the structure of the user

var userPat=new RegExp("^" + word + "(\\." + word + ")*$");

/* The following pattern describes the structure of a normal symbolic
domain, as opposed to ipDomainPat, shown above. */

var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");

/* Finally, let's start trying to figure out if the supplied address is valid. */

/* Begin with the coarse pattern to simply break up user@domain into
different pieces that are easy to analyze. */

var matchArray=emailStr.match(emailPat);

if (matchArray==null) {

/* Too many/few @'s or something; basically, this address doesn't
even fit the general mould of a valid e-mail address. */

alert("La dirección de email parece ser incorrecta\nVerifique (@) y (.)");
return false;
}
var user=matchArray[1];
var domain=matchArray[2];

// Start by checking that only basic ASCII characters are in the strings (0-127).

for (i=0; i<user.length; i++) {
if (user.charCodeAt(i)>127) {
alert("El nombre de usuario contiene caracteres inválidos.");
return false;
   }
}
for (i=0; i<domain.length; i++) {
if (domain.charCodeAt(i)>127) {
alert("El nombre de dominio contiene caracteres inválidos.");
return false;
   }
}

// See if "user" is valid 

if (user.match(userPat)==null) {

// user is not valid

alert("El nombre de usuario no parece ser válido.");
return false;
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
host name) make sure the IP address is valid. */

var IPArray=domain.match(ipDomainPat);
if (IPArray!=null) {

// this is an IP address

for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("La dirección IP es inválida!");
return false;
   }
}
return true;
}

// Domain is symbolic name.  Check if it's valid.
 
var atomPat=new RegExp("^" + atom + "$");
var domArr=domain.split(".");
var len=domArr.length;
for (i=0;i<len;i++) {
if (domArr[i].search(atomPat)==-1) {
alert("El nombre de dominio no parece ser válido.");
return false;
   }
}

/* domain name seems valid, but now make sure that it ends in a
known top-level domain (like com, edu, gov) or a two-letter word,
representing country (uk, nl), and that there's a hostname preceding 
the domain or country. */

if (checkTLD && domArr[domArr.length-1].length!=2 && 
domArr[domArr.length-1].search(knownDomsPat)==-1) {
alert("La dirección debe terminar en un dominio conocido\no código de país de dos letras.");
return false;
}

// Make sure there's a host name preceding the domain.

if (len<2) {
alert("Esta dirección no tiene un nombre de host!");
return false;
}

// If we've gotten this far, everything's valid!
return true;
}

function expand() {
/*for(x = 0; x < 50; x++) {
window.moveTo(screen.availWidth * -(x - 50) / 100, screen.availHeight * -(x - 50) / 100);
window.resizeTo(screen.availWidth * x / 50, screen.availHeight * x / 50);
}*/
window.moveTo(0,0);
window.resizeTo(screen.availWidth, screen.availHeight);
}

function ejecutarAccion(){
  var form1 = document.getElementById('form1');
  if (form1.rdAccion[0].checked) {
    if (emailCheck(form1.email.value)) {
      form1.action = '/agl/Controller?action=enviarMailPDFPostpago';
      form1.submit();
	   // form1.target = '_self';
      return true;
    }else{
    	//alert("correo electrónico inválido");
	    return false;
    }
  }
  else {
    var urlPDF = '/agl/Controller?action=mostrarPDFPostpago&control=';
    urlPDF = urlPDF + form1.selFactura.options[form1.selFactura.selectedIndex].value;
    urlPDF = urlPDF + '&tipo=';
    urlPDF = urlPDF + form1.selTipoFact.options[form1.selTipoFact.selectedIndex].value;
    //vPDF = self.open(urlPDF,'vPDF','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=0,resizable=1,status=0,left=0,top=0,width='+screen.availWidth+',height='+screen.availHeight,true);
    vPDF = self.open('/agl/agl_factura_frameset.jsp?urlPDF='+escape(urlPDF),'vPDF','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=0,resizable=1,status=0,left=0,top=0,width='+screen.availWidth+',height='+screen.availHeight,true);
    return false;
  }  
}
// Agregado por Rafael Lara Campos (rafael.lara@movilnet.com.ve)
// NUEVO
function chequeaRequeridos(frm, CamposRequeridos, Descripcion) {
	var alertMsg = "Debes llenar los siguientes campos: \n";
	
	var l_Msg = alertMsg.length;
	
	for (var i = 0; i < CamposRequeridos.length; i++){
		var obj = frm.elements[CamposRequeridos[i]];
		if (obj) {
			switch(obj.type) {
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == "" || obj.value == ""){
					alertMsg += " - " + Descripcion[i] + "\n";
				}
				break;
			case "select-multiple":
				if (obj.selectedIndex == -1){
					alertMsg += " - " + Descripcion[i] + "\n";
				}
				break;
			case "text":
      case "password":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					alertMsg += " - " + Descripcion[i] + "\n";
				}
				break;
			default:
			}
			
			if (obj.type == undefined) {
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++)
					if (obj[j].checked) blnchecked = true;
				
				if (!blnchecked)
					alertMsg += " - " + Descripcion[i] + "\n";
			}
		}
	}

	if (alertMsg.length == l_Msg) {
		return true;
	} else {
		alert(alertMsg);
		return false;
	}
}

// Agregado por Rafael Lara Campos (rafael.lara@movilnet.com.ve)
// desde OVAA
function verificarFecha() {
	var fechaAuxI = new Date (document.form1.fechaI.value.split("/")[2], document.form1.fechaI.value.split("/")[1] - 1, document.form1.fechaI.value.split("/")[0]);
	var fechaAuxF = new Date(document.form1.fechaF.value.split("/")[2], document.form1.fechaF.value.split("/")[1] - 1, document.form1.fechaF.value.split("/")[0]);
	
	if ((fechaAuxF - fechaAuxI > 0) || (document.form1.fechaI.value == "" || document.form1.fechaF.value == ""))
    return true;
  else
  {
		alert("La fecha inicial debe ser menor que la fecha final");
		return false;
	}	
}

// Agregado por Danny dos Santos(dannym.dossantos@movilnet.com.ve)
// desde OVAA
function verificarFechaTDC(txtFecha) 
{
  var fechaTDC = new Date (txtFecha.split("/")[2], txtFecha.split("/")[1] - 1, txtFecha.split("/")[0]);
  var hoy = new Date();

  if (fechaTDC > hoy)
    return true;
  else
  {
    alert("La fecha de vencimiento de la Tarjeta de Crédito no es válida");
	return false;
  }	
}

// Agregado por Rafael Lara Campos (rafael.lara@movilnet.com.ve)
// desde OVAA
function checkEnter()
{

  if (event.keyCode == 13)
  {
    event.returnValue = false;
  }
  else
  {
    event.returnValue = true;
  }
}

// Agregado por Rafael Lara Campos (rafael.lara@movilnet.com.ve)
// desde OVAA
function checkMsgLen(formObj, maxlen)
{
  var len = formObj.observaciones.value.length
  // formObj.count.value = len
  if (len >= maxlen)
  {
 		alert('IMPORTANTE:\nLas observaciones no puede exceder los 100 caracteres.');
		formObj.observaciones.value = formObj.observaciones.value.substr(0, formObj.observaciones.value.length - 1);
    return false;
  }
  else
  	return true;
}

// Agregado por Danny dos Santos (danny.dossantos@movilnet.com.ve)
// desde OVAA
function checkFloat(punto){
	if (document.all) {
		// manejo de eventos para Explorer
		var char0 = "0".charCodeAt(0);
		var char9 = "9".charCodeAt(0);
		var codPunto1;
		var codPunto2;
		var codMenos1 = 109;
		var codMenos2 = 189;
		if (punto=="punto") {
			codPunto1 = 190;
			codPunto2 = 110;
		}
		else {
			codPunto1 = 188;
			codPunto2 = 9;
		}
		var offsetNumKeyPad = 48;
		if ((window.event.keyCode >= char0 && window.event.keyCode <= char9) || (window.event.keyCode >= parseInt(char0+offsetNumKeyPad) && window.event.keyCode <= parseInt(char9+offsetNumKeyPad)) || window.event.keyCode == 13 || window.event.keyCode == 8 || window.event.keyCode == 9 || window.event.keyCode == 46 || window.event.keyCode==codPunto1 || window.event.keyCode==codPunto2 || window.event.keyCode==codMenos1 || window.event.keyCode==codMenos2 || window.event.ctrlKey)
			return true;
		window.event.returnValue = "";
		return false;
	}
}

// Agregado por Danny dos Santos y Rafael Lara Campos
// Nuevo
///////////////////////////////////////////////////////////////////////
//                                                                   //
// formatoMoneda(campo, milSep, decSep, e)                           //
//                                                                   //
// Permite colocar el contenido de un campo con forma to de moneda a //
// medida que el usuario tipea en el mismo. Sólo acepta números.     //
//                                                                   //
// campo  : Campo del formulario (objeto) al que se le quiere apli-  //
//          car el formato de moneda           .                     //
// milSep : Caracter que se usará como separador de miles. Por lo    //
//          general se usa el punto (.)                              //
// decSep : Caracter que se usará como separador decimal. Por lo     //
//          general se usa la coma (,)                               //
// e      : Listener del Evento. Por lo general event                //
//                                                                   //
// Ejemplo:                                                          //
//                                                                   //
// <input onKeyPress="return(formatoMoneda(this, '.', ',', event))"> //
//                                                                   //
///////////////////////////////////////////////////////////////////////
function formatoMoneda(campo, milSep, decSep, e)
{
	var sep = 0;
	var tecla = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var CualCodigo = (window.Event) ? e.which : e.keyCode;

	if (CualCodigo == 13) return true; // Enter

	tecla = String.fromCharCode(CualCodigo); // Obtiene el valor de la tecla presionada

	if (strCheck.indexOf(tecla) == -1) return false; // No es una tecla válida

	len = campo.value.length;

	for(i = 0; i < len; i++)
		if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != decSep)) break;

	aux = '';
	
	for(; i < len; i++)
		if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);
	
	aux += tecla;

	len = aux.length;

	if (len == 0) campo.value = '';
	if (len == 1) campo.value = '0'+ decSep + '0' + aux;
	if (len == 2) campo.value = '0'+ decSep + aux;

	if (len > 2)
	{
		aux2 = '';

		for (j = 0, i = len - 3; i >= 0; i--)
		{
			if (j == 3)
			{
				aux2 += milSep;
				j = 0;
			}
			aux2 += aux.charAt(i);
			j++;
		}

		campo.value = '';
		len2 = aux2.length;

		for (i = len2 - 1; i >= 0; i--)
			campo.value += aux2.charAt(i);

		campo.value += decSep + aux.substr(len - 2, len);
	}
	
	return false;
}

function countChars(elem, limite, divMsg)
{
  var totalMensaje = elem.value.length;
  var x = true;
  if (totalMensaje > limite)
  {
    elem.value = elem.value.substring(0, limite);
    totalMensaje = elem.value.length;
  }
  if (divMsg != null) 
  {
    //(totalMensaje > 0) ? divMsg.style.color = "#000000" : divMsg.style.color = "#AAAAAA"; 
    divMsg.innerHTML = "Caracteres restantes: " + (limite - totalMensaje);
  }
  
  return false;
}

function abrirpopup(nombre,ancho,alto) 
{
	dat = 'width=' + ancho + ',height=' + alto + ',scrollbars=1,resizable=1,location=0,status=1'; //,directories=1,menubar=1
	window.open(nombre,'',dat)
}
function resizeIframe() {
		// Must launched on the body onload event handler for IE
		// Use document.documentElement if you are in Compat mode
		i = parent.document.getElementById(window.name);
		iHeight = document.body.scrollHeight;
		if ((iHeight+5)<=377){
			i.style.height = 377 + "px";
		}else{
			i.style.height = iHeight + 30 + "px";
		}
		i.style.width = 100 + "%";
		parent.document.getElementById("contenido").height=iHeight + 35 + "px";
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
if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) || (key==32))
     return true;  
else if ((("abcdefghijklmnñopqrstuvwxyz").indexOf(keychar) > -1))
   return true;
else
   return false;
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
else if ((("0123456789()-/,.").indexOf(keychar) > -1))
   return true;
else
   return false;
}
function validarif(vthis, e)
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
if (vthis.value.length == 0) {
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)) {
    	return true;  
	} else if (("abcdefghijklmnñopqrstuvwxyz").indexOf(keychar) > -1) {
	   return true;
	} else {
		return false;
	}
} else if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)) {
    	return true;  
		} else if (("1234567890").indexOf(keychar) > -1) {
   	return true;
	} else {
   return false;
	}

}

function validarif(vthis, e)
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
if (vthis.value.length == 0) {
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)) {
    	return true;  
	} else if (("abcdefghijklmnñopqrstuvwxyz").indexOf(keychar) > -1) {
	   return true;
	} else {
		return false;
	}
} else if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)) {
    	return true;  
		} else if (("1234567890").indexOf(keychar) > -1) {
   	return true;
	} else {
   return false;
	}

}
function validartodo(e)
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
if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) || (key==32))
     return true;  
else if ((("abcdefghijklmnñopqrstuvwxyz0123456789()-/").indexOf(keychar) > -1))
   return false;
else
   return true;
}

