<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar



    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";


    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_POST['action'] == 'agregar_contacto') {


      if (!empty($_FILES['foto']['name'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/uploads/';
        $img_nombre = 'embudo_ventas_guibis'.md5(date('d-m-Y H:m:s').$iduser);
        $img_contacto = $img_nombre.'.'.$extension;
        $src = $destino.$img_contacto;
          move_uploaded_file($url_temp,$src);
      }else {
        $img_contacto = 'embudo_ventas_guibis.png';
        // code...
      }

       $identificacion       =  mysqli_real_escape_string($conection,$_POST['identificacion']);
       $tipo_identificacion      = (isset($_REQUEST['tipo_identificacion'])) ? $_REQUEST['tipo_identificacion'] : '';
       $nombres              =  mysqli_real_escape_string($conection,$_POST['nombres']);
       $email                =  mysqli_real_escape_string($conection,$_POST['email']);
       $tipo                 =  mysqli_real_escape_string($conection,$_POST['tipo']);
       $celular              =  mysqli_real_escape_string($conection,$_POST['celular']);
       $telefono             =  mysqli_real_escape_string($conection,$_POST['telefono']);
       $direccion            =  mysqli_real_escape_string($conection,$_POST['direccion']);
       $descripcion          =  mysqli_real_escape_string($conection,$_POST['descripcion']);


       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


       $query_insert=mysqli_query($conection,"INSERT INTO contactos_embudo_ventas (iduser,identificacion,tipo_identificacion,nombres,email,tipo,celular,telefono,direccion,descripcion,img,url,fuente)
                                     VALUES('$iduser','$identificacion','$tipo_identificacion','$nombres','$email','$tipo','$celular','$telefono','$direccion','descripcion','$img_contacto','$url','manual') ");




     if ($query_insert) {

        $last_id = mysqli_insert_id($conection);

       $texto_noticia = 'Se ha agregado contacto  '.$nombres.' para tu embudo de ventas. ';

        $estado_notificiacion  = 'Exitoso';

       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       // code...
     }else {

       $last_id = '';

        $estado_notificiacion  = 'No Exitoso';
          $texto_noticia = 'Error en insertar datos en el historial de agregar contactos '.mysqli_error($conection);

       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }


     $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,codigo,accion,estado)
                                                                                VALUES('$iduser','$texto_noticia','$last_id','mostrar_contacto_embudo_ventas','$estado_notificiacion') ");



    }




 ?>
