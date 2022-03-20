<?php

namespace App\Http\Controllers;

use App\XmlInsertDetalle;
use Illuminate\Http\Request;
use App\XmlInsertComprobante;
use Illuminate\Support\Facades\DB;

class ComprobantesController extends Controller
{
    //
    public function index(){

        //$comprobantes =XmlInsertComprobante::all();
        //$comprobantes =XmlInsertDetalle::all();
        //return with($comprobantes);
         //dd($comprobantes);
        
        
        //return $comprobantes->numero_autorizacion; //view('comprobantes.index', );
       return view('comprobantes.index');
    }


}
