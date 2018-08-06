<?php 
include_once("clases/class_gestion_datos.php");

session_start();
//echo $_SESSION["login_"];

if ($_SESSION['login_']==""){
echo '<SCRIPT language="JavaScript"> alert("         ****ACCESO DENEGADO****\n\nNO TIENE PERMISOS PARA ESTA ACCION");location.href = "cerrar_sesion.php" </script>';
}

$ano=$_REQUEST['ano'];
$mes=$_REQUEST['mes'];
$quincena=$_REQUEST['quincena'];
$bandera="1";
$buscar="1";

/*
if ($ano==""){
echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
}
if ($mes==""){
echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
}
if ($quincena==""){
echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
}*/

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
$desuniadm=$valor->desuniadm;

$rsconsultacon = pg_query($obj->conexionbd(),$obj->buscar_conceptos($ciusuario, $codnom, $codperi,$fecd,$fech));
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


p a{
color: Red;
}

p a{
color: Red;
}

.titulo{
border: solid 1px #5a5c5f; 
font-family: sans-serif; 
font-size: medium; 
font-weight: lighter; 
background-color:#a2bcff;
width: 50%; 
}

.resultado{
border: solid 1px #5a5c5f; 
font-family: sans-serif; 
font-size: medium; 
font-weight: lighter; 
width: 50%;
}

.p{
border: solid 1px #5a5c5f; 
font-family: sans-serif; 
font-size: medium; 
font-weight: lighter; 
color: blue;
width: 50%;
}
.n{
border: solid 1px #5a5c5f; 
font-family: sans-serif; 
font-size: medium; 
font-weight: lighter; 
color: red;
width: 50%;
}

</style>
<title>Recibo de pago SIGESP</title>
</head>
<body>
<DIV ID="recibo">
<form action="" name="form" method="post" id="form">
<table width="100%">
<tr>

<td >
<img src ="imagenes/CINTILLO_PRINCIPAL_LOGO_RP.png"  style="width: 98%; height:160px;">
</td>
</tr>
<tr>

</tr>


</table>


<?php if($bandera==1)
{
echo "<table align='center'  width='100%' id='res' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000'  style='border-collapse:collapse; '>";
echo "<tr>";
echo "<td align='center'>Año</td>";
echo "<td align='center'>Periodo</td>";
echo "<td align='center'>Fecha desde</td>";
echo "<td align='center'>Fecha hasta</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='center'>$ano</td>";
echo "<td align='center'>$periodo</td>";
echo "<td align='center'>$fecd</td>";
echo "<td align='center'>$fech</td>";
echo "</tr>";
echo "</table>";
 }?>
<table border="0" width="100%" id="box">

</table>
<br>

<?php if($bandera==1)
{?>
<fieldset style="border-collapse: collapse; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Datos del Recibo de Pago</i></b></legend>
<table align="center" width="100%" frame="box">
<tr>
<td class="titulo">CEDULA:</td>
<td class="resultado"><?php echo $cedper;?></td>
</tr>
<tr>
<td class="titulo">NOMBRE:</td>
<td class="resultado"><?php echo $nomper;?></td>
</tr>
<tr>
<td class="titulo">APELLIDO:</td>
<td class="resultado"><?php echo $apeper;?></td>
</tr>
<tr>
<td class="titulo">FECHA INGRESO:</td>
<td class="resultado"><?php echo $fecingper;?></td>
</tr>
<tr>
<td class="titulo">SUELDO:</td>
<td class="resultado"><?php echo $sueper;?></td>
</tr>
<tr>
<td class="titulo">CARGO:</td>
<td class="resultado"><?php echo $descar;?></td>
</tr>
<tr>
<td class="titulo">UNIDAD ADMINISTRATIVA:</td>
<td class="resultado"><?php echo $desuniadm;?></td>
</tr>

</table>
</fieldset>
<br>
<fieldset style="border-collapse: collapse; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Datos del Recibo de Pago</i></b></legend>

<table  align="center" width="100%" frame="box" >

<?php 
$i=0;
while($valorcon=pg_fetch_object($rsconsultacon)){
	
	$nomcon = array();	
	$nomcon = $valorcon->nomcon;

	$valsal = array();
	$valsal = number_format($valorcon->valsal,2);
	
//if ($valsal==""){
//echo '<SCRIPT language="JavaScript"> alert("    ****ACCESO DENEGADO****\n\n DEBE CONSULTAR MEDIANTE EL\nFORMULARIO CORRESPONDIENTE");location.href = "seleccion.php" </script>';
//}

$f2= $_REQUEST['fechasper'];
$f1= $_REQUEST['fecdesper'];	

	
  if ($valsal < 0){
 	$totaldedu+=$valsal; ?>
<tr>
<td class="titulo"><?php echo $nomcon; ?></td>
<td class="n" align="right"><?php echo $valsal; ?></td>
<?php  }//if $valsal<0 
if($valorcon->valsal > 0){
		$totaling+=$valorcon->valsal;?>
<td class="titulo"><?php echo $nomcon; ?></td>
<td class="p" align="right"><?php echo $valsal; ?></td>
</tr> 

<?php }//if $valsal >0
$asig1[$i-0]["uno"] = $nomcon;
$asig1[$i-1]["dos"] = $nomcon;
$asig1[$i-2]["tres"] =  $nomcon;
$asig1[$i-3]["cuatro"] =  $nomcon;
$asig1[$i-4]["cinco"] =  $nomcon;

$val1[$i-1]["uno"] = $valsal;
$val1[$i-2]["dos"] = $valsal;
$val1[$i-3]["tres"] =  $valsal;
$val1[$i-4]["cuatro"] =  $valsal;
$val1[$i-5]["cinco"] =  $valsal;

$i++; 

$CJ2=$val1[1]['uno'];
$FV=$val1[0]['tres'];
}?>
</table>
</fieldset>

<br>
<fieldset style="border-collapse: collapse; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Totales</i></b></legend>
<table width="100%" >
<tr>
<td class="titulo">INGRESOS</td>
<td class="p" align="right"><?php echo number_format($totaling,2); $totalingre=number_format($totaling,2); ?></td>
</tr>
<tr>
<td class="titulo">DEDUCCIONES</td>
<td class="n" align="right"><?php echo number_format($totaldedu,2); $totaldeduc=number_format($totaldedu,2); ?></td>
</tr>
<tr>
<td class="titulo" align="left">NETO A COBRAR</td>
<td  class="resultado" align="right"><b><?php echo number_format($totaling+$totaldedu,2); $totalGeneral=number_format($totaling+$totaldedu,2); ?></b></td>
</tr>
</table>
</fieldset>
<img src ="imagenes/pie_pag1.png"  style="width: 100%; height:98px;">
<p>
  <?php $_SESSION['usuario']  = $_POST['usuario'];
$usuario=$_SESSION['usuario']; }
?>
  <input name="usuario" type="hidden" value="<?php echo @$usuario; ?>" />
</p>

</form>
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


