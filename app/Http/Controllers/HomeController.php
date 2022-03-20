<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ComprobanteExport;
use App\Exports\ComprobanteMultiSheetExport;
use App\Exports\ExportExcelCommand;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');    
    }

    public function exportExcel()
    {

        //$originalDate = $request->get('dateini');
       // $newDate = date("d/m/Y", strtotime($originalDate));
        //return $newDate;
        $time = Carbon::now()->format('d.m.Y H.i.s');
        return Excel::download(new ComprobanteMultiSheetExport, 'comprobante'.$time.'.xlsx');
        //return Excel::download(new ComprobanteExport, 'comprobante.xlsx');

    }
    
    public function exportExcelCommand()
    {

        //$originalDate = $request->get('dateini');
       // $newDate = date("d/m/Y", strtotime($originalDate));
        //return $newDate;
        $time = Carbon::now()->format('d.m.Y H.i.s');
        return Excel::download(new ComprobanteMultiSheetExport, 'comprobantecommand'.$time.'.xlsx');
        return Excel::download(new ExportExcelCommand, 'comprobantecommand.xlsx');
    }



}

