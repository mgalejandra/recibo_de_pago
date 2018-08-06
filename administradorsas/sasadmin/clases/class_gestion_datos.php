<?php 
include ("classbd.php"); 
class Recordset
	{
		var $result, 	// result id
		$rowcount, 		// number of rows in result
		$curpos, 			// index of current row (begin=0, end=rowcount-1)
		$fieldcount, 	// number of fields in result
		$fn, 					// Array of fields names
		$rowset, 			// Array of fields with keys on field name
		$connection, 	// connection id
		$sql; // sql Execsql
		
		//Constructor

		function Recordset($cadsql,$Connection) {
		  
			$this->connection	= $Connection;
			$this->sql				= $cadsql;
			$this->fn					= array();
			$this->rowset			= array();
			$this->Execsql();
		}

		// Execute Execsql
		function Execsql() {
			$this->Close();
			$this->result = @pg_query($this->connection,$this->sql);
			//echo $this->sql;
			if (!$this->result)	return(0);
			$this->rowcount 	= @pg_num_rows($this->result);
			$this->fieldcount = @pg_num_fields($this->result);
			    for ($i=1;$i<=$this->fieldcount;$i++) {
                                $f=@pg_field_name($this->result,$i-1);
                                // Fill fields names array 
							
                                $this->fn[$i]=strtolower($f);
                        }
			
			/* if ($this->rowcount != 0){
			 foreach ($f=pg_fetch_assoc($this->result) as $campo => $valor){
		       
		    	  $this->fn[]=strtolower($campo);
			  } 
	       }*/
		  
			$this->curpos=0;
				
		} 

		//Move to first record
		function Primero() {
			$this->curpos=0;
		}

		//Move next record
		function Siguiente() {
				$this->curpos++;
			}

	 	/* function Mostrar(){
		
			if (!$this->result) return(0);
			if ($this->curpos==$this->rowcount) return(0);
			for($i=1;$i<=$this->fieldcount;$i++)
			
				$this->rowset[$this->fn[$i]] = pg_fetch_result($this->result,$this->curpos,$this->fn[$i]);
						
			return($this->rowset);
			
		}  */
		
		
		function Mostrar(){
		
			if (!$this->result) return(0);
			if ($this->curpos==$this->rowcount) return(0);
			for($i=0;$i<=$this->fieldcount;$i++){
			  $this->rowset[$this->fn[$i]] = pg_fetch_result($this->result,$this->curpos,$this->fn[$i]);
			}

			 return($this->rowset);
			
		} 
		
		
		//Return true if last record
		function Eof() {
			if ($this->curpos==$this->rowcount-1)
				return(1);
			return(0);
		}

		//Return true if first record
		function Bof() {
			if (!$this->curpos)
				return(1);
			return(0);
		}

		// Free result if exist
		function Close() {
			if ($this->result && $this->rowcount)
			pg_free_result($this->result);
			$this->result			= 0;
			$this->fn					= array();
			$this->rowset			= array();
			$this->rowcount		= 0;
			$this->fieldcount	= 0;
		}
	
	}// Fin de la clase recordset



class combo{
 function combo($cadsql="",$nombre="",$seleccion=""){
  $objConexion = new conexion();
  $conex=$objConexion->conectar(); 
  $rs=new Recordset($cadsql,$conex);
  while($Fields=$rs->Mostrar())
   {	
   	if($seleccion==$Fields[$rs->fn[2]]) $resultado=$resultado."<option value=".$Fields[$rs->fn[2]]." selected>".htmlentities($Fields[$rs->fn[1]])."</option>";
	else  $resultado=$resultado."<option value=".$Fields[$rs->fn[2]].">".htmlentities($Fields[$rs->fn[1]])."</option>";
	 $rs->Siguiente();
	}
	$rs->Close();
	return ($resultado);	
 }
}


class Evolucion{
 function conexionbd(){
  $objConexion = new conexion();
  $conex=$objConexion->conectar();
  return ($conex); 
 }
 function registrar_evolucion($evolucion,$paciente,$codigo_evo){
    $sql_verificar="select clvcodigo from consultorio.tblevolucion where clvcodigo=$codigo_evo";
	$execute_evolucion=@pg_query($this->conexionbd(),$sql_verificar);
  if (@pg_num_rows($execute_evolucion) > 0){
    $sql_insertar="UPDATE consultorio.tblevolucion set strevolucion='$evolucion' where clvcodigo=$codigo_evo and clvpaciente=$paciente";
  }else{
    $sql_insertar="INSERT INTO consultorio.tblevolucion (strevolucion,clvpaciente) values ('$evolucion',$paciente)";
  }
  $sw_evolucion=@pg_query($this->conexionbd(),$sql_insertar);
  if (@pg_affected_rows($sw_evolucion)>0){
   echo "<script>alert('El registro ha sido exitoso...')</script>";
  }else{
   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
  }
 }
 function consultar_evolucion($codPac){
  $sql_buscar_evolucion="select clvcodigo,strevolucion, dtmfecha from consultorio.tblevolucion where clvpaciente=$codPac and not blnborrado";
  return ($sql_buscar_evolucion);
 }
 function eliminar_evolucion($paciente,$codigo_evo){
  $sql_eliminar="UPDATE consultorio.tblevolucion set blnborrado='t' where clvcodigo=$codigo_evo and clvpaciente=$paciente";
  $sw=@pg_query($this->conexionbd(),$sql_eliminar);
 }
}

class Laboratorio{
 function conexionbd(){
  $objConexion = new conexion();
  $conex=$objConexion->conectar();
  return ($conex); 
 }
 function registrar_laboratorio($examen,$valor,$codPac){
  $sql_verificar="select clvmaestro from consultorio.tbllaboratorio where clvpaciente=$codPac and clvmaestro=$examen and not blnborrado";
  $sw_verificar=@pg_query($this->conexionbd(),$sql_verificar);
 	  if (@pg_num_rows($sw_verificar)==0){
		  $sql_insertar="INSERT INTO consultorio.tbllaboratorio (clvmaestro,strdescripcion,clvpaciente) values ($examen,'$valor',$codPac)";
		  $sw_evolucion=@pg_query($this->conexionbd(),$sql_insertar);
		  if (@pg_affected_rows($sw_evolucion)>0){
		   echo "<script>alert('El registro ha sido exitoso...')</script>";
		  }else{
		   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		  }
		}else{
			echo "<script>alert('Error: Ya existe un examen con el mismo nombre agregado en la lista.')</script>";
		}//fin de sw_verificar
	
 }
 function consultar_laboratorio($codPac){
  $sql_buscar_evolucion="select a.clvmaestro,a.strdescripcion,a.dtmfecha,b.strnombre from consultorio.tbllaboratorio a, consultorio.tblmaestro b where a.clvpaciente=$codPac and b.clvcodigo=a.clvmaestro and not a.blnborrado and not b.blnborrado";
  //echo $sql_buscar_evolucion;
  return ($sql_buscar_evolucion);
  
 }
 function eliminar_laboratorio($elimnar_lab,$codPac){
 	$sql_eliminar="update consultorio.tbllaboratorio set blnborrado=true where clvmaestro=$elimnar_lab and clvpaciente=$codPac";
	//echo $sql_eliminar;
	$sw_eliminar=pg_query($this->conexionbd(),$sql_eliminar);
		  if (@pg_affected_rows($sw_eliminar)>0){
		   echo "<script>alert('El registro ha sido eliminado exitosamente...')</script>";
		  }else{
		   echo "<script>alert('Error: El registro no se pudo eliminar...')</script>";
		  }
 }
}

class Radiologia{
	 function conexionbd(){
		 $objConexion = new conexion();
		 $conex=$objConexion->conectar();
		 return ($conex); 
	 }

	function registrar_radiologia($examen1,$txtdescripcion,$codPac){

		$sql_verificar="select clvmaestro from consultorio.tblradiologia where clvpaciente=$codPac and clvmaestro=$examen1 and not blnborrado";
		$sw_verificar=pg_query($this->conexionbd(),$sql_verificar);
			if (@pg_num_rows($sw_verificar)==0){
				$sql_insertar="INSERT INTO consultorio.tblradiologia (clvmaestro,strdescripcion,clvpaciente) values ($examen1,'$txtdescripcion',$codPac)";
				$sw_evolucion=pg_query($this->conexionbd(),$sql_insertar);
				if (@pg_affected_rows($sw_evolucion)>0){
					echo "<script>alert('El registro se almaceno exitosamente...')</script>";
				}else{
					echo "<script>alert('Error: El registro no se almaceno con exito...')</script>";
				}
			}else{
					echo "<script>alert('Error: Ya existe un examen con el mismo nombre agregado en la lista.')</script>";
			}//fin de sw_verificar
	}
	
	function consultar_radiologia($codPac){
		$sql_buscar_evolucion="select a.clvcodigo,a.clvmaestro,a.strdescripcion,a.dtmfecha,b.strnombre from consultorio.tblradiologia a, consultorio.tblmaestro b where a.clvpaciente=$codPac and b.clvcodigo=a.clvmaestro and not a.blnborrado and not b.blnborrado";
		//echo $sql_buscar_evolucion;
		return ($sql_buscar_evolucion);
   	}
	
	function eliminar_radiologia($maestro,$codPac){
 	$sql_eliminar="update consultorio.tblradiologia set blnborrado='t' where clvcodigo=$maestro and clvpaciente=$codPac";
	//echo $sql_eliminar;
	$sw_eliminar=pg_query($this->conexionbd(),$sql_eliminar);
		  if (@pg_affected_rows($sw_eliminar)>0){
		   echo "<script>alert('El registro ha sido eliminado exitosamente...')</script>";
		  }else{
		   echo "<script>alert('Error: El registro no se pudo eliminar...')</script>";
		  }
 	}
}

class Administrar{
	 function conexionbd(){
		 $objConexion = new conexion();
		 $conex=$objConexion->conectar();
		 return ($conex); 
	 }
	 
	 function consultar_admin($txtcedulaadmin){
	 	$sqlbuscar="select * from consultorio.tblusuario where strcedula = $txtcedulaadmin";
		//echo $sqlbuscar;
		return($sqlbuscar);
	 }
	 
	 function registrar_administrador($txtcedulaadmin,$txtloginadmin,$txtnombreape,$txtcontraseña,$chkadmin){
	 	$buscaradmin="select strcedula from consultorio.tblusuario where strcedula='$txtcedulaadmin'";
		$sw_buscaradmin=pg_query($this->conexionbd(),$buscaradmin);
		$rsbuscaradmin=pg_num_rows($sw_buscaradmin);
		$txtcontraseña=md5($txtcontraseña);
		$exi=0;
		if ($rsbuscaradmin==0){
			$regadmin="insert into consultorio.tblusuario (strlogin,strclave,strnombreape,blnadministrador,strcedula) values ('$txtloginadmin','$txtcontraseña','$txtnombreape','$chkadmin','$txtcedulaadmin')";
			//echo $regadmin;
			$sw_regadmin=pg_query($this->conexionbd(),$regadmin);
			$exi=@pg_affected_rows($sw_regadmin);
		}else{
			$midificaradmin="update consultorio.tblusuario set strlogin='$txtloginadmin',strclave='$txtcontraseña',strnombreape='$txtnombreape',blnadministrador='t'";
			//echo $midificaradmin;
			$sw_midificaradmin=pg_query($this->conexionbd(),$midificaradmin);
			$exi=@pg_affected_rows($sw_midificaradmin);
		}
		if ($exi==1){
		 echo "<script>alert('El registro ha sido exitoso')</script>";
		}else{
		 echo "<script>alert('Error: El registro no ha sido exitoso')</script>";
		}
	 }
	 
function buscar_componente(){
  $sql_buscar_componente="SELECT STRNOMBRE, CLVCODIGO FROM consultorio.tblmaestro WHERE clvmaestro=40 ORDER BY STRNOMBRE";
  //echo $sql_buscar_evolucion;
  return ($sql_buscar_componente);
  
 }
 
 function registrar_componente($cbotipocomp,$txtdescripcioncomp){
		  $sql_insertar="INSERT INTO consultorio.tblmaestro (clvmaestro,strnombre) values ($cbotipocomp,'$txtdescripcioncomp')";
		  $sw_componente=pg_query($this->conexionbd(),$sql_insertar);
		  if (@pg_affected_rows($sw_componente)>0){
		   echo "<script>alert('El registro ha sido exitoso...')</script>";
		  }else{
		   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		  }
 }
}
//***********************************************************************************************************************************************************
class medico{
 function conexionbd(){
  $objConexion = new conexion();
  $conex=$objConexion->conectar();
  return ($conex); 
 }
 function registrar_medico($cimedico,$pnombre,$snombre,$papellido,$sapellido,$tprincipal,$tcelular,$beeper,$nrocolegiado,$fnacimiento,$emailm){
    $sql_verificar="select clvcodigo from tblmedico where clvci_medico=$cimedico and not blnborrado";
    $execute_medico=@pg_query($this->conexionbd(),$sql_verificar);

  if (@pg_num_rows($execute_medico) > 0){
    $sql_insertar="UPDATE tblmedico set clvci_medico=$cimedico, strpri_nom_medico='$pnombre', strseg_nom_medico='$snombre', strpri_apellido_medico='$papellido', strseg_apellido_medico='$sapellido', strtelf_personal='$tprincipal', strtelf_celular='$tcelular', strbeeper_medico='$beeper', strnro_colegio_medico='$nrocolegiado', dtmfec_nac_medico='$fnacimiento', stremail_medico='$emailm' where clvci_medico=$cimedico";
  }else{
    $sql_insertar="INSERT INTO tblmedico (clvci_medico,strpri_nom_medico,strseg_nom_medico,strpri_apellido_medico,strseg_apellido_medico,strtelf_personal,strtelf_celular,strbeeper_medico,strnro_colegio_medico,dtmfec_nac_medico,stremail_medico) values ($cimedico,'$pnombre','$snombre','$papellido','$sapellido','$tprincipal','$tcelular','$beeper','$nrocolegiado','$fnacimiento','$emailm')";
  }

  $sw_medico=@pg_query($this->conexionbd(),$sql_insertar);
  if (@pg_affected_rows($sw_medico)>0){
   echo "<script>alert('El registro ha sido exitoso...')</script>";
  }else{
   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
  }
 }//fin registrar_medico

 function consultar_medico(){
  $sql_buscar_medico="select clvcodigo, clvci_medico, strpri_nom_medico, strpri_apellido_medico, strtelf_personal, strtelf_celular from tblmedico where not blnborrado order by clvci_medico";
  return ($sql_buscar_medico);
 }//fin consultar_medico

 function mostrar_medico($a){
  $sql_mostrar_medico="select clvci_medico, strpri_nom_medico, strseg_nom_medico, strpri_apellido_medico, strseg_apellido_medico, strtelf_personal, strtelf_celular, strbeeper_medico, strnro_colegio_medico, dtmfec_nac_medico, stremail_medico from tblmedico where clvcodigo = $a and not blnborrado ";
  return ($sql_mostrar_medico);
 }//fin mostrar_medico
 
 function eliminar_medico($a){
  $sql_eliminar="UPDATE tblmedico set blnborrado='t' where clvcodigo=$a";
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
  if (@pg_affected_rows($sw_eliminar)>0){
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>";
  }else{
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";
  }
 }//fin eliminar_medico
 
}//fin class medico
//********************************************************************************************************************************************************************
class paciente{
 function conexionbd(){
  $objConexion = new conexion();
  $conex=$objConexion->conectar();
  return ($conex); 
 }

function buscar_paciente($cipaciente){
	$sql_buscar="select clvcodigo, clvci_paciente, strpri_nom_paciente, strseg_nom_paciente, strpri_apellido_paciente, strseg_apellido_paciente, strsexo_paciente, strdir_paciente, strtelf_hab_paciente, strtelf_celular_paciente, strtelf_trab_paciente, stremail_paciente, strnom_padre_paciente, blnstatus_padre_paciente, strnom_madre_paciente, blnstatus_madre_paciente, strantecedentes_paciente, stralergias_paciente, clvid_religion_maestro, dtmfec_nac_paciente, strocupacion_paciente, clvnro_hijos, blnin_fuma, blnin_bebe_alcohol, clvtiposangre, clvedocivil from tblpaciente where clvci_paciente=$cipaciente";
	return ($sql_buscar);
 }


 function registrar_paciente($cipaciente,$pnombrepac,$snombrepac,$papellidopac,$sapellidopac,$sexopac,$edocivil,$direccionpac,$thabitacionpac,$tcelularpac,$ttrabajopac,$emailpac,$nmadre,$esmadre,$npadre,$espadre,$antecedentespac,$alergiaspac,$religion,$ocupacion,$fnacimientopac,$nrohijopac,$fumapaciente,$bebepaciente,$frhpaciente,$codconsultorio,$clvnacionalidad,$strreferido,$codMedico,$strobservaciones,$add,$upd){
 
    $sql_verificar="select clvcodigo from tblpaciente where clvci_paciente=$cipaciente and not blnborrado";
    $execute_verificar=@pg_query($this->conexionbd(),$sql_verificar);
 
  if (@pg_num_rows($execute_verificar) == 0){
		if($add=="t"){
  			$sql_insertar="insert into tblpaciente (clvci_paciente,strpri_nom_paciente,strseg_nom_paciente,strpri_apellido_paciente,strseg_apellido_paciente,strsexo_paciente,strdir_paciente,strtelf_hab_paciente,strtelf_celular_paciente,strtelf_trab_paciente,stremail_paciente,strnom_padre_paciente,blnstatus_padre_paciente,strnom_madre_paciente,blnstatus_madre_paciente,strantecedentes_paciente,stralergias_paciente,clvid_religion_maestro,dtmfec_nac_paciente,strocupacion_paciente,clvnro_hijos,blnin_fuma,blnin_bebe_alcohol,clvtiposangre,clvedocivil, clvconsultorio,clvnacionalidad,strreferido,clvmedico,strobservaciones) values ($cipaciente,'$pnombrepac','$snombrepac','$papellidopac','$sapellidopac','$sexopac','$direccionpac','$thabitacionpac','$tcelularpac','$ttrabajopac','$emailpac','$npadre','$espadre','$nmadre','$esmadre','$antecedentespac','$alergiaspac',$religion,'$fnacimientopac','$ocupacion',$nrohijopac,'$fumapaciente','$bebepaciente',$frhpaciente,$edocivil,$codconsultorio,$clvnacionalidad,'$strreferido',$codMedico,'$strobservaciones')";
		}else{
  			echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  			return(false);
  		}
  }else{
  		if($upd=="t"){
    		$sql_insertar="update tblpaciente set strpri_nom_paciente='$pnombrepac', strseg_nom_paciente='$snombrepac', strpri_apellido_paciente='$papellidopac', strseg_apellido_paciente='$sapellidopac', strsexo_paciente='$sexopac', strdir_paciente='$direccionpac', strtelf_hab_paciente='$thabitacionpac', strtelf_celular_paciente='$tcelularpac', strtelf_trab_paciente='$ttrabajopac',stremail_paciente='$emailpac', strnom_padre_paciente='$npadre', blnstatus_padre_paciente='$espadre', strnom_madre_paciente='$nmadre', blnstatus_madre_paciente='$esmadre', strantecedentes_paciente='$antecedentespac', stralergias_paciente='$alergiaspac', clvid_religion_maestro=$religion, dtmfec_nac_paciente='$fnacimientopac', strocupacion_paciente='$ocupacion', clvnro_hijos=$nrohijopac, blnin_fuma='$fumapaciente', blnin_bebe_alcohol='$bebepaciente', clvtiposangre=$frhpaciente, clvedocivil=$edocivil,clvnacionalidad=$clvnacionalidad,strreferido='$strreferido',clvmedico=$codMedico,strobservaciones='$strobservaciones' where clvci_paciente=$cipaciente";
  		}else{
  			echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  			return(false);
  		}
  }
 
  $sw_paciente=@pg_query($this->conexionbd(),$sql_insertar);
  if (@pg_affected_rows($sw_paciente)>0){
   echo "<script>alert('El registro ha sido exitoso...')</script>";
  }else{
   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
  }
 }//fin registrar_paciente
 
function guardar_foto_paciente($cipaciente,$archivo){
    $sql_guardar_foto="UPDATE tblpaciente set strfoto='$archivo' where clvci_paciente=$cipaciente";
    $sw_sql_guardar_foto=@pg_query($this->conexionbd(),$sql_guardar_foto);
    if (@pg_affected_rows($sw_sql_guardar_foto)>0){
            echo "<script>alert('La foto del paciente se ha guardado satisfactoriamente')</script>";
        }else{
            echo "<script>alert('La foto del paciente no se ha guardado')</script>";
        }
} 
}//fin paciente
//******************************************************************************************************************************
class consulta extends paciente{
	
	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}	
	
function buscar_motivo($codPac){
		$sql_buscar="select a.*, b.strdescripcion, 'Dr.(a) '||c.strpri_nom_medico ||' '|| c.strseg_nom_medico  ||' '|| c.strpri_apellido_medico ||'  '|| c.strseg_apellido_medico as strnombre
from tblconsulta a inner join tblmaestro b on a.clvtipoconsulta=b.id_maestro
inner join tblmedico c on a.clvmedico=c.clvcodigo where a.clvpaciente=$codPac and not a.blnborrado";
		return ($sql_buscar);
	}
	
	function mostrar_consulta($codconsulta){
		$sql_buscar="select clvcodigo, clvmedico,strpeso_paciente,strfrecuencia_cardiaca, strfrecuencia_respiratoria, strdes_motivo_consulta, strdes_sintoma,clvtipoconsulta from tblconsulta where clvcodigo=$codconsulta and not blnborrado";
		return ($sql_buscar);
	}

	function registrar_consulta($codPac,$nombremed,$pesopac,$frecuenciacar,$frecuenciares,$motivoconsulta,$sintomas,$codconsulta,$codconsultorio,$clvtipoconsulta,$add,$upd){
		echo "<br> class ".$add." ".$upd."<br>";	
		$rsmontopago = @pg_query($this->conexionbd(),$this->buscarmontopago($codconsultorio,$nombremed));
		$valoresMonto=@pg_fetch_object($rsmontopago);
		$montototal=($valoresMonto->dblmonto*$valoresMonto->dbliva)+$valoresMonto->dblmonto;
		
		$sql_buscar="select clvcodigo from tblconsulta where clvcodigo = $codconsulta and not blnborrado";
		$sw_buscar=@pg_query($this->conexionbd(),$sql_buscar);
		if($pesopac=='')
			$pesopac=0;
		if($frecuenciacar=='')
			$frecuenciacar=0;
		if($frecuenciares=='')
			$frecuenciares=0;
		if(@pg_num_rows($sw_buscar) == 0){
			if($add=="t"){
				$sql_insertar="insert into tblconsulta (clvpaciente,clvmedico,strpeso_paciente,strfrecuencia_cardiaca,strfrecuencia_respiratoria,strdes_motivo_consulta,strdes_sintoma,clvconsultorio,dblmontot,dblsaldop,clvtipoconsulta)values ($codPac,$nombremed,$pesopac,$frecuenciacar,$frecuenciares,'$motivoconsulta','$sintomas',$codconsultorio,$valoresMonto->dblmonto,$montototal,$clvtipoconsulta)";
			}else{
  				echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  				return(false);
  			}
		}else{
			if($upd=="t"){
				$sql_insertar="update tblconsulta set clvmedico=$nombremed, strpeso_paciente=$pesopac, strfrecuencia_cardiaca=$frecuenciacar, strfrecuencia_respiratoria=$frecuenciares,strdes_motivo_consulta='$motivoconsulta', strdes_sintoma='$sintomas',clvtipoconsulta=$clvtipoconsulta where clvcodigo = $codconsulta";
			}else{
  				echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  				return(false);
  			}
		}
		$sw_paciente=@pg_query($this->conexionbd(),$sql_insertar);
		if (@pg_affected_rows($sw_paciente)>0){
			echo "<script>alert('El registro ha sido exitoso...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		}	
	}//fin registrar consulta
	
	function eliminar_consulta($codconsulta){
		$sql_eliminar="UPDATE tblconsulta set blnborrado='t' where clvcodigo=$codconsulta";
		$sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
		if (@pg_affected_rows($sw_eliminar)>0){
			echo "<script>alert('El registro ha sido eliminado con exito...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";
		}
	}//fin eliminar_consulta
	
	function buscarmontopago($codconsultorio,$codmedico){
		$objpago = new pago();
		$valorpago=$objpago->mostrar_monto($codconsultorio,$codmedico);
		return($valorpago);
	}
}
//******************************************************************************************************
class examen {

	function conexionbd(){
          $objConexion = new conexion();
        $conex=$objConexion->conectar();
        return ($conex); 
    }
     
	function registrar_examen($dexamen,$clvexamen,$codPac,$codconsulta,$clvcodigo,$clvtipoexamen){ 
        $sql_buscar="select clvcodigo from tblexamen where clvtipoexamen=$clvtipoexamen and clvmaestro=$clvexamen and not blnborrado";
     
	$execute_examen=@pg_query($this->conexionbd(),$sql_buscar);
	    if (@pg_num_rows($execute_examen) == 0){ 
	$sql_insertar="insert into tblexamen (strdes_examen, clvmaestro,clvpaciente, clvconsulta,clvtipoexamen) values ('$dexamen',$clvexamen,$codPac,$codconsulta,$clvtipoexamen)"; }
	$sw_examen=@pg_query($this->conexionbd(),$sql_insertar);
if (@pg_affected_rows($sw_examen)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin registrar_examen
 
 function actualizar_examen($codexamen,$dexamen,$strresultado){ 
    $sql_buscar="select clvcodigo from tblexamen where clvcodigo=$codexamen and not blnborrado";
   $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_buscar);
if (@pg_num_rows($execute_verificar_actualizar) > 0){ 
	$sql_actualizar="update tblexamen set strdes_examen='$dexamen',strresultado='$strresultado' where clvcodigo=$codexamen";
 }
	$sw_examen=@pg_query($this->conexionbd(),$sql_actualizar);
if (@pg_affected_rows($sw_examen)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin actualizar_examen
 
    function buscar_examen($codconsulta){
        $sql_buscar="select ex.clvcodigo as clvcodigo, ti.strdescripcion as tipoexamen,ex.clvmaestro as codmaestro, 
ma.strdescripcion as examen, ex.strdes_examen as descripexamen,ex.strarcresultado 
from tblexamen ex, tblmaestro ma,tblmaestro ti
where ex.clvconsulta=$codconsulta and ex.clvmaestro=ma.id_maestro and ex.clvtipoexamen=ti.id_maestro and not ex.blnborrado";
        return ($sql_buscar);
    }
     
    function mostrar_examen($codexamen){
        $sql_mostrar="select * from tblexamen where clvcodigo=$codexamen and not blnborrado";
        return ($sql_mostrar);     
    }
     
    function eliminar_examen($codexamen){
        $sql_eliminar="UPDATE tblexamen set blnborrado='t' where clvcodigo=$codexamen";
        $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
        if (@pg_affected_rows($sw_eliminar)>0){
            echo "<script>alert('El registro ha sido eliminado con exito...')</script>";
        }else{
            echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";
        }
        $sql_eliminar_hijo="DELETE from tblexamen_archivo  where clvexamen=$codexamen";
        $sw_eliminar_hijo=@pg_query($this->conexionbd(),$sql_eliminar_hijo);
    }
function registrar_examen_archivo($codexamen,$archivo){ 
        $sql_buscar="select clvcodigo from tblexamen_archivo where strarchivo='$archivo'";
    $execute_examen_archivo=@pg_query($this->conexionbd(),$sql_buscar);
    if (@pg_num_rows($execute_examen_archivo) == 0){ 
    $sql_insertar="insert into tblexamen_archivo (clvexamen, strarchivo) values ($codexamen,'$archivo')";
 }
$sw_examen_archivo=@pg_query($this->conexionbd(),$sql_insertar);
if (@pg_affected_rows($sw_examen_archivo)>0){
    echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
      }else{ 
       echo "<script>alert('Error: El Archivo ya está registrado...')</script>"; 
      } 
 }//fin registrar_examen_archivo
 
function buscar_examen_archivo($codexamen){
        $sql_buscar_archivo="select * from tblexamen_archivo where clvexamen=$codexamen";
        return ($sql_buscar_archivo);
    }// fin buscar_examen_archivo
function eliminar_examen_archivo($clvcodigo){
        $sql_eliminar="DELETE from tblexamen_archivo where clvcodigo=$clvcodigo";
        $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
        if (@pg_affected_rows($sw_eliminar)>0){
            echo "<script>alert('El registro ha sido eliminado con exito...')</script>";
        }else{
            echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";
        }
    } // fin eliminar_examen_archivo 
}
//**********************************************************************************************************
class diagnosticoConsulta {

	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}	
	
	function registrar_diagnostico_consulta($dediagnosticocon, $codconsulta,$clvcodigo,$nomdiagnostico,$agr,$mod){
		
		$sql_buscar="select clvcodigo from tbldiagnostico_consulta where clvcodigo=$clvcodigo and not blnborrado";
		$rsBuscar=@pg_query($this->conexionbd(),$sql_buscar);
		
		if (@pg_num_rows($rsBuscar) == 0){
			if($agr=="t"){
				$sql_insertar="insert into tbldiagnostico_consulta (clvconsulta,clvmaestro,strobservaciones) values ($codconsulta,$nomdiagnostico,'$dediagnosticocon')";
			}else{
  				echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  				return(false);
  			}
		}else{
			if($mod=="t"){
				$sql_insertar="update tbldiagnostico_consulta set strobservaciones='$dediagnosticocon' where clvcodigo=$clvcodigo";
			}else{
  				echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  				return(false);
  			}
		}
		$sw_diagnostico=@pg_query($this->conexionbd(),$sql_insertar);
		if (@pg_affected_rows($sw_diagnostico)>0){
			echo "<script>alert('El registro ha sido exitoso...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		}

	}
	
	function mostrar_diagnostico($clvcodigo){
		$sql_mostrar="select clvcodigo, clvmaestro, strobservaciones from tbldiagnostico_consulta where clvcodigo=$clvcodigo and not blnborrado";
		return ($sql_mostrar);
	}

	function buscar_diagnostico_consulta($codconsulta){
		$sql_buscar="select d.clvcodigo as clvcodigo, d.clvmaestro as clvmaestro, d.strobservaciones as strobservaciones, m.strdescripcion as strdescripcion from tbldiagnostico_consulta as d, tblmaestro as m where d.clvconsulta=$codconsulta and d.clvmaestro=m.id_maestro and not d.blnborrado";
		return ($sql_buscar);
	}

	function eliminar_diagnostico($clvcodigo){
		$sql_eliminar="UPDATE tbldiagnostico_consulta set blnborrado='t' where clvcodigo=$clvcodigo";
		$sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
		if (@pg_affected_rows($sw_eliminar)>0){
			echo "<script>alert('El registro ha sido eliminado con exito...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";
		}
	}
}
//******************************************************************************************************************
class tratamiento{
	
	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}
	
	function registrar_tratamiento($codconsulta,$vademecum,$observacionConsulta,$posologiaConsulta, $clvcodigo,$agr,$mod){
		$sql_buscar="select clvcodigo from tbltratamiento where clvcodigo=$clvcodigo and not blnborrado";
		$rsBuscar=@pg_query($this->conexionbd(),$sql_buscar);
		
		if (@pg_num_rows($rsBuscar) == 0){
			if($add=="t"){
				$sql_insertar="insert into tbltratamiento (clvconsulta,clvvademecum,strobservacion,strposologia) values ($codconsulta,$vademecum,'$observacionConsulta','$posologiaConsulta')";
			}else{
  				echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  				return(false);
  			}
		}else{
			if($upd=="t"){
				$sql_insertar="update tbltratamiento set strobservacion='$observacionConsulta', strposologia='$posologiaConsulta' where clvcodigo=$clvcodigo";
			}else{
  				echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  				return(false);
  			}
		}

		$sw_tratamiento=@pg_query($this->conexionbd(),$sql_insertar);
		if (@pg_affected_rows($sw_tratamiento)>0){
			echo "<script>alert('El registro ha sido exitoso...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		}

	}

	function mostrar_tratamiento($clvcodigo){
		$sql_mostrar="select clvcodigo, clvvademecum, strobservacion, strposologia from tbltratamiento where clvcodigo='".$clvcodigo."' and not blnborrado";
		return ($sql_mostrar);
	}

	function buscar_tratamiento($codconsulta){
		$sql_buscar="select t.clvcodigo, t.strobservacion, t.strposologia, v.strnombre_comercial from tbltratamiento as t, tblvademecum as v where t.clvconsulta=$codconsulta and t.clvvademecum=v.clvcodigo and not t.blnborrado";	
		return ($sql_buscar);
	}

	function eliminar_tratamiento($clvcodigo){
		$sql_eliminar="UPDATE tbltratamiento set blnborrado='t' where clvcodigo=$clvcodigo";
		$sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
		if (@pg_affected_rows($sw_eliminar)>0){
			echo "<script>alert('El registro ha sido eliminado con exito...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";
		}
	}
}
//**************************************************************************************************************************
class seguro{
 
 function conexionbd(){ 
  $objConexion = new conexion(); 
  $conex=$objConexion->conectar(); 
  return ($conex);  
 }
 
 function registrar_seguro($strnom_seguro,$strdir_seguro,$strtelf_uno,$strtelf_dos,$strtelf_tres,$strnom_contacto,$stremail_seguro,$strpag_web,$strnro_fax,$strrif,$codseguro){ 
    $sql_verificar="select clvcodigo from tblseguro where strnom_seguro='$strnom_seguro' and not blnborrado";
    $execute_seguro=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_seguro) == 0){ 
$sql_insertar="INSERT INTO tblseguro (strnom_seguro, strdir_seguro,strtelf_uno, 
strtelf_dos, strtelf_tres,strnom_contacto,
stremail_seguro,strpag_web,strnro_fax,strrif) 
values('$strnom_seguro','$strdir_seguro','$strtelf_uno','$strtelf_dos','$strtelf_tres','$strnom_contacto','$stremail_seguro','$strpag_web','$strnro_fax','$strrif')";
 }
$sw_seguro=@pg_query($this->conexionbd(),$sql_insertar);
if (@pg_affected_rows($sw_seguro)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin registrar_seguro

 function actualizar_seguro($codSeguro,$strnom_seguro,$strdir_seguro,$strtelf_uno,$strtelf_dos,$strtelf_tres,$strnom_contacto,$stremail_seguro,$strpag_web,$strnro_fax,$strrif){ 
    $sql_verificar="select clvcodigo from tblseguro where clvcodigo=$codSeguro and not blnborrado";
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_verificar_actualizar) > 0){ 
$sql_actualizar="UPDATE tblseguro SET strnom_seguro='$strnom_seguro',strdir_seguro='$strdir_seguro',strtelf_uno='$strtelf_uno',strtelf_dos='$strtelf_dos',strtelf_tres='$strtelf_tres',strnom_contacto='$strnom_contacto',strpag_web='$strpag_web',stremail_seguro='$stremail_seguro',strrif='$strrif',strnro_fax='$strnro_fax' where clvcodigo = $codSeguro and not blnborrado";
 }

$sw_seguro=@pg_query($this->conexionbd(),$sql_actualizar);
if (@pg_affected_rows($sw_seguro)>0){ 
   echo "<script>alert('El regisro ha actualizado  exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin actualizar_seguro


 function consultar_seguro(){ 
  $sql_buscar_seguro="select * from tblseguro where not blnborrado order by strnom_seguro"; 
  return ($sql_buscar_seguro); 
 }//fin consultar_seguro 

 function mostrar_seguro($codSeguro){ 
  $sql_mostrar_seguro="select * from tblseguro where clvcodigo = $codSeguro and not blnborrado";
  return ($sql_mostrar_seguro); 
 }//fin mostrar_seguro 
 
 function eliminar_seguro($codSeguro){ 
  $sql_eliminar="UPDATE tblseguro set blnborrado='t' where clvcodigo=$codSeguro";
 $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
  if (@pg_affected_rows($sw_eliminar)>0){ 
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>"; 
  }else{ 
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>"; 
  }  
 }//fin eliminar_seguro 
}


//***********************************************************************************************************************************************************
//***********************************************************************************************************************************************************
// Emperatriz
class consultorio{
 
 function conexionbd(){ 
  $objConexion = new conexion(); 
  $conex=$objConexion->conectar(); 
  return ($conex);  
 }
 
 function registrar_consultorio($strnom_consultorio,$strtelf_uno_consultorio,$strtelf_dos_consultorio,$strtelf_tres_consultorio,$strnom_responsable,$strpag_web,$stremail,$strnro_fax,$add){ 
    $sql_verificar="select clvcodigo from tblconsultorio where strnom_consultorio='$strnom_consultorio' and not blnborrado";
$execute_consultorio=@pg_query($this->conexionbd(),$sql_verificar);

if (@pg_num_rows($execute_consultorio) == 0){
	if($add=="t"){ 
		$sql_insertar="INSERT INTO tblconsultorio (strnom_consultorio, strtelf_uno_consultorio,strtelf_dos_consultorio, strtelf_tres_consultorio,strnom_responsable,strpag_web,stremail,strnro_fax) values('$strnom_consultorio','$strtelf_uno_consultorio','$strtelf_dos_consultorio','$strtelf_tres_consultorio','$strnom_responsable','$strpag_web','$stremail','$strnro_fax')";
	}else{
  		echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  		return(false);
  	}
 }
 
$sw_consultorio=@pg_query($this->conexionbd(),$sql_insertar);
if (@pg_affected_rows($sw_consultorio)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin registrar_consultorio

 function actualizar_consultorio($codConsultorio,$strnom_consultorio,$strtelf_uno_consultorio,$strtelf_dos_consultorio,$strtelf_tres_consultorio,$strnom_responsable,$strpag_web,$stremail,$strnro_fax,$upd){ 
    echo "class ".$upd;
 	$sql_verificar="select clvcodigo from tblconsultorio where clvcodigo=$codConsultorio and not blnborrado";
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_verificar_actualizar) > 0){
	if($upd=="t"){ 
		$sql_actualizar="UPDATE tblconsultorio SET strnom_consultorio='$strnom_consultorio',strtelf_uno_consultorio='$strtelf_uno_consultorio',strtelf_dos_consultorio='$strtelf_dos_consultorio',strtelf_tres_consultorio='$strtelf_tres_consultorio',strnom_responsable='$strnom_responsable',strpag_web='$strpag_web',stremail='$stremail',strnro_fax='$strnro_fax' where clvcodigo = $codConsultorio and not blnborrado";
	}else{
  		echo "<script>alert('Lo siento no tiene permiso para realizar esta operacion...')</script>";
  		return(false);
  	}
 }
$sw_consultorio=@pg_query($this->conexionbd(),$sql_actualizar);
if (@pg_affected_rows($sw_consultorio)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin actualizar_consultorio


 function consultar_consultorio(){ 
  $sql_buscar_consultorio="select clvcodigo, strnom_consultorio, strtelf_uno_consultorio, strnom_responsable from tblconsultorio where not blnborrado order by strnom_consultorio"; 
  return ($sql_buscar_consultorio); 
 }//fin consultar_consultorio 

 function mostrar_consultorio($codConsultorio){ 
  $sql_mostrar_consultorio="select * from tblconsultorio where clvcodigo = $codConsultorio and not blnborrado ";
  return ($sql_mostrar_consultorio); 
 }//fin mostrar_consultorio 
 
 function eliminar_consultorio($codConsultorio){ 
  $sql_eliminar="UPDATE tblconsultorio set blnborrado='t' where clvcodigo=$codConsultorio";
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
  if (@pg_affected_rows($sw_eliminar)>0){ 
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>"; 
  }else{ 
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>"; 
  }  
 }//fin eliminar_consultorio 
  
}//fin class consultorio
//**************************************************************************
//*************************cita*********************************************
class cita{
	
	function conexionbd(){ 
	  $objConexion = new conexion(); 
	  $conex=$objConexion->conectar(); 
	  return ($conex);  
	}
	
	function mostrar_inf_pac_cita($citapaciente){
		$sql_buscar="select clvcodigo, strpri_nom_paciente, strpri_apellido_paciente from tblpaciente where clvci_paciente = $citapaciente and not blnborrado";
		return($sql_buscar);	
	}
	
	function registrar_cita($modreg,$codpaciente,$medicocita,$nomconsultorio,$diad, $turno,$hora,$fcita,$codcita){
		if ($modreg==1){
			$sql_insertar="update tblcita set clvmedico=$medicocita, clvconsultorio=$nomconsultorio, clvdia=$diad, clvturno=$turno, strhora_cita='$hora', dtmfec_cita='$fcita' where clvcodigo=$codcita";
		}else{
			$sql_insertar="insert into tblcita (clvpaciente, clvmedico, clvconsultorio, clvdia, clvturno, strhora_cita, dtmfec_cita) values ($codpaciente,$medicocita,$nomconsultorio,$diad, $turno,'$hora','$fcita')";
		}


		$sw_cita=@pg_query($this->conexionbd(),$sql_insertar);
		if (@pg_affected_rows($sw_cita)>0){
			echo "<script>alert('El registro ha sido exitoso...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		}

	}
	
	function mostrar_cita($codpaciente){
		$sql_buscar="select c.clvcodigo as clvcodigo, c.clvpaciente as clvpaciente,m.strpri_nom_medico ||' '|| m.strpri_apellido_medico as nombre_medico,con.strnom_consultorio as nombre_consultorio,(select strdescripcion from tblmaestro where id_maestro = clvdia) as dia,(select strdescripcion from tblmaestro where id_maestro = clvturno) as turno,c.strhora_cita as hora, c.dtmfec_cita as fecha from tblcita as c, tblmedico as m,tblconsultorio as con where c.clvmedico = m.clvcodigo and c.clvconsultorio = con.clvcodigo and c.clvpaciente = $codpaciente and not c.blnborrado order by c.clvcodigo";
		return $sql_buscar;
	}
	
	function mostrar_inf_cita($codcita){
		$sql_buscar="select clvcodigo, clvpaciente, clvmedico, clvconsultorio, clvdia, clvturno, strhora_cita, dtmfec_cita  from tblcita where clvcodigo=$codcita and not blnborrado";
		return $sql_buscar;
	}
	
	function mostrar_hora_cita($nomconsultorio,$medicocita,$diad, $turno){
		$sql_mostrar="select strrhora from tblhorario_medico where clvconsultorio=$nomconsultorio and clvmedico=$medicocita and clvdia_semana=$diad and clvturno = $turno and not blnborrado";
		return ($sql_mostrar);
	}

	function eliminar_cita($codcita){ 
		$sql_eliminar="UPDATE tblcita set blnborrado='t' where clvcodigo=$codcita";
		$sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
		if (@pg_affected_rows($sw_eliminar)>0){ 
			echo "<script>alert('El registro ha sido eliminado con exito...')</script>"; 
		}else{ 
			echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>"; 
		}  
	}//fin eliminar_cita 
}
//**************************************************************************
//*****************************pago*****************************************
class pago{
	
	function conexionbd(){ 
	  $objConexion = new conexion(); 
	  $conex=$objConexion->conectar(); 
	  return ($conex);  
	}
	
	function registrar_pago($codconsulta,$cbobanco,$tipopago,$txtefectivo,$txtcheque,$txtmontocheque,$txttarjeta,$txtmontotarjeta,$cboseguro,$txtmontoseguro,$codconsultorio,$codmedico,$montototal){
		
		$valorSumar=$this->sumar_monto($codconsulta);
				
		if($txtefectivo){
			$varprueba=$txtefectivo;
			$sumatotal=$valorSumar->sumamonto+$txtefectivo; 
		}else if($txtmontocheque){
			$varprueba=$txtmontocheque;
			$sumatotal=$valorSumar->sumamonto+$txtmontocheque;
		}else if($txtmontotarjeta){
			$varprueba=$txtmontotarjeta;
			$sumatotal=$valorSumar->sumamonto+$txtmontotarjeta;
		}else if($txtmontoseguro){
			$varprueba=$txtmontoseguro;
			$sumatotal=$valorSumar->sumamonto+$txtmontoseguro;
		}

		if ($montototal >= $sumatotal){
			$saldop=$montototal-$sumatotal;
			if ($tipopago=="efe"){
				$sql_insertar="insert into tblpago_consulta (clvconsulta,clvbanco,strtipopago,strmonto) values ($codconsulta,0,'$tipopago','$txtefectivo')";
			}else if($tipopago=="che"){
				$sql_insertar="insert into tblpago_consulta (clvconsulta,clvbanco,strtipopago,strmonto,strnrotarche) values ($codconsulta,$cbobanco,'$tipopago','$txtmontocheque','$txtcheque')";
			}else if($tipopago=="tar"){
				$sql_insertar="insert into tblpago_consulta (clvconsulta,clvbanco,strtipopago,strmonto,strnrotarche) values ($codconsulta,$cbobanco,'$tipopago','$txtmontotarjeta','$txttarjeta')";
			}else if($tipopago=="seg"){
				$sql_insertar="insert into tblpago_consulta (clvconsulta,clvbanco,strtipopago,clvseguro,strmonto) values ($codconsulta,0,'$tipopago',$cboseguro,'$txtmontoseguro')";
			}
			
			$sw_pago=@pg_query($this->conexionbd(),$sql_insertar);
			$sql_insertar="update tblconsulta set dblsaldop=$saldop where clvcodigo=$codconsulta";
			$sw_updateconsulta=@pg_query($this->conexionbd(),$sql_insertar);
			if (@pg_affected_rows($sw_pago)>0){
				echo "<script>alert('El registro ha sido exitoso...')</script>";
			}else{
				echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
			}
		}else{
			echo "<script>alert('Error: El monto a cancelar es mayor al monto total...')</script>";
		}
	}
	
	function buscar_pago($codconsulta){
		$sql_buscar="select pc.clvcodigo as codigo,pc.strtipopago as tpago, pc.strmonto as monto, pc.strnrotarche as numero, m.strdescripcion as banco, s.strnom_seguro as seguro from tblpago_consulta as pc left join tblmaestro as m on pc.clvbanco = m.id_maestro left join tblseguro as s on pc.clvseguro = s.clvcodigo where pc.clvconsulta = $codconsulta and not pc.blnborrado";	
		return ($sql_buscar);
	}
	
	function eliminar_pago($codigo,$saldop,$codconsulta){ 
		$sql_buscarmonto="select strmonto from tblpago_consulta where clvcodigo=$codigo";
		$sw_buscarmonto=@pg_query($this->conexionbd(),$sql_buscarmonto);
		$valorBuscarmonto=@pg_fetch_object($sw_buscarmonto);
		$saldop=$valorBuscarmonto->strmonto + $saldop;						
					
		$sql_eliminar="UPDATE tblpago_consulta set blnborrado='t' where clvcodigo=$codigo";
		$sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
		if (@pg_affected_rows($sw_eliminar)>0){
			$sql_insertar="update tblconsulta set dblsaldop=$saldop where clvcodigo=$codconsulta";
			$sw_updateconsulta=@pg_query($this->conexionbd(),$sql_insertar);	
			echo "<script>alert('El registro ha sido eliminado con exito...')</script>"; 
		}else{ 
			echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>"; 
		}  
	}//fin eliminar_pago
	
	function mostrar_pago($codconsulta){
		$sql_buscar="select dblmonto from tblconfifuracion where clvconsulta = $codconsulta and not blnborrado";	
		return ($sql_buscar);
	}
	
	function mostrar_monto($codconsultorio,$codmedico){
		$sql_buscar="select dblmonto, dbliva from tblconfiguracion where clvmedico = $codmedico and clvconsultorio = $codconsultorio and not blnborrado";	
		return ($sql_buscar);
	}
	
	function registrar_montopago($codconsulta,$monto,$iva){
		$saldop=($monto*$iva)+$monto;
		$sql_insertar="update tblconsulta set dblmontot=$monto, dblsaldop=$saldop, blnmodificado=true where clvcodigo=$codconsulta";
		$sw_montopago=@pg_query($this->conexionbd(),$sql_insertar);
		if (@pg_affected_rows($sw_montopago)>0){
			echo "<script>alert('El monto ha sido modificado con exito...')</script>";
		}else{
			echo "<script>alert('Error: El monto no ha sido modificado...')</script>";
		}
	}
	
	function sumar_monto($codconsulta){
		$sql_sumar ="select sum(strmonto) as sumamonto from tblpago_consulta where clvconsulta=$codconsulta and not blnborrado";
		$sw_sumar=@pg_query($this->conexionbd(),$sql_sumar);
		$valorSumar=@pg_fetch_object($sw_sumar);
		return ($valorSumar);
	}
}
//**************************************************************************
class obtenerusuario{
	function conexionbd(){ 
	  $objConexion = new conexion(); 
	  $conex=$objConexion->conectar(); 
	  return ($conex);  
	}
	
	function buscarusuario($nombre){
		$sql_buscar="select strnombre from tblusuario where strlogin ='$nombre' and not blnborrado";
		return ($sql_buscar);
	}

	function buscarconus($con){
		$sql_buscar="select strnom_consultorio from tblconsultorio where clvcodigo = $con and not blnborrado";
		return ($sql_buscar);
	}
}
//**************************************************vademecum**********************************************
class vademecum{ 
  
function conexionbd(){  
  $objConexion = new conexion();  
  $conex=$objConexion->conectar();  
  return ($conex);   
 } 
  
 function registrar_vademecum($strnombre_generico,$strnombre_comercial,$id_laboratorio_maestro){  
    $sql_verificar="select clvcodigo from tblvademecum where strnombre_comercial='$strnombre_comercial' and not blnborrado"; 
$execute_vademecum=@pg_query($this->conexionbd(),$sql_verificar); 
 
if (@pg_num_rows($execute_vademecum) == 0){  
$sql_insertar="INSERT INTO tblvademecum (strnombre_generico,strnombre_comercial,id_laboratorio_maestro)  
values('$strnombre_generico','$strnombre_comercial',$id_laboratorio_maestro)"; 
 } 
  
$sw_vademecum=@pg_query($this->conexionbd(),$sql_insertar); 
if (@pg_affected_rows($sw_vademecum)>0){  
   echo "<script>alert('El regisro ha sido exitoso...')</script>";  
  }else{  
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>";  
  }  
 }//fin registrar_vademecum 
 
 function actualizar_vademecum($codVademecum,$strnombre_generico,$strnombre_comercial,$id_laboratorio_maestro){  
    $sql_verificar="select clvcodigo from tblvademecum where clvcodigo=$codVademecum and not blnborrado"; 
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar); 
if (@pg_num_rows($execute_verificar_actualizar) > 0){  
$sql_actualizar="UPDATE tblvademecum SET strnombre_generico='$strnombre_generico',strnombre_comercial='$strnombre_comercial',id_laboratorio_maestro=$id_laboratorio_maestro where clvcodigo=$codVademecum"; 
 } 
$sw_vademecum=@pg_query($this->conexionbd(),$sql_actualizar); 
if (@pg_affected_rows($sw_vademecum)>0){  
   echo "<script>alert('El regisro ha sido exitoso...')</script>";  
  }else{  
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>";  
  }  
 }//fin actualizar_vademecum 
 
 
 function consultar_vademecum(){  
  $sql_buscar_vademecum="select a.clvcodigo, a.strnombre_comercial, a.strnombre_generico, b.strdescripcion 
from tblvademecum a inner join tblmaestro b on a.id_laboratorio_maestro=b.id_maestro 
where not a.blnborrado
order by a.strnombre_comercial
";  
  return ($sql_buscar_vademecum);  
 }//fin consultar_vademecum  
 
 function mostrar_vademecum($codVademecum){  
  $sql_mostrar_vademecum="select * from tblvademecum where clvcodigo = $codVademecum and not blnborrado "; 
  return ($sql_mostrar_vademecum);  
 }//fin mostrar_vademecum  
  
 function eliminar_vademecum($codVademecum){  
  $sql_eliminar="UPDATE tblVademecum set blnborrado='t' where clvcodigo=$codVademecum"; 
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar); 
  if (@pg_affected_rows($sw_eliminar)>0){  
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>";  
  }else{  
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";  
  }   
 }//fin eliminar_vademecum  
   
}
//**************************************************************************
class presentacion{ 
  
function conexionbd(){  
  $objConexion = new conexion();  
  $conex=$objConexion->conectar();  
  return ($conex);   
 } 
  
function registrar_presentacion($codVademecum,$clvpresentacion_maestro,$intunidad_medida,$clvunidad_maestro){  
    $sql_verificar="select clvpresentacion from presentacion_vademecum where clvpresentacion_maestro=$clvpresentacion_maestro and  intvalor_unidad =$intunidad_medida and clvunidad_maestro=$clvunidad_maestro";
$execute_presentacion=@pg_query($this->conexionbd(),$sql_verificar); 
 
if (@pg_num_rows($execute_vademecum) == 0){  
$sql_insertar="INSERT INTO presentacion_vademecum (clvvademecum,clvpresentacion_maestro,intvalor_unidad,clvunidad_maestro)  
values($codVademecum,$clvpresentacion_maestro,$intunidad_medida,$clvunidad_maestro)"; 
 } 
$sw_presentacion=@pg_query($this->conexionbd(),$sql_insertar); 
if (@pg_affected_rows($sw_presentacion)>0){  
   echo "<script>alert('El regisro ha sido exitoso...')</script>";  
  }else{  
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>";  
  }  
 }//fin registrar_presentacion 
 
 function actualizar_presentacion($codPresentacion,$codVademecum,$clvpresentacion_maestro,$intunidad_medida,$clvunidad_maestro){  
    $sql_verificar="select clvpresentacion from presentacion_vademecum where clvpresentacion=$codPresentacion";
 $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar); 
if (@pg_num_rows($execute_verificar_actualizar) > 0){  
$sql_actualizar="UPDATE presentacion_vademecum SET clvvademecum=$codVademecum,clvpresentacion_maestro=$clvpresentacion_maestro,clvunidad_maestro=$clvunidad_maestro,intvalor_unidad=$intunidad_medida where clvpresentacion=$codPresentacion";
} 
$sw_presentacion=@pg_query($this->conexionbd(),$sql_actualizar); 
if (@pg_affected_rows($sw_presentacion)>0){  
   echo "<script>alert('El regisro ha sido exitoso...')</script>";  
  }else{  
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>";  
  } 
 }//fin actualizar_presentacion 
 
 function consultar_presentacion($codVademecum){  
  $sql_buscar_presentacion="select a.clvpresentacion, b.strdescripcion as presentacion, a.intvalor_unidad, c.strdescripcion as unidad
from presentacion_vademecum a inner join tblmaestro b on a.clvpresentacion_maestro=b.id_maestro 
inner join tblmaestro c on a.clvunidad_maestro=c.id_maestro 
where not a.blnborrado and clvvademecum=$codVademecum";  
  return ($sql_buscar_presentacion);  
 }//fin consultar_presentacion  
 
 function mostrar_presentacion($codPresentacion){  
  $sql_mostrar_presentacion="select * from presentacion_vademecum where clvpresentacion = $codPresentacion and not blnborrado "; 
  return ($sql_mostrar_presentacion);  
 }//fin mostrar_presentacion  
  
 function eliminar_presentacion($codPresentacion){  
  $sql_eliminar="UPDATE presentacion_vademecum set blnborrado='t' where clvpresentacion=$codPresentacion"; 
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar); 
  if (@pg_affected_rows($sw_eliminar)>0){  
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>";  
  }else{  
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";  
  }  
 }//fin eliminar_presentacion  
   
}

class configuracion{  
   
function conexionbd(){   
  $objConexion = new conexion();   
  $conex=$objConexion->conectar();   
  return ($conex);    
 }  
   
function registrar_configuracion($codConsultorio,$codMedico,$dblmonto,$dbliva){   
    $sql_verificar="select clvcodigo from tblconfiguracion where clvconsultorio=$codConsultorio and  clvmedico=$codMedico and not blnborrado"; 
    $execute_configuracion=@pg_query($this->conexionbd(),$sql_verificar);  
 if (@pg_num_rows($execute_configuracion) == 0){   
$sql_insertar="INSERT INTO tblconfiguracion (clvConsultorio,clvMedico,dblmonto,dbliva)   
values($codConsultorio,$codMedico,$dblmonto,$dbliva)"; } 
$sw_configuracion=@pg_query($this->conexionbd(),$sql_insertar);  
if (@pg_affected_rows($sw_configuracion)>0){   
   echo "<script>alert('El regisro ha sido exitoso...')</script>";   
  }else{   
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>";   
  }   
 }//fin registrar_configuracion  
  
 function actualizar_configuracion($clvcodigo,$codConsultorio,$codMedico,$dblmonto,$dbliva){   
    $sql_verificar="select clvcodigo from tblconfiguracion where clvcodigo=$clvcodigo"; 
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar);  
if (@pg_num_rows($execute_verificar_actualizar) > 0){   
$sql_actualizar="UPDATE tblconfiguracion SET clvConsultorio=$codConsultorio,clvmedico=$codMedico,dblmonto=$dblmonto,dbliva=$dbliva where clvcodigo=$clvcodigo"; 
}  
$sw_configuracion=@pg_query($this->conexionbd(),$sql_actualizar);  
if (@pg_affected_rows($sw_configuracion)>0){   
   echo "<script>alert('El regisro ha sido exitoso...')</script>";   
  }else{   
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>";   
  }  
 }//fin actualizar_configuracion  
  
 function consultar_configuracion($codConsultorio){   
 $sql_buscar_configuracion="select a.*, b.strnom_consultorio as consultorio, 'Dr.(a) '||c.strpri_nom_medico ||' '|| c.strseg_nom_medico  ||' '|| c.strpri_apellido_medico ||'  '|| c.strseg_apellido_medico as strnombre, ((dblmonto * dbliva) + dblmonto) as total
from TBLCONFIGURACION a inner join tblconsultorio b on a.clvconsultorio=b.clvcodigo
inner join tblmedico c on a.clvmedico=c.clvcodigo where a.clvconsultorio=$codConsultorio and not a.blnborrado";  
return ($sql_buscar_configuracion);   
 }//fin consultar_configuracion   
  
 function mostrar_configuracion($codConfiguracion){   
  $sql_mostrar_configuracion="select * from tblconfiguracion where clvcodigo = $codConfiguracion and not blnborrado ";  
  return ($sql_mostrar_configuracion);   
 }//fin mostrar_configuracion   
   
 function eliminar_configuracion($codConfiguracion){   
  $sql_eliminar="UPDATE tblconfiguracion set blnborrado='t' where clvcodigo=$codConfiguracion";  
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);  
  if (@pg_affected_rows($sw_eliminar)>0){   
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>";   
  }else{   
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>";   
  }   
 }//fin eliminar_configuracion   
    
} 
//**********************************pdf*********************************************************************
class crearpdf{
		function conexionbd(){   
		  $objConexion = new conexion();   
		  $conex=$objConexion->conectar();   
		  return ($conex);    
		}
		
function buscarpacientepdf($codPac){
			$sql_buscar="select clvci_paciente as cedula, strpri_nom_paciente||' '||strseg_nom_paciente||' '||strpri_apellido_paciente||' '||strseg_apellido_paciente as nombre from tblpaciente where clvcodigo=$codPac";
			$sw_bppdf=@pg_query($this->conexionbd(),$sql_buscar);
			$valorbppdf=@pg_fetch_object($sw_bppdf);
			return($valorbppdf);
		}
		
		function buscartratamientopdf($codconsulta){
			$sql_buscar="select strobservacion as observacion, strposologia as tratamiento from tbltratamiento where clvconsulta = $codconsulta";
			$sw_btpdf=@pg_query($this->conexionbd(),$sql_buscar);
			$valorbtpdf=@pg_fetch_object($sw_btpdf);
			return($valorbtpdf);
		}
		function buscarmedicopdf($codmedico){
			$sql_buscar="select strpri_nom_medico ||' '||strpri_nom_medico||' '||strseg_apellido_medico||' '||strseg_apellido_medico as nombre, clvci_medico as cedula, strnro_colegio_medico as nrocolegio from tblmedico where clvcodigo=$codmedico and not blnborrado";
			$sw_bmpdf=@pg_query($this->conexionbd(),$sql_buscar);
			$valorbmpdf=@pg_fetch_object($sw_bmpdf);
			return($valorbmpdf);
		}
		function buscarhistoriapdf($cedulareporte){
			$sql_buscar="select a.clvci_paciente,''||a.strpri_nom_paciente ||' '|| a.strseg_nom_paciente  ||' '|| a.strpri_apellido_paciente ||'  '|| a.strseg_apellido_paciente as strnombre,
a.strsexo_paciente, a.strdir_paciente,a.strtelf_hab_paciente,a.strtelf_celular_paciente,
a.strtelf_trab_paciente,a.stremail_paciente,a.strnom_padre_paciente,a.strnom_madre_paciente,
a.strantecedentes_paciente,b.strdescripcion as religion,a.dtmfec_nac_paciente,a.strocupacion_paciente,
a.clvnro_hijos,a. blnin_fuma,a.blnin_bebe_alcohol,a.strtipo_sangre,c.strdescripcion as civil
,a.stralergias_paciente,d.strnom_consultorio,e.strdescripcion as nacionalidad, 'Dr.(a) '||f.strpri_nom_medico ||' '|| f.strseg_nom_medico  ||' '|| f.strpri_apellido_medico ||'  '||f.strseg_apellido_medico as medico 
,a.strrererido,a.strobservaciones,a.strfoto
from tblpaciente a 
left join tblmaestro b on a.clvid_religion_maestro=b.id_maestro
left join tblmaestro c on a.clvedocivil=c.id_maestro
left join tblconsultorio d on a.clvconsultorio=d.clvcodigo
left  join tblmaestro e on a.clvnacionalidad=e.id_maestro
left  join tblmedico f on a.clvmedico=f.clvcodigo
where a.clvci_paciente=$cedulareporte and not a.blnborrado";
			$sw_bhpdf=@pg_query($this->conexionbd(),$sql_buscar);
			$valorbhpdf=@pg_fetch_object($sw_bhpdf);
			return($valorbhpdf);
		}
function buscarconsultoriopdf($codConsultorio){
			$sql_buscar="select * from tblconsultorio where clvcodigo=$codConsultorio and not blnborrado";
			$sw_bcpdf=@pg_query($this->conexionbd(),$sql_buscar);
			$valorbcpdf=@pg_fetch_object($sw_bcpdf);
			return($valorbcpdf);
		}

}
//*******************************************reporte**************************************************************
class reporte{
		function conexionbd(){   
		  $objConexion = new conexion();   
		  $conex=$objConexion->conectar();   
		  return ($conex);    
		}
		
		function buscarreporte($cedulareporte){
			$sql_buscar="select pa.clvcodigo as codigo, con.clvcodigo as codconsulta , con.strdes_motivo_consulta as motivo, con.dtmfecharegistro as fecha, con.clvmedico as codmedico from tblpaciente as pa, tblconsulta as con where pa.clvcodigo=con.clvpaciente and pa.clvci_paciente= $cedulareporte and not pa.blnborrado and not con.blnborrado";
			return ($sql_buscar); 
		}
}
//********************************************maestro***************************************************************
class maestro{
 
 function conexionbd(){ 
  $objConexion = new conexion(); 
  $conex=$objConexion->conectar(); 
  return ($conex);  
 }
 
function registrar_maestro($id_padre_maestro,$strdescripcion){ 
    $sql_verificar="select id_maestro from tblmaestro where strdescripcion='$strdescripcion' and id_padre_maestro=$id_padre_maestro and not  blnborrado";
  $execute_maestro=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_maestro) == 0){ 
$sql_insertar="INSERT INTO tblmaestro (id_padre_maestro, strdescripcion) values($id_padre_maestro,'$strdescripcion')";
 }
echo $sql_insertar;
$sw_maestro=@pg_query($this->conexionbd(),$sql_insertar);
if (@pg_affected_rows($sw_maestro)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin registrar_maestro

 function actualizar_maestro($codMaestro,$id_padre_maestro,$strdescripcion){ 
    $sql_verificar="select id_maestro from tblmaestro where id_maestro=$codMaestro and not blnborrado";
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_verificar_actualizar) > 0){ 
$sql_actualizar="UPDATE tblmaestro SET id_padre_maestro=$id_padre_maestro,strdescripcion='$strdescripcion' where id_maestro=$codMaestro and not blnborrado";
 }
$sw_maestro=@pg_query($this->conexionbd(),$sql_actualizar);
if (@pg_affected_rows($sw_maestro)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin actualizar_maestro


 function consultar_maestro($id_padre_maestro){ 
  $sql_buscar_maestro="select b.strdescripcion as padres,a.strdescripcion,a.id_maestro 
from tblmaestro a inner join tblmaestro b on a.id_padre_maestro=b.id_maestro
where a.id_padre_maestro= $id_padre_maestro and not a.blnborrado order by a.strdescripcion"; 
 return ($sql_buscar_maestro); 
 }//fin consultar_maestro 

 function mostrar_maestro($id_maestro){ 
  $sql_mostrar_maestro="select * from tblmaestro where id_maestro = $id_maestro and not blnborrado ";
  return ($sql_mostrar_maestro); 
 }//fin mostrar_maestro 
 
 function eliminar_maestro($id_maestro){ 
  $sql_eliminar="UPDATE tblmaestro set blnborrado='t' where id_maestro=$id_maestro";
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
  if (@pg_affected_rows($sw_eliminar)>0){ 
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>"; 
  }else{ 
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>"; 
  }  
 }//fin eliminar_maestro 
  
}//fin class maestro
//************************************************************************************************************
