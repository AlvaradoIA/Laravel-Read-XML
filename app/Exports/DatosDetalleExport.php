<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class DatosDetalleExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
  private $datos;
  public function __construct($datos)
  {
    $this->datos = $datos;
  }
  /**
   * @return string
   */
  public function title(): string
  {
    return "Detalle";
  }
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return $this->datos;
  }

  public function headings(): array
  {

    return [
          'numeroAutorizacion',
          'fechaAutorizacion',
          'ruc',
          'claveAcceso',
          "codDoc",
          "estab",
          "ptoEmi",
          "secuencial",
          // END CABECERA
          // DETALLE
          "codigoPrincipal",
          "descripcion",
          "cantidad",
          "precioUnitario",
          "descuento",
          "precioTotalSinImpuesto",
          // END DETALLE
          "codigo",
          "codigoPorcentaje",
          "tarifa",
          "baseImponible",
          "valor"
    ];
  }
  /**
   * @return array
   */
  public function registerEvents(): array
  {
    return [
      AfterSheet::class    => function (AfterSheet $event) {
        // $event->sheet->setAutoSize(true);
        for ($i = 'A'; $i <= 'G'; $i++) {
          $event->sheet->getColumnDimension($i)->setAutoSize(true);
        }
      },
    ];
  }


}
