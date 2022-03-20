<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class DatosCabeceraExport implements FromCollection, WithHeadings, WithTitle, WithEvents
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
    return "Cabecera";
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
      'estado',
      'numeroAutorizacion',
      'fechaAutorizacion',
      'ambiente',
      'tipoEmision',
      'razonSocial',
      'nombreComercial',
      'ruc',
      'claveAcceso',
      "codDoc",
      "estab",
      "ptoEmi",
      "secuencial",
      "dirMatriz",
      "fechaEmision",
      "contribuyenteEspecial",
      "obligadoContabilidad",
      "tipoIdentificacionComprador",
      "razonSocialComprador",
      "identificacionComprador",
      "direccionComprador",
      "totalSinImpuestos",
      "totalBaseIva",
      "totalBaseCero",
      "totalBaseNoIva",
      "totalBaseExentoIva",
      "totalDescuento",
      "totalValorICE",
      "totalValorIva",
      "totalDevolucionIva",
      "totalValorIRBPNR",
      "propina",
      "importeTotal",
      "totalSinSubsidio",
      "ahorroPorSubsidio",
      "moneda"
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
