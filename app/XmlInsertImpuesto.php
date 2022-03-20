<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XmlInsertImpuesto extends Model
{
    protected $table='impuesto';

    protected $fillable=[
        'codigo',
        'codigo_porcentaje',
        'base_imponible',
        'tarifa',
        'valor',
        'valor_devolucion_iva',
        'cod_doc_sustento',
        'num_doc_sustento',
        'fecha_emision_doc_sustento',
        'comprobante_id',
    ];


}
