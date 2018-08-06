<?php 
include_once("clases/class_gestion_datos.php");
echo"<body style='background-color:#FFFFFF'>";

session_start();
//$_SESSION['login_']  = $_GET['login_'];
//$usuario=$_SESSION['login_'];
//echo "aquiiiii ".$usuario;


//print_r ($_GET);


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

//echo $ano;
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

$rsconsulta = pg_query($obj->conexionbd(),$obj->buscar_recibo_pago($ciusuario, $codnom,$fecdesper,$fechasper));
$valor=pg_fetch_object($rsconsulta);
$nomper=$valor->nomper;
$apeper=$valor->apeper;
$cedper=$valor->cedper;
$fecingper=$valor->fecingper;
$sueper=$valor->sueper;
$descar=$valor->descar;
$desuniadm=$valor->desuniadm;

$rsconsultacon = pg_query($obj->conexionbd(),$obj->buscar_conceptos($ciusuario, $codnom, $codperi,$fecdesper,$fechasper));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="js/validacion.js"></script>
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript" src="script.js"></script>

<style type="text/css">
#form
{
	
	
	
  	border: 10px outset #FFFFFF;
	

}


#titulo

{
	
	  font-weight: bold;
	font-size:xx-large;
	color:#0033CC;
	

	
}

#fecha
{
	
font-size:11px;
color:#0033CC;
	
}


#box{
background: #CCCCCC;
width: 100%;
height: auto;
display: none;
}
p a{
	color: Red;
}

#res{
background:#a2bcff;
width: 100%;
height: auto;
display: yes;
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
<script type="text/javascript">
$(document).ready(function(){

	$("a").click(function(){
		$("#box").show('slow');
		$("#res").hide('slow');
		$('p a').css('color', 'blue');
		
	});
});

</script>
<title>Recibo de pago SIGESP</title>
</head>
<body  >
<form action="" name="form" method="post" id="form">
<table width="100%">
<tr>

<td id="cintillo">
<img src ="imagenes/cintillo_inst.jpg">
</td>
</tr>
<tr>

<td id="titulo" align="right" >CONSULTA DE RECIBO DE PAGO
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://intranet.inder.gob.ve/index.php"><img src ="imagenes/cerrar.jpeg" ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>

</tr>
<tr>
<td  align="center" colspan="2">
&nbsp;<a href="#"><img src ="imagenes/fecha2.jpeg"></a>
</td>
<tr>
<td id="fecha" align="center" colspan="3">Seleccione el rango de fecha</td>



</tr>
</tr>

</table>

<table  border="0" width="100%">

<!-- <div id="box"></div> -->
</table>
<?php if($bandera==1)
{
echo "<table  width='100%' id='res' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000'  style='border-collapse:collapse; '>";
echo "<tr>";
echo "<td align='center'>Año</td>";
echo "<td align='center'>Periodo</td>";
echo "<td align='center'>Fecha desde</td>";
echo "<td align='center'>Fecha hasta</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='center'>$anocur</td>";
echo "<td align='center'>$codperi</td>";
echo "<td align='center'>$fecdesper</td>";
echo "<td align='center'>$fechasper</td>";
echo "</tr>";
echo "</table>";
 }?>
<table border="0" width="100%" id="box">
<?php 
	 $ind=1;
	 while ($valorperiodo=pg_fetch_object($rsperiodo)){  
		$anocur=$valorperiodo->anocur;
	 	$codperi=$valorperiodo->codperi;
		$newfecdes=explode("-",$valorperiodo->fecdesper);
		$newfechas=explode("-",$valorperiodo->fechasper);
	 	$fecdesper=$newfecdes[2]."/".$newfecdes[1]."/".$newfecdes[0];
		$fechasper=$newfechas[2]."/".$newfechas[1]."/".$newfechas[0];
		//echo $fecdesper."-".$fechasper."<br>";
	  ?>  
       	<tr id="<?php echo $ind; ?>" onMouseOver="document.getElementById('<?php echo $ind; ?>').style.backgroundColor='#CCCCCC'" onMouseOut="document.getElementById('<?php echo $ind; ?>').style.backgroundColor=''">
		<td class="texto" align="center"><a href="reporte.php?buscar=1&bandera=1&codperi=<?php echo $codperi; ?>&fecdesper=<?php echo $fecdesper; $f1=$fecdesper;?>&fechasper=<?php echo $fechasper; $f2=$fechasper;?>&anocur=<?php echo $anocur; ?>&usuario=<?php echo $usuario; ?>&ano=<?php echo $ano; ?>" ><?php echo $valorperiodo->anocur; ?> </a></td>
 		<td class="texto" align="center"><?php echo $codperi; ?> </td>
		<td class="texto" align="center"><?php echo $fecdesper; ?></td>
		<td class="texto" align="center"><?php echo $fechasper; ?></td>
		
	  </tr>
	  <?php $ind++; } ?>


</table>
<br>

<?php if($bandera==1)
{?>
<fieldset style="border-collapse: collapse; -moz-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Datos del Recibo de Pago</i></b></legend>
<table  width="100%" frame="box">
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
<fieldset style="border-collapse: collapse; -moinclude_once('clases/class_gestion_datos.php'); z-border-radius: 10px 10px 10px 10px; border-color:#0033CC;"><legend class="texto"><b><i>Asignaciones y Deducciones</i></b></legend>
<table  width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;">

<?php 
$i=0;
while($valorcon=pg_fetch_object($rsconsultacon)){
	
	$nomcon = array();	
	$nomcon = $valorcon->nomcon;

	$valsal = array();
	$valsal = number_format($valorcon->valsal,2);		

//		$asig1=$nomcon;
//		$valasig1=$valsal;
$f2= $_REQUEST['fechasper'];
$f1= $_REQUEST['fecdesper'];	

//echo "$nomcon";
//echo "$valsal";
	
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
}
//echo 'uno:'.$asig1[0]["uno"]. 'Dos:'.$asig1[1]["dos"]. 'Tres:'.$asig1[2]["tres"].'Cuatro:'.$asig1[3]["cuatro"]. 'Cinco:'.$asig1[4]["cinco"].'<br>'
//echo 'uno:'.$val1[0]["uno"]. 'Dos:'.$val1[1]["dos"]. 'Tres:'.$val1[2]["tres"].'Cuatro:'.$val1[3]["cuatro"]. 'Cinco:'.$val1[4]["cinco"].'<br>'
//fin while ?>

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
<td class="titulo" align="right">NETO A COBRAR</td>
<td  class="resultado" align="right"><b><?php echo number_format($totaling+$totaldedu,2); $totalGeneral=number_format($totaling+$totaldedu,2); ?></b></td>
</tr>
</table>
</fieldset>
<p>
  <?php $_SESSION['usuario']  = $_POST['usuario'];
$usuario=$_SESSION['usuario']; }?>
  <input name="usuario" type="hidden" value="<?php echo @$usuario; ?>" />
</p>
<? if($bandera==1) 
{?><p align="center"><a href="fpdf.php?fd=<? echo $f1;?>&fh=<? echo $f2;?>&a1=<? echo $asig1[0]['uno'];?>&a2=<? echo $asig1[1]['dos'];?>&a3=<? echo $asig1[2]['tres'];?>&a4=<? echo $asig1[3]['cuatro'];?>&a5=<? echo $asig1[4]['cinco'];?>&b1=<? echo $val1[0]['uno'];?>&b2=<? echo $val1[1]['dos'];?>&b3=<? echo $val1[2]['tres'];?>&b4=<? echo $val1[3]['cuatro'];?>&b5=<? echo $val1[4]['cinco'];?>&totaling=<? echo $totalingre;?>&total=<? echo $totalGeneral;?>&totaldedu=<? echo $totaldeduc;?>&fingreso=<? echo $fecingper;?>&sueldo=<? echo $sueper;?>&unidad=<? echo $desuniadm;?>&cedula=<? echo $cedper;?>&nombre=<? echo $nomper;?>&apellido=<? echo $apeper;?>&cargo=<? echo $descar;?>&asignaciones=<? echo $fechasper;?>&neto=<? echo $totalGeneral;?>&usu=<? echo $usuario;?>" target="_blank"><img src="imagenes/imprimir.gif"></img></a></p>  
<? }?>

<hr>
</form>
</body>
</html>
