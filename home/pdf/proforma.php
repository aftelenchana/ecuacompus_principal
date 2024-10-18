<?php
include ('../facturacion/facturacionphp/lib/codigo_barras/barcode.inc.php');
include "../../coneccion.php";
$iduser = $_GET['id'];
$codigoFactura = $_GET['codigoFactura'];
$rol_user = $_GET['rol_user'];
$id_generacion = $_GET['id_generacion'];
$clave_acc_guardar = $_GET['clave_acc_guardar'];
		new barCodeGenrator(''.$clave_acc_guardar.'', 1, 'barra.gif', 455, 60, false);
$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
WHERE id_emisor= '$iduser' AND secuencial = $codigoFactura");
$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
  $celular_receptor_uwu        = $data__emmisor['celular_receptor'];
  $direccion_receptor_uwu      = $data__emmisor['direccion_reeptor'];
  $email_receptor          = $data__emmisor['email_reeptor'];
  $codigo_formas_pago          = $data__emmisor['formas_pago'];
  $nombre_producto             = $data__emmisor['nombre_producto'];
	  $fecha_vencimiento_proforma             = $data__emmisor['fecha_vencimiento_proforma'];





$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
$result_documentos = mysqli_fetch_array($query_doccumentos);
$regimen = $result_documentos['regimen'];
$contabilidad             = $result_documentos['contabilidad'];
$email_empresa_emisor     = $result_documentos['email'];
$celular_empresa_emisor   = $result_documentos['celular'];
$telefono_empresa_emisor  = $result_documentos['telefono'];
$direccion_emisor          = $result_documentos['direccion'];
$whatsapp                 = $result_documentos['whatsapp'];
$nombres                  = $result_documentos['nombres'];
$apellidos                = $result_documentos['apellidos'];
$numero_identificacion_emisor  = $result_documentos['numero_identidad'];
$contribuyente_especial   = $result_documentos['contribuyente_especial'];
$estableciminento_f      = $result_documentos['estableciminento_f'];
$contabilidad            = $result_documentos['contabilidad'];
$punto_emision_f         = $result_documentos['punto_emision_f'];
$img_facturacion         = $result_documentos['img_facturacion'];
$numero_identidad_emisor        = $result_documentos['numero_identidad'];
  $url_img_upload          = $result_documentos['url_img_upload'];

$estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
$punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);

$nombre_empresa      = $result_documentos['nombre_empresa'];
if ($nombre_empresa == '' || $nombre_empresa== '0') {
  $nombre_empresa = ''.$nombres.' '.$apellidos.'';
  // code...
}else {
  $nombre_empresa      = $result_documentos['nombre_empresa'];
}

//fechas
$fecha_actual = date("d-m-Y");
$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));



//INFORMACION COMERCIAL DE LOS PUNTOS DE EMISON
$query = mysqli_query($conection, "SELECT * FROM  proformas   WHERE  proformas.id_emisor  = '$iduser'  ORDER BY fecha DESC");
$result = mysqli_fetch_array($query);
if ($result) {
  $secuencial_proforma = $result['secuencial'];
  $secuencial_proforma = $secuencial_proforma+1;
  // code...
}else {
  $secuencial_proforma =1;
}
     $numeroConCeros = str_pad($secuencial_proforma, 9, "0", STR_PAD_LEFT);


     $fecha_actual = date("d-m-Y");
     $fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));

     $clave_acc_guardar= ''.$fechasf.'55'.$numero_identidad_emisor.'2'.$estableciminento_f.''.$punto_emision_f .''.$numeroConCeros.'1234567810';


//$clave_acc_g

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PROFORMA </title>
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
    background:   #f0f0f0  ;
  }
  .informacion_factura{
    padding: 10px;
    margin-bottom: 30px;
    width: 350px;
    display: inline-block;
    background:   #f0f0f0
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
              <td><?php echo $nombre_empresa ?></td>
            </tr>
            <tr>
              <td class="td_bld">Matriz:</td>
              <td><?php echo $direccion_emisor ?></td>
            </tr>
            <tr>
              <td class="td_bld">Ruc:</td>
              <td><?php echo $numero_identificacion_emisor ?></td>
            </tr>
            <tr>
              <td class="td_bld">Correo:</td>
              <td><?php echo $email_empresa_emisor ?></td>
            </tr>
            <tr>
              <td class="td_bld">Teléfono</td>
              <td><?php echo $celular_empresa_emisor ?></td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="bloque_superior_row informacion_factura">
        <div class="">
          <table>
            <tbody>
              <tr>
                <td class="td_bld">Proforma No :<?php echo $estableciminento_f ?>-<?php echo $punto_emision_f ?>-<?php echo $numeroConCeros ?></td>
              </tr>
              <tr>
                <td class="td_bld">Número de Autorización</td>
              </tr>
              <tr>
                <td class="numero_autorzaxion"><?php echo $clave_acc_guardar ?></td>
              </tr>
              <tr>
                <td class="td_bld">Fecha Vencimiento</td>
              </tr>
              <tr>
                <td><?php echo $fecha_vencimiento_proforma ?></td>
              </tr>
              <tr>
                <td class="td_bld">Ambiente:PRODUCCIÓN</td>
              </tr>
              <tr>
                <td class="td_bld">EMISIÓN :NORMAL</td>
              </tr>
              <tr>
                <td class="td_bld">CLAVE ACCESO</td>
              </tr>
              <tr>
                <td> <img src="barra.gif" width="350px;" height="75px;" alt=""> </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <style media="screen">
    .parte_inermedia{
      background:  #74fffd ;
      padding: 2px;
    }
      .parte_inermedia table{
        padding: 0;
        margin: 0;
        background:  #f3ce9f ;
        width: 100%;

      }
    </style>


    <div class="parte_inermedia">
      <table>
        <tbody>
          <tr>
            <td> <span class="td_bld" >Razon Social del Comprador:</span><?php echo $nombre_empresa ?> </td>
          </tr>
          <tr>
            <td> <span class="td_bld" >RUC/CI:</span> <?php echo $numero_identificacion_emisor ?></td>
          </tr>
          <tr>
            <td> <span class="td_bld" >Dirección:</span> <?php echo $direccion_emisor ?></td>
          </tr>
          <tr>
            <td> <span class="td_bld" >Teléfono:</span> <?php echo $celular_empresa_emisor ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <br>

<style media="screen">
  .parte_productos{
    background:   #7483ff ;
    padding: 1px;
  }

  .parte_productos table{
    width: 100%;
    background: #e8e8e8 ;
    padding: 0px;
    margin: 0px;
    text-align: center;

  }
</style>

    <div class="parte_productos">
      <div class="">
        <table>
          <thead>
            <tr>
              <th>Codigo</th>
							<th>Imagen</th>
							<th>Nombre</th>
              <th>Cantidad</th>
              <th>Descripcion</th>
              <th>P/U</th>
              <th>DSCT</th>
              <th>IVA</th>
              <th>Sub Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
						 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
            $query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
              WHERE id_emisor= '$iduser' AND secuencial = $codigoFactura");
            while ($resultados = mysqli_fetch_array($query_resultados)) {
                   $producto = $resultados['id_producto'];


									 $query_producto = mysqli_query($conection, "SELECT * FROM producto_venta WHERE idproducto = $producto");
									 $data_producto  = mysqli_fetch_array($query_producto);
									 $img_producto   =  $data_producto['foto'];
									 $url_upload_img =  $data_producto['url_upload_img'];



                   //EMPESAMOS A SACAR LA INFORMACION DEL COMPROBANTE PARA PASAR AL PROFORMAS
                   $id_emisor = $resultados['id_emisor'];
                   $nombre_producto = $resultados['nombre_producto'];
                   $descripcion_producto = $resultados['descripcion_producto'];
                   $valor_unidad = $resultados['valor_unidad'];
                   $cantidad_producto = $resultados['cantidad_producto'];
                   $tipo_ambiente = $resultados['tipo_ambiente'];
                   $codigos_impuestos = $resultados['codigos_impuestos'];
                   $detalle_extra = $resultados['detalle_extra'];
                   $precio_neto = $resultados['precio_neto'];
                   $iva_producto = $resultados['iva_producto'];
                   $precio_p_incluido_iva = $resultados['precio_p_incluido_iva'];
                   $id_producto = $resultados['id_producto'];
                   $descuento = $resultados['descuento'];
                   $iva_frontend = $resultados['iva_frontend'];
                   $subtotal_frontend = $resultados['subtotal_frontend'];



                   $nombres_receptor = $resultados['nombres_receptor'];
                   $numero_identidad_receptor = $resultados['numero_identidad_receptor'];
                   $email_reeptor = $resultados['email_reeptor'];
                   $direccion_reeptor = $resultados['direccion_reeptor'];
                   $id_receptor = $resultados['id_receptor'];
                   $tipo_identificacion = $resultados['tipo_identificacion'];
                   $celular_receptor = $resultados['celular_receptor'];
                   $id_receptor = $resultados['id_receptor'];
                   $formas_pago = $resultados['formas_pago'];
                   $efectivo = $resultados['efectivo'];
                   $vuelto = $resultados['vuelto'];
                   $estado_financiero = $resultados['estado_financiero'];
                   $limpiar_consola = $resultados['limpiar_consola'];
									 $fecha_vencimiento_proforma = $resultados['fecha_vencimiento_proforma'];
									 $modulo = $resultados['modulo'];



                   $query_insert=mysqli_query($conection,"INSERT INTO proformas (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,detalle_extra,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,iva_frontend,subtotal_frontend,
                    nombres_receptor, numero_identidad_receptor,email_reeptor,direccion_reeptor,id_receptor,tipo_identificacion,celular_receptor,formas_pago,efectivo,vuelto,estado_financiero,limpiar_consola,secuencial,clave_acceso,modulo,url,IDROLPUNTOVENTA,rol)
                   VALUES('$iduser','$nombre_producto', '$descripcion_producto', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','$detalle_extra','$precio_neto','$iva_producto','$precio_p_incluido_iva','$id_producto','$descuento','$iva_frontend','$subtotal_frontend',
                   '$nombres_receptor', '$numero_identidad_receptor','$email_reeptor','$direccion_reeptor','$id_receptor','$tipo_identificacion','$celular_receptor','$formas_pago','$efectivo','$vuelto','$estado_financiero','$limpiar_consola','$secuencial_proforma','$clave_acc_guardar','$modulo','$url','$id_generacion','$rol_user')");





              $id_producto = $resultados['id_producto'];
              $cantidad_producto = $resultados['cantidad_producto'];
              $descripcion_producto = $resultados['descripcion_producto'];
              $valor_unidad = $resultados['valor_unidad'];
              $descuento = $resultados['descuento'];
              $iva_producto = $resultados['iva_producto'];
              $subtotal_frontend = $resultados['subtotal_frontend'];
             ?>
            <tr>
              <td><?php echo $id_producto; ?></td>
              <td> <img src="<?php echo $data_producto['url_upload_img'] ?>/home/img/uploads/<?php echo $img_producto  ?>" width="50px;" alt=""> </td>
							<td><?php echo $nombre_producto ?></td>
						  <td><?php echo $cantidad_producto; ?></td>
              <td><?php echo $descripcion_producto; ?></td>
              <td><?php echo $valor_unidad; ?></td>
              <td>$<?php echo $descuento; ?></td>
              <td>$<?php echo $iva_producto; ?></td>
              <td>$<?php echo $subtotal_frontend; ?></td>
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
    .parte_inferior_informacion .informacion_ghd{
      width: 65%;
    }
    .parte_inferior_informacion .informacion_ghd table{
      width: 450px;
      background:   #e8e8e8  ;
      border-radius: 5px;
      padding: 10px;
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
      margin: 0 auto;
      background:  #e8e8e8 ;
      padding: 5px;
      border-radius: 5px;
    }

    </style>

    <div class="parte_inferior_informacion">
      <div class="informacion_ghd">
        <table>
          <tbody>
            <tr>
              <td> <span class="td_bld" >Email Empresa: </span> <span><?php echo $email_empresa_emisor ?></span> </td>
              <td></td>
            </tr>
            <tr>
              <td> <span class="td_bld" >Email Cliente:</span> <span><?php echo $email_receptor ?></span> </td>
            </tr>
            <tr>
              <td> <span class="td_bld" >Teléfono Empresa:</span>  <span><?php echo $telefono_empresa_emisor ?></span> </td>
            </tr>
            <tr>
              <td> <span class="td_bld" >Direccion Cliente: </span> <span><?php echo $direccion_receptor_uwu ?></span> </td>
            </tr>
						<tr>
							<td> <span class="td_bld" >Fecha Vencimiento:</span> <span><?php echo $fecha_vencimiento_proforma ?></span> </td>
						</tr>

						<tr>
							<td> <span class="td_bld" >Formas de Pago:</span> <span>


								<?php
									mysqli_query($conection,"SET lc_time_names = 'es_ES'");
									 $query_lista = mysqli_query($conection,"SELECT * FROM formas_pago_facturacion WHERE formas_pago_facturacion.iduser ='$iduser'  AND formas_pago_facturacion.codigo_factura = '$codigoFactura'
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
										<div class="">
											<?php echo $nombre_formas_pago ?>-$<span><?php echo number_format($cantidad_metodo_pago,2) ?>  </span>
										</div>
										<?php
										}
										}
								?>
									</span>
						 </td>
						</tr>
          </tbody>
        </table>

      </div>
      <?php
      $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser' AND secuencial = $codigoFactura");
      $data_lista_t=mysqli_fetch_array($query_lista_t) ;
      $compra_total = $data_lista_t['compra_total'];
      $iva_general = $data_lista_t['iva_general'];
      $iva_general = $data_lista_t['iva_general'];
      $descuento_total = $data_lista_t['descuento_total'];
      $valor_total = $data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total'];


       ?>

      <div class="informacion_financiero_bancario">
        <div class="">
          <table>
            <tbody>
              <tr>
                <td class="td_bld" >Subtotal</td>
                <td>$<?php echo $compra_total ?></td>
              </tr>
              <tr>
                <td class="td_bld" >Descuento</td>
                <td>$<?php echo $descuento_total ?></td>
              </tr>
              <tr>
                <td class="td_bld" >IVA 12</td>
                <td>$<?php echo $iva_general ?></td>
              </tr>
              <tr>
                <td class="td_bld" >IVA</td>
                <td>$<?php echo $iva_general ?></td>
              </tr>
              <tr>
                <td class="td_bld" >ICE</td>
                <td>$0.00</td>
              </tr>
              <tr>
                <td class="td_bld" >IRBPNR</td>
                <td>$0.00</td>
              </tr>
              <tr>
                <td class="td_bld" >Descuento</td>
                <td>$<?php echo $descuento_total ?></td>
              </tr>
              <tr>
                <td class="td_bld" >Total:</td>
                <td>$<?php echo $valor_total ?> </td>
              </tr>
            </tbody>
          </table>

        </div>

      </div>

    </div>


  </body>
</html>
