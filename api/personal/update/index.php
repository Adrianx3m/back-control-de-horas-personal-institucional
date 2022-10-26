<?php

   error_reporting(0);
   header("Access-Control-Allow-Origin: *");
$auth = $_SERVER['HTTP_AUTH_ITT'];
   $method = $_SERVER['REQUEST_METHOD'];

   if($method=="PUT" && $auth=="RH"){

   require_once "../../../conexion.php";

 parse_str(file_get_contents("php://input"),$info);

  $personal=$info['key'];
  $nombre=$info['nombre'];
  $apellidop=$info['apellidop'];
  $apellidom=$info['apellidom'];
  $diac=$info['diac'];
  $mesc=$info['mesc'];
  $anioc=$info['anioc'];
  $puesto=$info['puesto'];
  $academia=$info['academia'];
$key = substr($personal, 0, 15);
  
$sql="UPDATE personal SET nombre='$nombre',apellido_p='$apellidop',apellido_m='$apellidom',dia='$diac',mes='$mesc',anio='$anioc',puesto=$puesto,academia=$academia WHERE personal_key='$key'";
	
	if($result=mysqli_query($conex,$sql)){
		 $error=array();
	$error[]=array(
	   'status'=>200,
	   'message'=>"Usuario actualizado correctamente"
	);

	echo json_encode($error);
	}
 
   }else{
	
      $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El metodo solicitado 'No existe' "
	);
	echo $method;
	echo json_encode($error);
}

?>