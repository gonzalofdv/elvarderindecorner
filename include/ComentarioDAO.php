<?php

require_once('ComentarioTransfer.php');
require_once('DAO.php');

class ComentarioDAO extends DAO{

	//Metodos
	
	public function insert(ComentarioTransfer $c){
		$db = $this->db;
		
		$codUsuario = $c->getCodUsuario();
		$codNoticia = $c->getCodNoticia();
		$comentario = $c->getComentario();
		
		$sql = "INSERT INTO comentarios (CodNoticia, CodUsuario, Comentario) VALUES ('$codNoticia', '$codUsuario', '$comentario')";
		$consulta = mysqli_query($db, $sql);
		if($consulta){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function delete($idNoticia){
		$db = $this->db;
		$sql = "DELETE FROM comentarios WHERE CodNoticia = '$idNoticia'"; 
		$consulta = mysqli_query($db, $sql);
		if($consulta){
			return true;
		}
		else{
			return false;
		}
	}

	public function devuelveComentarios($idNoticia){
		$db = $this->db;
		$sql = "SELECT * FROM comentarios WHERE CodNoticia LIKE '$idNoticia'";
		$consulta = mysqli_query($db, $sql);
		return $consulta;
	}

	public function existenComentarios($idNoticia){
		$db = $this->db;
		$sql = "SELECT * FROM comentarios WHERE CodNoticia LIKE '$idNoticia'";
		$consulta = mysqli_query($db, $sql);
		if($consulta){
			return true;
		}
		else{
			return false;
		}	
	}
	
}
	
?>