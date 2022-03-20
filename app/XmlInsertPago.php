<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XmlInsertPago extends Model
{
    protected $table='pago';

    protected $fillable=[
        'forma_pago',
        'total_pago',
        'plazo',
        'unidad_tiempo',
        'comprobante_id'
            
    ];
}
