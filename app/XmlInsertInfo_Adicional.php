<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XmlInsertInfo_Adicional extends Model
{
    //
    protected $table='info_adicional';

    protected $fillable=[
        'name',
        'value',
        'comprobante_id'
    ];
}
