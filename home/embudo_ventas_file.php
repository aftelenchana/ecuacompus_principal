
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

    <title>Embudo de Ventas</title>

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


              <!-- DataTable with Buttons -->
              <div class="card">

                <style>

                  .crm-guibis-wsp-column {
                      display: inline-block; /* Permitir que las columnas estén en línea */
                      vertical-align: top; /* Alinear verticalmente al top */
                      width: 300px; /* Fijar el ancho de las columnas */
                      margin-right: 0px; /* Espacio entre columnas */
                      padding: 0px;
                  }
                  .crm-guibis-wsp-card {
                      background-color: #f8f9fa; /* Fondo gris claro para la tarjeta */
                      border-radius: 10px;
                      padding: 2px;
                      margin: 2px;
                      font-size: 12px;
                      text-align: center; /* Centrar contenido en la tarjeta */
                  }
                  .crm-guibis-wsp-card h5 {
                    font-size: 12px;
                  }


                  .crm-guibis-wsp-header {
                      margin-bottom: 3px;
                      font-weight: bold;
                      font-size: 1rem; /* Tamaño de letra */
                      color: black; /* Color del texto */
                      text-align: center; /* Alinear el texto al centro */
                  }
                  .crm-guibis-wsp-img-cover {
                      width: 50px; /* Ajusta el ancho */
                      height: 50px; /* Ajusta la altura */
                      object-fit: cover;
                      border-radius: 50%;
                      margin-bottom: 10px; /* Espacio entre la imagen y el texto */
                  }
              </style>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header table-card-header">
                                <h5>Embudo de Ventas</h5>
                            </div>
                            <div class="card-block contenedor_crm_wsp">

                              <style media="screen">
                                .tarjeta_bloque_hr{
                                  border: 2px;
                                  margin: 10px;
                                }
                                .card-header-guibis{
                                  padding: 3px;
                                  background: #259bd6 ;
                                  color: #fff;
                                  font-weight: bold;
                                }
                                .card-header-guibis h5{
                                  padding: 1px;
                                  margin: 1px;
                                }

                                .boton_agregar_datos{
                                  float: right;
                                }
                                .dt-buttons{
                                  display: none;
                                }

                              </style>

                              <div class="card tarjeta_bloque_hr">
                                <div class="card-header-guibis">
                                    <h5>Búsqueda Global
                                     </h5>
                                </div>

                                <div class="card-block">
                                  <form action=""  id="procesar_datos" >
                                    <div class="row">

                                        <div class="col-12 col-md mb-3">
                                            <div class="form-group d-flex align-items-center">
                                                <label class="label-guibis-sm mr-2">Filtro</label>
                                                <input type="text" name="filtro" class="form-control input-guibis-sm" required id="filtro" placeholder="Filtro" oninput="buscarContactos()">
                                            </div>
                                        </div>


                                    </div>


                                  </form>

                                </div>

                              </div>









                              <style media="screen">
                                .botones_acciones_embudo{
                                  text-align: right;
                                  padding: 5px;
                                  margin: 5px;
                                }
                                .botones_acciones_embudo button{
                                  margin: 3px;
                                }
                              </style>
                              <div class="botones_acciones_embudo">
                                <button type="button" class="btn btn-primary btn-guibis-medium " id="boton_agregar_contacto" name="button">Agregar Contacto <i class="fas fa-plus"></i></button>

                                <button type="button" class="btn btn-success btn-guibis-medium " id="boton_agregar_contactos_masivamente_wsp" name="button">Agregar Contactos Masivamente Whatsapp <i class="fas fa-plus"></i></button>

                              </div>

                              <div class="card-block">
                                <div class="container-fluid  contenedor_clases_crm">
                                    <div class="row">
                                        <div class="col crm-guibis-wsp-column">
                                            <div class="crm-guibis-wsp-header"> <a href="contacts_embudo_venta?tipo=Primer Contacto">Primer Contacto</a> </div>
                                            <div class="resultado_primer_contacto"></div>

                                        </div>

                                        <div class="col crm-guibis-wsp-column">

                                            <div class="crm-guibis-wsp-header"> <a href="#">NO CONTESTA</a> </div>
                                            <div class="resultado_no_contesta"> </div>

                                        </div>

                                        <div class="col crm-guibis-wsp-column">
                                            <div class="crm-guibis-wsp-header"> <a href="#">CONOCIMIENTO</a> </div>
                                            <div class="resultado_conocimiento"> </div>

                                        </div>

                                        <div class="col crm-guibis-wsp-column">
                                            <div class="crm-guibis-wsp-header"> <a href="#">POTENCIALES</a> </div>
                                            <div class="resultado_potenciales"></div>

                                        </div>

                                        <div class="col crm-guibis-wsp-column">


                                            <div class="crm-guibis-wsp-header"> <a href="#">CONSIDERACIÓN</a> </div>
                                            <div class="resultado_consideracion"></div>


                                        </div>

                                    </div>
                                </div>


                              </div>



                            </div>
                        </div>
                    </div>
                </div>





              </div>
              <!-- Modal to add new record -->


                           <div class="modal fade" id="modal_agregar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                             <div class="modal-dialog ">
                               <div class="modal-content">
                                 <div class="modal-header header_guibis" style="background-color: #263238;">
                                   <h5 class="modal-title" id="proveedorModalLabel">Agregar Contacto</h5>
                                   <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                 </div>
                                 <div class="modal-body">

                                     <form method="post" name="agregar_contacto" id="agregar_contacto" onsubmit="event.preventDefault(); sendData_agregar_contacto()" >

                                     <div class="form-group">
                                       <label class="label-guibis-sm">Nombres</label>
                                       <input type="text"  class="form-control resultado_nombres_consumo_api input-guibis-sm" id="nombres"  name="nombres" aria-describedby="emailHelp" placeholder="Nombres">
                                     </div>
                                     <div class="form-group">
                                       <label class="label-guibis-sm">Email</label>
                                       <input type="email" name="email" class="form-control input-guibis-sm"  id="email" placeholder="Email">
                                     </div>

                                     <div class="row">
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Identificación</label>
                                           <input type="text" name="identificacion" class="form-control ocupar_api_sacar_informacion input-guibis-sm"  id="identificacion" placeholder="Identificación">
                                         </div>
                                       </div>
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Tipo de Identificación</label>
                                           <select class="form-control input-guibis-sm" name="tipo_identificacion"  id="tipo_identificacion">
                                             <option value="">Ninguna</option>
                                             <option value="04">RUC</option>
                                             <option value="05">CEDULA</option>
                                             <option value="06">PASAPORTE</option>
                                             <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                             <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                                           </select>
                                         </div>
                                       </div>
                                     </div>

                                     <div class="form-group">
                                       <label class="label-guibis-sm">Tipo</label>
                                       <select class="form-control input-guibis-sm" name="tipo" required id="tipo">
                                         <option value="Primer Contacto">Primer Contacto</option>
                                         <option value="NO CONTESTA">NO CONTESTA</option>
                                         <option value="CONOCIMIENTO">CONOCIMIENTO</option>
                                         <option value="POTENCIALES">POTENCIALES</option>
                                         <option value="CONSIDERACIÓN">CONSIDERACIÓN</option>
                                       </select>
                                     </div>

                                     <div class="row">
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Celular</label>
                                           <input type="number" name="celular" class="form-control input-guibis-sm"  id="celular" placeholder="Celular">
                                         </div>
                                       </div>
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Teléfono</label>
                                           <input type="number" name="telefono" class="form-control input-guibis-sm"  id="celular" placeholder="Teléfono">
                                         </div>
                                       </div>
                                     </div>


                                     <div class="form-group">
                                       <label class="label-guibis-sm">Dirección</label>
                                       <input type="text" name="direccion" class="form-control input-guibis-sm"  id="direccion" placeholder="Dirección">
                                     </div>


                                     <div class="form-group">
                                         <label class="label-guibis-sm">Ingresa una Imagen</label>
                                         <input type="file" name="foto" class="form-control input-guibis-sm" accept="image/png, .jpeg, .jpg"   id="exampleFormControlFile1">
                                     </div>
                                     <div class="form-group">
                                       <label class="label-guibis-sm">Descripción </label>
                                       <textarea class="form-control input-guibis-sm" name="descripcion"  id="descripcion" rows="3"></textarea>
                                     </div>

                                       <div class="modal-footer">
                                         <input type="hidden" name="action" value="agregar_contacto" required>
                                         <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                         <button type="submit" class="btn btn-primary btn-guibis-medium">Agregar Contacto</button>
                                       </div>
                                       <div class="noticia_agregar_contactos">

                                       </div>
                                     </form>
                                 </div>
                               </div>
                             </div>
                           </div>

                           <style media="screen">
                             .resultado_opciones_contactos_embudo {
                               font-size: 13px;
                             }
                           </style>



                           <div class="modal fade" id="modal_editar_contacto" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                             <div class="modal-dialog ">
                               <div class="modal-content">
                                 <div class="modal-header header_guibis" style="background-color: #263238;">
                                   <h5 class="modal-title" id="proveedorModalLabel">Editar Contacto</h5>
                                   <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                 </div>
                                 <div class="modal-body">

                                     <form method="post" name="editar_contacto" id="editar_contacto" onsubmit="event.preventDefault(); sendData_editar_contacto()" >

                                       <div class="img_editar_contacto text-center">

                                       </div>
                                       <div class="form-group">
                                           <label class="label-guibis-sm">Ingresa una Imagen</label>
                                           <input type="file" name="foto" class="form-control input-guibis-sm" accept="image/png, .jpeg, .jpg"   id="exampleFormControlFile1">
                                       </div>
                                     <div class="form-group">
                                       <label class="label-guibis-sm">Nombres</label>
                                       <input type="text"  class="form-control resultado_nombres_consumo_api input-guibis-sm" id="nombres_update"  name="nombres" aria-describedby="emailHelp" placeholder="Nombres">
                                     </div>
                                     <div class="form-group">
                                       <label class="label-guibis-sm">Email</label>
                                       <input type="email" name="email" class="form-control input-guibis-sm"  id="email_update" placeholder="Email">
                                     </div>

                                     <div class="row">
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Identificación</label>
                                           <input type="text" name="identificacion" class="form-control ocupar_api_sacar_informacion input-guibis-sm"  id="identificacion_update" placeholder="Identificación">
                                         </div>
                                       </div>
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Tipo de Identificación</label>
                                           <select class="form-control input-guibis-sm" name="tipo_identificacion"  id="tipo_identificacion_update">
                                             <option value="">Ninguna</option>
                                             <option value="04">RUC</option>
                                             <option value="05">CEDULA</option>
                                             <option value="06">PASAPORTE</option>
                                             <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                             <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                                           </select>
                                         </div>
                                       </div>
                                     </div>

                                     <div class="form-group">
                                       <label class="label-guibis-sm">Tipo</label>
                                       <select class="form-control input-guibis-sm" name="tipo" required id="tipo_update">
                                         <option value="Primer Contacto">Primer Contacto</option>
                                         <option value="NO CONTESTA">NO CONTESTA</option>
                                         <option value="CONOCIMIENTO">CONOCIMIENTO</option>
                                         <option value="POTENCIALES">POTENCIALES</option>
                                         <option value="CONSIDERACIÓN">CONSIDERACIÓN</option>
                                       </select>
                                     </div>

                                     <div class="row">
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Celular</label>
                                           <input type="number" name="celular" class="form-control input-guibis-sm"  id="celular_update" placeholder="Celular">
                                         </div>
                                       </div>
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Teléfono</label>
                                           <input type="number" name="telefono" class="form-control input-guibis-sm"  id="telefono_update" placeholder="Teléfono">
                                         </div>
                                       </div>
                                     </div>


                                     <div class="form-group">
                                       <label class="label-guibis-sm">Dirección</label>
                                       <input type="text" name="direccion" class="form-control input-guibis-sm"  id="direccion_update" placeholder="Dirección">
                                     </div>



                                     <div class="form-group">
                                       <label class="label-guibis-sm">Descripción </label>
                                       <textarea class="form-control input-guibis-sm" name="descripcion"  id="descripcion_update" rows="3"></textarea>
                                     </div>

                                       <div class="modal-footer">
                                         <input type="hidden" name="action" value="editar_contacto" required>
                                         <input type="hidden" name="id_contacto" id="id_contacto"  value="">
                                         <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                         <button type="submit" class="btn btn-primary btn-guibis-medium">Editar Contacto</button>
                                       </div>
                                       <div class="noticia_editar_contactos">

                                       </div>
                                     </form>
                                 </div>
                               </div>
                             </div>
                           </div>





                           <div class="modal fade" id="modal_agregar_contactos_wsp" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                             <div class="modal-dialog ">
                               <div class="modal-content">
                                 <div class="modal-header header_guibis" style="background-color: #263238;">
                                   <h5 class="modal-title" id="proveedorModalLabel">Agregar Contacto Masivamente de tu Whatsapp</h5>
                                   <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                 </div>
                                 <div class="modal-body">

                                     <form method="post" name="agregar_contacto_masivamente_wsp" id="agregar_contacto_masivamente_wsp" onsubmit="event.preventDefault(); sendData_agregar_contacto_msivamente_wsp()" >

                                     <div class="row">

                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Elige Tu número</label>
                                           <select class="form-control input-guibis-sm" name="numero_guibis" required id="numero_guibis">

                                           </select>
                                         </div>
                                       </div>
                                     </div>

                                     <div class="form-group">
                                       <label class="label-guibis-sm">Tipo</label>
                                       <select class="form-control input-guibis-sm" name="tipo" required id="tipo_update">
                                         <option value="Primer Contacto">Primer Contacto</option>
                                         <option value="NO CONTESTA">NO CONTESTA</option>
                                         <option value="CONOCIMIENTO">CONOCIMIENTO</option>
                                         <option value="POTENCIALES">POTENCIALES</option>
                                         <option value="CONSIDERACIÓN">CONSIDERACIÓN</option>
                                       </select>
                                     </div>





                                       <div class="modal-footer">
                                         <input type="hidden" name="action" value="agregar_contacto_masivamente_wsp" required>
                                         <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                         <button type="submit" class="btn btn-primary btn-guibis-medium">Agregar Contactos Masivamente de Whatsapp</button>
                                       </div>
                                       <div class="noticia_agregar_contactos_masivamente_wsp">

                                       </div>
                                     </form>
                                 </div>
                               </div>
                             </div>
                           </div>


                           <div class="modal fade" id="modal_eliminar_contacto" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                             <div class="modal-dialog ">
                               <div class="modal-content">
                                 <div class="modal-header header_guibis" style="background-color: #263238;">
                                   <h5 class="modal-title" id="proveedorModalLabel">Estas segura que deseas eliminar este contacto ? </h5>
                                   <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                 </div>
                                 <div class="modal-body">

                                     <form method="post" name="eliminar_contacto" id="eliminar_contacto" onsubmit="event.preventDefault(); sendData_eliminar_contacto()" >

                                       <div class="img_eliminar_contacto text-center">

                                       </div>

                                     <div class="form-group">
                                       <label class="label-guibis-sm">Nombres</label>
                                       <input type="text" readonly  class="form-control resultado_nombres_consumo_api input-guibis-sm" id="nombres_delete"  name="nombres" aria-describedby="emailHelp" placeholder="Nombres">
                                     </div>
                                     <div class="form-group">
                                       <label class="label-guibis-sm">Email</label>
                                       <input type="email" readonly name="email" class="form-control input-guibis-sm"  id="email_delete" placeholder="Email">
                                     </div>

                                     <div class="row">
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Identificación</label>
                                           <input type="text" readonly name="identificacion" class="form-control ocupar_api_sacar_informacion input-guibis-sm"  id="identificacion_delete" placeholder="Identificación">
                                         </div>
                                       </div>
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Tipo de Identificación</label>
                                           <select disabled class="form-control input-guibis-sm" name="tipo_identificacion"  id="tipo_identificacion_delete">
                                             <option value="">Ninguna</option>
                                             <option value="04">RUC</option>
                                             <option value="05">CEDULA</option>
                                             <option value="06">PASAPORTE</option>
                                             <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                             <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                                           </select>
                                         </div>
                                       </div>
                                     </div>

                                     <div class="form-group">
                                       <label class="label-guibis-sm">Tipo</label>
                                       <select disabled class="form-control input-guibis-sm" name="tipo" required id="tipo_delete">
                                         <option value="Primer Contacto">Primer Contacto</option>
                                         <option value="NO CONTESTA">NO CONTESTA</option>
                                         <option value="CONOCIMIENTO">CONOCIMIENTO</option>
                                         <option value="POTENCIALES">POTENCIALES</option>
                                         <option value="CONSIDERACIÓN">CONSIDERACIÓN</option>
                                       </select>
                                     </div>

                                     <div class="row">
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Celular</label>
                                           <input readonly type="number" name="celular" class="form-control input-guibis-sm"  id="celular_delete" placeholder="Celular">
                                         </div>
                                       </div>
                                       <div class="col">
                                         <div class="form-group">
                                           <label class="label-guibis-sm">Teléfono</label>
                                           <input readonly type="number" name="telefono" class="form-control input-guibis-sm"  id="telefono_delete" placeholder="Teléfono">
                                         </div>
                                       </div>
                                     </div>


                                     <div class="form-group">
                                       <label class="label-guibis-sm">Dirección</label>
                                       <input readonly type="text" name="direccion" class="form-control input-guibis-sm"  id="direccion_delete" placeholder="Dirección">
                                     </div>



                                     <div class="form-group">
                                       <label class="label-guibis-sm">Descripción </label>
                                       <textarea readonly class="form-control input-guibis-sm" name="descripcion"  id="descripcion_delete" rows="3"></textarea>
                                     </div>

                                       <div class="modal-footer">
                                         <input type="hidden" name="action" value="eliminar_contacto" required>
                                         <input type="hidden" name="id_contacto" id="id_contacto_delete"  value="">
                                         <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                         <button type="submit" class="btn btn-primary btn-guibis-medium">Eliminar Contacto</button>
                                       </div>
                                       <div class="noticia_eliminar_contactos">

                                       </div>
                                     </form>
                                 </div>
                               </div>
                             </div>
                           </div>





                                        <div class="modal fade" id="modal_envirar_mensaje_rapido" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                                          <div class="modal-dialog ">
                                            <div class="modal-content">
                                              <div class="modal-header header_guibis" style="background-color: #263238;">
                                                <h5 class="modal-title" id="proveedorModalLabel">Enviar Mensaje Rápido</h5>
                                                <button type="button" class="btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                              </div>
                                              <div class="modal-body">

                                                  <form method="post" name="enviar_mensaje_rapido" id="enviar_mensaje_rapido" onsubmit="event.preventDefault(); sendData_enviar_mensaje_rapido()" >

                                                    <div class="img_enviar_mensaje_rapido text-center">

                                                    </div>
                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="form-group">
                                                        <label class="label-guibis-sm">Elige Tu número</label>
                                                        <select class="form-control input-guibis-sm" name="numero_guibis" required id="numero_guibis_enviar_mensaje_rapido">

                                                        </select>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="mb-3">
                                                        <label class="label-guibis-sm">Mensaje </i></label>
                                                        <textarea class="form-control input-guibis-sm"   name="mensaje" id="mensaje" rows="3"></textarea>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col">

                                                      <div class="mb-3">
                                                        <label class="label-guibis-sm">Quieres elegir una plantilla ? </label>
                                                        <select class="form-control input-guibis-sm"  name="plantilla_wsp" id="plantilla_wsp">
                                                          <option value="">Ninguna</option>
                                                          <?php
                                                          $query_plantilla = mysqli_query($conection, "SELECT * FROM plantillas_wsp WHERE  plantillas_wsp.iduser= '$iduser'   AND plantillas_wsp.estatus = 1 ");
                                                          while ($data_plantilla = mysqli_fetch_array($query_plantilla)) {
                                                            echo '<option  value="' . $data_plantilla['id'] . '">' . $data_plantilla['nombre'] . '</option>';
                                                          }
                                                          ?>
                                                        </select>
                                                      </div>

                                                    </div>

                                                  </div>



                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="mb-3">
                                                            <label class="label-guibis-sm">Archivo</label>
                                                            <input type="file" name="archivo" class="form-control input-guibis-sm" id="archivo" placeholder="Agregue Archivo">
                                                        </div>
                                                    </div>
                                                  </div>


                                                  <div class="row">

                                                    <style media="screen">
                                                    .sugerencias-list {
                                                          border: 1px solid #ccc;
                                                          max-height: 200px;
                                                          overflow-y: auto;
                                                          position: absolute; /* Puedes ajustar según tus necesidades */
                                                          z-index: 1000; /* Asegúrate de que se muestre sobre otros elementos */
                                                          background-color: white;
                                                        }
                                                        .sugerencia-item {
                                                          padding: 8px;
                                                          cursor: pointer;
                                                        }
                                                        .sugerencia-item:hover {
                                                          background-color: #f0f0f0;
                                                        }

                                                        .archivos-agregados {
                                                            margin-top: 10px;
                                                        }
                                                        .archivo-item {
                                                            display: inline-block;
                                                            background-color: #f0f0f0;
                                                            padding: 5px;
                                                            margin-right: 5px;
                                                            margin-bottom: 5px;
                                                            border-radius: 4px;
                                                        }
                                                        .archivo-item .remove {
                                                            color: red;
                                                            margin-left: 5px;
                                                            cursor: pointer;
                                                        }
                                                    </style>
                                                    <div class="col">
                                                      <div class="mb-3">
                                                            <label class="label-guibis-sm">Búscador Archivos Nube</label>
                                                            <input type="text" name="buscador_archivos_nube" class="form-control input-guibis-sm" id="buscador_archivos_nube" placeholder="Búscador de Archivos Nube">
                                                            <div id="sugerencias" class="sugerencias-list" style="display: none;"></div>
                                                            <input type="hidden" name="archivos_seleccionados" id="archivos_seleccionados">
                                                        </div>
                                                        <div id="archivos-agregados" class="archivos-agregados"></div>
                                                    </div>
                                                  </div>
                                                    <div class="modal-footer">
                                                      <input type="hidden" name="action" value="enviar_mensaje_rapido" required>
                                                      <input type="hidden" name="contacto" id="contacto_mensaje_envio" value="">
                                                      <button type="button" class="btn btn-danger btn-guibis-medium" data-bs-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                                      <button type="submit" class="btn btn-primary btn-guibis-medium">Enviar Mensaje Rápido</button>
                                                    </div>
                                                    <div class="noticia_enviar_mensaje_rapido">

                                                    </div>
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

    <script src="embudo_ventas/contactos.js?v=10"></script>
    <script type="text/javascript">

    $(document).ready(function(){
      // Evento cuando cambia el valor del select
      $(document).on('change', '#plantilla_wsp', function(){
        var cliente = $(this).val(); // Obtener el valor seleccionado
        console.log(cliente);

        var action = 'info_cliente';
        $.ajax({
          url:'mensajeria/plantillas.php',
          type:'POST',
          async: true,
          data: {action:action,cliente:cliente},
           success: function(response){
             console.log(response);
             if (response != 'error') {
               var info = JSON.parse(response);

               $('#mensaje').val(info.texto);

             }
           },
           error:function(error){
             console.log(error);
             }
           });


      });
    });
    </script>



  </body>
</html>
