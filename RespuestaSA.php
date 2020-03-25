<?php
require_once('RespuestaDAO.php');
class RespuestaSa{
    protected $respuestaDAO;

    public function insertRespuesta(RespuestaTransfer $respuesta){
        if(!$this->respuestaDAO){
            $this->respuestaDAO = new RespuestaDAO();
        }
        $aux = $this->respuestaDAO;
		return $aux->insert($respuesta);
    }

    public function updateRespuesta(RespuestaTransfer $respuesta){
        if(!$this->respuestaDAO){
            $this->respuestaDAO = new RespuestaDAO();
        }
        $aux = $this->respuestaDAO;
		return $aux->update($respuesta);
       
    }

    public function deleteRespuesta(RespuestaTransfer $respuesta){
        if(!$this->respuestaDAO){
            $this->respuestaDAO = new RespuestaDAO();
        } 
        $aux = $this->respuestaDAO;
		return $aux->delete($respuesta);
    }

}
?>