<?php

namespace App\Exports;

use App\XmlInsertImpuesto;
use Illuminate\Http\Request;
use App\XmlInsertComprobante;
use App\XmlInsertDetalle;
use PhpParser\Node\Stmt\TryCatch;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ComprobanteExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $horaini = '00:00:00';
    $horafin = '23:59:59';
    $dateini = request('dateini');
    $datefin = request('datefin');

    $datei = ($dateini . " " . $horaini);
    $datef = ($datefin . " " . $horafin);

    
    $query_cab = XmlInsertComprobante::with(['impuesto'])->with(['detalle'])->with(['detalle.detalleimpuesto'])
      ->whereBetween("created_at", [$datei, $datef])
      ->select(
        "id",
        "estado",
        "numero_autorizacion",
        "fecha_autorizacion",
        "ambiente",
        "tipo_emision",
        "razon_social",
        "nombre_comercial",
        "ruc",
        "clave_acceso",
        "cod_doc",
        "estab",
        "pto_emi",
        "secuencial",
        "dir_matriz",
        "fecha_emision",
        "contribuyente_especial",
        "obligado_contabilidad",
        "tipo_identificacion_com",
        "razon_social_comprador",
        "identificacion_comprador",
        "direccion_comprador",
        "total_sin_impuestos",
        "total_descuento",
        "propina",
        "importe_total",
        "moneda"
      )
      ->get();


    $datos = collect();


    foreach ($query_cab as $querycol) {
      //  dd($querycol->toArray());
      $totalbiva = 0;
      $totalbcero = 0;
      $totalbnoiva = 0;
      $totalbexcento = 0;
      $valorice = 0;
      $valoriva = 0;
      $valordiva = 0;
      $valorIRBPNR = 0;

      foreach ($querycol->impuesto as $imp) {
        
        //TOTAL BASE IVA
        if (($imp->codigo_porcentaje == 2 || $imp->codigo_porcentaje == 3) && ($imp->codigo == 2)) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $bimponible = $imp->base_imponible;
            $totalbiva = $totalbiva + $bimponible;
          } //else{$totalbiva=$imp->totalImpuesto->baseImponible;}

        }
        //TOTAL BASE CERO
        if (($imp->codigo_porcentaje == 0) && ($imp->codigo == 2)) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {
  
            $bimponible = $imp->base_imponible;
            $totalbcero = $totalbcero + $bimponible;
          } //else{$totalbcero=$imp->totalImpuesto->baseImponible;}
  
        }
      }

      //TOTAL NOIVA
      foreach ($querycol->impuesto as $imp) {

        if (($imp->codigo_porcentaje == 6) && ($imp->codigo == 2)) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $bimponible = $imp->base_imponible;
            $totalbnoiva = $totalbnoiva + $bimponible;
          } //else{$totalbnoiva=$imp->totalImpuesto->baseImponible;}

        }
      }

      //TOTAL EXCENTO IVA
      foreach ($querycol->impuesto as $imp) {

        if (($imp->codigo_porcentaje == 7) && ($imp->codigo == 2)) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $bimponible = $imp->base_imponible;
            $totalbexcento = $totalbexcento + $bimponible;
          } //else{$totalbexcento=$imp->totalImpuesto->baseImponible;}
        }
      }

      //VALOR ICE
      foreach ($querycol->impuesto as $imp) {

        if ($imp->codigo == 3) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $valor = $imp->valor;
            $valorice = $valorice + $valor;
          } //else{$valorice=$imp->totalImpuesto->valor;}
        }
      }

      //VALOR IVA
      foreach ($querycol->impuesto as $imp) {

        if ($imp->codigo == 2) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $valoriv = $imp->valor;
            $valoriva = $valoriva + $valoriv;
          } //else{$valoriva=$imp->totalImpuesto->valor;}
        }
      }

      //VALOR DEVOLUCION IVA
      foreach ($querycol->impuesto as $imp) {

        if ($imp->codigo == 2) {
          $id_com = $querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $valordiv = $imp->valor_devolucion_iva;
            $valordiva = $valordiva + $valordiv;
          } //else{$valordiva=$imp->totalImpuesto->valorDevolucionIva;}
        }
      }


      //VALOR IRBPNR
      foreach ($querycol->impuesto as $imp) {

        if ($imp->codigo == 5) {
          // $id_com=$querycol->id;
          if ($imp->comprobante_id == $id_com) {

            $valorIRB = $imp->valor;
            $valorIRBPNR = $valorIRBPNR + $valorIRB;
          } //else{$valorIRBPNR=$imp->totalImpuesto->valor;}
        }
      }


      $comprobante = (object)[
        'estado' => $querycol->estado,
        'numero_autorizacion' => $querycol->numero_autorizacion,
        'fecha_autorizacion' => $querycol->fecha_autorizacion,
        'ambiente' => $querycol->ambiente,
        'tipo_emision' => $querycol->tipo_emision,
        'razon_social' => $querycol->razon_social,
        'nombre_comercial' => $querycol->nombre_comercial,
        'ruc' => $querycol->ruc,
        'clave_acceso' => $querycol->clave_acceso,
        "cod_doc" => $querycol->cod_doc,
        "estab" => $querycol->estab,
        "pto_emi" => $querycol->pto_emi,
        "secuencial" => $querycol->secuencial,
        "dir_matriz" => $querycol->dir_matriz,
        "fecha_emision" => $querycol->fecha_emision,
        "contribuyente_especial" => $querycol->contribuyente_especial,
        "obligado_contabilidad" => $querycol->obligado_contabilidad,
        "tipo_identificacion_com" => $querycol->tipo_identificacion_com,
        "razon_social_comprador" => $querycol->razon_social_comprador,
        "identificacion_comprador" => $querycol->identificacion_comprador,
        "direccion_comprador" => $querycol->direccion_comprador,
        "total_sin_impuestos" => $querycol->total_sin_impuestos,
        "totalBaseIva" => $totalbiva,
        "totalBaseCero" => $totalbcero,
        "totalBaseNoIva" => $totalbnoiva,
        "totalBaseExentoIva" => $totalbexcento,
        "total_descuento" => $querycol->total_descuento,
        "totalValorICE" => $valorice,
        "totalValorIva" => $valoriva,
        "totalDevolucionIva" => $valordiva,
        "totalValorIRBPNR" => $valorIRBPNR,
        "propina" => $querycol->propina,
        "importe_total" => $querycol->importe_total,
        "totalSinSubsidio" => 0,
        "ahorroPorSubsidio" => 0,
        "moneda" => $querycol->moneda,

      ];

      
      foreach ($querycol->detalle as $det) {

        $detalle = (object)[
          // CABECERA
          'numero_autorizacion' => $querycol->numero_autorizacion,
          'fecha_autorizacion' => $querycol->fecha_autorizacion,
          'ruc' => $querycol->ruc,
          'clave_acceso' => $querycol->clave_acceso,
          "cod_doc" => $querycol->cod_doc,
          "estab" => $querycol->estab,
          "pto_emi" => $querycol->pto_emi,
          "secuencial" => $querycol->secuencial,
          // END CABECERA
          // DETALLE
          "codigo_principal" => $det->codigo_principal,
          "descripcion" => $det->descripcion,
          "cantidad" => $det->cantidad,
          "precio_unitario" => $det->precio_unitario,
          "descuento" => $det->descuento,
          "precio_total_sin_impuesto" => $det->precio_total_sin_impuesto,
          // END DETALLE
          "codigo" => '',
          "codigo_porcentaje" => '',
          "tarifa" => 0,
          "base_imponible" => 0,
          "valor" => 0
        ];
        foreach ($det->detalleimpuesto as $key_detimp => $det_imp) {
          $detalle->codigo = $det_imp->codigo;
          $detalle->codigo_porcentaje = $det_imp->codigo_porcentaje;
          $detalle->tarifa += +$det_imp->tarifa;
          $detalle->base_imponible = $det_imp->base_imponible;
          $detalle->valor = $det_imp->valor;
        }
      }



      //$datos->push($comprobante,$detalle);
      $datos->push($comprobante);
      $datos->push($detalle);
    }

    // echo $datos;
    return $datos;
  }

  public function headings(): array
  {

    return [
      'estado',
      'numero_autorizacion',
      'fecha_autorizacion',
      'ambiente',
      'tipo_emision',
      'razon_social',
      'nombre_comercial',
      'ruc',
      'clave_acceso',
      "cod_doc",
      "estab",
      "pto_emi",
      "secuencial",
      "dir_matriz",
      "fecha_emision",
      "contribuyente_especial",
      "obligado_contabilidad",
      "tipo_identificacion_com",
      "razon_social_comprador",
      "identificacion_comprador",
      "direccion_comprador",
      "total_sin_impuestos",
      "totalBaseIva",
      "totalBaseCero",
      "totalBaseNoIva",
      "totalBaseExentoIva",
      "total_descuento",
      "totalValorICE",
      "totalValorIva",
      "totalDevolucionIva",
      "totalValorIRBPNR",
      "propina",
      "importe_total",
      "totalSinSubsidio",
      "ahorroPorSubsidio",
      "moneda",

    ];
  }

  /*public function sheets(): array
    {
        $sheets = [];

      

        return $sheets;
    }*/
}
