<?php session_start(); 

require_once('PreguntaSA.php');
require_once('RespuestaSA.php');
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
	<meta charset="utf-8">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<title>Registro Pregunta</title>
</head>
<body>
	<?php
		require("cabecera.php");
	?>
	<div id="contenido">
	<br>

		<?php
			if(!isset($_SESSION["login"]) || $_SESSION["login"] == false) {
				echo "<h1>Acceso denegado!</h1>";
				echo "<p>Para entrar a esta página es necesario que hayas iniciado sesión, si no tienes cuenta, ¡regístrate!.</p>";
				echo "<p>Te redireccionamos a la página de inicio.</p>";
				header("refresh:5; url=index.php");
			}
			else {
				if($_SESSION["esAdmin"] == false && $_SESSION["esFamilia"] == false){
					echo "<h1>Permisos insuficientes</h1>";
					echo "<p>Para poder introducir una nueva pregunta para el Quiz necesitas ser un Administrador o tener los privilegios de usuario Somos Familia que podrás conseguir colaborando en nuestra página. Infórmate más en la sección Somos Familia.</p>";
					echo "<p>Te redireccionamos a la página de inicio.</p>";
					header("refresh:5; url=index.php");
				}
				else{
		?>

			<form action="procesarQuiz.php" method="post">
			<fieldset>
				<legend>Bienvenido al Quiz!</legend>
				<?php
					$preguntaSA=new PreguntaSA();
					$respuestaSA=new RespuestaSA();
					$num=$preguntaSA->getNumPreguntas();
					$valores=array();
					$i=0;
					while($i<10){
						$rand =rand(1,$num);
						if(!in_array($rand,$valores)){
							array_push($valores,$rand);
							$pregunta=$preguntaSA->getPregunta($rand);
							$respuestas=$respuestaSA->getRespuestas($rand);
							echo $pregunta->Pregunta . "<br>";
							while($res=mysqli_fetch_array($respuestas)){
								echo '<input type=radio name=res'.$i.' value='.$res[3].' />'.$res[2]. '<br>';
								echo "<br>";
							}
							$i++;	
						}
					}
				?>
					<input type="submit" name="aceptar">	
			</fieldset>
			</form>
			<?php

				}
			}

			?>

	</div>
	<?php
		require("sidebarDer.php");
		require("pie.php");
	?>
</body>
</html>