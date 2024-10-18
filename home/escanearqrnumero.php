
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

    <title>Escaner Qr para <?php echo $data_numero['nombre'] ?> </title>

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
                 <input type="hidden" name="key_wsp_numero_private" id="key_wsp_numero_private" value="<?php echo $codigo ?>">

                 <style media="screen">

                    .login-container {
                        min-height: 100vh;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .login-box {
                        background-color: white;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        max-width: 900px;
                        width: 100%;
                        display: flex;
                        flex-wrap: wrap;
                        padding: 20px;
                    }
                    .login-info {
                        flex: 1;
                        padding: 20px;
                    }
                    .login-info h2 {
                        font-size: 24px;
                        font-weight: bold;
                        color: #075E54; /* WhatsApp green color */
                    }
                    .login-info p {
                        font-size: 16px;
                        margin-top: 10px;
                        color: #555;
                    }
                    .login-info .fa-check-circle {
                        color: #25D366; /* WhatsApp logo green */
                    }
                    .qr-section {
                        flex: 1;
                        padding: 20px;
                        text-align: center;
                        border-left: 1px solid #e0e0e0;
                    }
                    .qr-section img {
                        max-width: 80%;
                        height: auto;
                    }
                    .qr-section p {
                        margin-top: 10px;
                        font-size: 14px;
                        color: #555;
                    }

                 </style>

                 <div class="container login-container" id="contendedor_antes_loguearse" >
                      <div class="login-box">
                          <!-- Información del lado izquierdo -->
                          <div class="login-info">
                              <h2 class="mb-5"><i class="fab fa-whatsapp"></i> WhatsApp Web</h2>
                              <p class="mb-4"><i class="fas fa-check-circle"></i> Escanea este código QR con tu aplicación de WhatsApp para iniciar sesión.</p>
                              <ul class="list-unstyled">
                                  <li class="mb-4"><i class="fas fa-mobile-alt"></i> Abre WhatsApp en tu teléfono</li>
                                  <li class="mb-4"><i class="fas fa-ellipsis-h"></i> Ve al menú de ajustes y selecciona "WhatsApp Web"</li>
                                  <li><i class="fas fa-camera"></i> Escanea el código QR que aparece a la derecha</li>
                              </ul>
                          </div>

                          <!-- Sección del QR en el lado derecho -->
                          <div class="qr-section">

                            <span class="integrador_qr_wsp" ></span>
                              <p>Escanea el código para iniciar sesión.</p>
                          </div>
                      </div>
                  </div>


                  <div class="container" id="contendedor_despues_loguearse" >
                       <h2>Estado de Conexión y Lista de Contactos <?php echo $data_numero['nombre'] ?></h2>

                       <div class="console mt-4">
                           <div class="status">
                               <i class="fas fa-circle"></i> <!-- Icono de estado -->
                               <span id="connection-status">Conexión  <span class="estado_session" ></span> </span>
                           </div>

                           <h4 class="mt-4">Lista de Contactos</h4>
                           <ul id="contact-list" class="list-group">

                           </ul>
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
    <script src="mensajeria/whatsapp_numero_private.js?v=5"></script>




  </body>
</html>
