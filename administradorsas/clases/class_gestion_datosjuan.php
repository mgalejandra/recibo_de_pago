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
 function combo1($cadsql,$nombre,$seleccion){
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
 function registrar_medico($cimedico,$pnombre,$snombre,$papellido,$sapellido,$tprincipal,$tcelular,$beeper,$especialidad,$nrocolegiado,$fnacimiento,$emailm){
    $sql_verificar="select clvcodigo from tblmedico where clvci_medico=$cimedico and not blnborrado";
    $execute_medico=@pg_query($this->conexionbd(),$sql_verificar);

  if (@pg_num_rows($execute_medico) > 0){
    $sql_insertar="UPDATE tblmedico set clvci_medico=$cimedico, strpri_nom_medico='$pnombre', strseg_nom_medico='$snombre', strpri_apellido_medico='$papellido', strseg_apellido_medico='$sapellido', strtelf_personal='$tprincipal', strtelf_celular='$tcelular', strbeeper_medico='$beeper', clvid_especialidad_maestro=$especialidad, strnro_colegio_medico='$nrocolegiado', dtmfec_nac_medico='$fnacimiento', stremail_medico='$emailm', clvconsultorio=1 where clvci_medico=$cimedico";
  }else{
   // $sql_insertar="INSERT INTO tblmedico (clvci_medico,strpri_nom_medico,strseg_nom_medico,strpri_apellido_medico,strseg_apellido_medico,strtelf_personal,strtelf_celular,strbeeper_medico,clvid_especialidad_maestro,strnro_colegio_medico,dtmfec_nac_medico,stremail_medico,clvconsultorio) values ($cimedico,'$pnombre','$snombre','$papellido','$sapellido','$tprincipal','$tcelular','$beeper',$especialidad,'$nrocolegiado','$fnacimiento','$emailm',1)";
  }

  $sw_medico=@pg_query($this->conexionbd(),$sql_insertar);
  if (@pg_affected_rows($sw_medico)>0){
   echo "<script>alert('El registro ha sido exitoso...')</script>";
  }else{
   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
  }
 }//fin registrar_medico

 function consultar_medico(){
  $sql_buscar_medico="select clvcodigo, strpri_nom_medico, strpri_apellido_medico, strtelf_personal, strtelf_celular from tblmedico where not blnborrado order by clvci_medico";
  return ($sql_buscar_medico);
 }//fin consultar_medico

 function mostrar_medico($a){
  $sql_mostrar_medico="select clvci_medico, strpri_nom_medico, strseg_nom_medico, strpri_apellido_medico, strseg_apellido_medico, strtelf_personal, strtelf_celular, strbeeper_medico, clvid_especialidad_maestro, strnro_colegio_medico, dtmfec_nac_medico, stremail_medico from tblmedico where clvcodigo = $a and not blnborrado ";
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
	$sql_buscar="select clvcodigo, clvci_paciente, strpri_nom_paciente, strseg_nom_paciente, strpri_apellido_paciente, strseg_apellido_paciente, strsexo_paciente, strdir_paciente, strtelf_hab_paciente, strtelf_celular_paciente, strtelf_trab_paciente, stremail_paciente, strnom_padre_paciente, blnstatus_padre_paciente, strnom_madre_paciente, blnstatus_madre_paciente, strantecedentes_paciente, stralergias_paciente, clvid_religion_maestro, dtmfec_nac_paciente, strocupacion_paciente, clvnro_hijos, blnin_fuma, blnin_bebe_alcohol, strtipo_sangre, clvedocivil from tblpaciente where clvci_paciente=$cipaciente";

	return ($sql_buscar);
 }


 function registrar_paciente($cipaciente,$pnombrepac,$snombrepac,$papellidopac,$sapellidopac,$sexopac,$edocivil,$direccionpac,$thabitacionpac,$tcelularpac,$ttrabajopac,$emailpac,$nmadre,$esmadre,$npadre,$espadre,$antecedentespac,$alergiaspac,$religion,$ocupacion,$fnacimientopac,$nrohijopac,$fumapaciente,$bebepaciente,$frhpaciente){
    
	$sql_verificar="select clvcodigo from tblpaciente where clvci_paciente=$cipaciente and not blnborrado";
	$execute_verificar=@pg_query($this->conexionbd(),$sql_verificar);

  if (@pg_num_rows($execute_verificar) == 0){
    	$sql_insertar="insert into tblpaciente (clvci_paciente,strpri_nom_paciente,strseg_nom_paciente,strpri_apellido_paciente,strseg_apellido_paciente,strsexo_paciente,strdir_paciente,strtelf_hab_paciente,strtelf_celular_paciente,strtelf_trab_paciente,stremail_paciente,strnom_padre_paciente,blnstatus_padre_paciente,strnom_madre_paciente,blnstatus_madre_paciente,strantecedentes_paciente,stralergias_paciente,clvid_religion_maestro,dtmfec_nac_paciente,strocupacion_paciente,clvnro_hijos,blnin_fuma,blnin_bebe_alcohol,strtipo_sangre,clvedocivil) values ($cipaciente,'$pnombrepac','$snombrepac','$papellidopac','$sapellidopac','$sexopac','$direccionpac','$thabitacionpac','$tcelularpac','$ttrabajopac','$emailpac','$npadre','$espadre','$nmadre','$esmadre','$antecedentespac','$alergiaspac',$religion,'$fnacimientopac','$ocupacion',$nrohijopac,'$fumapaciente','$bebepaciente','$frhpaciente',$edocivil)";

  }else{
	$sql_insertar="update tblpaciente set strpri_nom_paciente='$pnombrepac', strseg_nom_paciente='$snombrepac', strpri_apellido_paciente='$papellidopac', strseg_apellido_paciente='$sapellidopac', strsexo_paciente='$sexopac', strdir_paciente='$direccionpac', strtelf_hab_paciente='$thabitacionpac', strtelf_celular_paciente='$tcelularpac', strtelf_trab_paciente='$ttrabajopac',stremail_paciente='$emailpac', strnom_padre_paciente='$npadre', blnstatus_padre_paciente='$espadre', strnom_madre_paciente='$nmadre', blnstatus_madre_paciente='$esmadre', strantecedentes_paciente='$antecedentespac', stralergias_paciente='$alergiaspac', clvid_religion_maestro=$religion, dtmfec_nac_paciente='$fnacimientopac', strocupacion_paciente='$ocupacion', clvnro_hijos=$nrohijopac, blnin_fuma='$fumapaciente', blnin_bebe_alcohol='$bebepaciente', strtipo_sangre='$frhpaciente', clvedocivil=$edocivil";
  }

  $sw_paciente=@pg_query($this->conexionbd(),$sql_insertar);
  if (@pg_affected_rows($sw_paciente)>0){
   echo "<script>alert('El registro ha sido exitoso...')</script>";
  }else{
   echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
  }
 }//fin registrar_paciente
}//fin paciente
//******************************************************************************************************************************
class consulta extends paciente{
	
	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}	
	
	function buscar_motivo($codPac){
		$sql_buscar="select clvcodigo, strdes_motivo_consulta, strdes_sintoma from tblconsulta where clvpaciente=$codPac and not blnborrado";
		return ($sql_buscar);
	}
	
	function mostrar_consulta($codconsulta){
		$sql_buscar="select clvcodigo, clvmedico,strpeso_paciente,strfrecuencia_cardiaca, strfrecuencia_respiratoria, strdes_motivo_consulta, strdes_sintoma from tblconsulta where clvcodigo=$codconsulta and not blnborrado";
		return ($sql_buscar);
	}

	function registrar_consulta($codPac,$nombremed,$pesopac,$frecuenciacar,$frecuenciares,$motivoconsulta,$sintomas,$codconsulta){
		$sql_buscar="select clvcodigo from tblconsulta where clvcodigo = $codconsulta and not blnborrado";
		$sw_buscar=@pg_query($this->conexionbd(),$sql_buscar);
		if($pesopac=='')
			$pesopac=0;
		if($frecuenciacar=='')
			$frecuenciacar=0;
		if($frecuenciares=='')
			$frecuenciares=0;
		if(@pg_num_rows($sw_buscar) == 0){
			$sql_insertar="insert into tblconsulta values ($codPac,$nombremed,$pesopac,$frecuenciacar,$frecuenciares,'$motivoconsulta','$sintomas')";
		}else{
			$sql_insertar="update tblconsulta set clvmedico=$nombremed, strpeso_paciente=$pesopac, strfrecuencia_cardiaca=$frecuenciacar, strfrecuencia_respiratoria=$frecuenciares,strdes_motivo_consulta='$motivoconsulta', strdes_sintoma='$sintomas' where clvcodigo = $codconsulta";
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
}
//******************************************************************************************************
class examen {

	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}
	
	function registrar_examen($dexamen,$nexamen,$codPac,$codconsulta,$codexamen){
		$sql_buscar="select clvcodigo from tblexamen where clvcodigo=$codexamen and not blnborrado";
		$rsBuscar=@pg_query($this->conexionbd(),$sql_buscar);
		if (@pg_num_rows($rsBuscar) == 0){
			$sql_insertar="insert into tblexamen (strdes_examen, clvmaestro,clvpaciente, clvconsulta) values ('$dexamen',$nexamen,$codPac,$codconsulta)";
		}else{
			$sql_insertar="update tblexamen set strdes_examen='$dexamen' where clvcodigo=$codexamen";
		}	
		$sw_examen=@pg_query($this->conexionbd(),$sql_insertar);

		if (@pg_affected_rows($sw_examen)>0){
			echo "<script>alert('El registro ha sido exitoso...')</script>";
		}else{
			echo "<script>alert('Error: El registro no ha sido exitoso...')</script>";
		}		
	}

	function buscar_examen($codconsulta){
		$sql_buscar="select ex.clvcodigo as clvcodigo, ex.clvmaestro as codmaestro, ma.strdescripcion as descripcion, ex.strdes_examen as descripexamen from tblexamen ex, tblmaestro ma where ex.clvconsulta=$codconsulta and ex.clvmaestro=ma.id_maestro and not ex.blnborrado";
		return ($sql_buscar);
	}
	
	function mostrar_examen($codexamen){
		$sql_mostrar="select clvcodigo, clvmaestro, strdes_examen from tblexamen where clvcodigo=$codexamen and not blnborrado";
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
	}
}
//**********************************************************************************************************
class diagnosticoConsulta {

	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}	
	
	function registrar_diagnostico_consulta($dediagnosticocon, $codconsulta,$clvcodigo,$nomdiagnostico){
		
		$sql_buscar="select clvcodigo from tbldiagnostico_consulta where clvcodigo=$clvcodigo and not blnborrado";
		$rsBuscar=@pg_query($this->conexionbd(),$sql_buscar);
		
		if (@pg_num_rows($rsBuscar) == 0){
			$sql_insertar="insert into tbldiagnostico_consulta (clvconsulta,clvmaestro,strobservaciones) values ($codconsulta,$nomdiagnostico,'$dediagnosticocon')";
		}else{
			$sql_insertar="update tbldiagnostico_consulta set strobservaciones='$dediagnosticocon' where clvcodigo=$clvcodigo";
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
	
	function registrar_tratamiento($codconsulta,$vademecum,$observacionConsulta,$posologiaConsulta, $clvcodigo){
		$sql_buscar="select clvcodigo from tbltratamiento where clvcodigo=$clvcodigo and not blnborrado";
		$rsBuscar=@pg_query($this->conexionbd(),$sql_buscar);
		
		if (@pg_num_rows($rsBuscar) == 0){
			$sql_insertar="insert into tbltratamiento (clvconsulta,clvvademecum,strobservacion,strposologia) values ($codconsulta,$vademecum,'$observacionConsulta','$posologiaConsulta')";
		}else{
			$sql_insertar="update tbltratamiento set strobservacion='$observacionConsulta', strposologia='$posologiaConsulta' where clvcodigo=$clvcodigo";
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
/*class seguro {
	
	function conexionbd(){
  		$objConexion = new conexion();
		$conex=$objConexion->conectar();
		return ($conex); 
	}

	function guardar_seguro(){

	}
}*/
//***********************************************************************************************************************************************************
//***********************************************************************************************************************************************************
// Emperatriz
class consultorio{
 
 function conexionbd(){ 
  $objConexion = new conexion(); 
  $conex=$objConexion->conectar(); 
  return ($conex);  
 }
 
 function registrar_consultorio($strnom_consultorio,$strtelf_uno_consultorio,$strtelf_dos_consultorio,$strtelf_tres_consultorio,$strnom_responsable,$strpag_web,$stremail,$strnro_fax){ 
    $sql_verificar="select clvcodigo from tblconsultorio where strnom_consultorio='$strnom_consultorio' and not blnborrado";
    $execute_consultorio=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_consultorio) == 0){ 
$sql_insertar="INSERT INTO tblconsultorio (strnom_consultorio, strtelf_uno_consultorio, 
strtelf_dos_consultorio, strtelf_tres_consultorio,strnom_responsable,
strpag_web,stremail,strnro_fax) 
values('$strnom_consultorio','$strtelf_uno_consultorio','$strtelf_dos_consultorio','$strtelf_tres_consultorio','$strnom_responsable','$strpag_web','$stremail','$strnro_fax')";
 }
$sw_consultorio=@pg_query($this->conexionbd(),$sql_insertar);
if (@pg_affected_rows($sw_consultorio)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin registrar_consultorio

 function actualizar_consultorio($codConsultorio,$strnom_consultorio,$strtelf_uno_consultorio,$strtelf_dos_consultorio,$strtelf_tres_consultorio,$strnom_responsable,$strpag_web,$stremail,$strnro_fax){ 
    $sql_verificar="select clvcodigo from tblconsultorio where clvcodigo=$codConsultorio and not blnborrado";
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_verificar_actualizar) > 0){ 
$sql_actualizar="UPDATE tblconsultorio SET strnom_consultorio='$strnom_consultorio',strtelf_uno_consultorio='$strtelf_uno_consultorio',strtelf_dos_consultorio='$strtelf_dos_consultorio',strtelf_tres_consultorio='$strtelf_tres_consultorio',strnom_responsable='$strnom_responsable',strpag_web='$strpag_web',stremail='$stremail',strnro_fax='$strnro_fax' where clvcodigo = $codConsultorio and not blnborrado";
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
