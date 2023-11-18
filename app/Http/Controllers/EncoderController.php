<?php

namespace App\Http\Controllers;

use App\Models\ConsumerInfo;
use App\Models\Encoder;
use App\Models\BillingRate;
use App\Models\AccountReceivable;
use App\Models\BillingMonth;
use Illuminate\Http\Request;
use DB;
use Datatables;
class EncoderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
        {
            $consumerData = ConsumerInfo::select('id','account_id','customerName', 'meter','cluster','rate_case','classification', DB::raw("CONCAT(purok, ', ', barangay, ', ', municipality) AS location"), 'Province')->whereIn('status', [0, 1])->get();
            $consumerData->load('encoders');
            
            return view('billing.encoder-billing',compact('consumerData'));
          }



    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function create(Request $request)
        {
            $last_encoder = Encoder::where('account_id', $request->account_id)
                ->whereNotNull('current_reading')
                ->orderByDesc('id')
                ->first();
        
            $billingMonth = BillingMonth::where('status_bill_month', 1)
                ->first();
        
            if (!$billingMonth) {
                return response()->json([
                    'status' => 400,
                    'message' => 'No Billing Month Found.',
                ]);
            }
        
            $billingrate = BillingRate::where('billingrate_name', $billingMonth->billingrate_name)
                ->where('rate_case', $request->rate_case)
                ->where('classification', $request->classification)
                ->orderByDesc('id')
                ->first();
        
            if (!$billingrate) {
                return response()->json([
                    'status' => 400,
                    'message' => 'No matching Billing Rate found.',
                ]);
            }
        
            $previous_reading = 0;
        
            if ($last_encoder) {
                $previous_reading = $last_encoder->current_reading;
                if ($previous_reading > $request->current_reading) {
                    $volume = ($request->current_reading !== null) ? ($previous_reading - $request->current_reading) : 0;
                } else {
                    $volume = ($request->current_reading !== null) ? ($request->current_reading - $previous_reading) : 0;
                }
            } else {
                $volume = 0;
            }
        
            $amountBill = 0;
            $totalVolume = 0;
        
            if ($volume != 0) {
                if ($billingrate) {
                    switch (true) {
                        case $volume <= 5 || $volume == 0:
                            $totalVolume = $volume - $billingrate->minVol;
                            $amountBill = $totalVolume * $billingrate->increment + $billingrate->minAmount;
                            break;
                        default:
                            $totalVolume = $volume - $billingrate->minVol;
                            $amountBill = $totalVolume * $billingrate->increment + $billingrate->minAmount;
                            break;
                    }
                }
            } else {
                if ($billingrate) {
                    switch (true) {
                        case $volume <= 5 || $volume == 0:
                            $totalVolume = 0;
                            $amountBill = 0;
                            break;
                        default:
                            $totalVolume = 0;
                            $amountBill = 0;
                            break;
                    }
                }
            }
            $existingRecord = Encoder::where('account_id', $request->account_id)
                ->where('from_reading_date', $request->from_reading_date)
                ->orderByDesc('id')
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Date Reading and delivered already exists.',
                ]);
            }
            $newDate = new \DateTime($request->from_reading_date);
            $newMonthYear = $newDate->format('Y-m');

            $existingRecordsWithSameMonthYear = Encoder::where('account_id', $request->account_id)
                ->whereRaw("DATE_FORMAT(from_reading_date, '%Y-%m') = ?", [$newMonthYear])
                ->first();

            if ($existingRecordsWithSameMonthYear) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Date Reading and delivered with the same month and year already exists.',
                ]);
            }
            $current_Read = DB::table('encoders')->insert([
                'rate_case' => $request->rate_case,
                'classification' => $request->classification,
                'cluster' => $request->cluster,
                'customerName' => $request->customerName,
                'Reader' => $request->Reader,
                'account_id' => $request->account_id,
                'date_delivered' => $request->date_delivered,
                'from_reading_date' => $request->from_reading_date,
                'previous_reading' => $previous_reading,
                'current_reading' => $request->current_reading,
                'amount_bill' => $amountBill,
                'volume' => $volume,
            ]);
        
            if($request->current_reading != 0){
                AccountReceivable::create([
                    'account_id' => $request->account_id,
                    'account_type'=> 'Water Bill',
                    'balance' => $amountBill,
                    'date' => date('Y-m-d', strtotime($request->from_reading_date)),
                    'item_name'=> date('M Y', strtotime($request->from_reading_date))
                ]);
            }
        
        
            if($volume > 0){
                
                AccountReceivable::create([
                    'account_id' => $request->account_id,
                    'account_type'=> 'Watershed',
                    'balance' => $volume,
                    'date' => date('Y-m-d', strtotime($request->from_reading_date)),
                    'item_name'=> date('M Y', strtotime($request->from_reading_date))
                ]);
            }
            if ($current_Read) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully submit reading, you can now check it in the reading list',
                ]);
            }
        
        }
    
    
    
    
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        // public function store(Request $request, $account_id)
        // {
        //     $user = ConsumerInfo::where('account_id', $account_id)->first();
        //     $readerdata = DB::table('readers')->where('account_id', $account_id)->latest()->first();
        //     $retriveData = Encoder::where('account_id', $account_id)
        //         ->orderBy('to_reading_date', 'desc') 
        //         ->latest(); 
        //     return view('billing.encoder-readingInput', compact(['user', 'retriveData','readerdata']));
        // }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Encoder  $encoder
     * @return \Illuminate\Http\Response
     */
    public function show(Encoder $encoder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Encoder  $encoder
     * @return \Illuminate\Http\Response
     */
    public function edit(Encoder $encoder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Encoder  $encoder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encoder $encoder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Encoder  $encoder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encoder $encoder)
    {
        //
    }

}
