<?php

   error_reporting(0);
   header("Access-Control-Allow-Origin: *");
   $auth = $_SERVER['HTTP_AUTH_ITT'];
   $method = $_SERVER['REQUEST_METHOD'];

   if($method=="GET" && $auth=="RH"){

   require_once "../../../conexion.php";

   $sql="SELECT id_puesto,puesto FROM puesto";
   $personal=array();

   if(!$result=mysqli_query($conex,$sql)) die();

   while($row=mysqli_fetch_array($result)){

      $key=$row['id_puesto'];
      $nombre=$row['puesto'];

	$personal[]=array(
	   'personal_key'=>$key,
	   'nombre'=>$nombre
	);
	

   }

   $close=mysqli_close($conex) or die();
   
   echo json_encode($personal);

   }else{

      $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El metodo solicitado 'No existe'"
	);

	echo json_encode($error);

   }

?>