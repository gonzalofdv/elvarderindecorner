<?php
require_once './include/transfer/NoticiaTransfer.php'; 
require_once('DAO.php');

class NoticiaDAO extends DAO{

	public function getNoticia($idNoticia) {
		$db = $this->db;
		$idNoticia= mysqli_real_escape_string($db,$idNoticia);

		$sql = "SELECT * from noticias where IdNoticia = '$idNoticia'";
		$consulta = mysqli_query($db, $sql);
        if($consulta){
            $obj = $consulta->fetch_object();
        }
        if(!$obj){
        	$n = "Noticia no encontrada";
        	return $n;
        }
		else{
			$n = new NoticiaTransfer($obj->CodUsuario, $obj->CodLiga, $obj->Titular, $obj->Texto, $obj->Foto, $obj->NotaNoticia, $obj->NumVotos, $obj->Votada);
			return $n;
		}
	}
	
	public function insert(NoticiaTransfer $n){
		$db = $this->db;
		
		$codUsuario = $n->getCodUsuario();
		$codUsuario= mysqli_real_escape_string($db,$codUsuario);
		$codLiga = $n->getCodLiga();
		$codLiga= mysqli_real_escape_string($db,$codLiga);
		$texto = $n->getTexto();
		$texto= mysqli_real_escape_string($db,$texto);
		$titular = $n->getTitular();
		$titular= mysqli_real_escape_string($db,$titular);
		$foto = $n->getFoto();
		$foto= mysqli_real_escape_string($db,$foto);

		$sql = "INSERT INTO noticias (CodUsuario, CodLiga, Texto, Titular, Foto, NotaNoticia, NumVotos, Votada) VALUES ('$codUsuario', '$codLiga', '$titular', '$texto', '$foto',0,0,0)";
		$consulta = mysqli_query($db, $sql);
		if($consulta){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function update($idNoticia, $titular, $cuerpo, $codLiga){
		$db = $this->db;
		$idNoticia= mysqli_real_escape_string($db,$idNoticia);
		$codLiga= mysqli_real_escape_string($db,$codLiga);
		$texto= mysqli_real_escape_string($db,$cuerpo);
		$titular= mysqli_real_escape_string($db,$titular);
		$sql = "UPDATE noticias SET CodLiga = '$codLiga', Texto = '$texto', Titular = '$titular' WHERE IdNoticia LIKE '$idNoticia'"; 
		$consulta = mysqli_query($db, $sql);
	}
	
	public function delete($idNoticia){
		$db = $this->db;
		$idNoticia= mysqli_real_escape_string($db,$idNoticia);
		$sql = "DELETE FROM noticias where IdNoticia = '$idNoticia'"; 
		$consulta = mysqli_query($db, $sql);
		if($consulta){
			return true;
		}
		else{
			return false;
		}
	}

	public function devuelveNoticias($codLiga){
        $db = $this->db;
        $codLiga = mysqli_real_escape_string($db,$codLiga);
        
        if($codLiga == 0){
            $sql = "SELECT * FROM noticias";
            $res = mysqli_query($db, $sql);
            return $res;
        }
        else{
            $sql = "SELECT * FROM noticias WHERE CodLiga = '$codLiga'";
            $res = mysqli_query($db, $sql);
            return $res;
        }

    }

    public function borrarNoticiasUsuario($idUsu){ //borra las noticias de un usuario
		$db = $this->db;
		$idUsu = mysqli_real_escape_string($db, $idUsu);
		
		$sql = "DELETE FROM noticias WHERE CodUsuario = '$idUsu'"; 
		$consulta = mysqli_query($db, $sql);
	}
	
	public function getNoticiasUsuario($idUsu) {
		$db = $this->db;
		$idUsu= mysqli_real_escape_string($db,$idUsu);

		$sql = "SELECT IdNoticia from noticias where CodUsuario = '$idUsu'";
		$consulta = mysqli_query($db, $sql);
        return $consulta;
	}

	public function getNotaAndVotos($idNoticia){
		$db = $this->db;
		$idUsu = mysqli_real_escape_string($db, $idNoticia);
		
		$sql = "SELECT NotaNoticia, NumVotos FROM noticias WHERE IdNoticia = '$idNoticia'"; 
		$consulta = mysqli_query($db, $sql);
		$aux = mysqli_fetch_array($consulta);
		return $aux;
	}

	public function insertarNuevaNota($idNoticia, $nuevaNota, $votos){
		$db = $this->db;
		$idNoticia= mysqli_real_escape_string($db,$idNoticia);
		$nuevaNota= mysqli_real_escape_string($db,$nuevaNota);
		$votos= mysqli_real_escape_string($db,$votos);
		$sql = "UPDATE noticias SET NotaNoticia = '$nuevaNota', NumVotos = '$votos' WHERE IdNoticia LIKE '$idNoticia'"; 
		$consulta = mysqli_query($db, $sql);	
	}

	public function noticiaVotada($idNoticia){
		$db = $this->db;
		$idNoticia= mysqli_real_escape_string($db,$idNoticia);
		$sql = "UPDATE noticias SET Votada = 1 WHERE IdNoticia LIKE '$idNoticia'"; 
		$consulta = mysqli_query($db, $sql);	
	}

	public function activaVotaciones(){
		$db = $this->db;
		$sql = "UPDATE noticias SET Votada = 0"; 
		$consulta = mysqli_query($db, $sql);	
	}
}
	
?>