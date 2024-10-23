<?php

session_start();


 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }


    if ($_POST['action'] == 'consultar_datos') {
        // Consulta a la base de datos
        $query_consulta = mysqli_query($conection, "SELECT * FROM nube_wsw
            WHERE nube_wsw.estatus = '1' AND nube_wsw.iduser = '$iduser'
            ORDER BY `nube_wsw`.`fecha` DESC ");

        // Inicializamos un array para almacenar los datos
        $data = array();

        while ($row = mysqli_fetch_assoc($query_consulta)) {

          $servidores_wsp = $row['servidor'];


          $query_servidor = mysqli_query($conection, "SELECT * FROM servidores_wsp
             WHERE  servidores_wsp.id = '$servidores_wsp' ");
             $data_servidor = mysqli_fetch_array($query_servidor);

             $url_servidor = $data_servidor['url'];


            $url = ''.$url_servidor.'/check-file';

            // El nombre del archivo puede variar. Aquí estamos usando 'guibis.png' como ejemplo
            $postData = array("fileName" => $row['nombre_archivo']); // Supongo que 'nombre_archivo' es un campo en tu tabla

            // Convertir los datos a formato JSON
            $data_json = json_encode($postData);

            // Inicializar cURL
            $ch = curl_init($url);

            // Configurar cURL para realizar una solicitud POST
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

            // Ejecutar la solicitud y obtener la respuesta
            $response = curl_exec($ch);

            // Verificar si hubo errores en la solicitud
            if (curl_errno($ch)) {
                // Error en la conexión
                $row['api_error'] = 'Error: ' . curl_error($ch);
                $row['api_fileName'] = '';
                $row['api_size'] = '';
                $row['api_createdAt'] = '';
                $row['api_modifiedAt'] = '';
                $row['api_modifiedAt'] = '';
                $row['api_success'] = '';
                $row['api_message'] = '';
            } else {
                // Decodificar el JSON de la respuesta
                $response_data = json_decode($response, true);


                // Verificar si el JSON está bien formado
                if (json_last_error() === JSON_ERROR_NONE) {
                    // Validar la estructura del JSON y agregar los resultados a $row
                    if (isset($response_data['success']) && $response_data['success'] === true) {
                        $row['api_success'] = $response_data['success'];
                        $row['api_message'] = $response_data['message'] ?? 'Mensaje no disponible';
                        $row['api_fileName'] = $response_data['fileName'] ?? 'Nombre de archivo no disponible';
                        $row['api_size'] = $response_data['size'] ?? 'Tamaño no disponible';
                        $row['api_createdAt'] = $response_data['createdAt'] ?? 'Fecha de creación no disponible';
                        $row['api_modifiedAt'] = $response_data['modifiedAt'] ?? 'Fecha de modificación no disponible';
                    } else {
                        // Manejar el caso de que el archivo no exista o respuesta no esperada
                        $row['api_success'] = false;
                        $row['api_message'] = 'Archivo no encontrado o error en la API.';
                        $row['api_fileName'] = '';
                        $row['api_size'] = '';
                        $row['api_createdAt'] = '';
                        $row['api_modifiedAt'] = '';
                    }
                } else {
                    // Manejar el caso de un JSON mal formado
                    $row['api_error'] = 'Error: Respuesta no es un JSON válido.';
                    $row['api_fileName'] = '';
                    $row['api_size'] = '';
                    $row['api_createdAt'] = '';
                    $row['api_message'] = '';
                    $row['api_modifiedAt'] = '';
                    $row['api_modifiedAt'] = '';
                    $row['api_success'] = '';
                }
            }

            // Cerrar cURL
            curl_close($ch);

            // Agregar los datos de la fila y la respuesta de la API al array final
            $data[] = $row;


        }

        // Devolver el resultado como JSON
  echo json_encode(array("data" => $data));
    }


 if ($_POST['action'] == 'agregar_variables_entorno') {


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

          $servidor       = $_POST['servidor'];
          $descripcion    = $_POST['descripcion'];




          $query_servidor = mysqli_query($conection, "SELECT * FROM servidores_wsp
             WHERE servidores_wsp.estatus = '1' AND servidores_wsp.id = '$servidor' ");
       $data_servidor = mysqli_fetch_array($query_servidor);

       $url_servidor = $data_servidor['url'];

          $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;

          $url_file_local = $url.'/home/img/uploads/'.$newFileName;


          $url_servidor_save = $data_servidor['url'].'/files/'.$newFileName;

          $query_insert=mysqli_query($conection,"INSERT INTO nube_wsw (iduser,url_file_local,servidor,tipo,url_api,descripcion,nombre_archivo)
                                        VALUES('$iduser','$url_file_local','$servidor','$fileExtension','$url_servidor_save','$descripcion','$newFileName') ");
       if ($query_insert) {


              $url = ''.$url_servidor.'/download-file';
              // URL de la API que deseas consumir

              // Datos que se enviarán en el cuerpo de la solicitud
              $data = [
                  'fileUrl' => $url_file_local
              ];

              // Inicializar cURL
              $ch = curl_init($url);

              // Configurar cURL para enviar una solicitud POST
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como string
              curl_setopt($ch, CURLOPT_POST, true); // Para enviar una solicitud POST
              curl_setopt($ch, CURLOPT_HTTPHEADER, [
                  'Content-Type: application/json' // Indica que estamos enviando JSON
              ]);
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Datos a enviar

              // Ejecutar la solicitud
              $response = curl_exec($ch);

              // Manejar errores de cURL
              if (curl_errno($ch)) {
                  echo 'Error de cURL: ' . curl_error($ch);
              } else {
                  // Convertir la respuesta JSON a un array de PHP
                  $responseData = json_decode($response, true);

                  // Verificar el resultado
                  if ($responseData['success']) {

                    $arrayName = array('noticia'=>'insert_correct','fileName'=>$responseData['fileName']);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

                    //INTEGREACION PARA LAS NOTIFICACIONES

                    $texto_noticia= "Se ha agregado un archivo $descripcion a tu nube para el envio rapido de mensajes";

                    $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,estado)
                                                                                               VALUES('$iduser','$texto_noticia','Exitoso') ");



                  } else {

                    $arrayName = array('noticia' =>'error_consumo_api','contenido_error' => $responseData['message']);
                    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                  }
              }

              // Cerrar la sesión cURL
              curl_close($ch);

              exit;



         }else {
           $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }


          } else {
            $arrayName = array('noticia' =>'error_mover_archivo','contenido_error' => mysqli_error($conection));
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
      } else {
        $arrayName = array('noticia' =>'error_subir_local','contenido_error' => mysqli_error($conection));
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
  } else {
    $arrayName = array('noticia' =>'path_vacio','contenido_error' => mysqli_error($conection));
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

 }




 if ($_POST['action'] == 'info_cliente') {
      $cliente       = $_POST['cliente'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM nube_wsw
         WHERE nube_wsw.estatus = '1' AND nube_wsw.id = '$cliente' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_archivo') {

 $id_archivo    = $_POST['id_archivo'];
 $descripcion    = $_POST['descripcion'];


   $query_insert = mysqli_query($conection,"UPDATE nube_wsw SET descripcion='$descripcion'
     WHERE id = '$id_archivo'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_archivo'=> $id_archivo);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

       $texto_noticia = 'Se ha editado un archivo en la nube '.$descripcion;

       $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,estado)
                                                                                  VALUES('$iduser','$texto_noticia','Exitoso') ");


     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_cliente') {

   $numero_extra             = $_POST['cliente'];

   $query_delete=mysqli_query($conection,"UPDATE nube_wsw SET estatus= 0  WHERE id='$numero_extra' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','cliente'=> $numero_extra);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

       $texto_noticia = 'Se ha Eliminado un archivo en la nube';

       $query_insert_notificaciones = mysqli_query($conection,"INSERT INTO notificaciones_guibis  (iduser,texto,estado)
                                                                                  VALUES('$iduser','$texto_noticia','Exitoso') ");




     }else {
       $arrayName = array('noticia' =>'error','contenido_error' => mysqli_error($conection));
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
