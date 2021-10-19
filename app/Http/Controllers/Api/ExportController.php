<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;


class ExportController extends Controller
{

    public function exportCsvFile(){

        $fileName = 'CourseMetrics.csv';
        $tblData = DB::table('genhuntdata')->get();         
     
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('huntID', 'propertyName', 'huntCourse', 'huntParty', 'HuntType', 'skyCover', 'temp', 'wind', 'precip', 'startTime', 'endTime', 'stopTime', 'huntDate', 'maHarv', 'mjHarv', 'faHarv', 'fjHarv');
        $callback = function() use($tblData, $columns) {
            $file = fopen('php://output', 'w');
        
            fputcsv($file, $columns);

            foreach ($tblData as $data) {
                $row['huntID']  = $data->huntID;
                $row['propertyName']    = $data->propertyName;
                $row['huntCourse']    = $data->huntCourse;
                $row['huntParty']  = $data->huntParty;
                $row['HuntType']    = $data->HuntType;
                $row['skyCover']    = $data->skyCover;
                $row['temp']  = $data->temp;
                $row['wind']    = $data->wind;
                $row['precip']    = $data->precip;
                $row['startTime']  = $data->startTime;
                $row['endTime']    = $data->endTime;
                $row['stopTime']    = $data->stopTime;
                $row['huntDate']  = $data->huntDate;
                $row['maHarv']    = $data->maHarv;
                $row['mjHarv']    = $data->mjHarv;
                $row['faHarv']  = $data->faHarv;
                $row['fjHarv']    = $data->fjHarv;
                fputcsv($file, $row);
            }                 
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
            
    }
    public function exportPdfFile(){
      // retreive all records from db
      $data = DB::table('genhuntdata')->get();

      // share data to view
      view()->share('data', $data);
      $pdf = PDF::loadView('pdf', $data)->setPaper('a4', 'landscape');

      // download PDF file with download method
      return $pdf->download('CourseMetrics.pdf');
    }
}
