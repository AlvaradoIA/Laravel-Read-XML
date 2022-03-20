<?php

namespace App\Console\Commands;

use Exception;
use SimpleXMLElement;
use App\XmlInsertPago;
use App\XmlInsertDetalle;
use App\XmlInsertImpuesto;
use App\XmlInsertComprobante;
use Illuminate\Console\Command;
use App\XmlInsertInfo_Adicional;
use App\XmlInsertDetalle_Impuesto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class ReadXmlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se lee archivo XML ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *
     * 
     */
    public function handle()
    {
        $this->info('Inicia lectura de documentos autorizados.');
        Log::info('Inicia lectura de documentos autorizados.');
        try {
            // Obtener el listado de archivos xml
            $files_xml = Storage::allFiles( 'XML/AUTORIZADOS');
            
            if ($files_xml== null){
                $this->info('Error al cargar archivo.');
            }else{
                $this->info('Exito al cargar.');
            }
        } catch (Exception $th) {
            $this->info('Error al obtener los archivos del disco ');
            Log::info($th);
            return;
        }
         // Procesar archivos
         $this->processGenerated($files_xml);
         $this->info('Cargo.');
        
       
    }


    /**
     * @param $name_business
     * @param $disk
     * @return int|void
     */
    

        

    /**
     * @param $files_xml
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function processGenerated($files_xml)
    {   
        $this->info('Funcion ProcessGenerated.');
        foreach ($files_xml as $key => $file) {
            // Attemps validate key in WEBSERVIDE
            
            $this->info('Foreach ejecutado');
            $this->attemps = 0 ;
            $file_folder = $file;
            

            $basename = pathinfo($file_folder, PATHINFO_BASENAME);
            

            try{
                $file =  explode('/', $file)[1];
                $this->info('Se obtuvo directorio de archivo');
            }catch(Exception $Ex){
                $this->info('Error al obtener directorio ');
            }
            
            $file_name = explode('.', $file);

            // have the xml extension in the file
            if (isset($file_name[count($file_name) - 1]) == 'XML' || isset($file_name[count($file_name) - 1]) == 'xml') {
               

                if (Storage::exists('XML/PROCESADOS/'.$basename))
                {
                    //
                    Storage::delete($file_folder);
                    $this->info('ARCHIVO YA EXISTENTE ELIMINADO');

                }else{
                /**
                 * Contenido XML
                 */

                $content = Storage::get($file_folder);
                $xml_object = $this->getXMLObject($content);
                

                $infoDoc = $this->getXMLObject( $xml_object->comprobante);
                $this->SaveDocumentTypeName($infoDoc, $xml_object);
                $this->info('FIN');

                    Storage::move($file_folder, 'XML/PROCESADOS/'.$basename);
                }

                
                
                // Existe clave de acceso
                if(isset($xml_object->numeroAutorizacion) && !empty($xml_object->numeroAutorizacion)){
       
                    // Put data local
                }   
            }
        }

    }
    
  
    /**
     * @param $xml_obj
     * @param object
     */
    public function SaveDocumentTypeName($xml_obj, $xml_object)
    {
        $this->info('Funcion SaveDocumentTypeName');
        
        switch ($xml_obj->infoTributaria->codDoc) {
            case '01':
                $this->info('Opcion 1');
                //$infoT=$xml_obj->infoTributaria;
                $infoF=$xml_obj->infoFactura;
                $this->insertcomprobante($xml_obj,$infoF, $xml_object);
                break;
            case '03':
                $this->info('Opcion 3');
                
                break;
            case '04':
                $this->info('Opcion 4');
                //$infoT=$xml_obj->infoTributaria;
                $infoN=$xml_obj->infoNotaCredito;
                $this->insertcomprobante($xml_obj,$infoN,$xml_object);
                break;
            case '05':
                $this->info('Opcion 5');
                break;
            case '06':
                $this->info('Opcion 6');
                break;
            case '07':
                $this->info('Opcion 7');
                
                //$infoT=$xml_obj->infoTributaria;
                $infoR=$xml_obj->infoCompRetencion;
                $this->insertcomprobante($xml_obj,$infoR,$xml_object);
                break;
            default : 
            $this->info('Default');
                break;
        }
        
        return  (0);
    }

    
                
    /**
     * Generate Key access
     * @param $xml
     * @return object $claveAcceso  | false
     */
    public function getXMLObject($xml)
    {
        $this->info('getXMLObject');
        try {
            $this->info('Evalua getXMLObject');
        
            return (new SimpleXMLElement($xml));
        } catch (\Throwable $th) {
            // ErroR
            $this->info('Error getXMLObject');
            Log::info($th);
            return false;
        }
    }


    public function insertcomprobante($xml_obj,$xml_obj_,$xml_object)
    {
        $this->info('Funcion insertfactura');
        $comprobante= new XmlInsertComprobante();
        // $rimpuesto= $xml_obj->codDoc;
        //echo($rimpuesto);

        if ($xml_obj->infoTributaria->codDoc == '01' || $xml_obj->infoTributaria->codDoc == '04' ){
            $xml_objinf=$xml_obj->infoAdicional;
            $xml_objde=$xml_obj->detalles;
            $xml_obj=$xml_obj->infoTributaria;
        }

        if ($xml_obj->infoTributaria->codDoc == '07'){
            $xml_objinf=$xml_obj->infoAdicional;
            $xml_objim=$xml_obj->impuestos;
            $xml_objde=$xml_obj->detalles;
            $xml_obj=$xml_obj->infoTributaria;
        }
      
            $comprobante->estado= $xml_object->estado;
            $comprobante->numero_autorizacion= $xml_object->numeroAutorizacion;
            $comprobante->fecha_autorizacion= $xml_object->fechaAutorizacion;
            $comprobante->ambiente= $xml_obj->ambiente;
            $comprobante->tipo_emision= $xml_obj->tipoEmision;
            $comprobante->razon_social= $xml_obj->razonSocial;
            $comprobante->nombre_comercial= $xml_obj->nombreComercial;
            $comprobante->ruc= $xml_obj->ruc;            
            $comprobante->clave_acceso= $xml_obj->claveAcceso;
            $comprobante->cod_doc= $xml_obj->codDoc;
            $comprobante->estab= $xml_obj->estab;
            $comprobante->pto_emi= $xml_obj->ptoEmi;
            $comprobante->secuencial= $xml_obj->secuencial;
            $comprobante->dir_matriz= $xml_obj->dirMatriz;
            $comprobante->agente_retencion= $xml_obj->agenteRetencion;

            /*infoFactura */
            $comprobante->fecha_emision=$xml_obj_->fechaEmision;
            $comprobante->dir_establecimiento=$xml_obj_->dirEstablecimiento;
            
            if ($xml_obj->codDoc == '07'){
            $comprobante->tipo_identificacion_com=$xml_obj_->tipoIdentificacionSujetoRetenido;
            $comprobante->razon_social_comprador=$xml_obj_->razonSocialSujetoRetenido;
            $comprobante->identificacion_comprador=$xml_obj_->identificacionSujetoRetenido;
            }else{ 
            $comprobante->contribuyente_especial=$xml_obj_->contribuyenteEspecial??0;
            $comprobante->tipo_identificacion_com=$xml_obj_->tipoIdentificacionComprador;
            $comprobante->razon_social_comprador=$xml_obj_->razonSocialComprador;
            $comprobante->identificacion_comprador=$xml_obj_->identificacionComprador;    
            }
            $comprobante->obligado_contabilidad= $xml_obj_->obligadoContabilidad;
            $comprobante->cod_doc_modificado= $xml_obj_->codDocModificado??0;
            $comprobante->num_doc_modificado= $xml_obj_->numDocModificado;
            $comprobante->fecha_emision_doc_sustento= $xml_obj_->fechaEmisionDocSustento;
            $comprobante->periodo_fiscal=$xml_obj_->periodoFiscal;
            $comprobante->direccion_comprador=$xml_obj_->direccionComprador;
            $comprobante->total_sin_impuestos=$xml_obj_->totalSinImpuestos??0;
            $comprobante->valor_modificacion=$xml_obj_->valorModificacion??0;
            $comprobante->total_descuento=$xml_obj_->totalDescuento??0;
            $comprobante->cod_doc_reembolso=$xml_obj_->codDocReembolso;
            $comprobante->total_comprobante_reemb=$xml_obj_->totalComprobantesReembolso;
            $comprobante->total_base_impon_reemb=$xml_obj_->totalBaseImponibleReembolso;
            $comprobante->total_impuesto_reemb=$xml_obj_->totalImpuestoReembolso;
            $comprobante->propina=$xml_obj_->propina??0;
            $comprobante->importe_total=$xml_obj_->importeTotal??0;
            $comprobante->moneda=$xml_obj_->moneda;
            
            $comprobante->save();

           

        if ($xml_obj->codDoc == '07'){
            try{  
          //  if( isset($data->campo) && $data->campo && $data->campo != null )
            $imp=$xml_objim->impuesto[0]->codigo;
            $cod=0;
                
            if($imp!=null){
                $this->info('condicion totalimpuesto 07');
                for ($i = 0; $cod >= 0; $i++) {
                    
                    $this->info('for totalimpuesto 07');
                    try{
                        if(!( isset($xml_objim->impuesto[$i]->codigo) && $xml_objim->impuesto[$i]->codigo && $xml_objim->impuesto[$i]->codigo != null ))
                        break;
                        
                        $cod=$xml_objim->impuesto[$i]->codigo;
                        $impuesto= new XmlInsertImpuesto();
                        $impuesto->codigo=$xml_objim->impuesto[$i]->codigo;
                        $impuesto->codigo_porcentaje= $xml_objim->impuesto[$i]->codigoRetencion;
                        $impuesto->base_imponible=$xml_objim->impuesto[$i]->baseImponible;
                        $impuesto->tarifa= $xml_objim->impuesto[$i]->porcentajeRetener;
                        $impuesto->valor= $xml_objim->impuesto[$i]->valorRetenido;
                        $impuesto->valor_devolucion_iva= $xml_objim->impuesto[$i]->valorDevolucionIva;
                        $impuesto->cod_doc_sustento= $xml_objim->impuesto[$i]->codDocSustento;
                        $impuesto->num_doc_sustento= $xml_objim->impuesto[$i]->numDocSustento;
                        $impuesto->fecha_emision_doc_sustento= $xml_objim->impuesto[$i]->fechaEmisionDocSustento;
                        $impuesto->comprobante_id= $comprobante->id;
                        $impuesto->save();
                        
                    }catch (Exception $e) {
                        $cod=-1;
                        echo $e->getMessage();
                        Log::info($e);
                        
                     }
                   
                    //******************************************** */
                       
                }
                
            }   
                }catch (Exception $e) {
                echo $e->getMessage();
                Log::info($e);
                }
       }else{
                try{  
                $imp=$xml_obj_->totalConImpuestos->totalImpuesto[0]->codigo;
                $cod=0;
                
                if($imp!=null){
                    $this->info('condicion totalimpuesto');
                    for ($i = 0; $cod >= 0; $i++) {
                        $this->info('for totalimpuesto');
                    try{  
                        if(!(isset($xml_obj_->totalConImpuestos->totalImpuesto[$i]->codigo) && $xml_obj_->totalConImpuestos->totalImpuesto[$i]->codigo && $xml_obj_->totalConImpuestos->totalImpuesto[$i]->codigo != null))
                        break;
                        $cod=$xml_obj_->totalConImpuestos->totalImpuesto[$i]->codigo;
                        $impuesto= new XmlInsertImpuesto();
                        $impuesto->codigo=$xml_obj_->totalConImpuestos->totalImpuesto[$i]->codigo;
                        $impuesto->codigo_porcentaje= $xml_obj_->totalConImpuestos->totalImpuesto[$i]->codigoPorcentaje;
                        $impuesto->base_imponible=$xml_obj_->totalConImpuestos->totalImpuesto[$i]->baseImponible;
                        $impuesto->tarifa= $xml_obj_->totalConImpuestos->totalImpuesto[$i]->tarifa??0;
                        $impuesto->valor= $xml_obj_->totalConImpuestos->totalImpuesto[$i]->valor;
                        $impuesto->valor_devolucion_iva= $xml_obj_->totalConImpuestos->totalImpuesto[$i]->valorDevolucionIva??0;
                        $impuesto->comprobante_id= $comprobante->id;
                            
                        $impuesto->save();  
                        

                    }catch (Exception $e) {
                        $cod=-1;
                        echo $e->getMessage();
                        Log::info($e);
                     }    
                    }
                    
                }
                }catch (Exception $e) {  
                    echo $e->getMessage();
                    Log::info($e);
                }  
             }


             if ($xml_obj->codDoc == '01'){
                try{  
                $_pago=$xml_obj_->pagos->pago[0]->formaPago;
                $pag=0;

                if($_pago!=null){
                    $this->info('condicion pago');
                    for ($i = 0; $pag >= 0; $i++) {
                        $this->info('for Pago');
                        try{ 
                        if(!(isset($xml_obj_->pagos->pago[$i]->formaPago) && $xml_obj_->pagos->pago[$i]->formaPago && $xml_obj_->pagos->pago[$i]->formaPago != null ))
                        break;
                        $pag=$xml_obj_->pagos->pago[$i]->formaPago;
                        $pago= new XmlInsertPago();
                        $pago->forma_pago=$xml_obj_->pagos->pago[$i]->formaPago;
                        $pago->total_pago=$xml_obj_->pagos->pago[$i]->total;
                        $pago->plazo=$xml_obj_->pagos->pago[$i]->plazo??0;
                        $pago->unidad_tiempo=$xml_obj_->pagos->pago[$i]->unidadTiempo;
                        $pago->comprobante_id= $comprobante->id;

                        $pago->save();
                        
                    }catch (Exception $e) {  
                        echo $e->getMessage();
                        $pag=-1;
                        Log::info($e);
                    }  
                    }
                }
                }catch (Exception $e) {  
                echo $e->getMessage();
                Log::info($e);
                }  
            }

            /*DETALLE */
            try{  
                
                if($xml_obj->codDoc == '04'){
                    $det=$xml_objde->detalle[0]->codigoInterno;
                }else{
                    $det=$xml_objde->detalle[0]->codigoPrincipal;
                }
                
                $cod=0;
                
                if($det!=null){
                    $this->info('condicion detalle');
                    for ($i = 0; $cod >= 0; $i++) {
                        $this->info('for detalle');
                        //********************** */
                    try{  
                        
                        $detalle= new XmlInsertDetalle();
                        if($xml_obj->codDoc == '04'){
                            if(!(isset($xml_objde->detalle[$i]->codigoInterno) && $xml_objde->detalle[$i]->codigoInterno && $xml_objde->detalle[$i]->codigoInterno != null ))
                            break;
                            $cod=$xml_objde->detalle[$i]->codigoInterno;
                            $detalle->codigo_principal=$xml_objde->detalle[$i]->codigoInterno;
                            $detalle->codigo_auxiliar= $xml_objde->detalle[$i]->codigoAdicional;
                        }else
                        {
                            if(!(isset($xml_objde->detalle[$i]->codigoPrincipal) && $xml_objde->detalle[$i]->codigoPrincipal && $xml_objde->detalle[$i]->codigoPrincipal != null ))
                            break;
                            $cod=$xml_objde->detalle[$i]->codigoPrincipal;
                            $detalle->codigo_principal=$xml_objde->detalle[$i]->codigoPrincipal;
                            $detalle->codigo_auxiliar= $xml_objde->detalle[$i]->codigoAuxiliar;
                        }
                        $detalle->descripcion=$xml_objde->detalle[$i]->descripcion;
                        $detalle->cantidad= $xml_objde->detalle[$i]->cantidad??0;
                        $detalle->precio_unitario= $xml_objde->detalle[$i]->precioUnitario??0;
                        $detalle->descuento= $xml_objde->detalle[$i]->descuento??0;
                        $detalle->precio_total_sin_impuesto= $xml_objde->detalle[$i]->precioTotalSinImpuesto??0;
                        $detalle->comprobante_id= $comprobante->id;
                            
                        $detalle->save();  

                        // DETALLE IMPUESTO
                             try{  
                                $detimp=$xml_objde->detalle[$i]->impuestos->impuesto[0]->codigo;
                                $codi=0;
                    
                                if($detimp!=null){
                                    $this->info('condicion detalle_impuesto');
                                    for ($j = 0; $codi >= 0; $j++) {
                                        $this->info('for detalle_impuesto');
                                        //********************** */
                                    try{
                                        if(!(isset($xml_objde->detalle[$i]->impuestos->impuesto[$j]->codigo) && $xml_objde->detalle[$i]->impuestos->impuesto[$j]->codigo && $xml_objde->detalle[$i]->impuestos->impuesto[$j]->codigo != null ))
                                        break;  
                                        $codi=$xml_objde->detalle[$i]->impuestos->impuesto[$j]->codigo;
                                        $detalle_impuesto= new XmlInsertDetalle_Impuesto();
                                        $detalle_impuesto->codigo=$xml_objde->detalle[$i]->impuestos->impuesto[$j]->codigo??0;
                                        $detalle_impuesto->codigo_porcentaje= $xml_objde->detalle[$i]->impuestos->impuesto[$j]->codigoPorcentaje??0;
                                        $detalle_impuesto->tarifa=$xml_objde->detalle[$i]->impuestos->impuesto[$j]->tarifa??0;
                                        $detalle_impuesto->base_imponible= $xml_objde->detalle[$i]->impuestos->impuesto[$j]->baseImponible??0;
                                        $detalle_impuesto->valor= $xml_objde->detalle[$i]->impuestos->impuesto[$j]->valor??0;
                                        $detalle_impuesto->detalle_id= $detalle->id;
                                        
                                            
                                        $detalle_impuesto->save();  
                                    }catch (Exception $e) {
                                        $codi=-1;
                                        echo $e->getMessage();
                                        Log::info($e);
                                    }    
                                    }
                        
                                }
                                }catch (Exception $e) {  
                                    echo $e->getMessage();
                                    Log::info($e);
                                }
            

                    }catch (Exception $e) {
                        $cod=-1;
                        echo $e->getMessage();
                        Log::info($e);
                     }    
                    }
                    
                }
                }catch (Exception $e) {  
                    echo $e->getMessage();
                    Log::info($e);
                    //info('Inicia lectura de documentos autorizados.');
                }
                    
                
               if(isset($xml_objinf->campoAdicional) && $xml_objinf->campoAdicional && $xml_objinf->campoAdicional != null ){
                    foreach ($xml_objinf->campoAdicional as $item){
                    $info_adicional= new XmlInsertInfo_Adicional();
                    $info_adicional->name=$item['nombre'];
                    $info_adicional->value=$item;
                    $info_adicional->comprobante_id=$comprobante->id;
                    
                    $info_adicional->save();
                    } 
                }
              
        
        return 0;
    }
    
    
    


}
