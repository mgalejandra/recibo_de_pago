<?php
   session_start();
  $id=$_GET[id_usuario_inder_publico];


    function fechaActualCompleta($fecha= ""){
        $fechaActual= date("l-d-F-Y");
        $arreglo= split("-", $fechaActual);

		if($arreglo[0] == "Monday"){
			$arreglo[0]= "Lunes";
		}else if($arreglo[0] == "Tuesday"){
			$arreglo[0]= "Martes";
		}else if($arreglo[0] == "Wednesday"){
			$arreglo[0]= "Miércoles";
		}else if($arreglo[0] == "Thursday"){
			$arreglo[0]= "Jueves";
		}else if($arreglo[0] == "Friday"){
			$arreglo[0]= "Viernes";
		}else if($arreglo[0] == "Saturday"){
			$arreglo[0]= "Sábado";
		}else if($arreglo[0] == "Sunday"){
			$arreglo[0]= "Domingo";
		}

		if($arreglo[2] == "January"){
			$arreglo[2]= "Enero";
		}else if($arreglo[2] == "February"){
			$arreglo[2]= "Febrero";
		}else if($arreglo[2] == "March"){
			$arreglo[2]= "Marzo";
		}else if($arreglo[2] == "April"){
			$arreglo[2]= "Abril";
		}else if($arreglo[2] == "May"){
			$arreglo[2]= "Mayo";
		}else if($arreglo[2] == "June"){
			$arreglo[2]= "Junio";
		}else if($arreglo[2] == "July"){
			$arreglo[2]= "Julio";
		}else if($arreglo[2] == "August"){
			$arreglo[2]= "Agosto";
		}else if($arreglo[2] == "September"){
			$arreglo[2]= "Septiembre";
		}else if($arreglo[2] == "October"){
			$arreglo[2]= "Octubre";
		}else if($arreglo[2] == "November"){
			$arreglo[2]= "Noviembre";
		}else if($arreglo[2] == "December"){
			$arreglo[2]= "Diciembre";
		}

		$cadena= $arreglo[0]." ".$arreglo[1]." de ".$arreglo[2]." de ".$arreglo[3];
		return $cadena;
	}
    function generarTree($id, $tipo, $titulo, $funcion, $ultimo, $ultimoPadre= false) {
        $retorno= "";
        $numero= uniqid();
        if($tipo == 'solo'){
            $retorno= "<div class='dTreeNode'>";
            if($ultimo){
                $retorno.= "<img src='../comunes/images/joinbottom.gif' alt=''>";
            }else{
                $retorno.= "<img src='../comunes/images/join.gif' alt=''>";
            }
            $retorno.= "<img id='is".$id.$numero."' src='../comunes/images/page.gif' alt=''>
                        <a id='as".$id.$numero."' class='node' href=\"".$funcion."\">
                            ".$titulo."
                        </a>
                    </div>";
        }else if($tipo == 'padre'){
            $retorno= "<div class='dTreeNode'>
                        <a href=\"javascript:ver('".$id.$numero."', 'dd".$id.$numero."');\">";
            if($ultimo){
                $retorno.= "<img id='il".$id.$numero."' src='../comunes/images/plusbottom.gif' alt=''>";
            }else{
                $retorno.= "<img id='il".$id.$numero."' src='../comunes/images/plus.gif' alt=''>";
            }
            $retorno.= "</a>
                        <img id='ib".$id.$numero."' src='../comunes/images/book.png' alt=''>
                        <a href=\"javascript:ver('".$id.$numero."', 'dd".$id.$numero."');\" class='node' onclick=\"".$funcion."\">
                            ".$titulo."
                        </a>
                    </div>
                    <div id='dd".$id.$numero."' class='clip'style='display: none;'>";
        }else if($tipo == 'hijo'){
            $retorno= " <div class='dTreeNode'>";
            if($ultimoPadre){
                $retorno.= "<img src='../comunes/images/empty.gif' alt=''>";
            }else{
                $retorno.= "<img src='../comunes/images/line.gif' alt=''>";
            }
            if($ultimo){
                $retorno.= "<img src='../comunes/images/joinbottom.gif' alt=''>";
            }else{
                $retorno.= "<img src='../comunes/images/join.gif' alt=''>";
            }
            $retorno.= "    <img id='id".$id.$numero."' src='../comunes/images/page.gif' alt=''>
                            <a href=\"".$funcion."\">
                                ".$titulo."
                            </a>
                        </div>";
            if($ultimo){
                $retorno.= "</div>";
            }
        }
        return $retorno;
    }

    function fechaCompleta($fecha, $separador) {
        $arreglo= split($separador, $fecha);

        if($arreglo[1] == "01"){
                $arreglo[1]= "Enero";
        }else if($arreglo[1] == "02"){
                $arreglo[1]= "Febrero";
        }else if($arreglo[1] == "03"){
                $arreglo[1]= "Marzo";
        }else if($arreglo[1] == "04"){
                $arreglo[1]= "Abril";
        }else if($arreglo[1] == "05"){
                $arreglo[1]= "Mayo";
        }else if($arreglo[1] == "06"){
                $arreglo[1]= "Junio";
        }else if($arreglo[1] == "07"){
                $arreglo[1]= "Julio";
        }else if($arreglo[1] == "08"){
                $arreglo[1]= "Agosto";
        }else if($arreglo[1] == "09"){
                $arreglo[1]= "Septiembre";
        }else if($arreglo[1] == "10"){
                $arreglo[1]= "Octubre";
        }else if($arreglo[1] == "11"){
                $arreglo[1]= "Noviembre";
        }else if($arreglo[1] == "12"){
                $arreglo[1]= "Diciembre";
        }

        $cadena= $arreglo[0]." de ".$arreglo[1]." de ".$arreglo[2];
        return $cadena;
    }

    function verificarSession() {
 
    if (!$_SESSION[id_usuario_inder_publico])
    { 
    	if(!$_SESSION['id_contacto']){
           // echo "<script>parent.location.href='../index.html'</script>";
           echo "<script>alert('Notiene Usuario en la opcion Correspondencia')</script>";
           echo "<script>parent.location.href='http://intranet.inder.gob.ve/sistemas.php'</script>";
        }  
  
     }
     else
     {
//$conex_string = "host=10.1.0.11 port=5432 dbname=bdcorresp user=postgres password=inder*admin+prod2010";
$conex_string = "host=192.168.0.246 port=5432 dbname=bdcorresp user=postgres password=inder*admin+prod2010";
$dbconex = pg_connect($conex_string);

$SQL="SELECT tblcontacto.id_contacto, tblcontacto.strnombre, tblcontacto.strapellido, tblcontacto.id_cargo_maestro,
tblcontacto.id_dpto_maestro, tblcontacto.id_coord_maestro, tblcontacto.id_coordext_maestro, tblcontactoprofile.id_profile_maestro,
tblmaestros.lngnumero
FROM 
tblcontacto, tblcontactoprofile, tblmaestros
WHERE 
tblmaestros.id_maestro = tblcontacto.id_dpto_maestro and
tblcontacto.id_contacto = tblcontactoprofile.id_contacto and
tblcontacto.strlogin='".$_SESSION[id_usuario_inder_publico]."' AND 
tblcontacto.id_estatus_maestro= 168 AND 
tblcontacto.bolborrado= 0";

$result = pg_query($dbconex, $SQL);
$row = pg_fetch_row($result);
pg_close($dbconex);

if ($row==0)
{
    echo "<script>alert('No existe Usuario Registrado en la opcion Correspondencia')</script>";
    echo "<script>parent.location.href='http://intranet.inder.gob.ve/sistemas.php'</script>";
}
else
{

  $_SESSION['id_contacto']= $row[0];
  $_SESSION['strnombre']= $row[1];
  $_SESSION['strapellido']= $row[2];
  $_SESSION['id_cargo_maestro']= $row[3];
  $_SESSION['id_dpto_maestro']= $row[4];
  $_SESSION['id_coord_maestro']= $row[5];
  $_SESSION['id_coordext_maestro']= $row[6];
  $_SESSION['id_profile']= $row[7];     
  $_SESSION['lngnumero']= $row[8];
//  $_SESSION['nombreusuario']= $row[1].' '.$row[2];

  if ($row[8]==0)
  {
    $_SESSION['estructura']='H';
  }
  else
  {
    $_SESSION['estructura']='V';
  }
/*        
  $_SESSION['id_contacto']= $data[0]['id_contacto'];
  $_SESSION['strnombre']= $data[0]['strnombre'];
  $_SESSION['strapellido']= $data[0]['strapellido'];
  $_SESSION['id_cargo_maestro']= $data[0]['id_cargo_maestro'];
  $_SESSION['id_dpto_maestro']= $data[0]['id_dpto_maestro'];
  $_SESSION['id_coord_maestro']= $data[0]['id_coord_maestro'];
  $_SESSION['id_coordext_maestro']= $data[0]['id_coordext_maestro'];
  $_SESSION['id_profile']= $dataProfile[0]['id_profile_maestro'];        
*/
}
}
    }

	function IsAlpha($str)

{
   $old = Array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
   $new = Array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
   if (str_replace($str, $old, $new) == "")

   {
      return (true);
   }   else   {
      return (false);
   }

}

?>
