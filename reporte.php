<?php 
include_once("clases/class_gestion_datos.php");
//include_once("conex.php");
//include_once("conex2.php");

session_start();
//echo $_SESSION["login_"];

if ($_SESSION['login_']==""){
echo '<SCRIPT language="JavaScript"> alert("         ****ACCESO DENEGADO****\n\nNO TIENE PERMISOS PARA ESTA ACCION");location.href = "cerrar_sesion.php" </script>';
}

$cedper=$_SESSION['strdocumento'];
//echo $cedper; 
$ano=$_REQUEST['ano'];
$mes=$_REQUEST['mes'];
$quincena=$_REQUEST['quincena'];
$bandera="1";
$buscar="1";

if ($ano==""){
echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
}
if ($mes==""){
echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
}
if ($quincena==""){
echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
}

echo"<body style='background-color:#FFFFFF'>";



////////////////////////  ENERO  /////////////////////////////////////
if ($mes=="Enero"){
	if ($quincena=="1"){
		$periodo="001";
		$fecd="01/01/$ano";
		$fech="15/01/$ano";
	}else{
		$periodo="002";
		$fecd="16/01/$ano";
		$fech="31/01/$ano";}}
////////////////////////  FEBRERO  /////////////////////////////////////
if ($mes=="Febrero"){
	if ($quincena=="1"){
		$periodo="003";
		$fecd="01/02/$ano";
		$fech="15/02/$ano";
	}else{
		$periodo="004";
		$fecd="16/02/$ano";
		$fech="28/02/$ano";}}
////////////////////////  MARZO  /////////////////////////////////////
if ($mes=="Marzo"){
	if ($quincena=="1"){
		$periodo="005";
		$fecd="01/03/$ano";
		$fech="15/03/$ano";
	}else{
		$periodo="006";
		$fecd="16/03/$ano";
		$fech="31/03/$ano";}}
////////////////////////  ABRIL  /////////////////////////////////////
if ($mes=="Abril"){
	if ($quincena=="1"){
		$periodo="007";
		$fecd="01/04/$ano";
		$fech="15/04/$ano";
	}else{
		$periodo="008";
		$fecd="16/04/$ano";
		$fech="30/04/$ano";}}
////////////////////////  MAYO  /////////////////////////////////////
if ($mes=="Mayo"){
	if ($quincena=="1"){
		$periodo="009";
		$fecd="01/05/$ano";
		$fech="15/05/$ano";
	}else{
		$periodo="010";
		$fecd="16/05/$ano";
		$fech="31/05/$ano";}}
////////////////////////  JUNIO  /////////////////////////////////////
if ($mes=="Junio"){
	if ($quincena=="1"){
		$periodo="011";
		$fecd="01/06/$ano";
		$fech="15/06/$ano";
	}else{
		$periodo="012";
		$fecd="16/06/$ano";
		$fech="30/06/$ano";}}
////////////////////////  JULIO  /////////////////////////////////////
if ($mes=="Julio"){
	if ($quincena=="1"){
		$periodo="013";
		$fecd="01/07/$ano";
		$fech="15/07/$ano";
	}else{
		$periodo="014";
		$fecd="16/07/$ano";
		$fech="31/07/$ano";}}
////////////////////////  AGOSTO  /////////////////////////////////////
if ($mes=="Agosto"){
	if ($quincena=="1"){
		$periodo="015";
		$fecd="01/08/$ano";
		$fech="15/08/$ano";
	}else{
		$periodo="016";
		$fecd="16/08/$ano";
		$fech="31/08/$ano";}}
////////////////////////  SEPTIEMBRE  /////////////////////////////////////
if ($mes=="Septiembre"){
	if ($quincena=="1"){
		$periodo="017";
		$fecd="01/09/$ano";
		$fech="15/09/$ano";
	}else{
		$periodo="018";
		$fecd="16/09/$ano";
		$fech="30/09/$ano";}}
////////////////////////  OCTUBRE  /////////////////////////////////////
if ($mes=="Octubre"){
	if ($quincena=="1"){
		$periodo="019";
		$fecd="01/10/$ano";
		$fech="15/10/$ano";
	}else{
		$periodo="020";
		$fecd="16/10/$ano";
		$fech="31/10/$ano";}}
////////////////////////  NOVIEMBRE  /////////////////////////////////////
if ($mes=="Noviembre"){
	if ($quincena=="1"){
		$periodo="021";
		$fecd="01/11/$ano";
		$fech="15/11/$ano";
	}else{
		$periodo="022";
		$fecd="16/11/$ano";
		$fech="30/11/$ano";}}
////////////////////////  DICIEMBRE  /////////////////////////////////////
if ($mes=="Diciembre"){
	if ($quincena=="1"){
		$periodo="023";
		$fecd="01/12/$ano";
		$fech="15/12/$ano";
	}else{
		$periodo="024";
		$fecd="16/12/$ano";
		$fech="31/12/$ano";}}
//////////////////////////////////////////////////////////////////////////
	
//$_SESSION['login_']  = $_GET['login_'];
//$usuario=$_SESSION['login_'];
//echo "aquiiiii ".$usuario;


//print_r ($_GET);
//echo $_SESSION["login_"];


$inactivo = 480; 

if(isset($_SESSION['tiempo']) ) { 
$vida_session = time() - $_SESSION['tiempo']; 
if($vida_session > $inactivo) 
{ 

session_destroy(); 

header("Location:sesion.php" ) ; 
} 
} 

$_SESSION['tiempo'] = time() ; 
		
$usuario=$_SESSION['login_'];
//echo "aqui ".$usuario;

foreach ($_REQUEST as $key => $value) 
 {
  $$key = $value;
 }
  if (!isset($sigue)) 
  {
   $sigue = 0;
  }

$objValidacion = new usuario_inder();
$obj = new recibopago();


//$usuario="jfigueroa";
//*************** buscar cedula de los usuarios ************************************
$rsconsultausuario = pg_query($objValidacion->conexionbd2(),$objValidacion->validar_usuario($usuario));
$valorconsultausuario=pg_fetch_object($rsconsultausuario);
$ciusuario=str_pad($valorconsultausuario->strdocumento, 10, "0", STR_PAD_LEFT);
//***********************************************************************************
//echo "<br>".$ciusuario;
//*********** buscar codigo de nomina ********************************************
$rs = pg_query($obj->conexionbd($ano),$obj->buscar_nomina($ciusuario));
$valorrs=pg_fetch_object($rs);
$codnom=$valorrs->codnom;
//***********************************************************************************
//echo "<br>aqui".$codnom;
//************** buscar periodo ****************************************************
$rsperiodo = pg_query($obj->conexionbd(),$obj->buscar_periodo($codnom));
//********************************************************************************** 
if($buscar==1){

$rsconsulta = pg_query($obj->conexionbd(),$obj->buscar_recibo_pago($ciusuario, $codnom,$fecd,$fech));
$valor=pg_fetch_object($rsconsulta);
$nomper=$valor->nomper;
$apeper=$valor->apeper;
$cedper=$valor->cedper;
$fecingper=$valor->fecingper;
$sueper=$valor->sueper;
$descar=$valor->descar;
$desnom=$valor->desnom;
$desuniadm=$valor->desuniadm;

$rsconsultacon = pg_query($obj->conexionbd(),$obj->buscar_conceptos($ciusuario, $codnom, $codperi,$fecd,$fech));
$rsconsultacon2 = pg_query($obj->conexionbd(),$obj->buscar_conceptos($ciusuario, $codnom, $codperi,$fecd,$fech));

}

if ($cedper==""){

echo '<SCRIPT language="JavaScript"> alert("                             ****ALERTA****\n\nNO EXISTE REGISTRO PARA LA FECHA SELECCIONADA\n          POR FAVOR ELIJA UNA FECHA DIFERENTE");location.href = "seleccion.php" </script>';
}
	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="js/validacion.js"></script>
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript" src="script.js"></script>

	<script type="text/javascript">
		 function busqueda(){	
				document.form1.boton.value='buscar';
				document.form1.submit();	
	}
</script>


<style type="text/css">
#form
{
  	border: 5px solid #DF0101;
	border-top:none;
	border-left:none;
	box-shadow: 2px 2px 5px #000000; 
}

#titulo
{
	font-weight: bold;
	font-size:xx-large;
	color:#084B8A;
	font-family:sans serif;
}


#tabla
{
	
	-moz-border-radius: 14px;
	-webkit-border-radius: 14px;
	border-radius: 14px; 
	border: 2px solid #D8250E;
	margin:auto;
}

#tabla2
{
	
	-moz-border-radius: 14px;
	-webkit-border-radius: 14px;
	border-radius: 14px; 
	margin:auto;
	background-color:#a2bcff;
}

#pie
{
	
	-moz-border-radius: 14px;
	-webkit-border-radius: 14px;
	border-radius: 14px; 
	margin:auto;
}

p a{
color: Red;
}

p a{
color: Red;
}

.titulo{
font-family: sans-serif; 
font-size: 14px;
font-weight: lighter; 
}


.personal{
border: solid 1px #5a5c5f; 
font-family: sans-serif; 
font-size: medium;
background-color:#a2bcff;
}

.resultado{
font-family: sans-serif; 
font-weight: lighter; 
font-size: 14px;
}

.p{
font-family: sans-serif;
font-weight: lighter; 
color: blue;
font-size: 14px;
}
.n{
font-family: sans-serif;
font-weight: lighter; 
color: red;
font-size: 14px;
}

</style>
<title>Recibo de pago SIGESP</title>
</head>
<body background="imagenes/fondo.jpg">
<DIV ID="recibo">

<table id="tabla" cellpadding="0" cellspacing="0" align="center" bgcolor="FFFFFF" bordercolor="D8250E" width="900PX" border="0">
<tr><td>


<!--/////////////////TABLA DE ENCABEZADO INICIO //////////////////////-->
<table width="100%" border="0">
<tr><td>

<table width="100%" height="80px" align="center" border="0">
<tr>
<!--<td align="center" colspan="3"><img src ="imagenes/cintillo sup.png"  style="width:px; height:px;"></td>-->
</tr>

<tr>
<td width="220" align="center"><img src ="imagenes/logo.jpg"  style="width:150px; height:px;"></td>
<td align="center">
<table width="%" height="px" align="center" border="0">

<tr>
<td align="center"><font size='2' color='000000'><strong>RECIBO DE PAGO</strong></font></td>
</tr>

<tr>
<td align="center"><font size='2' color='000000'><strong>Periodo: <?php echo $periodo;?> del <?php echo $fecd;?> al <?php echo $fech;?></strong></font></td>
</tr>

<tr>
<td align="center"><font size='2' color='000000'><strong><?php echo $desnom;?></strong></font></td>
</tr>
</table>

</td>
<td width="220" align="center"></td>
</tr>
</table>

</td></tr>
</table>
<!--/////////////////TABLA DE ENCABEZADO FINAL //////////////////////-->

<?php if($bandera==1)
{?>

<!--//////////////////////////////////////////////////////////////////////////-->
<!--///////////////////TABLA DE DATOS PERSONALES INICIO ///////////////////////-->
<table width="836px" align="center" border="0">
<tr><td>
<fieldset id="tabla" style="border-collapse: collapse; border:1px groove; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Datos Personales</i></b></legend>

<table cellpadding="0" cellspacing="0" width="" align="center" border="0">

<tr>
<td id="tabla" class="personal" width="350px" align="center"><font size='2' color='000000'><b><i>NOMBRES</i></b></font></td>
<td id="tabla" class="personal" width="350px" align="center"><font size='2' color='000000'><b><i>APELLIDOS</i></b></font></td>
<td id="tabla" class="personal" width="350px" align="center"><font size='2' color='000000'><b><i>C&Eacute;DULA</i></b></font></td>
</tr>

<tr>
<td align="center"><font size='2' color='000000'><?php echo $nomper;?></font></td>
<td align="center"><font size='2' color='000000'><?php echo $apeper;?></font></td>
<td align="center"><font size='2' color='000000'><?php echo $cedper;?></font></td>
</tr>

<tr>
<td height="15px"></td>
</tr>

<tr>
<td id="tabla" class="personal" width="350px" align="center"><font size='2' color='000000'><b><i>CARGO</i></b></font></td>
<td id="tabla" class="personal" width="350px" align="center"><font size='2' color='000000'><b><i>UNIDAD</i></b></font></td>
<td id="tabla" class="personal" width="350px" align="center"><font size='2' color='000000'><b><i>FECHA DE INGRESO</i></b></font></td>
</tr>

<tr>
<td align="center"><font size='2' color='000000'><?php echo $descar;?></strong></font></td>
<td align="center"><font size='2' color='000000'><?php echo $desuniadm;?></font></td>
<td align="center"><font size='2' color='000000'><?php echo $fecingper;?></font></td>
</tr>

</table>

</fieldset>
</td></tr>
</table>
<!--///////////////////TABLA DE DATOS PERSONALES FINAL ///////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////-->



<table>
<tr>
<td></td>
</tr>
</table>


<table  width="800px" align="center" border="0">
<tr>
<td width="400px" valign="top">
<!--/////////////////////////////////////////////////////////////////////////////////////-->
<!--///////////////////TABLA DE ASIGNACIONES INICIO ///////////////////////-->
<table width="400" align="center" border="0">
<tr><td>
<fieldset id="tabla" style="border-collapse: collapse; border:1px groove; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Asignaciones</i></b></legend>

<table width="390" align="center" width="100%" border="0">

<?php 
$totaling=="0";
while ($resultc1 =pg_fetch_array($rsconsultacon)){
		$nomcon=$resultc1["nomcon"];
		$valsal=$resultc1["valsal"];
		$valsal11= number_format($valsal,2,',','.');

	if ($valsal>0){
		$totaling=$totaling+$valsal;
		//echo "valsal: $valsal, total: $totaling<br>";
		//echo $totaling;
		?>
<tr>
<td class="titulo"><?php echo $nomcon;?></td>
<td class="p" align="right"><?php echo $valsal11;?></td>
</tr>

<?php } }?>

</table>
</fieldset>
</td></tr>
</table>
<!--///////////////////TABLA DE ASIGNACIONES FIN ///////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////-->
</td>
<td width="400px" valign="top">
<!--/////////////////////////////////////////////////////////////////////////////////////-->
<!--///////////////////TABLA DE DEDUCCIONES INICIO ///////////////////////-->
<table width="400" align="center" border="0">
<tr><td>
<fieldset id="tabla" style="border-collapse: collapse; border:1px groove; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Deducciones</i></b></legend>
<table width="390" align="left" width="100%" border="0">


<?php 
$totaldedu=="0";
while ($resultc2 =pg_fetch_array($rsconsultacon2)){
		$nomcon2=$resultc2["nomcon"];
		$valsal2=$resultc2["valsal"];
		$valsal22= number_format($valsal2,2,',','.');
		

	if ($valsal2<0){
		$totaldedu=$totaldedu+$valsal2;
		//echo $totaldedu;
		?>
<tr>
<td class="titulo"><?php echo $nomcon2;?></td>
<td class="n" align="right"><?php echo $valsal22;?></td>
</tr>

<?php } }  

$totalGeneral1=$totaling+$totaldedu;
$totalGeneral= number_format($totalGeneral1,2,',','.');


?>


</table>
</fieldset>
</td></tr>
</table>
<!--///////////////////TABLA DE DEDUCCIONES FIN ///////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////-->
</td>
</tr>
</table>



<table cellpadding="" width="800px" align="center" border="0">
<tr><td>
<fieldset id="tabla" style="border-collapse: collapse; border:1px groove; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Totales</i></b></legend>

<table cellpadding="2" cellspacing="0" width="800" align="center" border="0">

<tr>
<td align="left"><font size='2' color='000000'><strong>TOTAL INGRESOS BS.</strong></td>
<td class="p" align="right"><?php echo number_format($totaling,2,',','.'); $totalingre=number_format($totaling,2); ?></td>
</tr>

<tr>
<td ><font size='2' color='000000'><strong>TOTAL DEDUCCIONES BS.</strong></td>
<td class="n" align="right"><?php echo number_format($totaldedu,2,',','.'); $totaldeduc=number_format($totaldedu,2); ?></td>
</tr>

<tr>
<td align="left"><font size='2' color='000000'><strong>NETO A COBRAR</strong></td>
<td  class="resultado" align="right"><b><strong><?php echo $totalGeneral; ?></strong></b></td>
</tr>

</table>

</fieldset>
</td></tr>
</table>
<!--///////////////////TABLA DE DATOS PERSONALES FINAL ///////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////-->

<tr align="center">

<!--<td><img id="pie" src ="magenes/pie_pag1.png" style="width: 100%; height:70px;"></td>-->
<td><br></td>
</tr>
<br>


<p>
	  <?php $_SESSION['usuario']  = $_POST['usuario'];
	$usuario=$_SESSION['usuario']; }
	?>
  <input name="usuario" type="hidden" value="<?php echo @$usuario; ?>" />
</p>
</td></tr>
</table>
</DIV>


<div id="botones" name="botones" align="center">
<a href="seleccion.php"><img src ="imagenes/fecha2.png" ></a>&nbsp;&nbsp;
<a href="javascript:imprSelec('recibo')"><img src ="imagenes/imprimir.png" ></a>
<a href="cerrar_sesion.php"><img src ="imagenes/cerrar.png" ></a>



</body>

<script language="Javascript">
 function imprSelec(nombre)
 {
 var ficha = document.getElementById(nombre);
 var ventimp = window.open(' ', 'popimpr');
 ventimp.document.write( ficha.innerHTML );
 ventimp.document.close();
 ventimp.print( );
 ventimp.close();
 } 

</script> 

</html>


