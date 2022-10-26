<?php

   error_reporting(0);
   header("Access-Control-Allow-Origin: *");
$auth = $_SERVER['HTTP_AUTH_ITT'];
   $method = $_SERVER['REQUEST_METHOD'];

   if($method=="DELETE" && $auth=="RH"){

   require_once "../../../conexion.php";

 parse_str(file_get_contents("php://input"),$info);

  $personal=$info['key'];
$key = substr($personal, 0, 15);
  
$sql="DELETE FROM personal WHERE personal_key='$key'";
	
	if($result=mysqli_query($conex,$sql)){
		 $error=array();
	$error[]=array(
	   'status'=>200,
	   'message'=>"Usuario borrado correctamente"
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