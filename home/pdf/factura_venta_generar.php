<?php
include ('../facturacion/facturacionphp/lib/codigo_barras/barcode.inc.php');
include "../../coneccion.php";
      mysqli_set_charset($conection, 'utf8'); //linea a colocar

      //INFORMACION DE LA CONFIGURACION
      $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
      $result_configuracion = mysqli_fetch_array($query_configuracioin);
      $ambito_area          =  $result_configuracion['ambito'];


  $codigo_venta_factura = $_GET['venta'];
//INFORMACION DE LA VENTA
mysqli_query($conection,"SET lc_time_names = 'es_ES'");
 $query_venta_xml = mysqli_query($conection,"SELECT DATE_FORMAT(ventas_externas_generadas.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',ventas_externas_generadas.id,
 ventas_externas_generadas.fechaEmision,ventas_externas_generadas.razon_socialreceptorr,ventas_externas_generadas.identificacion_receptor,ventas_externas_generadas.claveAcceso,
 ventas_externas_generadas.xml_limpio
FROM `ventas_externas_generadas`
WHERE ventas_externas_generadas.id = '$codigo_venta_factura'");
$data_venta_xml =mysqli_fetch_array($query_venta_xml);

$xml_limpio = $data_venta_xml['xml_limpio'];


//de qui empezamos a sacar la informacion
if ($ambito_area == 'prueba') {
  $ruta_factura = 'C:\\xampp\\htdocs\\home\\archivos\\xml_autorizados\\'.$xml_limpio.'';

}else {
  $ruta_factura = '../archivos/xml_autorizados/'.$xml_limpio.'';
}
$acceso_factura = simplexml_load_file($ruta_factura);


  $claveAcceso                       = $acceso_factura->infoTributaria->claveAcceso;


$clave_acc_guardar = $claveAcceso;
		new barCodeGenrator(''.$clave_acc_guardar.'', 1, 'barra.gif', 455, 60, false);

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
    height: 300px;
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

<?php
$codDocModificado                = $acceso_factura->infoTributaria->codDoc;

//para crear el numero dl documento necesito de 4 partes
$estab                       = $acceso_factura->infoTributaria->estab;
$ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
$secuencial                  = $acceso_factura->infoTributaria->secuencial;
$numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';
$ruc_emisor                       = $acceso_factura->infoTributaria->ruc;
$razon_social_emisor             = $acceso_factura->infoTributaria->razonSocial;

$importeTotal                       = $acceso_factura->infoFactura->importeTotal;

$dirEstablecimiento                       = $acceso_factura->infoFactura->dirEstablecimiento;


//informacion del comprador
  $identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
  $tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
  $razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
  $obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
  $fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
  $totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
  $totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;

   $dirEstablecimiento                = $acceso_factura->infoFactura->dirEstablecimiento;
       $importeTotal                = $acceso_factura->infoFactura->importeTotal;
   $codigo_formas_pago                = $acceso_factura->infoFactura->pagos->pago->formaPago;

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
  <body>
    <div class="parte_superior">
      <div class="bloque_superior_row informacion_emisor">
        <table>
          <tbody>
            <tr>
              <td class="td_bld">Emisor:</td>
              <td><?php echo $razon_social_emisor ?></td>
            </tr>
            <tr>
              <td class="td_bld">Matriz:</td>
              <td><?php echo $dirEstablecimiento ?></td>
            </tr>
            <tr>
              <td class="td_bld">Ruc:</td>
              <td><?php echo $ruc_emisor ?></td>
            </tr>

          </tbody>
        </table>

      </div>
      <div class="bloque_superior_row informacion_factura">
        <div class="">
          <table>
            <tbody>
              <tr>
                <td class="td_bld">Factura No :<?php echo $estab ?>-<?php echo $ptoEmi ?>-<?php echo $secuencial ?></td>
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
                <td><?php echo $fechaEmision ?></td>
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
            <td> <span class="td_bld" >Razon Social Comprador:</span><?php echo $razon_social_comprador ?> </td>
          </tr>
          <tr>
            <td> <span class="td_bld" >RUC/CI:</span> <?php echo $identificacion_comprador ?></td>
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
            $base_tdll = 0;
            $base_array_detalle = 1;
            $contador_detalles = $acceso_factura->detalles->detalle;
            foreach($contador_detalles as $Item){
              (string)$descripcion_producto= $acceso_factura->detalles->detalle[$base_tdll]->descripcion;
              $codigoPrincipal= $acceso_factura->detalles->detalle[$base_tdll]->codigoPrincipal;
              $cantidad= $acceso_factura->detalles->detalle[$base_tdll]->cantidad;
              $precioUnitario= $acceso_factura->detalles->detalle[$base_tdll]->precioUnitario;
              $descuento= $acceso_factura->detalles->detalle[$base_tdll]->descuento;
              $precioTotalSinImpuesto= $acceso_factura->detalles->detalle[$base_tdll]->precioTotalSinImpuesto;
               $impuestos= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto;
              //CODIGO PARA DETALLES
              $codigo= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigo;
              $codigoPorcentaje= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigoPorcentaje;
              $tarifa= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->tarifa;
              $baseImponible= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->baseImponible;
              $valor= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->valor;
               $base_tdll =$base_tdll +1;
             ?>
            <tr>
              <td><?php echo ($codigoPrincipal); ?></td>
              <td><?php echo $cantidad; ?></td>
              <td><?php echo $descripcion_producto; ?></td>
              <td><?php echo ($precioUnitario); ?></td>
              <td>$<?php echo ($descuento); ?></td>
              <td>$<?php echo (($valor)); ?></td>
              <td>$<?php echo ($baseImponible); ?></td>
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
              <td> <span class="td_bld" >Formas de Pago:</span> <span><?php echo $nombre_formas_pago ?></span> </td>
            </tr>

          </tbody>
        </table>

      </div>

      <div class="informacion_financiero_bancario">
        <div class="">
          <table>
            <tbody>
              <tr>
                <td class="td_bld" >Subtotal</td>
                <td>$<?php echo ($totalSinImpuestos_general) ?></td>
              </tr>
              <tr>
                <td class="td_bld" >Descuento</td>
                <td>$<?php echo (($totalDescuento_general)) ?></td>
              </tr>
              <tr>
                <td class="td_bld" >IVA 12</td>
                <td>$<?php echo (($importeTotal-$totalSinImpuestos_general-$totalDescuento_general)) ?></td>
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
                <td>$<?php echo ($totalDescuento_general) ?></td>
              </tr>
              <tr>
                <td class="td_bld" >Total:</td>
                <td>$<?php echo ($importeTotal) ?> </td>
              </tr>
            </tbody>
          </table>

        </div>

      </div>

    </div>


  </body>
</html>
