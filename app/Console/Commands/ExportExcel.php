<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Console\Commands\DateTime;
use App\Exports\ExportExcelCommand;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     */
    public function handle()
    {   
      /*  $horaini='00:00:00';
        $dateini = Carbon::now();
        $dateini = $dateini->format('d/m/Y');        
        $datei=($dateini." ".$horaini);

        $datefin = Carbon::now();
        $datefin = $datefin->format('d/m/Y H:i:s');
        echo $datei;
       
        echo $datefin;*/

        
        
        $file='ExcelExport/comprobantes';
        $date = Carbon::now();
        
        $date = $date->format('d-m-Y H.i.s');
        $filename=($file.$date.'.xlsx');
        echo $filename;
        $this->info('Se exporta Excel de comprobantes del dia: '.$date);
        Log::info('Se exporta Excel de comprobantes del dia: '.$date);

        return Excel::store(new ExportExcelCommand, $filename);
    }

    public function exportExcelCommand()
    {

        //$originalDate = $request->get('dateini');
       // $newDate = date("d/m/Y", strtotime($originalDate));
        //return $newDate;
        //return Excel::download(new ExportExcelCommand, 'comprobantecommand.xlsx');
        
    }

}
