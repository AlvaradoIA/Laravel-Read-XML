<?php

namespace App\Exports;

use App\XmlInsertComprobante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
class ExportExcelCommand implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $fechaini=Carbon::now()->hour(0)->minutes(0)->seconds(0);
        $fechafin=Carbon::now()->hour(23)->minutes(59)->seconds(59);
    

        return XmlInsertComprobante::whereBetween("created_at",[$fechaini,$fechafin])->select("id", "estado", "fecha_autorizacion")->get();
    }
}
