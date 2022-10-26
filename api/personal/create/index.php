<?php

   error_reporting(0);
   header("Access-Control-Allow-Origin: *");
$auth = $_SERVER['HTTP_AUTH_ITT'];
   $method = $_SERVER['REQUEST_METHOD'];

   if($method=="POST" && $auth=="RH"){

   require_once "../../../conexion.php";
   
   $nombre=$_POST['nombre'];
   $apellidop=$_POST['apellidop'];
   $apellidom=$_POST['apellidom'];
   $diac=$_POST['diac'];
   $mesc=$_POST['mesc'];
   $anioc=$_POST['anioc'];
   $puesto=$_POST['puesto'];
   $academia=$_POST['academia'];

   $pkey=strtoupper("ITT-".substr($apellidop, 0, 2).substr($apellidom, 0, 2).substr($anioc, -2).$mesc.$diac.substr($nombre, 0, 1));

   $sql="INSERT INTO personal(personal_key,nombre,apellido_p,apellido_m,dia,mes,anio,token,puesto,academia) VALUES('$pkey','$nombre','$apellidop','$apellidom','$diac','$mesc','$anioc',NULL,$puesto,$academia)";
	if($result=mysqli_query($conex,$sql)){
		 $error=array();
	$error[]=array(
	   'status'=>200,
	   'message'=>"Usuario registrado con exito con key $pkey"
	);

	echo json_encode($error);
	}
 
   }else{
	
      $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El metodo solicitado 'No existe'"
	);

	echo json_encode($error);
}

?>