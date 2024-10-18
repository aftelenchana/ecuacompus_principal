<?php

$host='localhost';

$user='root';

$password='';

$db='ecuacompus';

$conection = @mysqli_connect($host,$user,$password,$db);

if (!$conection) {

  echo "Error en la coneccion";

}



 ?>
