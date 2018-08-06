$(document).ready(function(){
	
	$("#capa").mouseenter(function(){
		$("#informacion").css("display","block");
		
	});
	
	$("#capa").mouseleave(function(){
		$("#informacion").css("display","none");
		
	});
	
	/*$('#error').dialog({
		autoOpen: false,
		width: 300,
		buttons: {
			"Ok": function() { 
				$(this).dialog("close"); 
			}
		}
	});*/
	
	$('#error').dialog({
        bgiframe: true,
        autoOpen: false,
        width: 100,
        height: 100,
        modal: true,
        position: 'top'
    });

	
	$("#saveForm").click(function(){
		
		//if($("#element_1").val()=="false"){
			$('#error').show('slow');
		//}
		
	});
	
});