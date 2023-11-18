<?php

namespace App\Http\Controllers;

use App\Models\ConsumerLedger;
use Illuminate\Http\Request;
use DB;

class ConsumerLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //consumers ledger
    public function consumerLedger(Request $request){
        if ($request->ajax()) {
            $consumerLedger = DB::table('consumer_infos')
                ->orderBy('consumer_infos.customerName', 'asc')
                ->whereNot('status',2)
                ->select('id', 'account_id', 'customerName', 'connectionDate','updatestatusDate', 'rate_case', 'classification', 'cluster', 'consumerName2', 'trade1', 'trade2', 'concessionerName', 'meter', 'status',
                    DB::raw("CONCAT(region, ', ', province, ', ', municipality, ', ', barangay, ', ', purok) AS location"), 
                    'Province')
                ->get();
    
            return datatables()->of($consumerLedger)->addIndexColumn()
                ->addColumn('action', function ($consumerLedger) {
                    $url = route('collection.perConsumer-ledger', ['account_id' => $consumerLedger->account_id]);
    
                    $button = '
                        <a href="' . $url . '" class="action-button btn btn-primary btn-sm fetch-details" style="padding-top: 1mm; padding-bottom: 1mm; padding-left: 3mm; padding-right: 3mm; font-size: 9px;">
                        <i class="fa fa-eye fa-1x"></i>
                            <span class="action-text" style="font-size:9px">Show</span>
                        </a>
                    ';
    
                    return $button;
                })
                ->make(true);
            }
        return view('collection.consumer-ledger');
    }
    public function perConsumer(Request $request, $account_id)
    {
        
        $user = DB::table('consumer_infos')
        ->select('customerName', 'account_id')
        ->where('account_id', $account_id)
    
        ->first();

        if ($request->ajax()) {
         $ledgerConsumer = DB::table('consumer_ledgers')->select('id','customerName','transact_date','particular','or_no','issuance','collection','balance')
         ->where('account_id', $user->account_id)
         ->orderBy('transact_date', 'asc')
         ->get();
            $lastGeneratedBalance = 0;
            foreach ($ledgerConsumer as $entry) {
                if (strpos($entry->particular, 'Discount - ') === 0) {
                    $lastGeneratedBalance -= $entry->issuance;
                } elseif (!is_null($entry->collection)) {
                    $lastGeneratedBalance -= $entry->collection;
                } else {
                    $lastGeneratedBalance += $entry->issuance;
                }
                $entry->generated_balance = number_format(max($lastGeneratedBalance, 0), 2);
            }
 
       
         return datatables()->of($ledgerConsumer)->make(true);
            
            }
            $grand_total_issuance = DB::table('consumer_ledgers')
            ->select(
                DB::raw('SUM(CASE WHEN particular LIKE "Discount - %" THEN -issuance ELSE issuance END) as total_issuance'),) 
                ->where('account_id', $user->account_id) 
                ->get();
            $grand_total_collection = DB::table('consumer_ledgers')
            ->select(DB::raw('SUM(CASE WHEN particular LIKE "Discount - %" THEN -collection ELSE collection END) as total_collection'),)
            ->where('account_id', $user->account_id)
            ->get();
      
            $grand_total_balance = $grand_total_issuance[0]->total_issuance - $grand_total_collection[0]->total_collection ;
        
            
        return view('collection.perConsumer-ledger', compact('user','grand_total_issuance','grand_total_collection','grand_total_balance'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConsumerLedger  $consumerLedger
     * @return \Illuminate\Http\Response
     */
    public function show(ConsumerLedger $consumerLedger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConsumerLedger  $consumerLedger
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsumerLedger $consumerLedger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConsumerLedger  $consumerLedger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConsumerLedger $consumerLedger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConsumerLedger  $consumerLedger
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsumerLedger $consumerLedger)
    {
        //
    }
}
