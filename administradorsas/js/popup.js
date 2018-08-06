// JavaScript Document

function mostrar() {
 $("#pop").fadeIn('fast');
} //checkHover

$(document).ready(function (){

//Conseguir valores de la img
 var img_w = $("#pop img").width() + 0;
 var img_h = $("#pop img").height() + 0;

 //Darle el alto y ancho
 $("#pop").css('width', img_w + 'px');
 $("#pop").css('height', img_h + 'px');

 //Esconder el popup
 $("#pop").hide();

 //Consigue valores de la ventana del navegador
 var w = $(this).width();
 var h = $(this).height();

 //Centra el popup
 w = (w/2) - (img_w/1.5);
 h = (h/2) - (img_h/1.0);
 $("#pop").css("left",w + "px");
 $("#pop").css("top",h + "px");
 
 //temporizador, para que no aparezca de golpe
 setTimeout("mostrar()",500);

 //Función para cerrar el popup
 $("#pop").click(function (){
 $(this).fadeOut('slow');
 });

 });
