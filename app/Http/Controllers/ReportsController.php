<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ReportLog;
use Illuminate\Http\Request;
use App\Models\ConsumerInfo;
use App\Models\Encoder;
use App\Models\Library;
use App\Models\ConsumerLedger;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function showReport()
        {
            $reportLogs = ReportLog::with('user')->orderBy('time', 'desc') ->get();
            return view('reports.reportLogs', compact('reportLogs'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewMasterlist(Request $request)
    {
        // for master list
        $masterlist = DB::table('consumer_infos')
            ->join('libraries', 'consumer_infos.Classification', '=', 'libraries.categoryaddedName')
            ->select('customerName', 'consumerName2', 'consumer_infos.Classification', 'concessionerName', 'rate_case', 'cluster')
            ->whereNot('status',2)
            ->get();
    
        return view('reports.master-list', ['masterlist' => $masterlist]);
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportLog  $reportLog
     * @return \Illuminate\Http\Response
     */
//     public function monthSummaryBilling(Request $request)
// {
//     $billingSummary = DB::table('encoders')
//         ->select('from_reading_date', 'rate_case', 'cluster', DB::raw('SUM(volume) as total_volume'), DB::raw('SUM(amount_bill) as total_amount_bill'))
//         ->groupBy('from_reading_date', 'rate_case', 'cluster')
//         ->get();

//     return view('reports.monthly-billing-sum', ['billingSummary' => $billingSummary]);
// }
        public function monthSummaryBilling(Request $request)
        {
            $billingSummary = DB::table('encoders')
                ->selectRaw('YEAR(encoders.from_reading_date) AS year, MONTH(encoders.from_reading_date) AS month, encoders.rate_case, encoders.cluster, SUM(encoders.volume) AS total_volume, SUM(encoders.amount_bill) AS total_amount_bill')
                ->join('consumer_infos', 'consumer_infos.account_id', '=', 'encoders.account_id')
                ->where('consumer_infos.status', '<>', 2)
                ->groupBy('year', 'month', 'encoders.rate_case', 'encoders.cluster')
                ->get();

            return view('reports.monthly-billing-sum', ['billingSummary' => $billingSummary]);
        }

        // public function getClusterData(Request $request) {
        //     $Cluster = $request->input('cluster');
        //     $monthYear = $request->input('monthYear'); 
            
            
        //     $applications = DB::table('encoders')
        //         ->where('cluster', $Cluster)
        //         ->whereRaw('DATE_FORMAT(from_reading_date, "%Y-%m") = ?', [$monthYear]) 
                
        //         ->get();
                
        //     return response()->json($applications);
        // }
        public function getClusterData(Request $request) {
            $cluster = $request->input('cluster');
            $monthYear = $request->input('monthYear');
        
            $applications = DB::table('encoders')
                ->select(
                    'encoders.id',
                    'encoders.account_id',
                    'consumer_infos.customerName',
                    'encoders.Reader',
                    'encoders.cluster',
                    'encoders.current_reading',
                    'encoders.previous_reading',
                    'encoders.from_reading_date',
                    'encoders.date_delivered',
                    'encoders.amount_bill',
                    'encoders.volume'
                )
                ->join('consumer_infos', 'consumer_infos.account_id', '=', 'encoders.account_id')
                ->where('encoders.cluster', $cluster)
                ->whereRaw('DATE_FORMAT(encoders.from_reading_date, "%Y-%m") = ?', [$monthYear])
                ->where('consumer_infos.status', '<>', 2)
                ->get();
        
            return response()->json($applications);
        }
        
        public function monthSummaryCollection(Request $request)
        {
            $reqDate = $request->input('filterMonthYear');
            $water_rental_grand = 0;
            $surcharge_grand = 0;
            $discount_grand = 0;
            $misc_grand = 0;
            $watershed_grand = 0;
            $total_grand = 0;
            if ($request->ajax()) {
                $request_month = date('m', strtotime($reqDate));
                $request_year = date('Y', strtotime($reqDate));
                $clusters = Library::where('category', 'cluster')->pluck('categoryaddedName');
                $ledger_list = [];
                foreach($clusters as $cluster){
                    $total = 0;
                    $water_rental = ConsumerInfo::join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Water Bill%')
                    ->sum('account_receivables.balance');
                    $total += $water_rental;
                    $water_rental_grand += $water_rental;
                    $surcharge = ConsumerInfo::join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Penalty%')
                    ->sum('account_receivables.balance');
                    $total += $surcharge;
                    $surcharge_grand += $surcharge;
                    $discount = ConsumerInfo::
                    join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Discount%')
                    ->sum('account_receivables.balance');
                    $total -= $discount;
                    $discount_grand -= $discount;
                    $watershed = ConsumerInfo::join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Watershed%')
                    ->sum('account_receivables.balance');
                    $total += $watershed;
                    $watershed_grand += $watershed;
                    $misc = ConsumerInfo::join('customer_miscellaneouses', 'consumer_infos.account_id', 'customer_miscellaneouses.account_id')
                    ->whereMonth('customer_miscellaneouses.created_at', $request_month)
                    ->whereYear('customer_miscellaneouses.created_at', $request_year)
                    ->where('cluster', $cluster)
                  
                    ->where('customer_miscellaneouses.status', 1)
                    ->sum('customer_miscellaneouses.amount');
                    if($misc){
                        $misc_grand -= $misc;
                        $total -= $misc;
                        $misc = '('. number_format($misc, 2) . ')';
                    }else{
                        $misc = ConsumerInfo::join('customer_miscellaneouses', 'consumer_infos.account_id', 'customer_miscellaneouses.account_id')
                        ->whereMonth('customer_miscellaneouses.created_at', $request_month)
                        ->whereYear('customer_miscellaneouses.created_at', $request_year)
                        ->where('cluster', $cluster)
                       
                        ->where('customer_miscellaneouses.status', 0)
                        ->sum('customer_miscellaneouses.amount');
                        $misc_grand += $misc;
                        $total += $misc;
                        $misc = number_format($misc, 2);
                    }

                    $rate_case = ConsumerInfo::where('cluster', $cluster)->pluck('rate_case')->first();

                    $total_grand += $total;
                    $ledger = [
                        'rate_case' => $rate_case,
                        'cluster' => $cluster,
                        'water_rental' => number_format($water_rental, 2),     
                        'surcharge' => number_format($surcharge, 2),
                        'discount' => number_format($discount, 2),
                        'misc' => $misc,
                        'watershed' => number_format($watershed,2),
                        'total' => number_format($total, 2)
                    ];
                    array_push($ledger_list, $ledger );
                }

                return datatables()->of($ledger_list)->addIndexColumn()->make(true);
            }
            return view('reports.monthly-collection');
        }

        public function grandTotal(Request $request){
            $reqDate = $request->date;
            $water_rental_grand = 0;
            $surcharge_grand = 0;
            $discount_grand = 0;
            $misc_grand = 0;
            $watershed_grand = 0;
            $total_grand = 0;
            
                $request_month = date('m', strtotime($reqDate));
                $request_year = date('Y', strtotime($reqDate));
                $clusters = Library::where('category', 'cluster')->pluck('categoryaddedName');
                foreach($clusters as $cluster){
                    $total = 0;
                    $water_rental = ConsumerInfo::join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Water Bill%')
                    ->sum('account_receivables.balance');
                    $total += $water_rental;
                    $water_rental_grand += $water_rental;
                    $surcharge = ConsumerInfo::join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Penalty%')
                    ->sum('account_receivables.balance');
                    $total += $surcharge;
                    $surcharge_grand += $surcharge;
                    $discount = ConsumerInfo::
                    join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Discount%')
                    ->sum('account_receivables.balance');
                    $total -= $discount;
                    $discount_grand += $discount;
                    $watershed = ConsumerInfo::join('account_receivables', 'consumer_infos.account_id', 'account_receivables.account_id')
                    ->whereMonth('account_receivables.date', $request_month)
                    ->whereYear('account_receivables.date', $request_year)
                    ->where('cluster', $cluster)
                    ->whereNot('status',2)
                    ->where('account_type', 'like', '%Watershed%')
                    ->sum('account_receivables.balance');
                    $total += $watershed;
                    $watershed_grand += $watershed;
                    $misc = ConsumerInfo::join('customer_miscellaneouses', 'consumer_infos.account_id', 'customer_miscellaneouses.account_id')
                    ->whereMonth('customer_miscellaneouses.created_at', $request_month)
                    ->whereYear('customer_miscellaneouses.created_at', $request_year)
                    ->where('cluster', $cluster)
                   
                    ->where('customer_miscellaneouses.status', 1)
                    ->sum('customer_miscellaneouses.amount');
                    if($misc){
                        $misc_grand += $misc;
                        $total -= $misc;
                    }else{
                        $misc = ConsumerInfo::join('customer_miscellaneouses', 'consumer_infos.account_id', 'customer_miscellaneouses.account_id')
                        ->whereMonth('customer_miscellaneouses.created_at', $request_month)
                        ->whereYear('customer_miscellaneouses.created_at', $request_year)
                        ->where('cluster', $cluster)
                      
                        ->where('customer_miscellaneouses.status', 0)
                        ->sum('customer_miscellaneouses.amount');
                        $misc_grand -= $misc;
                        $total += $misc;
                    }

                    $rate_case = ConsumerInfo::where('cluster', $cluster)->pluck('rate_case')->first();

                    $total_grand += $total;
                }
            return response()->json([
                'water_rental_grand'=> $water_rental_grand,
                'surcharge_grand'=> $surcharge_grand,
                'discount_grand'=> $discount_grand,
                'misc_grand'=> number_format($misc_grand, 2),
                'watershed_grand'=> $watershed_grand,
                'total_grand'=> $total_grand,
            ]);
        }


        // public function getClusterDataCollection() {
        //     $Cluster = $request->input('cluster');
        //     $monthYear = $request->input('monthYear'); 
            
        //     $applications = DB::table('encoders')
        //         ->where('cluster', $Cluster)
        //         ->whereRaw('DATE_FORMAT(from_reading_date, "%Y-%m") = ?', [$monthYear]) 
        //         ->get();
                
        //     return response()->json($applications);
        // }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportLog  $reportLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportLog $reportLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportLog  $reportLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportLog $reportLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportLog  $reportLog
     * @return \Illuminate\Http\Response
     */
    public function clearHistoryLogs(Request $request)
        {
      //
        }
}
