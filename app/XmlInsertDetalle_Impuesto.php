<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XmlInsertDetalle_Impuesto extends Model
{
    protected $table='detalle_impuesto';

    protected $fillable=[
        'codigo',
        'codigo_porcentaje',
        'tarifa',
        'base_imponible',
        'valor',
        'detalle_id',
       
    ];
}
