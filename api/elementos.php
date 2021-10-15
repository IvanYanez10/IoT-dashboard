<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/elementos.class.php';

$_respuestas = new respuestas;
$_elementos = new elementos;

if($_SERVER['REQUEST_METHOD'] == "GET"){
  if(isset($_GET["page"])){
    $pagina = $_GET["page"];
    $elementos = $_elementos->listaElementos($pagina);
    echo json_encode($elementos);
    http_response_code(200);
  }else if(isset($_GET["id"])){
    $elementoId = $_GET["id"];
    $datosElemento = $_elementos->obtenerElemento($elementoId);
    echo json_encode($datosElemento);
    http_response_code(200);
  }
}
else if($_SERVER['REQUEST_METHOD'] == "PUT"){
   $postBody = file_get_contents("php://input");
   $datosArray = $_elementos->put($postBody);
  header('Content-Type: application/json');
  if(isset($datosArray["result"]["error_id"])){
     $responseCode = $datosArray["result"]["error_id"];
     http_response_code($responseCode);
   }else{
     http_response_code(200);
   }
   echo json_encode($datosArray);
}else{
  header('Content-Type: application/json');
}

?>
