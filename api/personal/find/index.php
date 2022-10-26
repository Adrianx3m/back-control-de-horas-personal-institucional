<?php

   //error_reporting(0);
   header("Access-Control-Allow-Origin: *");
   $method = $_SERVER['REQUEST_METHOD'];
   $auth = $_SERVER['HTTP_AUTH_ITT'];

   if($method=="GET" && $auth=="RH"){
	$personal = $_GET['key'];
	$personalkey = substr($personal, 0, 15);
	
   require_once "../../../conexion.php";

   $sql="SELECT personal_key,nombre,apellido_p,apellido_m,dia,mes,anio,puesto,academia FROM personal WHERE personal_key='$personalkey'";
   $personal=array();

   if(!$result=mysqli_query($conex,$sql)) die();

   if($verify=mysqli_num_rows($result)<=0){
	 $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El archivo solicitado 'No existe'."
	);

	echo json_encode($error);
	}else{

   while($row=mysqli_fetch_array($result)){

      $key=$row['personal_key'];
      $nombre=$row['nombre'];
	$apellidop=$row['apellido_p'];
	$apellidom=$row['apellido_m'];
	$cumple=''.$row['dia'].'/'.$row['mes'].'/'.$row['anio'];
	$puesto=$row['puesto'];
	$academia=$row['academia'];

	$personal[]=array(
	   'personal_key'=>$key,
	   'nombre'=>$nombre,
	   'apellidoP'=>$apellidop,
	   'apellidoM'=>$apellidom,
	   'cumpleaños'=>$cumple,
	   'puesto'=>$puesto,
	   'academia'=>$academia
	);
	

   }

   $close=mysqli_close($conex) or die();
   
   echo json_encode($personal);
}

   }else{

      $error=array();
	$error[]=array(
	   'status'=>422,
	   'message'=>"El archivo solicitado 'No existe'."
	);

	echo json_encode($error);

   }

?>