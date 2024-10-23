<?php


session_start();

 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar


  if ($_SESSION['rol'] == 'cuenta_empresa') {
  include "../sessiones/session_cuenta_empresa.php";


  }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Recursos Humanos') {
    include "../sessiones/session_cuenta_recursos_humanos.php";
    }



    if ($_POST['action'] == 'buscar_contactos_primer_contacto') {

      mysqli_query($conection,"SET lc_time_names = 'es_ES'");

      $filtro = $_POST['filtro'];

     $sql = ( "
     SELECT
       contactos_embudo_ventas.id,
       contactos_embudo_ventas.nombres,
      DATE_FORMAT(contactos_embudo_ventas.fecha, '%W  %d de %b %Y %h:%m:%s') as 'fecha',
      contactos_embudo_ventas.email,
      contactos_embudo_ventas.celular,
      contactos_embudo_ventas.direccion,
      contactos_embudo_ventas.descripcion,
      contactos_embudo_ventas.url,
      contactos_embudo_ventas.img,
      contactos_embudo_ventas.tipo
      FROM contactos_embudo_ventas
        WHERE contactos_embudo_ventas.iduser ='$iduser'  AND contactos_embudo_ventas.estatus = '1'
     ");

     if ($filtro != '') {
       $sql .= " AND (contactos_embudo_ventas.nombres like '%$filtro%' OR contactos_embudo_ventas.email like '%$filtro%' OR contactos_embudo_ventas.celular like '%$filtro%'
       OR contactos_embudo_ventas.descripcion like '%$filtro%' OR contactos_embudo_ventas.direccion like '%$filtro%' OR contactos_embudo_ventas.tipo like '%$filtro%')";
     }


     if ($filtro == '') {
        $sql .= " ORDER BY contactos_embudo_ventas.fecha DESC LIMIT 100  ";

    }

     $query_consulta = mysqli_query($conection, $sql);

     $data = array();
  while ($row = mysqli_fetch_assoc($query_consulta)) {
      $data[] = $row;
  }

  echo json_encode(array("data" => $data));

   }



   if ($_POST['action'] == 'info_contactos') {

        $contacto       = $_POST['contacto'];
        $query_consulta = mysqli_query($conection, "SELECT * FROM contactos_embudo_ventas
           WHERE contactos_embudo_ventas.iduser ='$iduser'  AND contactos_embudo_ventas.estatus = '1' AND contactos_embudo_ventas.id = '$contacto' ");
     $data_contactos = mysqli_fetch_array($query_consulta);
     echo json_encode($data_contactos,JSON_UNESCAPED_UNICODE);

   }



   if ($_POST['action'] == 'editar_contacto') {

        $id_contacto     =  mysqli_real_escape_string($conection,$_POST['id_contacto']);//Detalles adicionales del bien.

       if (!empty($_FILES['foto']['name'])) {
         $foto           =    $_FILES['foto'];
         $nombre_foto    =    $foto['name'];
         $type 					 =    $foto['type'];
         $url_temp       =    $foto['tmp_name'];
         $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
         $destino = '../img/uploads/';
         $img_nombre = 'embudo_ventas_guibis'.md5(date('d-m-Y H:m:s').$iduser);
         $img = $img_nombre.'.'.$extension;
         $src = $destino.$img;
           move_uploaded_file($url_temp,$src);

        $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

       }else {
         $query_contacto = mysqli_query($conection, "SELECT * FROM contactos_embudo_ventas WHERE contactos_embudo_ventas.id = $id_contacto");
         $data_contacto = mysqli_fetch_array($query_contacto);
         $img     = $data_contacto['img'];
         $url = $data_contacto['url'];
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


       $query_insert = mysqli_query($conection,"UPDATE contactos_embudo_ventas SET identificacion='$identificacion',tipo_identificacion='$tipo_identificacion',nombres='$nombres',
         email='$email', tipo='$tipo',celular='$celular',telefono='$telefono'
         ,direccion='$direccion',descripcion='$descripcion'

         WHERE id = '$id_contacto'");
       if ($query_insert) {

         //insertamos los cambios en un historial de cmabios

         $estado_notificiacion  = 'Exitoso';
         $texto_noticia = 'Se ha editado el contacto '.$nombres.' ';

           $arrayName = array('noticia'=>'insert_correct');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

         }else {


           $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
                      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

          $estado_notificiacion  = 'No Exitoso';
          $texto_noticia = "Se a tratado de editar  el contacto  $nombres en enbudo de ventas pero hubo un error ".mysqli_error($conection);
         }



      $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,codigo,accion,estado)
                                                                                 VALUES('$iduser','$texto_noticia','$id_contacto','mostrar_contacto_embudo_ventas','$estado_notificiacion') ");


     }





     if ($_POST['action'] == 'buscar_numeros_disponibles') {

       $query_consulta = mysqli_query($conection, "SELECT
         numeros_extras.id,
         numeros_extras.nombre,
         numeros_extras.numero,
         numeros_extras.key_wsp,
         servidores_wsp.nombre as 'nombre_servidor',
         servidores_wsp.tipo as 'tipo_servidor',
         servidores_wsp.url
          FROM numeros_extras
          INNER JOIN servidores_wsp ON servidores_wsp.id = numeros_extras.servidor
          WHERE   numeros_extras.estatus = '1' AND numeros_extras.iduser = '$iduser'
       ORDER BY `numeros_extras`.`fecha` DESC ");

       $data = array();
       while ($row = mysqli_fetch_assoc($query_consulta)) {
           // Código para sacar la información de cada número extra según el ID
           $key_wsp = $row['key_wsp'];
           $url     = $row['url'];


           $ch = curl_init();

           $url_verificacion_session = ''.$url.'/check-session';

           $postData = array(
               'sessionId' => $key_wsp  // Asegúrate de enviar los datos requeridos por la API
           );

           // Configurar cURL para hacer la solicitud POST
           curl_setopt($ch, CURLOPT_URL, $url_verificacion_session);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

           // Ejecutar la solicitud y obtener la respuesta
           $response = curl_exec($ch);

           // Verificar si hubo un error en la solicitud
           if(curl_errno($ch)) {
               echo 'Error en cURL: ' . curl_error($ch);
           }

           // Cerrar cURL
           curl_close($ch);

           // Convertir la respuesta JSON en un array de PHP
           $data_api = json_decode($response, true);

           // Agregar la respuesta a la fila actual
           if (isset($data_api['sessionId'])) {
               // La sesión está activa
               $row['sessionId'] = $data_api['sessionId'];
               $row['status'] = $data_api['status'];
               $row['message'] = $data_api['message'];
               $row['url_qr'] = ''.$url.'/get-qr/'.$key_wsp.'';
           } elseif (isset($data_api['error'])) {
               // La sesión no fue encontrada
               $row['error'] = $data_api['error'];
               $row['status'] = 'Session No Creada';
               $row['message'] = 'Ingresa a consola para crearla';
               $row['url_qr'] = '';
           }


           // Agregar el array modificado a $data
           $data[] = $row;
       }


    echo json_encode(array("data" => $data));
       // code...
     }




     if ($_POST['action'] == 'agregar_contacto_masivamente_wsp') {


       $numero_guibis = $_POST['numero_guibis'];
       $tipo = $_POST['tipo'];

       $query_consulta_numero = mysqli_query($conection, "SELECT servidores_wsp.url,numeros_extras.key_wsp FROM numeros_extras
         INNER JOIN servidores_wsp ON servidores_wsp.id = numeros_extras.servidor
          WHERE numeros_extras.estatus = '1' AND numeros_extras.id = '$numero_guibis' ");
      $data_numero = mysqli_fetch_array($query_consulta_numero);

      $url_server = $data_numero['url'];
      $key_wsp_numero_private = $data_numero['key_wsp'];


       //PRIMERA API VERIFICAR LA SESION
       $ch = curl_init();
       $url_contactos = ''.$url_server.'/get-contacts';

       $postData = array(
           'sessionId' => $key_wsp_numero_private  // Asegúrate de enviar los datos requeridos por la API
       );

       // Configurar cURL para hacer la solicitud POST
       curl_setopt($ch, CURLOPT_URL, $url_contactos);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

       // Ejecutar la solicitud y obtener la respuesta
       $response = curl_exec($ch);

       // Verificar si hubo un error en la solicitud
       if(curl_errno($ch)) {
           echo 'Error en cURL: ' . curl_error($ch);
       }

       // Cerrar cURL
       curl_close($ch);

       // Convertir la respuesta JSON en un array de PHP
       $data  = json_decode($response, true);

       $datos_wsp_insertados = 0;
       $datos_wsp_duplicados = 0;
       $datos_wsp_no_error_insertados = 0;
       // Retornar los contactos como respuesta JSON
       if (isset($data ) && is_array($data )) {

          // Recorrer cada contacto
          foreach ($data  as $key => $contacto) {

              $numero = explode('@', $contacto['id'])[0];
              $nombre = isset($contacto['name']) ? $contacto['name'] : '';
              $nickname = isset($contacto['notify']) ? $contacto['notify'] : '';

              $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


              //PRIMERO VERIFICAMOS SI ES QUE EXISTE EN LA BASE DE DATOS


              $query_consulta_existencia = mysqli_query($conection, "SELECT * FROM contactos_embudo_ventas
                  WHERE contactos_embudo_ventas.estatus = '1' AND contactos_embudo_ventas.iduser = '$iduser'
                  AND contactos_embudo_ventas.celular = '$numero' ");


                   $existencia_numero  = mysqli_num_rows($query_consulta_existencia);


                  if ($existencia_numero > 0) {
                    $datos_wsp_duplicados++;


                    // code...
                  }else {
                    $query_insert=mysqli_query($conection,"INSERT INTO contactos_embudo_ventas (iduser,nombres,celular,img,url,fuente,tipo)
                                                  VALUES('$iduser','$nombre','$numero','embudo_ventas_guibis.png','$url','whatsapp','$tipo') ");

                        if ($query_insert) {
                            $datos_wsp_insertados++;
                        } else {
                          $datos_wsp_no_error_insertados++;

                        }
                    // code...
                  }



          }

          $arrayName = array('noticia' =>'insert_correct','datos_wsp_insertados' => $datos_wsp_insertados,'datos_wsp_duplicados' => $datos_wsp_duplicados,'datos_wsp_no_error_insertados' => $datos_wsp_no_error_insertados);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


          $texto_noticia = "Se han registrado $datos_wsp_insertados contactos a tu embudo de ventas";


          $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,accion,estado)
                                                                                     VALUES('$iduser','$texto_noticia','mostrar_contactos_embudo_ventas_producto','Exitoso') ");




       } else {
         $arrayName = array('noticia' =>'no_es_json .');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }



     }




      if ($_POST['action'] == 'eliminar_contacto') {

        $id_contacto             = $_POST['id_contacto'];

        $query_delete=mysqli_query($conection,"UPDATE contactos_embudo_ventas SET estatus= 0  WHERE id='$id_contacto' ");

        if ($query_delete) {


            $arrayName = array('noticia'=>'insert_correct','id_contacto'=> $id_contacto);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

            $query_consulta = mysqli_query($conection, "SELECT * FROM contactos_embudo_ventas
               WHERE contactos_embudo_ventas.iduser ='$iduser'   AND contactos_embudo_ventas.id = '$id_contacto' ");
         $data_contactos = mysqli_fetch_array($query_consulta);

         $nombres = $data_contactos['nombres'];

            $texto_noticia = "Se han Eliminado  $nombres de tu lista de contactos de embudo de ventas";


            $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,accion,estado)
                                                                                       VALUES('$iduser','$texto_noticia','mostrar_contactos_embudo_ventas_producto','Exitoso') ");


          }else {
            $arrayName = array('noticia' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }

      }





      if ($_POST['action'] == 'enviar_mensaje_rapido') {



        $url_file_local = '';
        if (isset($_FILES['archivo'])) {

           $file = $_FILES['archivo'];

           // Obtener información del archivo
           $fileName = $file['name'];
           $fileTmpPath = $file['tmp_name'];
           $fileSize = $file['size'];
           $fileError = $file['error'];

           // Obtener la extensión del archivo
           $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

           // Definir la carpeta de destino
           $uploadDir = '../img/uploads/'; // Asegúrate de crear esta carpeta
           if (!is_dir($uploadDir)) {
               mkdir($uploadDir, 0755, true);
           }

           // Crear un nuevo nombre para el archivo para evitar colisiones
           $newFileName = uniqid('', true) . '.' . $fileExtension;

           // Verificar si no hay errores y el archivo es válido
           if ($fileError === UPLOAD_ERR_OK) {
               // Mover el archivo a la carpeta de destino
               $destination = $uploadDir . $newFileName;
               if (move_uploaded_file($fileTmpPath, $destination)) {
                   // Archivo subido exitosamente

               $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
               $url_file_local = $url.'/home/img/uploads/'.$newFileName;




               } else {
                  $url_file_local = '';
                 $arrayName = array('noticia' =>'error_mover_archivo','contenido_error' => mysqli_error($conection));
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
               }
           } else {
             $url_file_local = '';
             //$arrayName = array('noticia' =>'error_subir_local','contenido_error' => mysqli_error($conection));
             //echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }
       } else {
         $url_file_local = '';
       }




       if (isset($_POST['archivos_seleccionados'])) {
       $archivosSeleccionados = $_POST['archivos_seleccionados']; // Recuperar el valor desde POST
       $archivosArray = explode(',', $archivosSeleccionados); // Separar por comas

       // Inicializar una cadena para almacenar las URLs
       $urlsNube = '';

       // Recorrer cada archivo seleccionado
       foreach ($archivosArray as $archivo) {
           // Para cada archivo, volvemos a explotar para obtener el ID
           $partes = explode('-', $archivo);
           if (count($partes) > 0) {
               $id = trim($partes[0]); // Este es el ID
              // echo "ID del archivo seleccionado: " . $id . "<br>";

               // Sanitizar el ID para la consulta SQL
               $id = mysqli_real_escape_string($conection, $id);

               // Realizar la consulta para obtener la URL
               $query_nube = mysqli_query($conection, "SELECT * FROM nube_wsw WHERE nube_wsw.estatus = '1' AND nube_wsw.id = '$id' ");
               $data_nube = mysqli_fetch_array($query_nube);

               // Verificar que se haya obtenido algún resultado
               if ($data_nube) {
                   $url_nube = $data_nube['url_file_local'];

                   // Asegurarse de que la URL esté correctamente codificada
                   $url_nube = urlencode($url_nube);

                   // Concatenar la URL a la cadena, separada por un espacio
                   $urlsNube .= urldecode($url_nube) . ' '; // Agregar un espacio después de cada URL
               } else {
                  // echo "No se encontró el archivo con ID: " . $id . "<br>";
               }
           }
       }

       // Imprimir todas las URLs separadas por espacios
    //   echo "URLs de archivos: " . trim($urlsNube); // Trim para quitar el último espacio
   }else {
     $urlsNube = '';
   }


   $mensaje = $_POST['mensaje'].' '.$urlsNube.' '.$url_file_local;


   $numero_guibis = $_POST['numero_guibis'];


     $query_numero = mysqli_query($conection, "SELECT numeros_extras.key_wsp,
       servidores_wsp.url
        FROM numeros_extras
       INNER JOIN servidores_wsp ON servidores_wsp.id = numeros_extras.servidor
     WHERE numeros_extras.estatus = '1' AND numeros_extras.id = '$numero_guibis' ");
     $data_numero = mysqli_fetch_array($query_numero);

     $key_wsp    = $data_numero['key_wsp'];

     $url_server = $data_numero['url'];
     //PRA CONTACTOS
     $contacto = $_POST['contacto'];


     $query_consulta_contacto = mysqli_query($conection, "SELECT * FROM contactos_embudo_ventas
        WHERE contactos_embudo_ventas.iduser ='$iduser'  AND contactos_embudo_ventas.estatus = '1' AND contactos_embudo_ventas.id = '$contacto' ");
     $data_contacto = mysqli_fetch_array($query_consulta_contacto);

       $numero = $data_contacto['celular'];



       //PRIMERA API VERIFICAR LA SESION
       $ch = curl_init();
       $url_sen_mensaje = ''.$url_server.'/send-message';

       //echo "esta es la key $key_wsp";



       $postData = array(
           'sessionId' => $key_wsp,
           'to' => $numero,
           'message' => $mensaje

       );

      // var_dump($postData);

      // echo "$url_sen_mensaje";




       // Configurar cURL para hacer la solicitud POST
       curl_setopt($ch, CURLOPT_URL, $url_sen_mensaje);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

       // Ejecutar la solicitud y obtener la respuesta
       $response = curl_exec($ch);


      // var_dump($response);

       // Verificar si hubo un error en la solicitud
       if(curl_errno($ch)) {
          // echo 'Error en cURL: ' . curl_error($ch);
            $arrayName = array('noticia' =>'error_insertar','mensaje' => curl_error($ch));
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       } else {
           // Convertir la respuesta JSON en un array de PHP
           $data = json_decode($response, true);

           // Verificar si la clave "message" contiene el texto esperado
           if(isset($data['message']) && $data['message'] == 'Mensaje enviado correctamente.') {
               $estatus_mensaje = 'Enviado';

                 $arrayName = array('noticia'=>'enviado');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           } else {

             $estatus_mensaje = 'No Enviado';
             //  echo 'Error al enviar el mensaje: ' . (isset($data['message']) ? $data['message'] : 'Respuesta inesperada.');
             $arrayName = array('noticia' =>'error_insertar','mensaje' => $estatus_mensaje);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }
       }

       // Cerrar cURL
       curl_close($ch);

      }







 ?>
