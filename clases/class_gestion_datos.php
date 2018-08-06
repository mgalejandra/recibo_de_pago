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
class recibopago {
 
 function conexionbd($ano){ 
//echo "aa".$ano;
  $objConexion = new conexion(); 
  $conex=$objConexion->conectar(); 
  return ($conex);  
 }
 
 function buscar_recibo_pago($ciusuario, $codnom,$fecdesper,$fechasper){
		$newfecdes=explode("/",$fecdesper);
 		$newfechas=explode("/",$fechasper);
	 	$fecdesper=$newfecdes[2]."-".$newfecdes[1]."-".$newfecdes[0];
		$fechasper=$newfechas[2]."-".$newfechas[1]."-".$newfechas[0];	 
		
 	$sql="SELECT DISTINCT 
sno_personal.codper, 
MAX(sno_personal.cedper) as cedper, 
max(sno_personal.nomper) as nomper, 
MAX(sno_personal.apeper) as apeper, 
MAX(sno_personal.nacper) as nacper, 
MAX(sno_hpersonalnomina.codcueban) AS codcueban, 
MAX(sno_hpersonalnomina.tipcuebanper) as tipcuebanper, 
MAX(sno_personal.fecleypen) AS fecleypen, 
MAX(sno_personal.fecingper) as fecingper, 
MAX(sno_personal.fecegrper) as fecegrper, 
MAX(sno_personal.rifper) as rifper, 
sum(sno_hsalida.valsal) as total, 
MAX(sno_personal.coreleper) AS coreleper,
MAX(sno_hunidadadmin.desuniadm) as desuniadm, 
MAX(sno_hpersonalnomina.fecingper) AS fecingnom, 
MAX(sno_hpersonalnomina.fecculcontr) AS fecculcontr, 
MAX(sno_hunidadadmin.minorguniadm) as minorguniadm, 
MAX(sno_hunidadadmin.ofiuniadm) AS ofiuniadm, 
MAX(sno_hunidadadmin.uniuniadm) AS uniuniadm, 
MAX(sno_hunidadadmin.depuniadm) as depuniadm, 
MAX(sno_hunidadadmin.prouniadm) AS prouniadm, 
MAX(sno_hpersonalnomina.sueper) AS sueper, 
MAX(sno_hpersonalnomina.pagbanper) AS pagbanper, 
MAX(sno_hpersonalnomina.pagefeper) AS pagefeper, 
MAX(sno_ubicacionfisica.desubifis) AS desubifis, 
 MAX((SELECT MAX(desnom) FROM sno_hnomina  where sno_hpersonalnomina.codnom = sno_hnomina.codnom)) as desnom,
MAX(sno_hnomina.racnom) AS racnom, 
sno_personal.codorg, 
MAX(sno_hnomina.adenom) AS adenom, 
MAX(sno_hpersonalnomina.sueintper) AS sueintper, 
MAX(sno_hpersonalnomina.codcar) AS codcar, 
MAX(sno_hpersonalnomina.codasicar) AS codasicar, 
MAX((SELECT desest FROM sigesp_estados WHERE sigesp_estados.codpai = sno_ubicacionfisica.codpai AND sigesp_estados.codest = sno_ubicacionfisica.codest)) AS desest, 
MAX((SELECT tipnom FROM sno_hnomina WHERE sno_hpersonalnomina.codnom = sno_hnomina.codnom AND sno_hpersonalnomina.codemp = sno_hnomina.codemp AND sno_hpersonalnomina.anocur=sno_hnomina.anocurnom AND sno_hpersonalnomina.codperi=sno_hnomina.peractnom)) AS tiponom, 
MAX((SELECT suemin FROM sno_hclasificacionobrero WHERE sno_hclasificacionobrero.codnom = sno_hpersonalnomina.codnom AND sno_hclasificacionobrero.grado = sno_hpersonalnomina.grado AND sno_hclasificacionobrero.codemp = sno_hpersonalnomina.codemp AND sno_hclasificacionobrero.codperi = sno_hpersonalnomina.codperi AND sno_hclasificacionobrero.anocur = sno_hpersonalnomina.anocur)) AS sueobr, 
MAX((SELECT denmun FROM sigesp_municipio WHERE sigesp_municipio.codpai = sno_ubicacionfisica.codpai AND sigesp_municipio.codest = sno_ubicacionfisica.codest AND sigesp_municipio.codmun = sno_ubicacionfisica.codmun)) AS denmun, 
MAX((SELECT denpar FROM sigesp_parroquia WHERE sigesp_parroquia.codpai = sno_ubicacionfisica.codpai AND sigesp_parroquia.codest = sno_ubicacionfisica.codest AND sigesp_parroquia.codmun = sno_ubicacionfisica.codmun AND sigesp_parroquia.codpar = sno_ubicacionfisica.codpar)) AS denpar, 
MAX((SELECT nomban FROM scb_banco WHERE scb_banco.codemp = sno_hpersonalnomina.codemp AND scb_banco.codban = sno_hpersonalnomina.codban)) AS banco, 
MAX((SELECT MAX(nomage) FROM scb_agencias WHERE scb_agencias.codemp = sno_hpersonalnomina.codemp AND scb_agencias.codban = sno_hpersonalnomina.codban AND scb_agencias.codage = sno_hpersonalnomina.codage)) AS agencia, 
MAX((SELECT MAX(denasicar) FROM sno_hasignacioncargo WHERE sno_hpersonalnomina.codemp = sno_hasignacioncargo.codemp AND sno_hpersonalnomina.codnom = sno_hasignacioncargo.codnom AND sno_hpersonalnomina.anocur = sno_hasignacioncargo.anocur AND sno_hpersonalnomina.codasicar = sno_hasignacioncargo.codasicar)) as denasicar, 
MAX((SELECT MAX(denasicar) FROM sno_hasignacioncargo WHERE sno_hpersonalnomina.codemp = sno_hasignacioncargo.codemp AND sno_hpersonalnomina.codnom = sno_hasignacioncargo.codnom AND sno_hpersonalnomina.anocur = sno_hasignacioncargo.anocur AND sno_hpersonalnomina.codasicar = sno_hasignacioncargo.codasicar AND sno_hpersonalnomina.codperi = sno_hasignacioncargo.codperi)) as descar, 
sno_hnomina.codnom, 
MAX((SELECT sno_categoria_rango.descat FROM sno_rango, sno_categoria_rango WHERE sno_rango.codemp=sno_personal.codemp AND sno_rango.codcom=sno_personal.codcom AND sno_rango.codran=sno_personal.codran AND sno_categoria_rango.codcat=sno_rango.codcat)) AS descat FROM sno_personal, 
sno_hpersonalnomina, 
sno_hsalida, 
sno_hunidadadmin, 
sno_ubicacionfisica, 
sno_hnomina, 
sno_hperiodo 
WHERE 
sno_hsalida.codemp='0001' 
AND (sno_hsalida.tipsal<>'P2' AND sno_hsalida.tipsal<>'V4' AND sno_hsalida.tipsal<>'W4' ) 
AND sno_hperiodo.fecdesper>='$fecdesper' 
AND sno_hperiodo.fechasper<='$fechasper'
AND sno_hpersonalnomina.codnom<>'000'  
AND sno_hpersonalnomina.codper>='$ciusuario' 
AND sno_hpersonalnomina.codper<='$ciusuario' 
AND sno_hpersonalnomina.codsubnom<='1' 
AND (sno_hsalida.tipsal='A' OR sno_hsalida.tipsal='V1' OR sno_hsalida.tipsal='W1' OR sno_hsalida.tipsal='D' OR sno_hsalida.tipsal='V2' OR sno_hsalida.tipsal='W2' OR sno_hsalida.tipsal='P1' OR sno_hsalida.tipsal='V3' OR sno_hsalida.tipsal='W3') 
AND sno_hpersonalnomina.codemp = sno_hnomina.codemp 
AND sno_hpersonalnomina.codnom = sno_hnomina.codnom 
AND sno_hpersonalnomina.anocur = sno_hnomina.anocurnom 
AND sno_hpersonalnomina.codperi = sno_hnomina.peractnom 
AND sno_hnomina.codemp = sno_hperiodo.codemp 
AND sno_hnomina.codnom = sno_hperiodo.codnom 
AND sno_hnomina.anocurnom = sno_hperiodo.anocur 
AND sno_hnomina.peractnom = sno_hperiodo.codperi 
AND sno_hpersonalnomina.codemp = sno_personal.codemp 
AND sno_hpersonalnomina.codper = sno_personal.codper 
AND sno_hpersonalnomina.codemp = sno_ubicacionfisica.codemp 
AND sno_hpersonalnomina.codubifis = sno_ubicacionfisica.codubifis 
AND sno_hpersonalnomina.codemp = sno_hsalida.codemp 
AND sno_hpersonalnomina.codnom = sno_hsalida.codnom 
AND sno_hpersonalnomina.anocur = sno_hsalida.anocur 
AND sno_hpersonalnomina.codperi = sno_hsalida.codperi 
AND sno_hpersonalnomina.codper = sno_hsalida.codper 
AND sno_hpersonalnomina.codemp = sno_hunidadadmin.codemp 
AND sno_hpersonalnomina.anocur = sno_hunidadadmin.anocur 
AND sno_hpersonalnomina.codperi = sno_hunidadadmin.codperi 
AND sno_hpersonalnomina.minorguniadm = sno_hunidadadmin.minorguniadm 
AND sno_hpersonalnomina.ofiuniadm = sno_hunidadadmin.ofiuniadm 
AND sno_hpersonalnomina.uniuniadm = sno_hunidadadmin.uniuniadm 
AND sno_hpersonalnomina.depuniadm = sno_hunidadadmin.depuniadm 
AND sno_hpersonalnomina.prouniadm = sno_hunidadadmin.prouniadm 
GROUP BY 
sno_hpersonalnomina.codemp, 
sno_hpersonalnomina.codnom, 
sno_hnomina.codnom, 
sno_personal.codper, 
sno_hpersonalnomina.codcar, 
sno_hpersonalnomina.codasicar, 
sno_hpersonalnomina.anocur,
sno_hpersonalnomina.codban, 
sno_personal.codorg";
//echo $sql; 	 
 	return($sql);
 }
 
function buscar_conceptos($ciusuario, $codnom, $codperi,$fecdesper,$fechasper){
			$newfecdes=explode("/",$fecdesper);
 		$newfechas=explode("/",$fechasper);
	 	$fecdesper=$newfecdes[2]."-".$newfecdes[1]."-".$newfecdes[0];
		$fechasper=$newfechas[2]."-".$newfechas[1]."-".$newfechas[0];
	$sql="SELECT 
sno_hconcepto.codconc, 
sno_hconcepto.codperi, 
MAX(sno_hconcepto.titcon) as nomcon, 
SUM(sno_hsalida.valsal) AS valsal, 
MAX(sno_hsalida.tipsal) AS tipsal, 
0 AS acuemp, 
0 AS acupat , 
MAX(sno_hconcepto.repacucon) as repacucon, 
MAX(sno_hconcepto.repconsunicon) AS repconsunicon, 
MAX(sno_hconcepto.consunicon) AS consunicon, 
SUM(sno_hsalida.monacusal) AS monacusal, 
(SELECT SUM(moncon) FROM sno_hconstantepersonal WHERE sno_hconcepto.repconsunicon='1' AND sno_hconstantepersonal.codper = '$ciusuario' AND sno_hconstantepersonal.codemp = sno_hconcepto.codemp AND sno_hconstantepersonal.codnom = sno_hconcepto.codnom AND sno_hconstantepersonal.anocur = sno_hconcepto.anocur AND sno_hconstantepersonal.codperi = sno_hconcepto.codperi AND sno_hconstantepersonal.codcons = sno_hconcepto.consunicon ) AS unidad FROM sno_hsalida, 
sno_hconcepto, 
sno_hperiodo 
WHERE sno_hsalida.codemp='0001' 
AND sno_hsalida.codper='$ciusuario' 
AND sno_hperiodo.fecdesper>='$fecdesper' 
AND sno_hperiodo.fechasper<='$fechasper' 
AND sno_hsalida.codnom<>'000'   
AND sno_hsalida.valsal<>0 
AND (sno_hsalida.tipsal='A' OR sno_hsalida.tipsal='V1' OR sno_hsalida.tipsal='W1' OR sno_hsalida.tipsal='D' OR sno_hsalida.tipsal='V2' OR sno_hsalida.tipsal='W2' OR sno_hsalida.tipsal='P1' OR sno_hsalida.tipsal='V3' OR sno_hsalida.tipsal='W3') 
AND sno_hsalida.codemp = sno_hconcepto.codemp 
AND sno_hsalida.codnom = sno_hconcepto.codnom 
AND sno_hsalida.anocur = sno_hconcepto.anocur 
AND sno_hsalida.codperi = sno_hconcepto.codperi 
AND sno_hsalida.codconc = sno_hconcepto.codconc 
AND sno_hsalida.codemp = sno_hperiodo.codemp 
AND sno_hsalida.codnom = sno_hperiodo.codnom 
AND sno_hsalida.anocur = sno_hperiodo.anocur 
AND sno_hsalida.codperi = sno_hperiodo.codperi 
GROUP BY 
sno_hconcepto.codemp, 
sno_hconcepto.codnom, 
sno_hconcepto.codconc, 
sno_hsalida.tipsal, 
sno_hconcepto.anocur, 
sno_hconcepto.codperi, 
sno_hconcepto.consunicon,
sno_hconcepto.repconsunicon 
UNION 
SELECT 
sno_hconcepto.codconc,
 '' as codperi, 
 MAX(sno_hconcepto.titcon) as nomcon, 
 0 AS valsal, 
 MAX(sno_hsalida.tipsal) AS tipsal, 
 MAX(abs(sno_hconceptopersonal.acuemp)) AS acuemp, 
 MAX(abs(sno_hconceptopersonal.acupat)) AS acupat , 
 MAX(sno_hconcepto.repacucon) as repacucon,
 MAX(sno_hconcepto.repconsunicon) AS repconsunicon , 
 MAX(sno_hconcepto.consunicon) AS consunicon, 
 0 AS unidad, 
 0 AS monacusal 
 FROM 
 sno_hsalida, 
 sno_hconcepto, 
 sno_hperiodo, 
 sno_hconceptopersonal 
 WHERE 
 sno_hsalida.codemp='0001' 
 AND sno_hsalida.codper='$ciusuario' 
 AND sno_hperiodo.fecdesper>='$fecdesper' 
 AND sno_hperiodo.fechasper<='$fechasper' 
 AND sno_hsalida.codnom<>'000'  
 AND sno_hsalida.valsal<>0 
 AND (sno_hsalida.tipsal='A' OR sno_hsalida.tipsal='V1' OR sno_hsalida.tipsal='W1' OR sno_hsalida.tipsal='D' OR sno_hsalida.tipsal='V2' OR sno_hsalida.tipsal='W2' OR sno_hsalida.tipsal='P1' OR sno_hsalida.tipsal='V3' OR sno_hsalida.tipsal='W3') 
 AND sno_hsalida.codemp = sno_hconcepto.codemp 
 AND sno_hsalida.codnom = sno_hconcepto.codnom 
 AND sno_hsalida.anocur = sno_hconcepto.anocur 
 AND sno_hsalida.codperi = sno_hconcepto.codperi 
 AND sno_hsalida.codconc = sno_hconcepto.codconc 
 AND sno_hsalida.codemp = sno_hperiodo.codemp 
 AND sno_hsalida.codnom = sno_hperiodo.codnom 
 AND sno_hsalida.anocur = sno_hperiodo.anocur 
 AND sno_hsalida.codperi = sno_hperiodo.codperi 
 AND sno_hsalida.codemp = sno_hconceptopersonal.codemp 
 AND sno_hsalida.codnom = sno_hconceptopersonal.codnom 
 AND sno_hsalida.anocur = sno_hconceptopersonal.anocur 
 AND sno_hsalida.codperi = sno_hconceptopersonal.codperi 
 AND sno_hsalida.codconc = sno_hconceptopersonal.codconc 
 AND sno_hsalida.codper = sno_hconceptopersonal.codper 
 and sno_hconcepto.codperi = '$codperi' 
 GROUP BY 
 sno_hconcepto.codemp, 
 sno_hconcepto.codnom, 
 sno_hconcepto.codconc 
 ORDER BY 
 codconc";
//echo $sql;
return($sql);

}
function buscar_nomina($ciusuario){
	$sql="select codnom from sno_personalnomina where codper='$ciusuario' order by codnom asc";
//echo $sql;
	return($sql);
}

function buscar_periodo($codnom){
	$sql="SELECT sno_hperiodo.anocur as anocur,sno_hperiodo.codnom as codnom, sno_hperiodo.codperi as codperi, sno_hperiodo.fecdesper as fecdesper, sno_hperiodo.fechasper as fechasper FROM sno_hperiodo INNER JOIN sno_periodo ON sno_periodo.cerper = 1 AND sno_hperiodo.codemp = sno_periodo.codemp AND sno_hperiodo.codnom = sno_periodo.codnom AND sno_hperiodo.codperi = sno_periodo.codperi WHERE sno_hperiodo.codemp = '0001' AND sno_hperiodo.codnom<> '000' AND sno_hperiodo.codperi <> '000' order by sno_periodo.codperi";
//echo $sql;
	return($sql);
}

}//fin class recibopago

class usuario_inder {

 function conexionbd2(){ 
  $objConexion2 = new conexion2(); 
  $conex2=$objConexion2->conectar2(); 
  return ($conex2);  
 }
	
	function validar_usuario($usuario){
		$sql="select strdocumento from tbl_usuario where strlogin='$usuario'";
		//echo $sql;
		return ($sql);
		
	}

}//class usuario_inder
