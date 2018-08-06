<?php


	$fech=$_REQUEST["fh"];
	$fecd=$_REQUEST["fd"];
	$cedula=$_REQUEST["cedula"];
	$nombre=$_REQUEST["nombre"];
	$apellido=$_REQUEST["apellido"];
	$cargo=$_REQUEST["cargo"];
	$neto=$_REQUEST["neto"];
	$fingreso=$_REQUEST["fingreso"];
	$sueldo=$_REQUEST["sueldo"];
	$unidad=$_REQUEST["unidad"];
	$totaling=$_REQUEST["totaling"];
	$totaldedu=$_REQUEST["totaldedu"];
	$total=$_REQUEST["total"];

//DENOMINACIONES	
	$a1=$_REQUEST["a1"];
	$a2=$_REQUEST["a2"];
	$a3=$_REQUEST["a3"];
	$a4=$_REQUEST["a4"];
	$a5=$_REQUEST["a5"];

//MONTOS
	$b1=$_REQUEST["b1"];
	$b2=$_REQUEST["b2"];
	$b3=$_REQUEST["b3"];
	$b4=$_REQUEST["b4"];
	$b5=$_REQUEST["b5"];
	

include('class.ezpdf.php');
$pdf =& new Cezpdf('letter');
$pdf->selectFont('fonts/courier.afm');

		$config=array('showHeadings'=>3, // Mostrar encabezados
						 'xPos'=>315,
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5 ,
						 'cols'=>array('apellidoss'=>array('justification'=>'left','width'=>80), // Justificaci�n y ancho de la columna
						 			   'nombress'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'cedulas'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'cargos'=>array('justification'=>'center','width'=>130),
									   'desdes'=>array('justification'=>'center','width'=>60),
									   'hastas'=>array('justification'=>'center','width'=>60),
									   'sueldos'=>array('justification'=>'center','width'=>70),
									   'unidads'=>array('justification'=>'center','width'=>200),
									   'valsal'=>array('justification'=>'left')));
 
$data[] = array('apellidos'=>$apellido, 'nombres'=>$nombre, 'cedula'=>$cedula, 'cargo'=>$cargo, 'desde'=>$fecd, 'hasta'=>$fech );
$data1[] = array('fingreso'=>$fingreso, 'sueldo'=>$sueldo, 'unidad'=>$unidad );
$data2[] = array('totaling'=>$totaling, 'totaldedu'=>$totaldedu, 'total'=>$total );
$data3[] = array('nomcon'=>$a1, 'valsal'=>$b1);
$data3[] = array('nomcon'=>$a2, 'valsal'=>$b2);
$data3[] = array('nomcon'=>$a3, 'valsal'=>$b3);
$data3[] = array('nomcon'=>$a4, 'valsal'=>$b4);
$data3[] = array('nomcon'=>$a5, 'valsal'=>$b5);

$as_titulo = "Datos del Recibo de Pago";

$titles = array('apellidos'=>'<b>Apellidos</b>','nombres'=>'<b>Nombres</b>', 'cedula'=>'<b>Cedula</b>', 'cargo'=>'<b>Cargo</b>' , 'desde'=>'<b>Desde</b>', 'hasta'=>'<b>Hasta</b>');
$titles2 = array('unidad'=>'<b>Unidad Administrativa</b>','fingreso'=>'<b>Fecha de Ingreso</b>','sueldo'=>'<b>sueldo</b>');
$titles3 = array('totaling'=>'<b>Ingreso</b>','totaldedu'=>'<b>Deducciones</b>', 'total'=>'<b>Neto a Cobrar</b>');
$titles4 = array('nomcon'=>'<b>Denominacion</b>','valsal'=>'<b>Monto</b>');



$li_tm=$pdf->getTextWidth(11,$as_titulo);
$tm=306-($li_tm/2);


$pdf->ezImage('imagenes/prueba.png', 75,100,100,200);
$pdf->addText($tm,660,9,"COMPROBANTE DE PAGO "); 
$pdf->ezText("\n\n",6);
$pdf->ezText($fecha); // Fecha
//pdf->ezText("\n\n\n",15);
$pdf->addText($tm,630,8,"NOMINA DE FUNCIONARIOS");
//
$pdf->ezTable($data,$titles,'',$config );
$pdf->ezText("\n\n",3);
$pdf->ezTable($data1,$titles2,'',$config );
$pdf->ezText("\n\n",12);
//
$pdf->addText($tm,540,9,"ASIGNACIONES Y DEDUCCIONES ");
$pdf->ezTable($data3,$titles4,'',$config);
$pdf->ezText("\n\n\n",3);
$pdf->ezTable($data2,$titles3,'',$config);
$pdf->ezText("\n\n\n",4);

	
$pdf->ezText("\n\n\n",4);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"),10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n",10);
$pdf->ezStream();
?>
