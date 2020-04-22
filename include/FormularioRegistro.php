<?php
require_once('sa/UsuarioSA.php');
require_once('transfer/UsuarioTransfer.php');
require_once ('Form.php');

class FormularioRegistro extends Form {

	public function __construct(){}

	protected function procesaFormulario($datos){
		$result = array();

		$nombre = isset($datos['nom']) ? $datos['nom'] : null;
		if(empty($nombre)){
			$result[] = "El nombre no puede estar vacío";
		}

		$apellido1 = isset($datos['apellido1']) ? $datos['apellido1'] : null;
		if(empty($apellido1)){
			$result[] = "El apellido1 no puede estar vacío";
		}

		$apellido2 = isset($datos['apellido2']) ? $datos['apellido2'] : null;
		if(empty($apellido2)){
			$result[] = "El apellido2 no puede estar vacío";
		}

		$sexo = isset($datos['sexo']) ? $datos['sexo'] : null;
		if(empty($sexo)){
			$result[] = "El sexo no puede estar vacío";
		}

		$equipo = isset($datos['equipo']) ? $datos['equipo'] : null;
		if(empty($equipo)){
			$result[] = "El equipo no puede estar vacío";
		}

		$nombreUsuario = isset($datos['usu']) ? $datos['usu'] : null;
		if(empty($nombreUsuario)){
			$result[] = "El nombre de usuario no puede estar vacío";
		}

		$contrasena = isset($datos['contrasena']) ? $datos['contrasena'] : null;
		if(empty($contrasena)){
			$result[] = "La contrasena no puede estar vacía";
		}

		$contrasenaRep = isset($datos['rContrasena']) ? $datos['rContrasena'] : null;
		if(empty($contrasenaRep)){
			$result[] = "La contrasena repetida no puede estar vacía";
		}

		$mail = isset($datos['mail']) ? $datos['mail'] : null;
		if(empty($mail)){
			$result[] = "El e-mail no puede estar vacío";
		}

		$condi = isset($datos['condi']) ? $datos['condi'] : null;
		if(empty($condi)){
			$result[] = "Hay que marcar la condicion no puede estar vacío";
		}

		if(count($result) === 0){
			if($contrasena==$contrasenaRep){
				$p = new UsuarioTransfer($nombre, $apellido1, $apellido2, $sexo, $equipo, $nombreUsuario, $contrasena, $mail, 0, 0, 0);
				$usuarioSA = new UsuarioSA();
				$anadido = $usuarioSA ->newUsuario($p);
				if($anadido){
					$result = 'mostrarAlertas.php?codAlerta=8';
				}
				else{
					$result = 'mostrarAlertas.php?codAlerta=9';
				}
			}
			else{
				//$result = 'mostrarAlertas.php?codAlerta=10';
				$result[] = "Las contraseñas no coinciden";
			}
		}

		return $result;
	}

	protected function generaCamposFormulario($datosIniciales){

		
		$nombre = '';
		$apellido1 = '';
		$apellido2 = '';
		$sexo = '';
		$equipo = '';
		$usu = '';
		$mail = '';
		$condi = '';

		if($datosIniciales) {
			$nombre = isset($datosIniciales['nom']) ? $datosIniciales['nom'] : $usuario;
			$apellido1 = isset($datosIniciales['apellido1']) ? $datosIniciales['apellido1'] : $apellido1;
			$apellido2 = isset($datosIniciales['apellido2']) ? $datosIniciales['apellido2'] : $apellido2;
			$sexo = isset($datosIniciales['sexo']) ? $datosIniciales['sexo'] : $sexo;
			$equipo = isset($datosIniciales['equipo']) ? $datosIniciales['equipo'] : $equipo;
			$usu = isset($datosIniciales['usu']) ? $datosIniciales['usu'] : $usu;
			$mail = isset($datosIniciales['mail']) ? $datosIniciales['mail'] : $mail;
			$condi = isset($datosIniciales['condi']) ? $datosIniciales['condi'] : $condi;
		}

		$html = <<<EOF
		<legend>Registro Usuario</legend>
		Nombre:<br> <input type="text" name="nom" value="$nombre"><br>
		Apellido1:<br> <input type="text" name="apellido1" value="$apellido1"><br>
		Apellido2:<br> <input type="text" name="apellido2" value="$apellido2"><br>
		Sexo:<br/>
		<input type="radio" name="sexo" value="hombre" checked/> Hombre
		<input type="radio" name="sexo" value="mujer" /> Mujer<br>
		Equipo favorito: <br> <input type="text" name="equipo" value="$equipo"><br>
		Nombre de usuario:<br> <input type="text" name="usu" value="$usu"><br>
		Contraseña:<br/>
		<input type="password" name="contrasena" value="" /><br>
		Repetir contraseña:<br>
		<input type="password" name="rContrasena" value="" /><br>
		E-mail:<br> <input type="text" name="mail" value="$mail"><br>
		<input type="checkbox" name="condi" value="ok">Acepto las condiciones del servicio<br>
		<input type="submit" name="aceptar">
		EOF;	
		
		return $html;
	}

}


?>