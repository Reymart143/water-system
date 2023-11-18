<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountReceivable;
use App\Models\TreasurerReceipt;
use App\Models\ConsumerLedger;
use App\Models\BillingMonth;
use App\Models\DiscountRate;
use App\Models\PenaltyRate;
use App\Models\ConsumerInfo;
use DB;
use Carbon\Carbon; 

class TreasurerReceiptController extends Controller
{
  
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $billingReceiptTreasuer = DB::table('consumer_infos')
            ->whereIn('consumer_infos.status', [0, 1])
            ->whereNot('status',2)
            ->get();
    
                return datatables()->of($billingReceiptTreasuer)->addIndexColumn()
                ->addColumn('action', function ($billingReceiptTreasuer) {
                  
                    $url = route('collection.treasureMakeReceipt', ['account_id' => $billingReceiptTreasuer->account_id]);
                    $button = '
                        <a href="' . $url . '" class="action-button view btn btn-success btn-sm fetch-details-receipt" style="margin-left:13px;padding-top: 1mm; padding-bottom: 1mm; padding-left: 3mm; padding-right: 3mm; font-size: 9px;">
                            <i class="fa-solid fa-file-invoice-dollar fa-2x"></i>
                            <span class="action-text" style="font-size:8px">Receipt</span>
                        </a>
                    ';
    
                    return $button;
                })
                ->make(true);
        }
        
        return view('collection.treasurer-receipt');
    }
    public function makeReceipt(Request $request,$account_id)
        {
           
            $user = DB::table('consumer_infos')
                ->select('customerName', 'account_id', 'rate_case')
                ->where('account_id', $account_id)
                ->whereNot('status',2)
                ->first();

            return view('collection.treasureMakeReceipt', compact('user'));
        }
        public function alreadyInReceipt(Request $request) {
            if ($request->ajax()) {
                $account_id = $request->input('account_id');
    
                    $waterbill = DB::table('account_receivables')
                    ->select('id', 'account_type', 'item_name', 'balance', 'date')
                    ->where('balance', '!=', 0)
                    ->where('account_id', $request->account_id)
                    ->where('isPaid', 2)
                    ->get();
    
                return datatables()->of($waterbill)->addIndexColumn()
                    ->addColumn('action', function ($waterbill) {
                        if($waterbill->account_type != 'Discount'){
                           $button = '
                        <input type="hidden" id="account_' . $waterbill->id . '" value="' . $waterbill->account_type . '" data-name="' . $waterbill->item_name . '" />
                        <button type="button" name="undo" onclick="backToReceivable(' . $waterbill->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
                            <i class="fa fa-undo"></i>
                            <span class="action-text" style="font-size:10px">Cancel</span>
                        </button>
                       
                    ';  
                        }else{
                            $button = '
                            <input type="hidden" id="account_' . $waterbill->id . '" value="' . $waterbill->account_type . '" data-name="' . $waterbill->item_name . '" />
                            <button type="button" name="softDelete" onclick="Delete(' . $waterbill->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
                            <i class="fa fa-trash-o"></i>
                            <span class="action-text" style="font-size:10px">Delete</span>
                        </button>
                        ';  
                        }
                       


                    return $button;
                    })
                    ->make(true);
            }
            return view('collection.treasureMakeReceipt');
        }
        public function updateToReceivable(Request $request) {
            $id = $request->input('id');
        
      
            DB::table('account_receivables')->where('id', $id)->update(['isPaid' => 0]);
        
            return response()->json(['message' => 'Status updated successfully']);
        }
      public function receivable(Request $request) {
        if ($request->ajax()) {
            $account_id = $request->input('account_id');

            $receivables = DB::table('account_receivables')
                ->select('id', 'account_type', 'item_name', 'balance', 'date')
                ->where('balance', '!=', 0)
                ->where('account_id', $request->account_id)
                ->where('isPaid',0) 
                ->get();

            return datatables()->of($receivables)->addIndexColumn()
                ->addColumn('action', function ($receivables) {
                    $checkbox = '
                        <input type="checkbox" style="width:30px;height:20px;" name="selected_items[]" value="' . $receivables->id . '" data-account-type="' . $receivables->account_type . '" data-item-name="' . $receivables->item_name . '">
                    
                    ';
                    return $checkbox;
                })
                ->make(true);
        }
        return view('collection.treasureMakeReceipt');
    }

        
        public function makePenalty($account_id)
        {
           
          
            $user = DB::table('consumer_infos')
                ->select('customerName', 'account_id', 'rate_case')
                ->whereNot('status',2)
                ->where('account_id',$account_id)
                ->first();
        
            $currentDate = Carbon::now()->format('Y-m-d');
        
            $waterbill = DB::table('account_receivables')
                ->select('id', 'account_type', 'item_name', 'balance', 'date')
                ->where('balance', '!=', 0)
                ->where('account_id', $user->account_id)
                ->whereNot('isPaid', 1)
                ->get();
        
            
            $PenaltyRate = null;

            $billingMonth = BillingMonth::where('status_bill_month', 1)->first();
        
            if ($billingMonth && $billingMonth->status_bill_month == 1) {
                $PenaltyRate = PenaltyRate::where('penalty_name', $billingMonth->penalty_name)
                    ->select('penalty_days', 'penalty_percent')
                    ->orderByDesc('id')
                    ->first();
            }
        
           
            $holidays = DB::table('holidays')->pluck('holiday_date');
        
            foreach ($waterbill as $selectedItem) {
                if ($selectedItem->account_type == 'Water Bill') {
                  
                    if ($PenaltyRate !== null) {
                        $PenaltyDays = $PenaltyRate->penalty_days;
                        $originalDate = Carbon::createFromFormat('Y-m-d', $selectedItem->date);
        
                      
                        $PenaltyDate = $originalDate->copy();
                        $skipCount = 0;
                        while ($skipCount < $PenaltyDays) {
                            $PenaltyDate->addDay();
                            if ($PenaltyDate->isWeekend() || in_array($PenaltyDate->format('Y-m-d'), $holidays->toArray())) {
                                continue;
                            }
                            $skipCount++;
                        }
        
                        $PenaltyDate = $PenaltyDate->format('Y-m-d');
                        $isPenalty = $currentDate >= $PenaltyDate;
        
                        $existingPenalty = AccountReceivable::where('account_id', $account_id)
                            ->where('account_type', 'Penalty')
                            ->where('item_name', $selectedItem->item_name)
                            ->where('date', $PenaltyDate)
                            ->first();
        
                        if ($isPenalty && !$existingPenalty) {
                            $balance = $selectedItem->balance;
                            $PenaltyPercent = $PenaltyRate->penalty_percent / 100;
                            $TotalPenalty = number_format(($balance * $PenaltyPercent), 2);
        
                            AccountReceivable::create([
                                'account_id' => $account_id,
                                'account_type' => 'Penalty',
                                'item_name' => $selectedItem->item_name,
                                'balance' => sprintf("%.2f", $TotalPenalty), 
                                'date' => $PenaltyDate
                            ]);
                        }
                    }
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Penalty checking updates'
            ]);
        }
        public function AddedToReceipt(Request $request) {
            
            $selectedItems = $request->input('selectedItems');
            foreach ($selectedItems as $itemId) {
                $selectedItem = AccountReceivable::find($itemId);
              
                if ($selectedItem) {


                    if ($selectedItem->account_type != 'Watershed') {
                        $billingMonth = BillingMonth::where('status_bill_month', 1)->first();
        
                        if ($billingMonth && $billingMonth->status_bill_month == 1) {
                            $DiscountRate = DiscountRate::where('discount_name', $billingMonth->discount_name)
                                ->select('discount_days', 'discount_percent')
                                ->orderByDesc('id')
                                ->first();
        
                       
                        }
                    
                        $ReceiptDate = $request->receiptcurrentDate;
                        $DiscountDays = $DiscountRate->discount_days;
                        $ReceiptDate = $request->receiptcurrentDate; 
                        $DiscountDate = date('Y-m-d', strtotime($selectedItem->date . ' + ' . $DiscountDays . ' days'));
                       
                        $isDiscount = $ReceiptDate <= $DiscountDate;
                      
                        if ($isDiscount) {
                            
                            if ($selectedItem->account_type != 'Penalty') {
                               
                                $balance = $selectedItem->balance;
                                $DiscountPercent = $DiscountRate->discount_percent / 100;
                                $TotalDiscounted = number_format(($balance * $DiscountPercent), 2);
                               
                                $current_date = date('Y-m-d');
                                AccountReceivable::create([
                                    'account_id' => $request->account_id,
                                    'date' => $current_date,
                                    'account_type' => 'Discount',
                                    'item_name' => $selectedItem->item_name,
                                    'balance' => $TotalDiscounted,
                                    'isPaid' => 2,
                                ]);
                                
                            }
                        }
                    }
                }
            }
       
            AccountReceivable::whereIn('id', $selectedItems)->update(['isPaid' => 2]);
            
            return response()->json(['message' => 'Billing added to receipt successfully']); 
        }
        
    
        // public function createReceipt(Request $request)
        // {
        //     $receipt = new TreasurerReceipt();
        //     $receipt->fill($request->all());
        //     $receipt->save();
        
        //     $selectedItems = $request->input('selected_items', []);
        
          
        //     $calculateBalanceDiscount = 0;
        //     $isDiscount = false; 
          
          
        //     foreach ($selectedItems as $itemId) {
        //         $selectedItem = AccountReceivable::find($itemId);
              
        //         if ($selectedItem) {
                   
        //             $particular = $selectedItem->account_type . ' - ' . $selectedItem->item_name;
        
        
        //             ConsumerLedger::create([
        //                 'account_id' => $request->account_id,
        //                 'customerName' => $request->customerName,
        //                 'particular' => $particular,
        //                 'issuance' => $selectedItem->balance,
        //                 'transact_date' =>  $selectedItem->date,
        //             ]);
        
        //             $selectedItem->update(['isPaid' => 1]);
        
                   
        //         }
        //     }

        //         ConsumerLedger::create([
        //             'account_id' => $request->account_id,
        //             'customerName' => $request->customerName,
        //             'or_no' => $request->or_number,
        //             'collection' => $request->collection_bill,
        //             'transact_date' => $request->receiptcurrentDate,
        //         ]);
        
        //     return response()->json(['success' => true, 'message' => 'Receipt created successfully']);
        // }
        
        public function createReceipt(Request $request)
        {
            
            $receipt = new TreasurerReceipt();
            $receipt->receiptID = $this->getRecNo(); 
           
            $receipt->fill($request->all());
            $receipt->save();
            

            $selectedData = $request->input('selected_data', []);
           
            foreach ($selectedData as $data) {
             
       
                    $transactDate = date('Y-m-d', strtotime($data['date']));

                    ConsumerLedger::create([
                        'account_id'    => $request->account_id,
                        'customerName'  => $request->customerName,
                        'particular'    => $data['account_type'] . ' - ' . $data['item_name'],
                        'issuance'      => $data['balance'],
                        'transact_date' => $transactDate,
                    ]);

      
                    AccountReceivable::where([
                        'account_type' => $data['account_type'],
                        'item_name'    => $data['item_name'],
                    ])->where('account_id',$request->account_id)->update(['isPaid' => 1]);
                }
                ConsumerLedger::create([
                    'account_id'    => $request->account_id,
                    'customerName'  => $request->customerName,
                    'or_no'         => $request->or_number,
                    'collection'    => $request->collection_bill,
                    'transact_date' => $request->receiptcurrentDate,
                ]);
            return response()->json(['success' => true, 'message' => 'Receipt created successfully']);
        }
        
        private function getRecNo()
        {
           
            $lastReceiptID     = DB::table('treasurer_receipts')->pluck('receiptID')->last();
            $lastIncrementPart = preg_replace('/[^0-9]/', '', $lastReceiptID);       
            $newIncrementPart  = $lastIncrementPart + 1;     
            $newreceiptID      = str_pad($newIncrementPart, 2, '0', STR_PAD_LEFT);
        
            return $newreceiptID;
        }
      
        
            public function AbstractReceipt(Request $request) {
                if ($request->ajax()) {
                    $status = 2;
                    $accountReceivable = DB::table('treasurer_receipts')
                        ->select(
                            'consumer_infos.cluster',
                            'treasurer_receipts.id',
                            'treasurer_receipts.or_number',
                            'treasurer_receipts.receiptcurrentDate',
                            'treasurer_receipts.Total_Amount_Water_bill',
                            'treasurer_receipts.customerName',
                            'treasurer_receipts.collector',
                            'treasurer_receipts.stub_no',
                            'treasurer_receipts.receiptID'
                        )
                        ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'treasurer_receipts.account_id')
                        ->whereNot('status',$status)
                        ->get();
                    
                    return datatables()->of($accountReceivable)->addIndexColumn()->make(true);
                }
                return view('collection.receipt');
            }
            public function abstractCollection(Request $request)
            {
                if ($request->ajax()) {
                    $accountReceivable = ConsumerLedger::select(
                        'consumer_ledgers.or_no', 
                        'consumer_ledgers.collection',
                        'consumer_ledgers.transact_date',
                        'consumer_ledgers.customerName',
                        DB::raw('MAX(treasurer_receipts.collector) as collector'),
                        DB::raw('MAX(treasurer_receipts.stub_no) as stub_no')
                    )
                    ->whereNotNull('consumer_ledgers.or_no')
                    ->whereNotNull('consumer_ledgers.collection')
                    ->leftJoin('treasurer_receipts', 'consumer_ledgers.account_id', '=', 'treasurer_receipts.account_id')
                    ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'consumer_ledgers.account_id')
                    ->where('consumer_infos.status', '<>', 2)
                    ->groupBy('consumer_ledgers.or_no', 'consumer_ledgers.collection', 'consumer_ledgers.transact_date', 'consumer_ledgers.customerName')
                    ->get();
            
                    return datatables()->of($accountReceivable)->addIndexColumn()->make(true);
                }
            
                return view('collection.AbstractCollection');
            }
            
            
            
            
}   
