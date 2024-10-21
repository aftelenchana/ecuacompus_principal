
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

    <title>Números Extras</title>

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
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <button class="btn btn-secondary create-new btn-primary waves-effect waves-light" type="button" id="open-offcanvas">
                <span>
                  <i class="ri-add-line ri-16px me-sm-2"></i>
                  <span class="d-none d-sm-inline-block">Agregar nuevo número</span>
                </span>
              </button>

              <!-- DataTable with Buttons -->
              <div class="card">
                <div class="card-datatable table-responsive pt-0">
                  <table id="tabla_clientes" class="table table-bordered">
                    <thead>
                      <tr>

                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Número</th>
                        <th>Status</th>
                        <th>Mensaje</th>
                        <th>QR</th>

                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <!-- Modal to add new record -->

  <!-- Offcanvas que se mostrará al hacer clic en el botón -->
  <div class="offcanvas offcanvas-end" id="add-new-record" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="exampleModalLabel">Nuevo Número </h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <!-- Formulario dentro del offcanvas -->
      <form class="add-new-record pt-0 row g-3" id="add_cliente" onsubmit="return false">
        <div class="col-sm-12">
          <div class="input-group input-group-merge">
            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
            <div class="form-floating form-floating-outline">
              <input type="text" id="basicFullname" class="form-control dt-full-name" name="nombre" placeholder="Nombre" aria-label="John Doe" aria-describedby="basicFullname2" />
              <label for="basicFullname">Nombre </label>
            </div>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="input-group input-group-merge">
            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
            <div class="form-floating form-floating-outline">
              <input type="text" id="basicFullname" class="form-control dt-full-name" name="numero" placeholder="Número" aria-label="John Doe" aria-describedby="basicFullname2" />
              <label for="basicFullname">Número</label>
            </div>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="input-group input-group-merge">
            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
            <div class="form-floating form-floating-outline">
              <!-- Reemplazamos el input por un select -->
              <select id="basicServer" class="form-select" name="servidor" aria-label="Selecciona servidor">
                <?php
                $query_servidor = mysqli_query($conection, "SELECT * FROM servidores_wsp WHERE  servidores_wsp.estatus = 1   ");
                while ($data_servidor = mysqli_fetch_array($query_servidor)) {

                  $url_servidor = $data_servidor['url'];

                  $ch = curl_init();

                  $url_verificacion_session = $url_servidor . '/check-session';
                  $postData = array(
                      'sessionId2' => 'hola mundo'  // Asegúrate de enviar los datos requeridos por la API
                  );

                  // Configurar cURL para hacer la solicitud POST
                  curl_setopt($ch, CURLOPT_URL, $url_verificacion_session);
                  curl_setopt($ch, CURLOPT_POST, true);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));  // Convertir el array PHP a JSON

                  // Ejecutar la solicitud y obtener la respuesta
                  $response = curl_exec($ch);

                  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                  if(curl_errno($ch)) {
                      $estado_api = 'Error en cURL: ' . curl_error($ch);
                      $row['mensaje'] = $estado_api;
                      $row['estado'] = 'No Disponible';
                      $row['http_code'] = '404';
                  } else {
                      $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                      $row['http_code'] = $http_code;
                      // Verifica si json_decode devolvió null y si hubo un error en la conversión
                      if (json_last_error() === JSON_ERROR_NONE) {
                          $data_api = json_decode($response, true);
                          // La respuesta es un JSON válido
                          if (isset($data_api['error']) && $data_api['error'] === 'El sessionId es requerido.') {
                              $estado = 'Disponible';
                              $mensaje = 'Servidor Disponible';
                              echo '<option  value="' . $data_servidor['id'] . '">' . $data_servidor['nombre'] . '/ ' . $data_servidor['tipo'] . '</option>';
                              // Aquí puedes agregar más código si es necesario
                          } else {
                              $estado = 'No Disponible';
                              $mensaje = 'Servidor no disponible Servidor Caido';

                              if ($row['http_code'] == 400) {
                                $estado = 'Disponible';
                                $mensaje = 'Servidor Disponible';
                                echo '<option  value="' . $data_servidor['id'] . '">' . $data_servidor['nombre'] . '/ ' . $data_servidor['tipo'] . '</option>';
                                // code...
                              }else {
                                $estado = 'No Disponible';
                                $mensaje = 'Servidor no disponible Servidor Caido';
                                // code...
                              }


                          }
                      } else {

                        if ($row['http_code'] == 400) {
                          $estado = 'Disponible';
                          $mensaje = 'Servidor Disponible';
                            echo '<option  value="' . $data_servidor['id'] . '">' . $data_servidor['nombre'] . '/ ' . $data_servidor['tipo'] . '</option>';
                          // code...
                        }else {
                          // Maneja el caso donde la respuesta no es un JSON válido
                          $mensaje = 'Error: Respuesta no válida';
                          $estado= 'No Disponible';
                          $mensaje = 'Servidor no  creado.';
                          // code...
                        }

                      }

                  }

                  // Cerrar cURL
                  curl_close($ch);

                }
                ?>
              </select>
              <label for="basicServer">Servidor</label>
            </div>
          </div>
        </div>

        <!-- Más campos aquí -->
        <div class="col-sm-12">
            <input type="hidden" name="action" value="agregar_numero_extra" required>
          <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Agregar Número</button>
          <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
        </div>
        <div class="noticia_agregar_numeros">

        </div>
      </form>
    </div>
  </div>



              <!--/ Multilingual -->
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
    <script type="text/javascript" src="mensajeria/numeros_extras.js?v=7"></script>
    <!-- Script para mostrar el offcanvas al hacer clic en el botón -->
    <script>
      document.getElementById('open-offcanvas').addEventListener('click', function () {
        var offcanvasElement = new bootstrap.Offcanvas(document.getElementById('add-new-record'));
        offcanvasElement.show(); // Muestra el offcanvas
      });
    </script>


  </body>
</html>
