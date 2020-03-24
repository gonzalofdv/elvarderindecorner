<?php

require_once('PreguntaTransfer.php');
require_once('PreguntaSA.php');
require_once('RespuestaTransfer.php');
require_once('RespuestaSA.php');

$preg = $_POST['preg'];
$codLiga = $_POST['liga'];
$v = $_POST['v'];
$f1 = $_POST['f1'];
$f2 = $_POST['f2'];
$condi = $_POST['condi'];

if(!empty($preg)) && (!empty($codLiga)) && (!empty($v)) && (!empty($f1)) && (!empty($f2)) && (!empty($condi))){
	if($codLiga != 0){
		$p = new PreguntaTransfer($preg, $codLiga);
		$preguntaSA = new PreguntaSA();
		$anadido = $preguntaSA->newPregunta($p);

		if($anadido){
			//ahora tocaria cargar las respuestas
			//primero obtenemos el id de la pregunta que acabamos de añadir
			//y con ese id podemos completar la informacion de las respuestas

			//obtenemos el id
			$idP = $preguntaSA->obtenerID($p);
			//hemos obtenido el id
			//ahora creamos los 3 transfer respuestas
			$r1 = new RespuestaTransfer($idP, $v, '1'); //1=correcta
			$r2 = new RespuestaTransfer($idP, $f1, '0'); //0=falsa
			$r3 = new RespuestaTransfer($idP, $f2, '0');

			//ahora insertamos las 3 respuestas
			$respuestaSA = new RespuestaSA();
			$respuestaSA->insertRespuesta($r1);
			$respuestaSA->insertRespuesta($r2);
			$respuestaSA->insertRespuesta($r3);

			//ya hemos insertado todo, ahora mostramos mensaje y volvemos al a pagina
			echo "Nueva pregunta insertada a la BBDD correctamente, gracias por colaborar<br> Redireccionando en 3 segundos...";
			header("refresh:3; url=index.php")

		}
		else{
			//Error de algun fallo introduciendo la pregunta
		}
	}
	else{
		//Mandar error de que hay que seleccionar una liga
		echo "Debes seleccionar una liga! <br>";
		echo "Redireccionando...";
		header("refresh:3; url=formularioPreguntaRespuesta.php");
	}
}
else{
	//Mandar error de que faltan campos por rellenar
	echo "Faltan campos por rellenar! <br>";
	echo "Redireccionando...";
	header("refresh:3; url=formularioPreguntaRespuesta.php");
}