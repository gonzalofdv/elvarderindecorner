<?php
require_once('UsuarioDAO.php');

class UsuarioSA {

	// Atributos
    protected $usuarioDAO;
	
	public function newUsuario(UsuarioTransfer $usuario){
		if(!$this->usuarioDAO){
			$this->usuarioDAO = new UsuarioDAO();
		}
		usuarioDAO->insert($usuario);
	}
	
	public function updateUsuario(){
		if(!$this->usuarioDAO){
			$this->usuarioDAO = new UsuarioDAO();
		}
		usuarioDAO->update($usuario);
	}
	
	public function deleteUsuario(){
		if(!$this->usuarioDAO){
			$this->usuarioDAO = new UsuarioDAO();
		}
		usuarioDAO->delete($usuario);
	}
	
}
	
?>