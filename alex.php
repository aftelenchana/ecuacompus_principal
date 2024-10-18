<?php
$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;
ob_start();
    require "coneccion.php" ;
      mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar
  session_start();
  if (!empty($_SESSION['active'])) {
    header('location:home/');
  }
if (isset($_COOKIE['session_token'])) {
    $sessionToken = $_COOKIE['session_token'];
} else {
  $sessionToken = bin2hex(random_bytes(32));
  setcookie('session_token', $sessionToken, time() + (86400 * 30), "/", null, true, true);
}
 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
  function getRealIP() {
      if (isset($_SERVER["HTTP_CLIENT_IP"])) {
          return $_SERVER["HTTP_CLIENT_IP"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
          return $_SERVER["HTTP_X_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
          return $_SERVER["HTTP_X_FORWARDED"];
      } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
          return $_SERVER["HTTP_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
          return $_SERVER["HTTP_FORWARDED"];
      } else {
          return $_SERVER["REMOTE_ADDR"];
      }
  }
  if ($url == 'localgost') {
    $direccion_ip = '186.42.9.232';
  }else {
    $direccion_ip = getRealIP();
  }
  //codigo para verificar la existencia de la direccion ip
  $query_insert_busqueda=mysqli_query($conection,"INSERT INTO vivitas_generales(direccion_ip)
                       VALUES('$direccion_ip') ");
                       // Asumimos que la sesión está activa y tenemos la información del dominio
                       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
                       $domain = $_SERVER['HTTP_HOST'];
                       echo "$domain";
                       $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
                       $result_documentos = mysqli_fetch_array($query_doccumentos);
                       if ($result_documentos) {
                           $url_img_upload = $result_documentos['url_img_upload'];
                           $img_facturacion = $result_documentos['img_facturacion'];
                           $nombre_empresa = $result_documentos['nombre_empresa'];
                           $celular        = $result_documentos['celular'];
                           $email        = $result_documentos['email'];
                           $facebook                = $result_documentos['facebook'];
                           $instagram           = $result_documentos['instagram'];
                           $whatsapp             = $result_documentos['whatsapp'];
                           // Asegúrate de que esta ruta sea correcta y corresponda con la estructura de tu sistema de archivos
                           $img_sistema = $url_img_upload.'/home/img/uploads/'.$img_facturacion;
                       } else {
                           // Si no hay resultados, tal vez quieras definir una imagen por defecto
                         $img_sistema = '/img/guibis.png';
                       }
                        ?>
