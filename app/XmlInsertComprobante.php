<?php

namespace App;
use App\XmlInsertDetalle;

use Illuminate\Database\Eloquent\Model;

class XmlInsertComprobante extends Model
{
    //
    protected $table='comprobante';

    
    protected $fillable=[
       'id',
       'estado',
       'numero_autorizacion',
       'fecha_autorizacion',
       'ambiente',
       'tipo_emision',
       'razon_social',
       'nombre_comercial',
       'ruc',
       'clave_acceso',
       'cod_doc',
       'estab',
       'pto_emi',
       'secuencial',
       'dir_matriz',
       'agente_retencion',
       'contribuyente_especial',
       'fecha_emision',
       'dir_establecimiento',
       'obligado_contabilidad',
       'tipo_identificacion_com',
       'razon_social_comprador',
       'identificacion_comprador',
       'cod_doc_modificado',
       'num_doc_modificado',
       'fecha_emision_doc_sustento',
       'periodo_fiscal',
       'direccion_comprador',
       'total_sin_impuestos',
       'valor_modificacion',
       'total_descuento',
       'cod_doc_reembolso',
       'total_comprobante_reemb',
       'total_base_impon_reemb',
       'total_impuesto_reemb',
       'propina',
       'importe_total',
       'moneda',
       'status',
       'create_at',
       'updated_at',
       'deleted_at'
    ];

    public function impuesto()
    {
        return $this->hasMany(XmlInsertImpuesto::class,'comprobante_id','id')->select('id','comprobante_id','codigo','codigo_porcentaje','base_imponible','tarifa','valor','valor_devolucion_iva');
    }

    public function pago()
    {
        return $this->hasMany(XmlInsertPago::class,'comprobante_id','id')->select('id','comprobante_id','forma_pago','total_pago');
    }

    public function detalle()
    {
        return $this->hasMany(XmlInsertDetalle::class,'comprobante_id','id')->select('id','comprobante_id','codigo_principal','descripcion','cantidad','precio_unitario','descuento','precio_total_sin_impuesto');
    }

  


}
