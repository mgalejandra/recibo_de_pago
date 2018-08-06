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

//************************************************************************************************************
//***********************************************usuario******************************************************
class usuario{
  
 function conexionbd(){ 
  $objConexion = new conexion(); 
  $conex=$objConexion->conectar(); 
  return ($conex);  
 }
 
function registrar_usuario($login,$cedula,$contrasena,$nombre,$apellido,$estatus,$cclave){ 
    if($estatus==""){
    	$estatus="false";
    }
	if($cclave==""){
    	$cclave="false";
    }
    $sql_buscar_fecha="select current_date as fecha";
    $rs_buscar_fecha=@pg_query($this->conexionbd(),$sql_buscar_fecha);
    $valorfecha = pg_fetch_object($rs_buscar_fecha);
    $fecharegistro=$valorfecha->fecha; 
    $correo=$login."@inder.gob.ve";
    $contrasena=md5($contrasena);
    
    
    $sql_insertar="INSERT INTO tbl_ares_usuario (str_nombreusuario,str_cedula,str_contrasena,str_nombre,str_apellido,str_correo,dtm_fechacreacion,bol_estado,str_idsede, bol_cambiar_clave) values('$login','$cedula','$contrasena','$nombre','$apellido','$correo','$fecharegistro','$estatus','0002','$cclave')";
    $rs_insertar_usuario=pg_query($this->conexionbd(),$sql_insertar);
	    $sql_buscar_id="select last_value from tbl_ares_usuario_seq_idusuario_seq";
		$rs_buscar_id=pg_query($this->conexionbd(),$sql_buscar_id);
	    $valorid = pg_fetch_object($rs_buscar_id);
	    $lastregistro=$valorid->last_value;
			if($lastregistro){
				$sql_insertar_sistema1="insert into tbl_ares_usuario_sistema (int_idusuario,int_idsistema,dtm_fecha_agregacion) values ($lastregistro,5,'$fecharegistro')";
				$rs_insertar_sistema1=@pg_query($this->conexionbd(),$sql_insertar_sistema1);
				$sql_insertar_sistema2="insert into tbl_ares_usuario_sistema (int_idusuario,int_idsistema,dtm_fecha_agregacion) values ($lastregistro,8,'$fecharegistro')";
				$rs_insertar_sistema2=@pg_query($this->conexionbd(),$sql_insertar_sistema2);
					if ((@pg_affected_rows($rs_insertar_sistema1)>0) && (@pg_affected_rows($rs_insertar_sistema2)>0)){ 
				   		echo "<script>alert('Permiso al sistema listo')</script>"; 
				  	}else{ 
				   		echo "<script>alert('Error: No se otorgo permiso al sistema...')</script>"; 
				  	}
				$mascara='1111000000000000';
				$sql_insertar_permiso="insert into tbl_ares_permiso_usuario (int_idfuncionalidad,int_idusuario,str_mascara,bol_visible) values (173,$lastregistro,'$mascara',true)";
				$rs_insertar_permiso=@pg_query($this->conexionbd(),$sql_insertar_permiso);
				$sql_insertar_permiso1="insert into tbl_ares_permiso_usuario (int_idfuncionalidad,int_idusuario,str_mascara,bol_visible) values (174,$lastregistro,'$mascara',true)";
				$rs_insertar_permiso1=@pg_query($this->conexionbd(),$sql_insertar_permiso1);
				$sql_insertar_permiso2="insert into tbl_ares_permiso_usuario (int_idfuncionalidad,int_idusuario,str_mascara,bol_visible) values (175,$lastregistro,'$mascara',true)";
				$rs_insertar_permiso2=@pg_query($this->conexionbd(),$sql_insertar_permiso2);
				$sql_insertar_permiso3="insert into tbl_ares_permiso_usuario (int_idfuncionalidad,int_idusuario,str_mascara,bol_visible) values (228,$lastregistro,'$mascara',true)";
				$rs_insertar_permiso3=@pg_query($this->conexionbd(),$sql_insertar_permiso3);
					if ((@pg_affected_rows($rs_insertar_permiso)>0) && (@pg_affected_rows($rs_insertar_permiso1)>0) && (@pg_affected_rows($rs_insertar_permiso2)>0) && (@pg_affected_rows($rs_insertar_permiso3)>0)){ 
				   		echo "<script>alert(192.168.0.246'Permiso a los modulos listo')</script>"; 
				  	}else{ 
				   		echo "<script>alert('Error: No se otorgo permiso a los modulos...')</script>"; 
				  	}
				$sql_insertar_miembro="insert into tbl_ares_miembros_grupo (int_idgrupo,int_idusuario) values (22,$lastregistro)";
				$rs_insertar_miembro=@pg_query($this->conexionbd(),$sql_insertar_miembro);
				$sql_insertar_miembro1="insert into tbl_ares_miembros_grupo (int_idgrupo,int_idusuario) values (46,$lastregistro)";
				$rs_insertar_miembro1=@pg_query($this->conexionbd(),$sql_insertar_miembro1);
					if ((@pg_affected_rows($rs_insertar_miembro)>0) && (@pg_affected_rows($rs_insertar_miembro1)>0)){ 
				   		echo "<script>alert('Ya es miembro de los grupos')</script>"; 
				  	}else{ 
				   		echo "<script>alert('Error: No es miembro de los grupos...')</script>"; 
				  	}
			}else{
				echo "<script>alert('Error al insertar el usuario')</script>"; 
			}
		

 }//fin registrar_usuario

 function actualizar_usuario($codUsuario,$strlogin,$strclave,$strnombre,$strcedula,$strapellido,$strcorreo){ 
    $sql_verificar="select clvcodigo from tblusuario where clvcodigo=$codUsuario and not blnborrado";
    $execute_verificar_actualizar=@pg_query($this->conexionbd(),$sql_verificar);
if (@pg_num_rows($execute_verificar_actualizar) > 0){ 
$sql_actualizar="UPDATE tblusuario SET strlogin='$strlogin',strclave='$strclave',strnombre='$strnombre',strcedula='$strcedula',strapellido='$strapellido',strcorreo='$strcorreo' where clvcodigo=$codUsuario and not blnborrado";
 }
$sw_usuario=@pg_query($this->conexionbd(),$sql_actualizar);
if (@pg_affected_rows($sw_usuario)>0){ 
   echo "<script>alert('El regisro ha sido exitoso...')</script>"; 
  }else{ 
   echo "<script>alert('Error: No ha sido exitoso el registro...')</script>"; 
  } 
 }//fin actualizar_usuario


 function consultar_usuario($login){ 
  $sql_buscar_usuario="select str_nombreusuario as login, seq_idusuario as id from tbl_ares_usuario where str_nombreusuario='$login' and bol_estado=true";
 return ($sql_buscar_usuario); 
 }//fin consultar_usuario 

 function consultar_usuario_cedula($strcedula){ 
  $sql_buscar_usuario="SELECT tblusuario.*,tblmaestro.strdescripcion FROM tblusuario LEFT OUTER JOIN tblusuario_consultorio 
ON (tblusuario.clvcodigo=tblusuario_consultorio.clvusuario)LEFT OUTER JOIN tblmaestro 
ON (tblmaestro.id_maestro=tblusuario_consultorio.clvgrupo) where tblusuario.strcedula='$strcedula' and not tblusuario.blnborrado"; 
return ($sql_buscar_usuario); 
 }//fin consultar_usuario 

 function mostrar_usuario($codUsuario){ 
  $sql_mostrar_usuario="select * from tblusuario where clvcodigo = $codUsuario and not blnborrado ";  
 return ($sql_mostrar_usuario); 
 }//fin mostrar_usuario 
 
 function eliminar_usuario($codUsuario){ 
  $sql_eliminar="UPDATE tblusuario set blnborrado='t' where clvcodigo=$codUsuario";
  $sw_eliminar=@pg_query($this->conexionbd(),$sql_eliminar);
  if (@pg_affected_rows($sw_eliminar)>0){ 
   echo "<script>alert('El registro ha sido eliminado con exito...')</script>"; 
  }else{ 
   echo "<script>alert('Error: El registro no ha sido eliminado con exito...')</script>"; 
  }  
 }//fin eliminar_usuario 

  
}//fin class usuario
//************************************************************************************************************
