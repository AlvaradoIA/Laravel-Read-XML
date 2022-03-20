<?php

namespace App;

use App\XmlInsertDetalle_Impuesto;
use Illuminate\Database\Eloquent\Model;

class XmlInsertDetalle extends Model
{
    protected $table='detalle';

    protected $fillable=[
        'codigo_principal',
        'codigo_auxiliar',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento',
        'precio_total_sin_impuesto',
        'comprobante_id'
    ];

    public function detalleimpuesto()
    {
        return $this->hasMany(XmlInsertDetalle_Impuesto::class,'detalle_id','id')->select('id','detalle_id','codigo','codigo_porcentaje','tarifa','base_imponible','valor',);
    }


}
