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


    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp            =  $result_configuracion['envio_wsp'];
    $url_conect_wsp              =  $result_configuracion['url_wsp'];



    if ($_POST['action'] == 'enviar_mensaje') {

      $codigo_envio             = $_POST['codigo_envio'];


      //INFORMACION Y CONFIGURACION DEL ENVIO

      $query_configuraciones = mysqli_query($conection,"SELECT *  FROM mensajes_masivos_wsp
                              WHERE mensajes_masivos_wsp.id  = '$codigo_envio'");

      $data_configuraciones = mysqli_fetch_array($query_configuraciones);

      $mensaje          = $data_configuraciones['mensaje'];
      $incluir_nombre   = $data_configuraciones['incluir_nombre'];







      $query_mensajes_datos = mysqli_query($conection,"SELECT *  FROM datos_mensajes_masivos
                              WHERE datos_mensajes_masivos.id_mensajes_masivos  = '$codigo_envio'
                              AND datos_mensajes_masivos.estado != 'Procesado'");

      $data_mensajes_datos = mysqli_fetch_array($query_mensajes_datos);
      $numero = $data_mensajes_datos['numero'];
      $nombre = $data_mensajes_datos['nombre'];
      $id     = $data_mensajes_datos['id'];

      if ($incluir_nombre == 'on') {
        // Reemplazar '@name@' con el valor de la variable $nombre
        $mensaje = str_replace('@name@', $nombre, $mensaje);
      }



      $query_udate = mysqli_query($conection,"UPDATE datos_mensajes_masivos SET estado= 'Procesado',  estado_envio = 'Enviado' WHERE id='$id'  ");

      if ($query_udate) {

        //CONTAMOS LOS DATOS QUE FALTAN

        $query_cantidad_datos = mysqli_query($conection,"SELECT COUNT(*) as  cantidad_datos  FROM
        datos_mensajes_masivos WHERE datos_mensajes_masivos.id_mensajes_masivos  = '$codigo_envio'
        AND datos_mensajes_masivos.estado != 'Procesado'");

        $data_cantidad_datos = mysqli_fetch_array($query_cantidad_datos);
        $cantidad_datos_faltantes = $data_cantidad_datos['cantidad_datos'];



        $arrayName = array('noticia' =>'dato_procesado','numero' =>$numero,'codigo_envio' =>$codigo_envio,'cantidad_datos_faltantes' =>$cantidad_datos_faltantes);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

      }else {
        $arrayName = array('noticia' =>'error_isnertar_mensajes_masivos','contenido_error' => mysqli_error($conection));
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }


    }



 ?>
