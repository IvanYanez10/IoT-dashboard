<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class elementos extends conexion{

  private $state = "";
  private $elemetoId = "";
  private $table = "elements";

  public function listaElementos($pagina){
      $query = "SELECT id, name, element, state FROM " . $this->table . " limit $pagina";
      $datos = parent::obtenerDatos($query);
      return ($datos);
  }

  public function  obtenerElemento($id){
    $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
    return parent::obtenerDatos($query);
  }

  public function put($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    $this->elemetoId = $datos['id'];
    if(isset($datos['state'])) { $this->state = $datos['state']; }
    $resp = $this->modificarEstado();
    if($resp){
      $respuesta = $_respuestas->response;
      $respuesta["result"] = array(
          "elemetoId" => $this->elemetoId
      );
      return $respuesta;
    }else{
      return $_respuestas->error_500();
    }
  }


  private function modificarEstado(){
        $query = "UPDATE " . $this->table . " SET state ='" . $this->state . "' WHERE id = '" . $this->elemetoId . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }

}
?>
