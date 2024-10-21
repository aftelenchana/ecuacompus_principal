<?php

// Reportar todos los errores de PHP (ver el manual de PHP para más niveles de errores)
error_reporting(E_ALL);

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones


session_start();


 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";
      $empresa = 1;

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }


    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp            =  $result_configuracion['envio_wsp'];
    $url_conect_wsp              =  $result_configuracion['url_wsp'];


    if ($_POST['action'] == 'iniciar_campana') {

      //CODIGO PARA INGRESAR EN CAMAPAÑA PARA SACAR EL ID Y CON ESE ID JUGAR

             $mensaje   =  mysqli_real_escape_string($conection,$_POST['descripcion']);
            $intervalo_tiempo      = $_POST['intervalo_tiempo'];
            $numero_extra          = $_POST['numero_extra'];


            $metodo_envio          = $_POST['metodo_envio'];



            $modo_tiempo      = (isset($_REQUEST['modo_tiempo'])) ? $_REQUEST['modo_tiempo'] : '';
            $fecha_envio      = (isset($_REQUEST['fecha_envio'])) ? $_REQUEST['fecha_envio'] : '';
            $hora_envio       = (isset($_REQUEST['hora_envio'])) ? $_REQUEST['hora_envio'] : '';
            $tipo_embudo      = (isset($_REQUEST['tipo_embudo'])) ? $_REQUEST['tipo_embudo'] : '';


            if (!empty($fecha_envio) && !empty($hora_envio)) {
                // Combinar fecha y hora con segundos
                $fecha_hora_envio = $fecha_envio . ' ' . $hora_envio . ':00';

            } else {

              $fecha_hora_envio = '';
            }





            $query_numero = mysqli_query($conection, "SELECT * FROM numeros_extras
            WHERE numeros_extras.estatus = '1' AND numeros_extras.id = '$numero_extra' ");
            $data_numero = mysqli_fetch_array($query_numero);

            $key_wsp = $data_numero['key_wsp'];


            $incluir_nombre      = (isset($_REQUEST['incluir_nombre'])) ? $_REQUEST['incluir_nombre'] : '';

            $query_insert_mensajes_masivos =mysqli_query($conection,"INSERT INTO mensajes_masivos_wsp (iduser,empresa,mensaje,intervalo_tiempo,estado,incluir_nombre,key_wsp,
            metodo_envio,modo_tiempo,fecha_hora_envio,tipo_embudo)
                                VALUES('$iduser','$empresa','$mensaje','$intervalo_tiempo','Iniciado','$incluir_nombre','$key_wsp',
            '$metodo_envio','$modo_tiempo','$fecha_hora_envio','$tipo_embudo') ");

          if ($query_insert_mensajes_masivos) {

            $query_mensajes_masivos = mysqli_query($conection, "SELECT * FROM mensajes_masivos_wsp
               WHERE mensajes_masivos_wsp.iduser ='$iduser'
               AND mensajes_masivos_wsp.estatus = '1'
               AND mensajes_masivos_wsp.empresa = '$empresa'
               ORDER BY mensajes_masivos_wsp.fecha DESC ");

            $data_mensajes_masivos = mysqli_fetch_array($query_mensajes_masivos);
            $id_mensajes_masivos    = $data_mensajes_masivos['id'];

            //echo "este es el id $id_mensajes_masivos";

            //CODIGO SI EL CASO DEL METODO DE ENVIO ES DE metodo_envio = embudo_ventas

            $datos_embudo = 0;


            if ($metodo_envio == 'embudo_ventas') {

              $tipo_embudo      = (isset($_REQUEST['tipo_embudo'])) ? $_REQUEST['tipo_embudo'] : '';

              if ($tipo_embudo == 'Todos') {

                $query_embudo = mysqli_query($conection, "SELECT contactos_embudo_ventas.id,contactos_embudo_ventas.nombres,
                 DATE_FORMAT(contactos_embudo_ventas.fecha, '%W  %d de %b %Y %h:%m:%s') as 'fecha',contactos_embudo_ventas.email,
                 contactos_embudo_ventas.celular,
                 contactos_embudo_ventas.direccion,
                 contactos_embudo_ventas.descripcion,
                 contactos_embudo_ventas.url,
                 contactos_embudo_ventas.img,
                 contactos_embudo_ventas.tipo
                 FROM contactos_embudo_ventas
                   WHERE contactos_embudo_ventas.iduser ='$iduser'  AND contactos_embudo_ventas.estatus = '1'
                ORDER BY `contactos_embudo_ventas`.`fecha` DESC LIMIT 100");

             while ($data_embudo = mysqli_fetch_assoc($query_embudo)) {

               $numero = $data_embudo['celular'];
               $nombres = $data_embudo['nombres'];


               $query_insert_datos_mensajes_masivos =mysqli_query($conection,"INSERT INTO datos_mensajes_masivos (iduser,empresa,id_mensajes_masivos,numero,nombre,tipo)
                                         VALUES('$iduser','$empresa','$id_mensajes_masivos','$numero','$nombres','embudo') ");

                 if ($query_insert_datos_mensajes_masivos) {
                     $datos_embudo = $datos_embudo+1;
                 }



             }
                // code...
            }else {


              $query_embudo = mysqli_query($conection, "SELECT contactos_embudo_ventas.id,contactos_embudo_ventas.nombres,
               DATE_FORMAT(contactos_embudo_ventas.fecha, '%W  %d de %b %Y %h:%m:%s') as 'fecha',contactos_embudo_ventas.email,
               contactos_embudo_ventas.celular,
               contactos_embudo_ventas.direccion,
               contactos_embudo_ventas.descripcion,
               contactos_embudo_ventas.url,
               contactos_embudo_ventas.img,
               contactos_embudo_ventas.tipo
               FROM contactos_embudo_ventas
                 WHERE contactos_embudo_ventas.iduser ='$iduser'
                 AND contactos_embudo_ventas.estatus = '1'
                 AND contactos_embudo_ventas.tipo = '$tipo_embudo'
              ORDER BY `contactos_embudo_ventas`.`fecha` DESC LIMIT 100");

           while ($data_embudo = mysqli_fetch_assoc($query_embudo)) {

             $numero = $data_embudo['celular'];
             $nombres = $data_embudo['nombres'];


             $query_insert_datos_mensajes_masivos =mysqli_query($conection,"INSERT INTO datos_mensajes_masivos (iduser,empresa,id_mensajes_masivos,numero,nombre,tipo)
                                       VALUES('$iduser','$empresa','$id_mensajes_masivos','$numero','$nombres','embudo_ventas') ");

               if ($query_insert_datos_mensajes_masivos) {
                   $datos_embudo = $datos_embudo+1;
               }


             }


            }
          }

            //CODIGO PARA CATEGORIAS


            $categoria      = (isset($_REQUEST['categoria'])) ? $_REQUEST['categoria'] : '';
            $datos_categoria    = 0;

            if (!empty($categoria) && $categoria != 'Ninguna') { 
              $query_consulta_categoria = mysqli_query($conection, "SELECT usuarios_wsp.numero,usuarios_wsp.nombres,usuarios_wsp.email,
                categorias_wsp.nombre as 'categoria',categorias_wsp.descripcion as 'descripcion',usuarios_wsp.id FROM usuarios_wsp
                INNER JOIN categorias_wsp ON categorias_wsp.id = usuarios_wsp.categoria
                 WHERE usuarios_wsp.iduser ='$iduser'  AND usuarios_wsp.estatus = '1' AND usuarios_wsp.categoria = '$categoria'
              ORDER BY `usuarios_wsp`.`fecha` ASC ");

              $existencia_datos_categoria = mysqli_num_rows($query_consulta_categoria);

              if ($existencia_datos_categoria>0) {

                  while ($data_lista_categoria = mysqli_fetch_array($query_consulta_categoria)) {

                      $numero_categoria = $data_lista_categoria['numero'];
                      $nombres          = $data_lista_categoria['nombres'];

                    $query_insert_datos_mensajes_masivos =mysqli_query($conection,"INSERT INTO datos_mensajes_masivos (iduser,empresa,id_mensajes_masivos,numero,nombre,tipo)
                                              VALUES('$iduser','$empresa','$id_mensajes_masivos','$numero_categoria','$nombres','categoria') ");

                      if ($query_insert_datos_mensajes_masivos) {
                          $datos_categoria = $datos_categoria+1;
                      }

                }

              }

            }

            //CODIGO PARA QUE SE PUEDA ANALIZAR EL FORMATO EXCEL
            $datos_excel = 0;

            if (isset($_POST['resultado_datos_excel']) && !empty($_POST['resultado_datos_excel'])) {
                $resultado_datos_excel = $_POST['resultado_datos_excel'];

                // Separar los elementos por coma
                $elementos = explode(', ', $resultado_datos_excel);

                // Iterar sobre los elementos
                foreach ($elementos as $elemento) {
                    // Separar por el guion
                    $partes = explode('-', $elemento);

                    // Obtener el número y el nombre
                    $numero = trim($partes[0]); // Primer parte como número
                    $nombre = isset($partes[1]) ? trim($partes[1]) : ''; // Segunda parte como nombre, si existe

                    // Inserción en la base de datos
                    $query_insert_datos_mensajes_masivos = mysqli_query($conection, "INSERT INTO datos_mensajes_masivos (iduser, empresa, id_mensajes_masivos, numero, nombre, tipo)
                                                            VALUES('$iduser', '$empresa', '$id_mensajes_masivos', '$numero', '$nombre', 'grupos')");

                    if ($query_insert_datos_mensajes_masivos) {
                        $datos_excel++; // Incrementar contador si la inserción fue exitosa
                    } else {
                        // Manejo de errores, puedes usar un log o mostrar un mensaje
                        // echo "Error en la inserción: " . mysqli_error($conection);
                    }
                }
            }

            // Aquí puedes usar $datos_excel para saber cuántos registros se insertaron

            //AHORA HAGAMOS DEL GRUPOS DE whatsapp


            $datos_grupos = 0;

            if (isset($_POST['selected_groups'])) {

              //PRIMERA API VERIFICAR LA SESION
              $ch = curl_init();
              $url_grupos = ''.$url_conect_wsp.'/get-groups';

              $postData = array(
                  'sessionId' => $key_wsp  // Asegúrate de enviar los datos requeridos por la API
              );

              // Configurar cURL para hacer la solicitud POST
              curl_setopt($ch, CURLOPT_URL, $url_grupos);
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
              $data = json_decode($response, true);
              $groups = json_decode($response, true);

              $selectedGroups = $_POST['selected_groups'];

                  // Recorrer cada grupo seleccionado
                  foreach ($selectedGroups as $groupId) {
                      // Verificar si el ID del grupo existe en $groups
                      if (isset($groups[$groupId])) {
                          $group = $groups[$groupId]; // Obtener el grupo correspondiente

                        //  echo "Grupo: " . htmlspecialchars($group['subject']) . "<br>";

                          // Recorrer los participantes del grupo
                          if (isset($group['participants'])) {
                              foreach ($group['participants'] as $participant) {
                              //    echo "ID del participante: " . htmlspecialchars($participant['id']) . "<br>";
                              //    echo "Rol de administración: " . htmlspecialchars($participant['admin']) . "<br>";

                                  $numero = $participant['id'];
                                  $numero = str_replace('@s.whatsapp.net', '', $numero);

                                  $query_insert_datos_mensajes_masivos = mysqli_query($conection, "INSERT INTO datos_mensajes_masivos (iduser, empresa,  id_mensajes_masivos, numero, tipo)
                                                              VALUES('$iduser', '$empresa',  '$id_mensajes_masivos', '$numero','grupos')");

                                  if ($query_insert_datos_mensajes_masivos) {
                                      $datos_grupos++;
                                    // code...
                                  }
                              }
                          } else {
                            //  echo "No hay participantes en este grupo.<br>";
                          }

                          //echo "<hr>";
                      } else {
                        //  echo "El grupo con ID $groupId no existe en los datos del JSON.<br>";
                      }
                  }



          }


          //CODIGO PARA SACAR EL NUMERO DE CONTACTOS SELECCIONADOS

          $datos_selected = 0;


      $selected_contacts      = (isset($_REQUEST['selected_contacts'])) ? $_REQUEST['selected_contacts'] : '';

      if (!empty($selected_contacts)) {
          // Separar los contactos por coma
          $contactsArray = explode(',', $selected_contacts);

          // Recorrer el array de contactos y hacer lo que necesites con cada uno
          foreach ($contactsArray as $contact) {
              // Eliminar espacios en blanco alrededor de cada contacto (si los hay)
              $contact = trim($contact);

              // Verificar si el formato es válido antes de procesar
              if (strpos($contact, '-') !== false) {
                  // Separar el número y el nombre usando el guion
                  list($numero, $nombre) = explode('-', $contact);

                  // Si el nombre es "Desconocido", asignar un valor vacío
                  $nombre = ($nombre === 'Desconocido') ? '' : trim($nombre);

                  // Insertar el contacto en la base de datos
                  $query_insert_contact = mysqli_query($conection, "INSERT INTO datos_mensajes_masivos (iduser, empresa, id_mensajes_masivos, numero, nombre, tipo)
                                                      VALUES('$iduser', '$empresa', '$id_mensajes_masivos', '$numero', '$nombre', 'numeros')");

                  if ($query_insert_contact) {
                      $datos_selected++;
                  }
              }
          }
      }

      // Aquí puedes usar $datos_selected para saber cuántos registros se insertaron



          $total_datos_subidos = $datos_selected + $datos_grupos + $datos_excel + $datos_categoria + $datos_embudo;

          if ($total_datos_subidos > 0) {


            //CONTAR LA CANTIDAD PARA QUE SE HAGA EL IF , ES DECIR CANTIDAD DE DATOS

            $query_cantidad_datos = mysqli_query($conection,"SELECT COUNT(*) as  cantidad_datos  FROM
            datos_mensajes_masivos WHERE datos_mensajes_masivos.id_mensajes_masivos  = '$id_mensajes_masivos'");

            $data_cantidad_datos = mysqli_fetch_array($query_cantidad_datos);
            $cantidad_datos = $data_cantidad_datos['cantidad_datos'];





            $arrayName = array('noticia' =>'procesar_datos','mensaje_masivo' =>$id_mensajes_masivos,'cantidad_datos' =>$cantidad_datos,'intervalo_tiempo' =>$intervalo_tiempo
          ,'modo_tiempo' =>$modo_tiempo,'fecha_hora_envio' =>$fecha_hora_envio);
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

            // code...
          }else {

            $arrayName = array('noticia' =>'no_procesar_no_datos','mensaje_masivo' =>$id_mensajes_masivos);
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            // code...
          }



            // code...
          }else {
            $arrayName = array('noticia' =>'error_isnertar_mensajes_masivos','contenido_error' => mysqli_error($conection));
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }








    }



 ?>
