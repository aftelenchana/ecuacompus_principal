<?php
include ('../facturacion/facturacionphp/lib/codigo_barras/barcode.inc.php');
include "../../coneccion.php";
      mysqli_set_charset($conection, 'utf8'); //linea a colocar
$iduser = $_GET['id'];
$clave_acc_guardar = $_GET['clave_acc_guardar'];
$codigo_factura    = $_GET['codigo_factura'];
$fechaAutorizacion = $_GET['fechaAutorizacion'];


		new barCodeGenrator(''.$clave_acc_guardar.'', 1, 'barra.gif', 455, 60, false);
$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura'");
$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
  $celular_receptor_uwu        = $data__emmisor['celular_receptor'];
  $direccion_receptor_uwu      = $data__emmisor['direccion_reeptor'];
  $email_reeptor               = $data__emmisor['email_reeptor'];
  $codigo_formas_pago          = $data__emmisor['formas_pago'];
  $razon_social_cliente_2      = $data__emmisor['nombres_receptor'];
  $identificacion_cliente      = $data__emmisor['numero_identidad_receptor'];
	$celular_receptor            = $data__emmisor['celular_receptor'];
	$direccion_reeptor           = $data__emmisor['direccion_reeptor'];
  $idcliente                   = $data__emmisor['id_receptor'];
  $sucursal_facturacion        = $data__emmisor['sucursal_facturacion'];


  $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion'");
  $data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

  $direccion_sucursal        = $data_sucursal['direccion_sucursal'];

  $estableciminento_f  = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
  $punto_emision_f  = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);



  //codigo para sacar la secuencia del usuario

  $establecimiento_sinceros        = $data_sucursal['establecimiento'];
  $punto_emision_sinceros        = $data_sucursal['punto_emision'];

  $query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = '$iduser' AND comprobante_factura_final.punto_emision ='$punto_emision_sinceros'
    AND comprobante_factura_final.establecimiento ='$establecimiento_sinceros' ORDER BY fecha DESC");
   $result_secuencia = mysqli_fetch_array($query_secuencia);
   if ($result_secuencia) {
     $secuencial = $result_secuencia['codigo_factura'];
     $secuencial = $secuencial +1;
     // code...
   }else {
     $secuencial =1;
   }
   $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);



$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
$result_documentos = mysqli_fetch_array($query_doccumentos);
$regimen = $result_documentos['regimen'];
$contabilidad             = $result_documentos['contabilidad'];
$email_empresa_emisor     = $result_documentos['email'];
$celular_empresa_emisor   = $result_documentos['celular'];
$telefono_empresa_emisor  = $result_documentos['telefono'];
$direccion_emisor          = $result_documentos['direccion'];
$nombres                  = $result_documentos['nombres'];
$apellidos                = $result_documentos['apellidos'];
$numero_identificacion_emisor  = $result_documentos['numero_identidad'];
$contribuyente_especial   = $result_documentos['contribuyente_especial'];

$contabilidad            = $result_documentos['contabilidad'];
$img_facturacion         = $result_documentos['img_facturacion'];
$contabilidad         = $result_documentos['contabilidad'];
$regimen         = $result_documentos['regimen'];
$razon_social         = $result_documentos['razon_social'];

$facebook                = $result_documentos['facebook'];
$pagina_web                = $result_documentos['pagina_web'];
$instagram           = $result_documentos['instagram'];
$whatsapp             = $result_documentos['whatsapp'];
$url_img_upload             = $result_documentos['url_img_upload'];
$nombre_empresa      = $result_documentos['nombre_empresa'];


//fechas
$fecha_actual = date("d-m-Y");
$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));



//INFORMACION COMERCIAL DE LOS PUNTOS DE EMISON

$numeroConCeros = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
$secuencial_neto = $numeroConCeros;

$email_empresa_emisor = str_replace('@', '&#64;', $email_empresa_emisor);

$email_receptor = str_replace('@', '&#64;', $email_reeptor);

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura </title>
  </head>
  <style media="screen">

.img_logo_empresa{
  text-align: center;
}

  .img_logo_empresa img{
    width: 100px;
  }
  .parte_superior{
    padding: 2px;
    margin: 2px;
    height: 250px;
  }
  .td_bld{
    font-weight: bold;
  }
  .informacion_emisor th,td{
    padding: 0;
    margin: 0;
  }

  .informacion_emisor{
    padding: 10px;
    margin-bottom: 30px;
    margin-right: 5px;
    display: inline-block;
    width: 300px;
    border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
  }
  .informacion_factura{
    padding: 10px;
    border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
    margin-bottom: 30px;
    width: 340px;
    display: inline-block;
  }
  .informacion_factura table{
    margin: 0 auto;
  }


  .numero_autorzaxion{
    font-size: 11px;
  }
  .informacion_ghd{
    display: inline-block;
  }

  .informacion_financiero_bancario{
    display: inline-block;
      font-size: 11px;
  }


  .parte_superior .bloque_superior_row{
    font-size: 11px;

  }


  .clave_ed_acces{
    font-size: 11px;
    text-align: center;
  }


  </style>
  <body>
    <div class="parte_superior">
      <div class="bloque_superior_row informacion_emisor">
        <div class="img_logo_empresa">
          <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
        </div>
        <table>
          <tbody>
            <tr>
              <td class="td_bld">Emisor:</td>
              <td class="celda_confogurar"><?php echo $razon_social ?></td>
            </tr>
            <?php if (!empty($nombre_empresa)): ?>
              <tr>
                <td class="td_bld">Nombre Comercial:</td>
                <td class="celda_confogurar"><?php echo $nombre_empresa ?></td>
              </tr>

            <?php endif; ?>
            <style>
              .celda_confogurar {
                max-width: 240px; /* Ajusta esto según el ancho de tu contenedor */
                word-wrap: break-word;
                word-break: break-all;
                font-size: 100%; /* Empieza con el tamaño de fuente por defecto */
              }
            </style>
            <tr>
              <td class="td_bld">Matriz:</td>
              <td> <?php echo $direccion_sucursal ?></td>
            </tr>
            <tr>
              <td class="td_bld">Ruc:</td>
              <td><?php echo $numero_identificacion_emisor ?></td>
            </tr>
            <tr>
              <td class="td_bld">Correo:</td>
              <td class="celda_confogurar" ><?php echo $email_empresa_emisor ?></td>
            </tr>
            <tr>
              <td class="td_bld">Teléfono</td>
              <td><?php echo $celular_empresa_emisor ?></td>
            </tr>
            <tr>
                    <td class="td_bld">Regimen:</td>
                    <td><?php echo $regimen ?></td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="bloque_superior_row informacion_factura">
        <div class="">
          <table>
            <tbody>
              <tr>
                <td class="td_bld">Factura No :<?php echo $estableciminento_f ?>-<?php echo $punto_emision_f ?>-<?php echo $secuencial_neto ?></td>
              </tr>
              <tr>
                <td class="td_bld">Número de Autorización</td>
              </tr>
              <tr>
                <td class="numero_autorzaxion"><?php echo $clave_acc_guardar ?></td>
              </tr>
              <tr>
                <td class="td_bld">Fecha Autorización</td>
              </tr>
              <tr>
                <td><?php echo $fechaAutorizacion ?></td>
              </tr>
              <tr>
                <td class="td_bld">OBLIGADO A LLEVAR CONTABILIDAD:<?php echo $contabilidad  ?></td>

              </tr>
              <tr>
                <td class="td_bld">Ambiente:Producción</td>
              </tr>
              <tr>
                <td class="td_bld">EMISIÓN :NORMAL</td>
              </tr>
              <tr>
                <td class="td_bld">CLAVE ACCESO</td>
              </tr>
              <tr>
                <td> <img src="barra.gif" width="340px;" height="75px;" alt=""> </td>
              </tr>
              <tr>
                <td class="clave_ed_acces"><?php echo $clave_acc_guardar ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <style media="screen">
    .parte_inermedia{

      padding: 2px;
    }
      .parte_inermedia table{
        padding: 0;
        margin: 0;
        width: 100%;
        font-size: 11px;
        border: 1px solid black; /* Establece el borde de la tabla y sus celdas */

      }

    </style>
    <div class="parte_inermedia">
      <table>
        <tbody>
          <tr>
            <td> <span class="td_bld" >Razon Social Comprador:</span><?php echo $razon_social_cliente_2 ?> </td>
          </tr>
          <tr>
            <td> <span class="td_bld" >RUC/CI:</span> <?php echo $identificacion_cliente ?></td>
          </tr>
          <tr>
            <td> <span class="td_bld" >Dirección:</span> <?php echo $direccion_reeptor ?></td>
          </tr>
          <tr>
            <td> <span class="td_bld" >Teléfono:</span> <?php echo $celular_receptor ?> </td>
          </tr>
          <tr>
            <td> <span class="td_bld" >Fecha Emisión:</span> <?php echo $fecha ?> </td>
          </tr>
        </tbody>
      </table>
    </div>
        <br>

        <style media="screen">
          .parte_productos{
            padding: 1px;
            font-size: 11px;
          }

          .parte_productos .parte_productos_solo_productos{
            width: 100%;
            background: #e8e8e8 ;
            padding: 0px;
            margin: 0px;
            text-align: center;
          }

          .parte_productos .parte_productos_solo_productos {
            border-collapse: collapse; /* Opcional: para eliminar el espacio entre bordes */
        }

          .parte_productos .th_productos{
              border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
          }
          .parte_productos .td_productos{
              border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
          }
        </style>

        <div class="parte_productos">
          <div class="">
            <table class="parte_productos_solo_productos">
              <thead>
                <tr>
                  <th class="th_productos">Cod.</th>
                  <th class="th_productos">Cant.</th>
                  <th class="th_productos">Descrip.</th>
                  <th class="th_productos">Nota Extra 1</th>
                  <th class="th_productos">Nota Extra 2</th>
                  <th class="th_productos">P/U</th>
                  <th class="th_productos">DSCT</th>
                  <th class="th_productos">IVA</th>
                  <th class="th_productos">Sub Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
                  WHERE id_emisor= '$iduser' AND comprobantes.secuencial = '$codigo_factura' ");
                while ($resultados = mysqli_fetch_array($query_resultados)) {
                  $id_producto = $resultados['id_producto'];
                  $cantidad_producto = $resultados['cantidad_producto'];
                  $nombre_producto = $resultados['nombre_producto'];
                  $descripcion_producto = $resultados['descripcion_producto'];
                  $valor_unidad = $resultados['valor_unidad'];
                  $descuento = $resultados['descuento'];
                  $iva_producto = $resultados['iva_producto'];
                  $subtotal_frontend = $resultados['subtotal_frontend'];
                 ?>
                <tr>
                  <td class="td_productos"><?php echo ($id_producto); ?></td>
                  <td class="td_productos"><?php echo $cantidad_producto; ?></td>
                  <td class="td_productos"><?php echo $descripcion_producto; ?></td>
                  <td class="td_productos"><?php echo $resultados['detalle_extra']; ?></td>
                  <td class="td_productos"><?php echo $resultados['detalle_extra2']; ?></td>
                  <td class="td_productos"><?php echo number_format($valor_unidad,2); ?></td>
                  <td class="td_productos">$<?php echo number_format($descuento,2); ?></td>
                  <td class="td_productos">$<?php echo $resultados['iva_frontend']; ?></td>
                  <td class="td_productos">$<?php echo number_format($subtotal_frontend,2); ?></td>
                </tr>

                <?php
                }
            ?>
              </tbody>
            </table>
          </div>
        </div>


<br><br>

    <style media="screen">

    .conte_gene_inferior_sc{
      width: 65%;
      font-size: 11px;
      display: flex;
      align-items: center; /* Alinea los elementos verticalmente en el centro */
      justify-content: space-between; /* Separa los elementos equitativamente */

    }

    .parte_inferior_informacion .informacion_ghd{
      width: 65%;
      font-size: 11px;


    }
    .parte_inferior_informacion .informacion_ghd table{
      width: 450px;
      margin: 3px;
      padding: 10px;
      border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
    }
    .parte_inferior_informacion{
      width: 99%;
      margin: 0 auto;
    }
    .informacion_financiero_bancario{
      width: 200px;
      border-radius: 5px;
      padding: 5px;
      margin: 5px;


    }
    .informacion_financiero_bancario table{
      width: 190px;
      text-align: center;
      margin: 3 auto;
      background:  #e8e8e8 ;
      padding: 5px;

    }
    .tabla_ghdd{
          border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
    }




    </style>

    <div class="parte_inferior_informacion">
      <div class="conte_gene_inferior_sc">
        <div class="informacion_ghd">
          <table class="tabla_ghdd">
            <tbody>
              <tr class="tr_info_gjd" >
                <td class="td_info_gjd" > <span class="td_bld" >Email Empresa: </span> <span><?php echo $email_empresa_emisor ?></span> </td>
                <td class="td_info_gjd"></td>
              </tr>
              <tr class="tr_info_gjd" >
                <td> <span class="td_bld" >Email Cliente:</span> <span><?php echo $email_reeptor ?>


                  <?php
                  $query__correos_email = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email_cliente
                     WHERE lista_correos_envios_email_cliente.iduser ='$iduser'  AND lista_correos_envios_email_cliente.estatus = '1' AND lista_correos_envios_email_cliente.cliente = '$idcliente'
                  ORDER BY `lista_correos_envios_email_cliente`.`fecha` DESC ");
                   $result__email= mysqli_num_rows($query__correos_email);
                  if ($result__email > 0) {
                        while ($data_email=mysqli_fetch_array($query__correos_email)) {
                          $email_cliente = $data_email['correo'];
                          echo "$email_cliente"."<br>";
                        }
                      }
                   ?>

                </span> </td>
              </tr>
              <tr class="tr_info_gjd" >
                <td class="td_info_gjd"> <span class="td_bld " >Teléfono Empresa:</span>  <span><?php echo $telefono_empresa_emisor ?></span> </td>
              </tr>
              <tr class="tr_info_gjd" >
                <td class="td_info_gjd"> <span class="td_bld" >Direccion Cliente: </span> <span><?php echo $direccion_reeptor ?></span> </td>
              </tr>
              <?php

              $query_nota = mysqli_query($conection, "SELECT * FROM notas_extras_facturacion   WHERE iduser = '$iduser'
              AND codigo_factura = '$codigo_factura' AND codigo_factura = '$codigo_factura'");
              $data_nota = mysqli_fetch_array($query_nota);

              if ($data_nota) {
                $nota_extra = $data_nota['texto'];
              }else {
                $nota_extra = '';
              }
               ?>
               <?php if (!empty($nota_extra)): ?>
                 <tr>
                   <td class="td_info_gjd"> <span class="td_bld" >Nota Extras: </span> <span><?php echo $nota_extra ?></span> </td>
                 </tr>
               <?php endif; ?>
            </tbody>
          </table>

          <style media="screen">
          .formas_pago_table  {
            border-collapse: collapse; /* Opcional: para eliminar el espacio entre bordes */
            text-align: center;
            background: #fff;
        }

          .formas_pago_table .th_productos{
              border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
          }
          .formas_pago_table .td_productos{
              border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
          }
          </style>


            <table class="formas_pago_table">

                <thead>
                  <tr>
                    <th class="th_productos">Forma de Pago</th>
                    <th class="th_productos">Cantidad</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                   $query_lista = mysqli_query($conection,"SELECT * FROM formas_pago_facturacion WHERE formas_pago_facturacion.iduser ='$iduser'  AND formas_pago_facturacion.codigo_factura = '$codigo_factura'
                   ORDER BY `formas_pago_facturacion`.`fecha` DESC ");
                       $result_lista= mysqli_num_rows($query_lista);
                     if ($result_lista > 0) {
                           while ($data_lista=mysqli_fetch_array($query_lista)) {

                              $id_pago = $data_lista['id'];

                             $codigo_formas_pago = $data_lista['formaPago'];
                              $cantidad_metodo_pago = $data_lista['cantidad_metodo_pago'];

                             if ($codigo_formas_pago == 01) {
                                $nombre_formas_pago = 'SIN UTILIZACION DEL SISTEMA FINANCIERO';
                              }

                              if ($codigo_formas_pago == 15) {
                                $nombre_formas_pago = 'COMPESACION DE DE DEUDAS';
                              }

                              if ($codigo_formas_pago == 16) {
                                $nombre_formas_pago = 'TARJETA DE DEBITO';
                              }

                              if ($codigo_formas_pago == 17) {
                                $nombre_formas_pago = 'DINERO ELECTRONICO';
                              }

                              if ($codigo_formas_pago == 18) {
                                $nombre_formas_pago = 'TARJETA PREPAGO';
                              }

                              if ($codigo_formas_pago == 19) {
                                $nombre_formas_pago = 'TARJETA DE CREDITO';
                              }

                              if ($codigo_formas_pago == 20) {
                                $nombre_formas_pago = 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO';
                              }

                              if ($codigo_formas_pago == 21) {
                                $nombre_formas_pago = 'ENDOSO DE TITULOS';
                              }

                   ?>



                  <tr>
                    <td class="td_productos"><?php echo ($nombre_formas_pago); ?></td>
                    <td class="td_productos">$<?php echo number_format($cantidad_metodo_pago,2) ?> </td>
                  </tr>

                  <?php
                  }
                  }
              ?>

              </tbody>

            </table>




        </div>
      </div>



      <?php
      //sacar informacion general de todo
      $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura'");
      $data_lista_t=mysqli_fetch_array($query_lista_t);

      $descuento_total = $data_lista_t['descuento_total'];


             //codigo para sacr el 12 %
      $query_lista_12 = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '2'");
      $data_lista_12=mysqli_fetch_array($query_lista_12);

      //codigo para sacr el 12 %
      $compra_total_iva = $data_lista_12['compra_total']-$data_lista_12['descuento_total'];

      //codigo para sacr el 0%

      $query_lista_base_0 = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '0'");
      $data_lista_t_base_0=mysqli_fetch_array($query_lista_base_0);

       $compra_total_base_cero = $data_lista_t_base_0['compra_total']-$data_lista_t_base_0['descuento_total'];


       //codigo para sacr el no_objeto

       $query_lista_no_objeto = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
       'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
       SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
       FROM `comprobantes`
       WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '7'");
       $data_lista_no_objeto =mysqli_fetch_array($query_lista_no_objeto);

        $compra_total_no_objeto = $data_lista_no_objeto['compra_total']-$data_lista_no_objeto['descuento_total'];

        //codigo para sacar excento_iva

        $query_lista_excento_iva = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
        'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
        SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
        FROM `comprobantes`
        WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura' AND comprobantes.tipo_ambiente = '6'");
        $data_lista_excento_iva =mysqli_fetch_array($query_lista_excento_iva);
          $compra_total_excento_iva = $data_lista_excento_iva['compra_total']-$data_lista_excento_iva['descuento_total'];

         $compra_general = $compra_total_iva + $compra_total_base_cero + $compra_total_no_objeto + $compra_total_excento_iva;

         $total_pagar = (($compra_general+$data_lista_t['iva_general']));


       ?>
       <style media="screen">
         .tabla_resumen_fernando{
                     border: 1px solid black; /* Establece el borde de la tabla y sus celdas */
         }
       </style>


      <div class="informacion_financiero_bancario">
        <div class="">
          <table class="tabla_resumen_fernando">
            <tbody>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >Sin Iva</td>
                <td class="td_resumen">$<?php echo number_format($compra_total_base_cero,2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >Con Iva</td>
                <td class="td_resumen">$<?php echo number_format($compra_total_iva,2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >No Objeto</td>
                <td class="td_resumen">$<?php echo number_format($compra_total_no_objeto,2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >Excento de Iva</td>
                <td class="td_resumen">$<?php echo number_format($compra_total_excento_iva,2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >Subtotal</td>
                <td class="td_resumen">$<?php echo number_format($compra_general,2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >Descuento</td>
                <td class="td_resumen">$<?php echo number_format($descuento_total,2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >IVA 12</td>
                <td class="td_resumen">$<?php echo number_format($data_lista_t['iva_general'],2) ?></td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >ICE</td>
                <td class="td_resumen">$0.00</td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >IRBPNR</td>
                <td class="td_resumen">$0.00</td>
              </tr>
              <tr class="tr_resumen">
                <td class="td_bld td_resumen" >Total:</td>
                <td class="td_resumen">$<?php echo number_format($total_pagar,2) ?> </td>
              </tr>
            </tbody>
          </table>

        </div>

      </div>

    </div>

    <?php

    //codigo para saber como va el emisor
    if (empty($nombre_empresa) || $nombre_empresa == '0') {
      $nombre_salida = $razon_social;
    }else {
      $nombre_salida = $nombre_empresa;
    }

    if (!empty($facebook)) {
      $facebook = '<a style="text-align: center; margin:3px; padding4px  " href="'.$facebook.'"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="30px;"></a>';
    }else {
      $facebook = '';
    }

    if (!empty($instagram)) {
      $instagram = '<a style="text-align: center; margin:3px; padding4px " href="'.$instagram.'"> <img src="https://guibis.com/home/img/reacciones/instagram.png" alt="" width="30px;"></a>';
    }else {
      $instagram = '';
    }

    if (!empty($whatsapp)) {
      $whatsapp = '<a style="text-align: center; margin:3px; padding4px" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;'.$nombre_salida.'&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="30px;"></a>';
    }else {
      $whatsapp = '';
    }

    if (!empty($pagina_web)) {
      $pagina_web = '<a style="text-align: center; margin:3px; padding4px" href="'.$pagina_web.'"> <img src="https://guibis.com/home/img/reacciones/web.png" alt="" width="30px;"></a>';
    }else {
      $pagina_web = '';
    }


     ?>
     <style media="screen">
       .informacion_adicional_factura{
         font-size: 11px;
         text-align: center;
         margin: 0 auto;
         padding: 10px;

       }
       .contenedores_redes{
         text-align: center;
         margin: 0 auto;
         width: 100%;
       }
       .fb_gy{
         width: 25%;
         display: inline-block;
       }
       .titulo_informacion_extra{
         padding: 5px;
         margin: 5px;
       }
     </style>
     <br><br><br><br><br>



    <div class="informacion_adicional_factura">
      <div class="titulo_informacion_extra">
        <h3>Nuestras Redes Sociales</h3>

      </div>
      <div class="contenedores_redes">
        <div class="fb_gy">
          <?php echo $facebook ?>

        </div>
        <div class="fb_gy">
              <?php echo $instagram ?>

        </div>
        <div class="fb_gy">
              <?php echo $whatsapp ?>

        </div>
        <div class="fb_gy">
              <?php echo $pagina_web ?>

        </div>
      </div>



    </div>



  </body>
</html>
