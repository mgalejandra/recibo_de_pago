<?php
include_once("clases/class_gestion_datos.php");

session_start();
//echo $_SESSION["login_"];

if ($_SESSION['login_']==""){
echo '<SCRIPT language="JavaScript"> alert("         ****ACCESO DENEGADO****\n\nNO TIENE PERMISOS PARA ESTA ACCION");location.href = "cerrar_sesion.php" </script>';
}
header('Content-Type: text/html; charset=utf-8');
?>

<html>
<head>
<title>..::Recibo de Pago::..</title>
<link type="text/css" href="recibo_pago.css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="js/validacion.js"></script>
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript" src="script.js"></script>

</head>

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
		alert('Debe seleccionar el a\u00f1o que desea consultar');
		document.form.ano.focus();
		return false;
		}
	if (document.form.mes.value=="0"){
		alert('Debe seleccionar el mes que desea consultar');
		document.form.mes.focus();
		return false;
		}
	if (document.form.quincena.value=="0"){
		alert('Debe seleccionar la quincena que desea consultar');
		document.form.quincena.focus();
		return false;
		}
	}
</script>

<body background="imagenes/fondo.jpg">
<!-------- CODIGO PARA CENTRAR EN CUALQUIER RESOLUCION INICIO ------->
<div style="display: table; height: 90%; width:100%; #position: relative; overflow: hidden; text-align:center;">
<div style=" #position: absolute; #top: 50%;display: table-cell; vertical-align: middle; text-align:center;">
<div style=" #position: relative; #top: -50%; text-align:center;">
<!-- LO QUE VA CENTRADO EN LA PANTALLA INICIO -->
<table background="imagenes/FONDO_RECIBOS_PAGO.png" width="978" height="568" bordercolor="D8250E" cellpadding="0" cellspacing="1" bgcolor="" align="center" border="0">
<tr>
<td align="center">
<!-- ------------------------------------------------------------------------------------------------------------------ -->
<form method="post" action="reporte.php" id="form" name="form" onSubmit="return revisar();">

<table name="tabla" id="tabla" cellpadding="10" border="0">

<tr>
<td><label for="ano"><span style='color:#535354; font-weight:700;'>AÑO:</span></label></td>
<td>
<select name='ano' id='ano' onchange="javascript:disablefields();">
<option value='0'>-Seleccione-</option>
<option value='2018'>2018</option>
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

<tr>
<td align="center" colspan="2"><input type="submit" name="desc" id="desc" value="Consultar" style="cursor:pointer" ></input></td>
</tr>
</form>

</table>

<table name="tabla2" id="tabla2" border="0">
<tr>
<td><a href="cerrar_sesion.php"><img src ="imagenes/cerrar.png" ></a></td>
</tr>
</table>


<!-- ------------------------------------------------------------------------------------------------------------------ -->
</td>
</tr>
</table>
<!---- LO QUE VA CENTRADO EN LA PANTALLA FIN --->
</div>
</div>
</div>
<!-------- CODIGO PARA CENTRAR EN CUALQUIER RESOLUCION FIN ------->
</body>
</html>

