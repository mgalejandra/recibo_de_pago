<?php 
include_once("clases/class_gestion_datos.php");
echo"<body style='background-color:#FFFFFF'>";



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
 <link type="text/css" href="recibo_pago.css" rel="stylesheet" />
<style type="text/css"> 
      body {background: url("imagenes/FONDO_RECIBOS_PAGO.png") fixed center no-repeat; font-family: Helvetica, Arial, Sans-Serif;} 
    
   </style> 

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="js/validacion.js"></script>
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript" src="script.js"></script>

<script>

function disablefields(){
	
	var selObj = document.getElementById('ano');
	var selIndex = selObj.selectedIndex;
	
	if (selObj.options[selIndex].value != "0"){
		
		mes.disabled=false;
		quincena.disabled=false;
		
	}if  (selObj.options[selIndex].value == "0"){

			mes.disabled=true;
			quincena.disabled=true;
		}
	
}

function revisar() {


	if (document.form.ano.value=="0"){
		alert('Debe seleccionar el a\u00f1o que desea consultar')
		document.form.ano.focus()
		return false;
		}
	if (document.form.mes.value=="0"){
		alert('Debe seleccionar el mes que desea consultar')
		document.form.mes.focus()
		return false;
		}
	if (document.form.quincena.value=="0"){
		alert('Debe seleccionar la quincena que desea consultar')
		document.form.quincena.focus()
		return false;
		}

	



	}



</script>
</head>

<body>



<form method="post" action="#" id="form" name="form" onSubmit="return revisar();">
<table name="tabla" id="tabla" cellpadding="10" >
<tr>
<td><label for="ano"><span style='color:#535354; font-weight:700;'>AÑO:</span></label></td>
<td>
<select name='ano' id='ano' onchange="javascript:disablefields();">
<option value='0'>-Seleccione-</option>
<option value='2012'>2012</option>
<option value='2013'>2013</option>
</select>
</td>
</tr>

<tr>
<td><label for="mes"><span style='color:#535354; font-weight:700;'>MES:</span></label></td>
<td><select name='mes' id='mes' disabled="disabled" >
<option value='0'>-Seleccione-</option>
<option value='Enero'>Enero</option>
<option value='Febrero'>Febrero</option>
<option value='Marzo'>Marzo</option>
<option value='Abril'>Abril</option>
<option value='Mayo'>Mayo</option>
<option value='Junio'>Junio</option>
<option value='Julio'>Julio</option>
<option value='Agosto'>Agosto</option>
<option value='Septiembre'>Septiembre</option>
<option value='Octubre'>Octubre</option>
<option value='Noviembre'>Noviembre</option>
<option value='Diciembre'>Diciembre</option>
</select>
</td>
</tr>

<tr>

<td><label for="quincena"><span style='color:#535354; font-weight:700;'>QUINCENA:</span></label></td>
<td>
<select name='quincena' id='quincena' disabled="disabled" >
<option value='0'>-Seleccione-</option>
<option value='1'>1era</option>
<option value='2'>2da</option>
</select>
</td>
</tr>



</form>
</table>


<input type="submit" name="descargar" id="descargar" value="Descargar" style="cursor:pointer" ></input>




</body>
</html>