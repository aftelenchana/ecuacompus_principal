
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

    <title>Nube</title>

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
        <!-- Menu -->


        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php
         require 'scripts/barra_superior.php';

          ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <button class="btn btn-secondary create-new btn-primary waves-effect waves-light" type="button" id="boton_agregar_cliente">
                <span>
                  <i class="ri-add-line ri-16px me-sm-2"></i>
                  <span class="d-none d-sm-inline-block">Agregar Nuevo Archivo</span>
                </span>
              </button>

              <!-- DataTable with Buttons -->
              <div class="card">
                <div class="card-datatable table-responsive pt-0">
                  <table id="tabla_clientes" class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Mensaje</th>
                        <th>Tamaño</th>
                        <th>Fecha </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <!-- Modal to add new record -->


                             <div class="modal fade" id="modal_agregar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                 <div class="modal-content">
                                   <div class="modal-header header_guibis" style="background-color: #263238;">
                                     <h5 class="modal-title" id="proveedorModalLabel">Agregar Archivos</h5>
                                     <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                   </div>
                                   <div class="modal-body">

                                     <form action=""  id="add_cliente" >


                                       <div class="form-group">
                                           <label class="label-guibis-sm"></label>
                                           <input type="file" name="archivo" required class="form-control"  id="foto_subida">
                                       </div>


                                       <div class="mb-3">
                                         <label class="label-guibis-sm">Servidor</label>
                                         <select class="form-control input-guibis-sm" required  name="servidor" id="servidor">
                                         </select>
                                       </div>

                                       <div class="mb-3">
                                         <label class="label-guibis-sm">Descripción </i></label>
                                         <textarea class="form-control input-guibis-sm"   name="descripcion" id="descripcion" rows="3"></textarea>
                                       </div>

                                         <div class="modal-footer">
                                           <input type="hidden" name="action" value="agregar_variables_entorno">
                                           <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                           <button type="submit" class="btn btn-primary btn-guibis-medium">Agregar Archivos <i class="fas fa-plus"></i></button>
                                         </div>
                                         <div class="noticia_agregar_variables_entorno"></div>
                                       </form>
                                   </div>
                                 </div>
                               </div>
                             </div>



                             <div class="modal fade" id="modal_editar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                 <div class="modal-content">
                                   <div class="modal-header header_guibis" style="background-color: #263238;">
                                     <h5 class="modal-title" id="proveedorModalLabel">Editar Archivo  </h5>
                                     <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                   </div>
                                   <div class="modal-body">

                                     <form action=""  id="update_cliente" >

                                       <div class="mb-3">
                                         <label class="label-guibis-sm">Editar Archivo </i></label>
                                         <textarea class="form-control input-guibis-sm"   name="descripcion" id="descripcion_update" rows="3"></textarea>
                                       </div>
                                         <div class="modal-footer">
                                           <input type="hidden" name="action" value="editar_archivo">
                                           <input type="hidden" name="id_archivo" id="id_archivo" value="">
                                           <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                           <button type="submit" class="btn btn-primary btn-guibis-medium">Editar Archivo</button>
                                         </div>
                                         <div class="alerta_editar_archivo"></div>
                                       </form>
                                   </div>
                                 </div>
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
    <script type="text/javascript" src="mensajeria/nube.js?v=5"></script>
    <script type="text/javascript" src="mensajeria/numeros_extras.js?v=13"></script>
    <!-- Script para mostrar el offcanvas al hacer clic en el botón -->


  </body>
</html>
