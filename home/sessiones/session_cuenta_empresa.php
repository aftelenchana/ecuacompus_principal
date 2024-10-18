<?php



$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}

$iduser= $_SESSION['id'];

$user_in= $_SESSION['user_in'];

$id_generacion =  $iduser;
$rol = $_SESSION['rol'];

$query = mysqli_query($conection, "SELECT * FROM usuarios    WHERE usuarios.id =$iduser");
$result=mysqli_fetch_array($query);
$nombres           = $result['nombres'];

$direccion         = $result['direccion'];
$codigo_sri        = $result['codigo_sri'];


$img_logo          = $result['img_facturacion'];
$url_img_upload           = $result['url_img_upload'];
$email_user           = $result['email'];
$fecha                = $result['fecha_creacion'];
$ciudad_user          = $result['ciudad'];
$telefono_user        = $result['telefono'];
$celular_user         = $result['celular'];



$nombre_empresa                   = $result['nombre_empresa'];
$razon_social               = $result['razon_social'];
$numero_identidad               = $result['numero_identidad'];

$whatsapp             = $result['whatsapp'];
$instagram            = $result['instagram'];
$facebook             = $result['facebook'];
$pagina_web             = $result['pagina_web'];

$descripcion_usuerio             = $result['descripcion'];

$latitud             = $result['latitud'];
$longitud             = $result['longitud'];
$key_user                = $result['codigo_registro'];

 ?>
