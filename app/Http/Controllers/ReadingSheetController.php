<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use dataTables;
use App\Models\ConsumerInfo;


class ReadingSheetController extends Controller
{
public function sheet()
{
    $sheet = DB::table('consumer_infos')
        ->select(
            'consumer_infos.id', 
            'consumer_infos.customerName', 
            'consumer_infos.rate_case', 
            'consumer_infos.classification', 
            'consumer_infos.cluster',
            DB::raw("CONCAT(consumer_infos.purok, ', ', consumer_infos.barangay, ', ', consumer_infos.municipality) AS location"),
            'consumer_infos.Province',
            'encoders.current_reading' 
        )
        ->leftJoin('encoders', function ($join) {
            $join->on('consumer_infos.account_id', '=', 'encoders.account_id')
                ->whereRaw('encoders.from_reading_date = (SELECT MAX(from_reading_date) FROM encoders WHERE encoders.account_id = consumer_infos.account_id)');
        })
        ->whereIn('consumer_infos.status', [0, 1])
        ->get();

    return view('billing.reading-sheet', compact('sheet'));
}

    
}
