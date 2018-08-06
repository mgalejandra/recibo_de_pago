<?php





	$neto=$_REQUEST["neto"];

//DENOMINACIONES	
	$a1=$_REQUEST["a1"];
	$a2=$_REQUEST["a2"];
	$a3=$_REQUEST["a3"];
	$a4=$_REQUEST["a4"];
	$a5=$_REQUEST["a5"];

/*
include("../../conexion.php");
session_start();
$nom2=$_SESSION['nombre'];
if ($nom2==""){
echo '<SCRIPT language="JavaScript"> alert("         ****ACCESO DENEGADO****\n\nNO TIENE PERMISOS PARA ESTA ACCION");location.href = "../../index.php" </script>';
}
*/
require('fpdf/fpdf.php');


class PDF extends FPDF
{
    function Header()
    {    


        $this->Image('imagenes/CINTILLO_PRINCIPAL_LOGO.png',5,5,200);
        $this->SetFont('Arial','B',12);
        $this->Cell(18);
        $this->Cell(150,58,'COMPROBANTE DE PAGO',0,0,'C'); 	
       	$this->SetY(100);
	
        $this->Cell(18);
	$this->SetFont('Arial','B',12);
        $this->Cell(150,58,'ASIGNACIONES Y DEDUCCIONES',0,0,'C'); 	
       	$this->SetY(65);
       }

    function Footer()
    {
        $this->SetY(31);
        $this->Image('imagenes/pie_pag1.png',21,250,172,21);

	$this->SetFont('Arial','',12);
	$fecha=date("Y-m-d");
       	$hora=date("H:i:s");
      	$fecha=("Fecha: ").date("Y-m-d");
      	$hora=("Hora: ").date("H:i:s");
      	$this->Text(170,30,$fecha);
        $this->Text(170,35,$hora);
    }

////////////////////////////////////////////////////////////////////////////////

//Tabla coloreada
function TablaColores($header)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(220,220,220);
$this->SetTextColor(0);
$this->SetDrawColor(112,128,144);
$this->SetLineWidth(.3);
$this->SetFont('','B');

//Cabecera
for($i=0;$i<count($header);$i++);
$this->Cell(70,7,"Apellidos",1,0,'C',1);
$this->Cell(70,7,"Nombres",1,0,'C',1);
$this->Cell(40,7,"Cedula de Identidad",1,0,'C',1);
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');

//Datos
$fill=false;
$apellido=$_REQUEST['apellido'];
$nombre=$_REQUEST['nombre'];
$cedula=$_REQUEST['cedula'];
$this->Cell(70,6,$apellido,'LR',0,'L',$fill);
$this->Cell(70,6,$nombre,'LR',0,'L',$fill);
$this->Cell(40,6,$cedula,'LR',0,'R',$fill);
$this->Ln();
$fill=true;
$this->Cell(180,0,'','T');
$this->Ln(5);
}

//Tabla coloreada 2
function TablaColores2($header2)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(220,220,220);
$this->SetTextColor(0);
$this->SetDrawColor(112,128,144);
$this->SetLineWidth(.3);
$this->SetFont('','B');

//Cabecera
for($i=0;$i<count($header2);$i++);
$this->Cell(110,7,"Cargo",1,0,'C',1);
$this->Cell(35,7,"Fecha de Ingreso",1,0,'C',1);
$this->Cell(35,7,"Sueldo",1,0,'C',1);
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');

//Datos
$fill=false;
$cargo=$_REQUEST['cargo'];
$fingreso=$_REQUEST['fingreso'];
$sueldo=$_REQUEST['sueldo'];
$this->Cell(110,6,$cargo,'LR',0,'L',$fill);
$this->Cell(35,6,$fingreso,'LR',0,'R',$fill);
$this->Cell(35,6,$sueldo,'LR',0,'R',$fill);
$this->Ln();
$fill=true;
$this->Cell(180,0,'','T');
$this->Ln(5);
}

//Tabla coloreada 3
function TablaColores3($header3)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(220,220,220);
$this->SetTextColor(0);
$this->SetDrawColor(112,128,144);
$this->SetLineWidth(.3);
$this->SetFont('','B');

//Cabecera
for($i=0;$i<count($header3);$i++);
$this->Cell(110,7,"Unidad Administrativa",1,0,'C',1);
$this->Cell(35,7,"Hasta",1,0,'C',1);
$this->Cell(35,7,"Desde",1,0,'C',1);
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');

//Datos
$fill=false;
$unidad=$_REQUEST['unidad'];
$fech=$_REQUEST['fh'];
$fecd=$_REQUEST['fd'];
$this->Cell(110,6,$unidad,'LR',0,'L',$fill);
$this->Cell(35,6,$fecd,'LR',0,'R',$fill);
$this->Cell(35,6,$fech,'LR',0,'R',$fill);
$this->Ln();
$fill=true;
$this->Cell(180,0,'','T');
$this->Ln(5);
}


//Tabla coloreada 4
function TablaColores4($header4)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(220,220,220);
$this->SetTextColor(0);
$this->SetDrawColor(112,128,144);
$this->SetLineWidth(.3);
$this->SetFont('','B');

//Cabecera
for($i=0;$i<count($header4);$i++);
$this->Cell(90,7,"Denominacion",1,0,'C',1);
$this->Cell(90,7,"Monto",1,0,'C',1);
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');

//Datos
$fill=false;
$b1=$_REQUEST["b1"];
$b2=$_REQUEST["b2"];
$b3=$_REQUEST["b3"];
$b4=$_REQUEST["b4"];
$b5=$_REQUEST["b5"];
$b6=$_REQUEST["b6"];
$b7=$_REQUEST["b7"];

	if ($b2==""){	
		$b2='0.00';
	}
	if ($b6==""){	
		$b6='0.00';
	}
	if ($b7==""){	
		$b7='0.00';
	}

$this->Cell(90,6,"Remuneracion",'LR',0,'L',$fill);
$this->Cell(90,6,$b1,'LR',0,'L',$fill);
$this->Ln();

	$fill=!$fill;
$this->Cell(90,6,"Prima de Antiguedad",'LR',0,'L',$fill);
$this->Cell(90,6,$b2,'LR',0,'L',$fill);
$fill=true;
   $this->Ln();
   
	$fill=!$fill;
$this->Cell(90,6,"S.S.O",'LR',0,'L',$fill);
$this->Cell(90,6,$b3,'LR',0,'L',$fill);
$fill=true;
   $this->Ln();
   
	$fill=!$fill;
$this->Cell(90,6,"S.P.F",'LR',0,'L',$fill);
$this->Cell(90,6,$b4,'LR',0,'L',$fill);
$fill=true;
   $this->Ln();

$this->Cell(90,6,"Fondo Ahorro de Vivienda",'LR',0,'L',$fill);
$this->Cell(90,6,$b5,'LR',0,'L',$fill);
$fill=true;
   $this->Ln();
   
	$fill=!$fill;
$this->Cell(90,6,"Descto. Caja de Ahorros",'LR',0,'L',$fill);
$this->Cell(90,6,$b6,'LR',0,'L',$fill);
$fill=true;
   $this->Ln();
   
   $fill=!$fill;
$this->Cell(90,6,"Prestamo CATINDER",'LR',0,'L',$fill);
$this->Cell(90,6,$b7,'LR',0,'L',$fill);
$fill=true;
   $this->Ln();
   
$fill=true;
$this->Cell(180,0,'','T');
$this->Ln(5);
}

//Tabla coloreada 5
function TablaColores5($header5)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(220,220,220);
$this->SetTextColor(0);
$this->SetDrawColor(112,128,144);
$this->SetLineWidth(.3);
$this->SetFont('','B');

//Cabecera
for($i=0;$i<count($header5);$i++);
$this->Cell(70,7,"Ingreso",1,0,'C',1);
$this->Cell(70,7,"Deducciones",1,0,'C',1);
$this->Cell(40,7,"Neto",1,0,'C',1);
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');

//Datos
$fill=false;
$totaling=$_REQUEST['totaling'];
$totaldedu=$_REQUEST['totaldedu'];
$total=$_REQUEST['total'];
$this->Cell(70,6,$totaling,'LR',0,'L',$fill);
$this->Cell(70,6,$totaldedu,'LR',0,'L',$fill);
$this->Cell(40,6,$total,'LR',0,'R',$fill);
$this->Ln();
$fill=true;
$this->Cell(180,0,'','T');
$this->Ln(5);
}

////////////////////////////////////////////////////////////////////////////////

    function __construct()
    {       
        parent::__construct('P','mm','Letter');
    }
}
    $pdf=new PDF();
 
    $pdf->SetMargins(18, 25);
    $pdf->AliasNbPages();
	
	$dia= date('d');
	$mes= date('m');
	$ano= date('Y');
		
		$pdf->AddPage(); 
		 
		$pdf->SetFont('Arial','',10);

	/////$dia= date('d');
		$mes= date('m');
		$ano= date('Y');/////////////////////////////////'Cargo','Desde','Hasta'/////////////////

	//Títulos de las columnas
	$pdf->TablaColores($header);
	$pdf->ln();

	$pdf->TablaColores2($header2);
	$pdf->ln();

	$pdf->TablaColores3($header3);
	$pdf->ln(20);

	$pdf->TablaColores4($header4);
	$pdf->ln();

	$pdf->TablaColores5($header5);
	$pdf->ln();

	///////////////////////////////////////////////////////

	$pdf->SetFont('Arial','',7);
	$pdf->MultiCell(175,12,('Generado a traves del Sistema de Recibo de Pago en fecha '.$dia.'/'.$mes.'/'.$ano.'.'),0,'J',0);
		
	$pdf->Output(); 
		
		
?>
