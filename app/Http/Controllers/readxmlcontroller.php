<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class readxmlcontroller extends Controller
{
    //
    public function index()
    {
    $xmlDataString = file_get_contents(public_path('factura.xml'));
        
        $xmlObject = simplexml_load_string($xmlDataString, NULL, LIBXML_NOCDATA);
        //$xmlObject = simplexml_load_string($xmlDataString);

        //$lol = simplexml_load_file('el_archivo.xml', NULL, LIBXML_NOCDATA);
        //simplexml_load_file
        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true); 
   
        // echo "<pre>";
        // print_r($phpDataArray);
        dd($phpDataArray);

    }
}
