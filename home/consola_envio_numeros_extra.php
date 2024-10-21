
<?php
ob_start();
include "../coneccion.php";
mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar
session_start();


if (empty($_SESSION['active'])) {
    header('location:/');
} else {
    // Asumimos que la sesión está activa y tenemos la información del dominio
    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $domain = $_SERVER['HTTP_HOST'];

    $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
    $result_documentos = mysqli_fetch_array($query_doccumentos);

    if ($result_documentos) {
        $url_img_upload = $result_documentos['url_img_upload'];
        $img_facturacion = $result_documentos['img_facturacion'];

        // Asegúrate de que esta ruta sea correcta y corresponda con la estructura de tu sistema de archivos
        $img_sistema = $url_img_upload.'/home/img/uploads/'.$img_facturacion;
    } else {
        // Si no hay resultados, tal vez quieras definir una imagen por defecto
      $img_sistema = '/img/guibis.png';
    }
}

$codigo = $_GET['codigo'];

$query_numero = mysqli_query($conection, "SELECT * FROM numeros_extras
   WHERE numeros_extras.estatus = '1' AND numeros_extras.key_wsp = '$codigo' ");
$data_numero = mysqli_fetch_array($query_numero);


$query_consulta_numero = mysqli_query($conection, "SELECT servidores_wsp.url FROM numeros_extras
  INNER JOIN servidores_wsp ON servidores_wsp.id = numeros_extras.servidor
   WHERE numeros_extras.estatus = '1' AND numeros_extras.key_wsp = '$codigo' ");
$data_numero_url = mysqli_fetch_array($query_consulta_numero);
$url_server = $data_numero_url['url'];

?>

<!doctype html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $data_numero['nombre'] ?>  </title>

    <meta name="description" content="" />

    <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="/img/guibis.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <?php
       require 'scripts/menu.php';
        ?>
        <div class="layout-page">
          <?php
         require 'scripts/barra_superior.php';
          ?>
          <div class="content-wrapper">

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card">


                <div class="row container">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header table-card-header">
                                <h5>Realizar Campañas <?php echo $data_numero['nombre'] ?> con <?php echo $data_numero['numero'] ?></h5>
                            </div>
                            <div class="card-block">
                               <form  class="" method="post" name="iniciar" id="iniciar" onsubmit="event.preventDefault(); sendData_iniciar();">
                                <div class="mb-3">
                                  <label for="descripcion" class="form-label">Ingrese el Mensaje</label>
                                  <textarea class="form-control" required name="descripcion" id="descripcion" rows="7">
                                    <?php echo '🌟 ¡Bienvenidos a '.$nombre_empresa.'! 🌟

     Hola @name@, esperamos que estés teniendo un excelente día. En '.$nombre_empresa.', nos dedicamos a ofrecerte soluciones rápidas y eficientes para todos tus requerimientos . 🚚💨


     Nuestros Servicios:

     Envíos locales y nacionales 🇪🇨
     Entregas rápidas y seguras 🏃💼
     Rastreo en tiempo real de tus envíos 📍
     Si tienes alguna consulta o necesitas una cotización, no dudes en contactarnos:

     Celular: '.$celular_user.' 📞
     Correo:  '.$email_user.'📧
     ¡En '.$nombre_empresa.', tu satisfacción es nuestra prioridad! Estamos a tu disposición para cualquier necesidad de envío que tengas. 🌟
     '; ?>
                                  </textarea>
                                </div>



                                <div class="mb-3">
                                  <label for="exampleFormControlFile1" class="form-label">Agregue Imagenes</label>
                                  <input type="file" class="form-control" name="lista[]"  multiple id="lista"  accept="image/png, .jpeg, .jpg" >
                                </div>

                                <style media="screen">
                                  #miniaturas_productos img{
                                    width: 20%;
                                    display: inline-block;
                                    padding: 5px;
                                    margin: 5px;

                                  }
                                </style>

                                <div class="row">
                                   <span class="conte_img_pr" id="salida_imagenes_contenedor">
                                     <output id="miniaturas_productos"></output>
                                    </span>
                                 </div>


                                 <style media="screen">
                                 .contenedior_general_boton_enviar{
                                   text-align: center;
                                   padding: 10px;
                                   margin: 10px;
                                 }

                                 </style>

                                 <!-- Pestañas (Tabs) -->
                                 <ul class="nav nav-tabs" id="myTab" role="tablist">
                                     <li class="nav-item">
                                         <a class="nav-link active" id="datos-generales-tab" data-bs-toggle="tab" href="#datos-generales" role="tab" aria-controls="datos-generales" aria-selected="true">Categorias</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" id="autorizaciones-sri-tab" data-bs-toggle="tab" href="#autorizaciones-sri" role="tab" aria-controls="autorizaciones-sri" aria-selected="false">Archivo Excel</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" id="rrhh-tab" data-bs-toggle="tab" href="#rrhh" role="tab" aria-controls="rrhh" aria-selected="false">Grupos</a>
                                     </li>

                                     <li class="nav-item">
                                         <a class="nav-link" id="numeros-tab" data-bs-toggle="tab" href="#numeros" role="tab" aria-controls="numeros" aria-selected="false">Números</a>
                                     </li>
                                 </ul>

                                 <!-- Contenido de cada pestaña -->
                                 <div class="tab-content" id="myTabContent">
                                     <!-- Contenido de la pestaña Datos Generales -->
                                     <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                                         <div class="card mt-3">
                                             <div class="card-header bg-primary text-white">
                                                 Categorias
                                             </div>
                                             <div class="card-body">
                                                 <!-- Formulario Datos Generales -->

                                                   <div class="mb-3">
                                                     <label for="proveedor" class="form-label">Categoria </label>
                                                     <select class="form-control input-guibis-sm" name="categoria" id="categoria">
                                                       <option value="Ninguna">Ninguna</option>
                                                       <?php
                                                       $query_proveedor = mysqli_query($conection, "SELECT * FROM categorias_wsp WHERE  categorias_wsp.iduser= '$iduser'   AND categorias_wsp.estatus = 1");
                                                       while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                                         echo '<option  value="' . $proveedor['id'] . '">' . $proveedor['nombre'] . '/ ' . $proveedor['descripcion'] . '</option>';
                                                       }
                                                       ?>
                                                     </select>
                                                   </div>
                                                     <!-- Más campos aquí... -->

                                             </div>
                                         </div>
                                     </div>

                                     <!-- Contenido de la pestaña Autorizaciones SRI -->
                                     <div class="tab-pane fade" id="autorizaciones-sri" role="tabpanel" aria-labelledby="autorizaciones-sri-tab">
                                         <div class="card mt-3">
                                             <div class="card-header bg-primary text-white">
                                                 Archivo Excel
                                             </div>
                                             <div class="card-body">
                                               <a href="librerias/wsp_ejemplo.xlsx" download>
                                                   <img src="img/reacciones/excel.png" alt="" width="20px;">
                                               </a>
                                               <div class="mb-3">
                                                   <label for="proveedor" class="form-label">Archivo Excel</label>
                                                   <input class="form-control input-guibis-sm" type="file" name="usuarios_wsp" accept=".xlsx, .xls, .csv" id="file_input">
                                                 </div>

                                                 <div class="mb-3">
                                                   <label class="label-guibis-sm">Intervalos Ej (1-4;1)</label>
                                                   <input type="text" class="form-control input-guibis-sm" name="intervalos_excel" id="intervalos_excel" placeholder="Intervalos Excel">
                                                 </div>

                                                 <div id="table-container" style="max-height: 300px; overflow-y: auto;"></div>

                                                 <div class="mb-3">
                                                   <label for="result" class="form-label">Resultado</label>
                                                   <input class="form-control input-guibis-sm" value="" type="text" id="result">
                                                   <input type="text" id="datos_excel"  name="resultado_datos_excel" value="">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <!-- Contenido de la pestaña RRHH -->
                                     <!-- Contenido de la pestaña RRHH -->
                                     <div class="tab-pane fade" id="rrhh" role="tabpanel" aria-labelledby="rrhh-tab">
                                         <div class="card mt-3">
                                             <div class="card-header bg-primary text-white">
                                                 Grupos
                                             </div>
                                             <div class="card-body">
                                               <div class="mb-3">
                                                 <label for="proveedor" class="form-label">Grupos </label>


                                                 <?php

                                                 //PRIMERA API VERIFICAR LA SESION
                                                 $ch = curl_init();
                                                 $url_grupos = ''.$url_server.'/get-groups';

                                                 $postData = array(
                                                     'sessionId' => $codigo  // Asegúrate de enviar los datos requeridos por la API
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

                                                 // Retornar los contactos como respuesta JSON
                                                 if (isset($data) && is_array($data)) {
                                                   // Verificamos si existe la clave 'status' en el array
                                                           if (isset($data['status'])) {
                                                               switch ($data['status']) {
                                                                   case 'error':
                                                                       $modtrar_grupos = 'no_grupos';
                                                                       break;
                                                                   case 'status':
                                                                       $modtrar_grupos = 'no_grupos';
                                                                       break;
                                                                   default:
                                                                       $modtrar_grupos = 'si_grupos';
                                                                       break;
                                                               }
                                                           } else {
                                                               // Si 'status' no está definido en el array
                                                               $modtrar_grupos = 'no_grupos';
                                                           }
                                                       } else {
                                                           // Si $data no es un array o no está definido
                                                           $modtrar_grupos = 'no_grupos';
                                                       }


                                                  ?>

                                                  <?php if ($modtrar_grupos == 'si_grupos'): ?>
                                                    <?php

                                                    foreach ($groups as $groupId => $group) {
                                                        ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="selected_groups[]" value="<?php echo $groupId; ?>" id="group_<?php echo $groupId; ?>">
                                                            <label class="form-check-label" for="group_<?php echo $groupId; ?>">
                                                                <?php echo htmlspecialchars($group['subject']); ?>
                                                            </label>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                  <?php endif; ?>

                                               </div>

                                             </div>
                                         </div>
                                     </div>

                                     <!-- Contenido de la pestaña RRHH -->
                                     <div class="tab-pane fade" id="numeros" role="tabpanel" aria-labelledby="numeros-tab">
                                         <div class="card mt-3">
                                             <div class="card-header bg-primary text-white">
                                               Números
                                             </div>
                                             <div class="card-body">

                                                                          <?php

                                                                          //PRIMERA API VERIFICAR LA SESION
                                                                          $ch = curl_init();
                                                                          $url_contactos = ''.$url_server.'/get-contacts';

                                                                          $postData = array(
                                                                              'sessionId' => $codigo  // Asegúrate de enviar los datos requeridos por la API
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
                                                                          $data = json_decode($response, true);

                                                                          // Retornar los contactos como respuesta JSON
                                                                          if (isset($data) && is_array($data)) {
                                                                              //echo json_encode($data);
                                                                          } else {
                                                                              echo json_encode(['error' => 'No se encontraron contactos.']);
                                                                          }


                                                                           ?>

                                                                           <style>
                                                                             .tag {
                                                                                 display: inline-block;
                                                                                 background-color: #f1f1f1;
                                                                                 border-radius: 20px;
                                                                                 padding: 5px 10px;
                                                                                 margin-right: 5px;
                                                                                 margin-bottom: 5px;
                                                                                 font-size: 14px;
                                                                             }
                                                                             .tag i {
                                                                                 margin-left: 10px;
                                                                                 cursor: pointer;
                                                                             }
                                                                             .tag-container {
                                                                                 margin-top: 10px;
                                                                             }
                                                                             .contact-list {
                                                                                 max-height: 150px;
                                                                                 overflow-y: auto;
                                                                                 background-color: white;
                                                                                 border: 1px solid #ced4da;
                                                                                 border-radius: 0.25rem;
                                                                                 z-index: 1000;
                                                                                 position: absolute;
                                                                                 width: 100%;
                                                                             }
                                                                             .contact-list div {
                                                                                 padding: 10px;
                                                                                 cursor: pointer;
                                                                             }
                                                                             .contact-list div:hover {
                                                                                 background-color: #f1f1f1;
                                                                             }
                                                                         </style>

                                                                         <div class=" mt-4">
                                                           <label for="contactInput">Escribe @ para buscar contactos:</label>
                                                           <input type="text" id="contactInput" class="form-control" placeholder="Escribe @ y selecciona un contacto">
                                                           <div id="contactList" class="list-group mt-2 d-none"></div>

                                                           <div id="tagContainer" class="mt-3"></div>
                                                           <input type="hidden" id="hiddenContacts" name="selected_contacts">

                                                       </div>

                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="mb-3">
                                   <label class="label-guibis-sm">Intervalo Tiempo (segundos)</label>
                                   <input type="text" class="form-control input-guibis-sm" required  name="intervalo_tiempo" id="intervalo_tiempo" placeholder="Intervalos Tiempo Segundos">
                                 </div>

                                 <div class="mb-3">
                                     <label class="form-check-label label-guibis-sm" for="intervalo_tiempo_checkbox">Incluir el Nombre</label>
                                     <input type="checkbox" class="form-check-input input-guibis-sm" name="incluir_nombre" id="incluir_nombre">
                                 </div>

                                 <div class="row">
                                     <div class="col">
                                         <div class="form-check">
                                             <input type="radio" name="modo_tiempo" value="en_tiempo_real" class="form-check-input" id="en_tiempo_real" checked />
                                             <label class="form-check-label" for="en_tiempo_real">En tiempo Real</label>
                                         </div>

                                         <div class="form-check">
                                             <input type="radio" name="modo_tiempo" value="diferido" class="form-check-input" id="diferido" />
                                             <label class="form-check-label" for="diferido">Diferido</label>
                                         </div>
                                     </div>

                                     <!-- Input que aparece solo si se selecciona Diferido -->
                                     <div class="col" id="input_diferido" style="display: none;">
                                         <div class="form-group">
                                             <label class="label-guibis-sm">Fecha de Envío</label>
                                             <input type="date" name="fecha_envio" class="form-control input-guibis-sm" id="fecha_envio" placeholder="Fecha de Envío">
                                         </div>
                                         <div class="form-group">
                                             <label class="label-guibis-sm">Hora de Envío</label>
                                             <input type="time" name="hora_envio" class="form-control input-guibis-sm" id="hora_envio" placeholder="Hora de Envío">
                                         </div>
                                     </div>
                                 </div>

                                 <div id="alerta_diferido" class="alert alert-warning background-warning" style="display: none;">
                                     Solo procesará inertamente las campañas publicitarias
                                 </div>

                                 <input type="hidden" name="numero_extra" value="<?php echo $data_numero['id'] ?>">

                                 <div class="contenedior_general_boton_enviar">
                                     <button type="submit" class="btn btn-success btn-guibis-medium" >  <i class="fab fa-whatsapp"></i> Procesar Campaña Mensaje </button>
                                 </div>
                                 <input type="hidden" name="metodo_envio" value="numeros_extra">


                                  <input type="hidden" name="action" value="iniciar_campana">
                                  <div class="alerta_inicio_campana"></div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header table-card-header">
                                <h5>Vista Previa </h5>
                            </div>
                            <div class="card-block" id="vistaPrevia">


                                <!-- Aquí se mostrará la vista previa del mensaje -->
                            </div>
                            <div class="">
                              <div class="imagenes_vizualizar" id="miniaturas_vista_previa_salida_imagenes">

                              </div>
                              <div class="imagenes_vizualizar" id="url_miniaturas_vista_previa_salida_imagenes">

                              </div>

                            </div>

                            <style media="screen">
                            .imagenes_vizualizar{
                              text-align: center;
                            }
                              .imagenes_vizualizar img{
                                width: 50%;
                              }
                            </style>
                        </div>
                    </div>



                </div>











              </div>
            </div>
            <!-- / Content -->

            <?php
           require 'scripts/footer.php';

             ?>

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <!-- Flat Picker -->
    <script src="/assets/vendor/libs/moment/moment.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <!-- Form Validation -->
    <script src="/assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="/assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="/assets/js/main.js"></script>

    <script type="text/javascript" src="mensajeria/enviar_mensaje_numeros_extra.js?v=10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

            <script type="text/javascript">
          function handleFileSelect(evt) {
              var files = evt.target.files;
              for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                  continue;
                }

                var reader = new FileReader();
                reader.onload = (function(theFile) {
                  return function(e) {
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="img_galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                    document.getElementById('miniaturas_productos').insertBefore(span, null);
                    document.getElementById('miniaturas_vista_previa_salida_imagenes').insertBefore(span, null);
                  };
                })(f);
                reader.readAsDataURL(f);
              }
            }
              document.getElementById('lista').addEventListener('change', handleFileSelect, false);
          </script>

          <script type="text/javascript">
          function updatePreview() {
              var texto = $('#descripcion').val();

              // Convertir negritas y saltos de línea
              var textoFormateado = texto.replace(/\*(.*?)\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');

              // Extraer URLs de imágenes
              var urlsImagenes = texto.match(/(https?:\/\/.*\.(?:png|jpg|jpeg|gif|svg))/ig);

              // Limpiar la vista previa de imágenes anteriores
              $('#url_miniaturas_vista_previa_salida_imagenes').empty();

              if (urlsImagenes) {
                  // Crear y añadir cada imagen a la vista previa
                  urlsImagenes.forEach(function(url) {
                      $('#url_miniaturas_vista_previa_salida_imagenes').append($('<img>').attr('src', url).css('max-width', '100px').css('margin-right', '10px'));
                  });
              }

              // Actualizar el contenido de la vista previa de texto
              $('#vistaPrevia').html(textoFormateado);
          }

          // Escuchar cambios en el área de texto y actualizar la vista previa
          $('#descripcion').on('input', updatePreview);

          // Llamar a updatePreview al cargar la página para mostrar el contenido inicial
          $(document).ready(function() {
              updatePreview();
          });



          </script>


          <script>
              // Lista de contactos JSON devuelta por la API
              const contacts = <?php echo json_encode($data); ?>;
              console.log('Contacts:', contacts);

              const contactInput = document.getElementById('contactInput');
              const contactList = document.getElementById('contactList');
              const tagContainer = document.getElementById('tagContainer');
              const hiddenContacts = document.getElementById('hiddenContacts');
              let selectedContacts = [];

              // Función para actualizar los contactos seleccionados en el input hidden con ID y nombre
              function updateHiddenInput() {
            hiddenContacts.value = selectedContacts
                .map(contact => {
                    // Eliminar "@s.whatsapp.net" del id
                    const cleanId = contact.id.replace('@s.whatsapp.net', '');
                    return `${cleanId}-${contact.name || 'Desconocido'}`;  // ID limpio - Nombre
                })
                .join(',');  // Separados por comas
            console.log('Hidden input updated:', hiddenContacts.value);
        }

              // Función para crear una etiqueta (tag) que muestra número - nombre
              function createTag(contact) {
      const tag = document.createElement('span');
      tag.classList.add('badge', 'badge-info', 'mr-2');

      // Eliminar "@s.whatsapp.net" del id
      const cleanId = contact.id.replace('@s.whatsapp.net', '');
      const label = `${cleanId} - ${contact.name || 'Desconocido'}`;  // ID limpio - Nombre
      tag.innerHTML = `${label} <i class="fas fa-times" style="cursor:pointer"></i>`;

      // Funcionalidad para eliminar la etiqueta
      tag.querySelector('i').onclick = function() {
          tag.remove();
          selectedContacts = selectedContacts.filter(c => c.id !== contact.id);
          updateHiddenInput();
      };
      tagContainer.appendChild(tag);
      console.log('Tag created:', label);
  }

              // Función para filtrar y mostrar contactos en la lista
              // Función para filtrar y mostrar contactos en la lista
function showContactList(filter) {
  contactList.innerHTML = ''; // Limpiar la lista
  const matches = Object.values(contacts).filter(c => {
      return (
          (c.name && c.name.toLowerCase().includes(filter.toLowerCase())) ||
          (c.notify && c.notify.toLowerCase().includes(filter.toLowerCase())) ||
          (c.id && c.id.toLowerCase().includes(filter.toLowerCase()))
      );
  });

  if (matches.length === 0) {
      contactList.classList.add('d-none');
  } else {
      matches.slice(0, 10).forEach(contact => {
          const div = document.createElement('div');
          div.classList.add('list-group-item', 'list-group-item-action');

          // Eliminar "@s.whatsapp.net" del id antes de mostrarlo
          const cleanId = contact.id.replace('@s.whatsapp.net', '');

          // Muestra el id (número) y el nombre en la lista de contactos
          div.textContent = `${cleanId} - ${contact.name || 'Desconocido'}`;
          div.onclick = function() {
              // Evitar duplicados
              if (!selectedContacts.some(c => c.id === contact.id)) {
                  selectedContacts.push(contact);
                  createTag(contact);  // Crea el tag con ambos valores
                  updateHiddenInput();
              }
              contactList.classList.add('d-none');
              contactInput.value = ''; // Limpiar el campo
          };
          contactList.appendChild(div);
      });
      contactList.classList.remove('d-none');
  }
}


              // Evento cuando se escribe en el input
              contactInput.addEventListener('input', function(e) {
                    let value = e.target.value.trim();

                    if (value.startsWith('@')) {
                        // Quitar el '@' y cualquier ocurrencia de '@s.whatsapp.net'
                     value = value.slice(1).replace(/@s\.whatsapp\.net/g, '');  // Expresión regular para quitarlo en cualquier parte
                        showContactList(value);
                    } else {
                        contactList.classList.add('d-none');
                    }
                });

              contactInput.addEventListener('keydown', function(e) {
                  if (e.code === 'Tab' || e.code === 'Space' || e.code === 'Enter') {
                      e.preventDefault(); // Evita que ocurra el comportamiento predeterminado de la tecla (como tabular)

                      const value = contactInput.value.trim();
                      if (value !== '') {
                          const unknownContact = { id: value, name: 'Desconocido' };
                          if (!selectedContacts.some(c => c.id === unknownContact.id)) {
                              selectedContacts.push(unknownContact);
                              createTag(unknownContact);  // Crea el tag con ambos valores
                              updateHiddenInput();
                              contactInput.value = ''; // Limpiar el input después de agregar el contacto desconocido
                          }
                      }
                  }
              });

              // Click fuera del contactList para ocultarlo
              document.addEventListener('click', function(e) {
                  if (!contactList.contains(e.target) && e.target !== contactInput) {
                      contactList.classList.add('d-none');
                  }
              });
          </script>


          <script>
let jsonData = [];

document.getElementById('file_input').addEventListener('change', function(e) {
const file = e.target.files[0];
const reader = new FileReader();

reader.onload = function(e) {
  const data = new Uint8Array(e.target.result);
  const workbook = XLSX.read(data, { type: 'array' });
  const firstSheetName = workbook.SheetNames[0];
  const worksheet = workbook.Sheets[firstSheetName];
  jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

  displayTable(jsonData);
};

reader.readAsArrayBuffer(file);
});

function displayTable(data) {
const tableContainer = document.getElementById('table-container');
let tableHtml = '<table class="table table-sm">';

data.forEach((row, index) => {
  tableHtml += `<tr data-index="${index}">`;
  row.forEach(cell => {
    tableHtml += `<td>${cell}</td>`;
  });
  tableHtml += '</tr>';
});

tableHtml += '</table>';
tableContainer.innerHTML = tableHtml;
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

// Detectar cambios en el input 'intervalos_excel'
document.getElementById('intervalos_excel').oninput = function() {
    const intervals = this.value.split(';'); // Separar los intervalos por punto y coma
    const rows = document.querySelectorAll('#table-container table tr');

    console.log("Intervalos ingresados:", intervals);
    console.log("Número de filas:", rows.length);

    // Limpiar resaltado antes de aplicar nuevos resaltados
    rows.forEach(row => row.style.backgroundColor = '');

    // Procesar cada intervalo ingresado
    intervals.forEach(interval => {
        if (interval.includes('-')) {
            const [start, end] = interval.split('-').map(Number);
            for (let i = start; i <= end; i++) {
                if (i > 0 && i <= rows.length) {
                    rows[i - 1].style.backgroundColor = 'yellow'; // Resaltar la fila
                }
            }
        } else {
            const index = Number(interval);
            if (index > 0 && index <= rows.length) {
                rows[index - 1].style.backgroundColor = 'yellow'; // Resaltar la fila
            }
        }
    });

    updateResult(intervals); // Actualizar el resultado
};

// Función para actualizar el resultado
function updateResult(intervals) {
    let result = [];

    intervals.forEach(interval => {
        if (interval.includes('-')) {
            const [start, end] = interval.split('-').map(Number);
            for (let i = start; i <= end; i++) {
                const row = jsonData[i - 1]; // jsonData debe contener tus datos
                if (row) {
                  const value = row[1] ? `${row[0]}-${row[1]}` : row[0];
                        result.push(value);
                }
            }
        } else {
            const row = jsonData[Number(interval) - 1]; // jsonData debe contener tus datos
            if (row) {
              const value = row[1] ? `${row[0]}-${row[1]}` : row[0];
             result.push(value);
            }
        }
    });

    // Verificación visual y asignación al campo HTML
    const resultField = document.getElementById('result');
    const resultText = result.join(', ');

    console.log("Resultado generado:", resultText); // Verificación en la consola
    $("#datos_excel").val(resultText);
    $("#result").val(resultText);

    console.log(document.getElementById('datos_excel').value);


}
});

</script>








  </body>
</html>
