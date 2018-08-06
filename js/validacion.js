// JavaScript Document

function check(k,name){
		if(k.value.length==0){
			alert("Lo Siento... " + name +" no puede estar en blanco");
			k.focus();
			return false;
		}else{
			return true;
		}
}

function checkCombo(c,name){
		if(c.value==0 || c.value=="NULL" || c.value==""){
			alert("Lo siento... debe indicar "+ name+ " para poder continuar");
			c.focus();
			return false;
		}else{
			return true;
		}
	}


function validacion_recibo(){
	
		 boolokay=false;

		 if (confirm("�Esta seguro que desea continuar con el registro?")){
		  	
			//if(check(document.form.codper, 'Cedula'))
			boolokay=true;
			if(boolokay){
			  document.form.action='reporte.php?buscar=1';
			  document.form.submit();
			}
			
		 }	
	
}