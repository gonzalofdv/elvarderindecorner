<?php
require_once('include/transfer/NoticiaTransfer.php');
require_once('include/sa/NoticiaSA.php');
require_once('include/sa/UsuarioSA.php');
require_once('include/transfer/UsuarioTransfer.php');
require('include/sa/LigaSA.php');
require_once __DIR__.'/Form.php';

class FormularioNoticia extends Form {

	public function __construct(){}

	protected function procesaFormulario($datos){
		$result = array();
		$directorio = './img/noticias/';  

		$titular = isset($datos['titular']) ? htmlspecialchars($datos['titular']) : null;
		$cuerpo = isset($datos['cuerpo']) ? nl2br($datos['cuerpo']) : null;
		$condi = isset($datos['condi']) ? htmlspecialchars($datos['condi']) : null;
		$codLiga = isset($datos['liga']) ? htmlspecialchars($datos['liga']) : null;
		$nombreUsu = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : null;
		$foto = isset($_FILES['imagen']['name']) ? htmlspecialchars($_FILES['imagen']['name']) : null; 
		move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$foto);

		if((!empty($titular)) && (!empty($cuerpo)) && (!empty($condi)) && (!empty($foto))){
			if($codLiga != 0){
				

				$usuarioSA = new UsuarioSA();
				$consulta = $usuarioSA->obtenerId($nombreUsu); 	
				$codUsuario = $consulta->IdUsuario;
				$n = new NoticiaTransfer($codUsuario, $codLiga, $cuerpo, $titular, $foto,0,0,0);
				
				$noticiaSA = new NoticiaSA();
				$anadido = $noticiaSA->insertNoticia($n);
				
				if($anadido){
					$usuarioSA->sumarPuntos($codUsuario,5);
					
					$result = 'correcto';
				}
				else{
					$result="fallo";
				}
			}
		}
		else{
			//Mandar error de que faltan campos por rellenar
			$result[] = "Faltan campos por rellenar";
		}

	 	return $result;
	}

	protected function generaCamposFormulario($datosIniciales){

		$titular = '';
		$cuerpo = 'Escribe aqui la noticia que quieres agregar.';
		$codLiga = 0;
		$valueLiga = "Ligas:";

		if($datosIniciales) {
			$titular = isset($datosIniciales['titular']) ? $datosIniciales['titular'] : $titular;
			$cuerpo = isset($datosIniciales['cuerpo']) ? $datosIniciales['cuerpo'] : $cuerpo;
			$codLiga = isset($datosIniciales['liga']) ? $datosIniciales['liga'] : $codLiga;
			if($codLiga != 0){
				$ligasa = new LigaSA();
				$valueLiga = $ligasa->getNombreLiga($codLiga)->Nombre;
			}
			else{
				$valueLiga = "Ligas:";
			}
		}
	
		$html = '';
        $html .= '<legend>Nueva Noticia</legend>';
        $html .= '<div class="formulario">';
        $html .= '<br> <input type="text" name="titular" placeholder="Titular:" value="'.$titular.'"><br>';
        $html .= '<textarea name="cuerpo" rows="10" cols="40">'.$cuerpo.'</textarea><br>';
		$html .= '<div class="caja">';
        $html .= '<select name="liga">';
        $html .= '<option value="'.$codLiga.'">'.$valueLiga.'</option>';
            $ligasa=new LigaSA();
            $res=$ligasa->devuelveLigaSA();
            while($valores = mysqli_fetch_array($res)){
                $html .= '<option value=' . $valores[0] . '> ' . $valores[1] . '</option>';
            }
        $html .='</select>';
		$html .= '</div>';
        $html .='<br>';
        $html .='<input id="imagen" type="file" name="imagen" /><br>';
        $html .='<input type="checkbox" name="condi" value="ok"><label>Confirmar enviar noticia.</label><br>';
        $html .='<button type="submit" class="botonEnviar" name="aceptar">Enviar</button>';
        $html .='</div>';

		return $html;
	}

}


?>