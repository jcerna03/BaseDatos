<?php
require('./lib.php');
session_start();
$con = new ConectorBD();
if (isset($_SESSION['usuario'])) {
    $usuario =  $_SESSION['usuario'];
  if ($con->initConexion('dbagenda')=='OK') {
    $resultado = $con->consultar(['usuario'], ['id','nombre'], "WHERE correo ='".$usuario."'");
    $fila = $resultado->fetch_assoc();
    $response['nombre']=$fila['nombre'];
    $resultado = $con->getEventos($usuario);
    $i=0;
    while ($fila = $resultado->fetch_assoc()) {
      $response['eventos'][$i]['id']=$fila['id'];
      $response['eventos'][$i]['title']=$fila['title'];
      if($fila['allDay']==1)
      {
        $response['eventos'][$i]['start']=$fila['start_date'];
        $response['eventos'][$i]['end']=$fila['end_date'];
        $response['eventos'][$i]['allDay']=true;
      }
      else{
        $response['eventos'][$i]['start']=$fila['start_date']." ".$fila['start_hour'];
        $response['eventos'][$i]['end']=$fila['end_date']." ".$fila['end_hour'];
        $response['eventos'][$i]['allDay']=false;
      }    
      $i++;
    }
    $response['msg'] = "OK";
  }else {
    $response['msg'] = "No se pudo conectar a la Base de Datos";
  }
}else {
  $response['msg'] = "No se ha iniciado una sesión";
}
echo json_encode($response);
$con->cerrarConexion();


 ?>