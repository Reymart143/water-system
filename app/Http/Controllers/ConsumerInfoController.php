<?php

namespace App\Http\Controllers;

use App\Models\ConsumerInfo;
use Illuminate\Http\Request;
use App\Models\AccountReceivable;
use App\Models\BillingMonth;
use App\Models\PenaltyRate;
use DB;
use dataTables;
use Carbon\Carbon;
class ConsumerInfoController extends Controller
{
  
    public function create(Request $request)
    {

        $customerform = DB::table('consumer_infos')->insert([
            'account_id'      => $this->getAccountNum(),
            // 'account_id' => $request->account_id,
            'customerName'    => $request->customerName,
            'connectionDate'  => $request->connectionDate,
            'rate_case'       => $request->rate_case,
            'classification'  => $request->classification,
            'cluster'         => $request->cluster,
            'consumerName2'   => $request->consumerName2,
            'trade1'          => $request->trade1,
            'concessionerName'=>$request->concessionerName,
            'trade2'          => $request->trade2,
            'meter'           => $request->meter,
            'region'          => $request->region,
            'municipality'    => $request->municipality,
            'barangay'        => $request->barangay,
            'purok'           => $request->purok,
            'Province'        => $request->Province,
        ]);
         return response()->json([
            'status'=>200,
            'message'=> 'Successfully Registered as customer',
         ]);
    }
    private function getAccountNum()
    {
        do {
          
            $lastAccountId      = DB::table('consumer_infos')->pluck('account_id')->last();  
            $lastYearPart       = substr($lastAccountId, 0, 4);
            $lastIncrementPart  = (int)substr($lastAccountId, -2);
            $currentYear        = date('Y');
            $newIncrementPart   = ($currentYear == $lastYearPart) ? $lastIncrementPart + 1 : 1;
            $newAccountId       = $currentYear . str_pad($newIncrementPart, 2, 0, STR_PAD_LEFT);
            $exists             = DB::table('consumer_infos')->where('account_id', $newAccountId)->exists();
        } while ($exists);
    
        return $newAccountId;
    }
    
 
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $superAdminDatacustomer = DB::table('consumer_infos')
                ->orderBy('consumer_infos.customerName', 'asc')
                ->select('id', 'account_id', 'customerName', 'connectionDate','updatestatusDate', 'rate_case', 'classification', 'cluster', 'consumerName2', 'trade1', 'trade2', 'concessionerName', 'meter', 'status',
                    DB::raw("CONCAT(region, ', ', province, ', ', municipality, ', ', barangay, ', ', purok) AS location"), 
                    'Province')
                ->get();
    
            return datatables()->of($superAdminDatacustomer)->addIndexColumn()
                ->addColumn('action', function ($superAdminDatacustomer) {
                    $button = '
                        <input type="hidden" id="account_' . $superAdminDatacustomer->id . '" value="' . $superAdminDatacustomer->customerName . '" data-name="' . $superAdminDatacustomer->consumerName2 . '" />
                        <button type="button" name="view" onclick="viewSuperAdmincustomer(' . $superAdminDatacustomer->id . ')" class="action-button view btn btn-primary btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                            <i class="fa fa-eye" ></i>
                            <span class="action-text" style="font-size:10px">View</span>
                        </button>
                        <button type="button" name="edit" onclick="editSuperAdmincustomer(' . $superAdminDatacustomer->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                            <i class="fa fa-edit" ></i>
                            <span class="action-text" style="font-size:10px">Edit</span>
                        </button>
                        <button type="button" name="softDelete" onclick="superadminDeletecustomer(' . $superAdminDatacustomer->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
                            <i class="fa fa-trash-o"></i>
                            <span class="action-text" style="font-size:10px">Delete</span>
                        </button>
                    ';


                    return $button;
                })
                ->make(true);
        }
        
        return view('billing.customer');
    }
    public function getCustomerInfo($id) {
        
        $customerInfo = DB::table('consumer_infos')->where('id', $id)->first();
       
        return response()->json($customerInfo);
    }
    public function edit($id)
        {
           
            if(request()->ajax())
            {
                $data = ConsumerInfo::findOrFail($id);
                return response()->json(['result' => $data]);
            }
        }
        public function update(Request $request)
        {
    
            $customerform = DB::table('consumer_infos')->where('id', $request->id)->update([
                'account_id' => $request->account_id,
                'customerName' => $request->customerName,
                'connectionDate' => $request->connectionDate,
                'rate_case' => $request->rate_case,
                'classification' => $request->classification,
                'cluster' => $request->cluster,
                'consumerName2' => $request->consumerName2,
                'trade1' => $request->trade1,
                'trade2' => $request->trade2,
                'concessionerName' => $request->concessionerName,
                'meter' => $request->meter,
                'region' => $request->region,
                'municipality' => $request->municipality,
                'barangay' => $request->barangay,
                'purok' => $request->purok,
                'Province' => $request->Province,
                'status' => $request->status,
              
                'updatestatusDate' => $request->updatestatusDate
            ]);
           
            return response()->json([
                'status'=> 200,
                'message'=>'Success Update Info!!'
            ]);
    
        }
        public function delete($id)
        {
            return view('confirm-delete', ['id' => $id]);
        }
        public function customerdeleteInSuperadmin($id){
            try {
                $user = ConsumerInfo::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'Customer deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'User not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the user'], 500);
            }
        }
       //Disconnection notice for consumer 
    //    public function disconnectionForm(Request $request) {
    //         $water_bills = DB::table('account_receivables')
    //         ->select(
    //             'account_receivables.account_id',
    //             'account_receivables.item_name',
    //             'account_receivables.balance',
    //             'consumer_infos.customerName',
    //             DB::raw("CONCAT(region, ', ', province, ', ', municipality, ', ', barangay, ', ', purok) AS location"),
    //             'Province')
    //         ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'account_receivables.account_id')
    //         ->where('account_type', 'Water Bill')
    //         ->where('isPaid', 0)
    //         ->where('balance', '>', 0)
    //         ->get();
            
    //         $disconnectionNotices = [];
            
    //         foreach ($water_bills as $water_bill) {
    //             $customerName = $water_bill->customerName;
    //             $location = $water_bill->location;
    //             $account_id = $water_bill->account_id;
    //             $item_name = $water_bill->item_name;
    //             $water_bill_balance = $water_bill->balance;
            
    //             $penalty = DB::table('account_receivables')
    //                 ->where('account_type', 'Penalty')
    //                 ->where('item_name', $item_name)
    //                 ->where('isPaid', 0)
    //                 ->where('balance', '>', 0)
    //                 ->first();
            
    //             if ($penalty) {
    //                 $surcharge = $penalty->balance;
            
    //                 $watershed = DB::table('account_receivables')
    //                     ->where('account_type', 'Watershed')
    //                     ->where('item_name', $item_name)
    //                     ->where('isPaid', 0)
    //                     ->where('balance', '>', 0)
    //                     ->first();
            
    //                 $watershed_balance = $watershed ? $watershed->balance : 0;
            
    //                 $total = $water_bill_balance + $surcharge + $watershed_balance;
            
    //                 $disconnectionNotices[] = [
    //                     'customerName' => $customerName,
    //                     'location' => $location,
    //                     'account_id' => $account_id,
    //                     'month_delinquent' => $item_name,
    //                     'water_rental' => number_format($water_bill_balance, 2),
    //                     'surcharge' => number_format($surcharge, 2),
    //                     'watershed' => number_format($watershed_balance, 2),
    //                     'total' => number_format($total, 2),
    //                 ];
    //             }
    //         }
           
    //     return view('billing.disconnection-notice',compact('disconnectionNotices'));
    // }
    public function disconnectionForm(Request $request) {
     
        
        return view('billing.disconnection-notice');
    }
        public function filterDisconnectionNotices(Request $request) {

            $asof_date = $request->input('asof_date');
            $selectedCluster = $request->input('cluster_selected');
            $selectedCustomer = $request->input('customer_selected');
            $status = 2;
            
            $disconnectionNotices = [];
            $water_bills = DB::table('account_receivables')
                ->select(
                    'account_receivables.account_id',
                    'account_receivables.item_name',
                    'account_receivables.balance',
                    'account_receivables.date',
                    'consumer_infos.customerName',
                    'consumer_infos.cluster',
                
                    DB::raw("CONCAT(purok, ', ', barangay, ', ', municipality) AS location"),
                    'Province'
                )
                ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'account_receivables.account_id')
                
                ->where('account_type', 'Water Bill')
                ->whereNot('status', $status)
                ->where('isPaid', 0)
                ->where('balance', '>', 0);
        
            if (!empty($selectedCluster) && $selectedCluster !== 'All') {
                $water_bills->where('consumer_infos.cluster', $selectedCluster);
            }
        
            if (!empty($selectedCustomer) && $selectedCustomer !== 'All') {
                $water_bills->where('consumer_infos.customerName', $selectedCustomer);
            }
            
            $water_bills = $water_bills->get();
    
        
            $grand_water_bill = 0; 
            $grand_surcharge = 0;
        
            $grand_watershed = 0;
            $grand_total = 0;
        
            foreach ($water_bills as $water_bill) {
            
            
                $cluster = $water_bill->cluster;
                $customerName = $water_bill->customerName;
                
                $location = $water_bill->location;
                $account_id = $water_bill->account_id;
                $item_name = $water_bill->item_name;

                $water_bill_balance = $water_bill->balance;
                
                $penalty = DB::table('account_receivables')
                ->select(
                    'account_receivables.account_id',
                    'account_receivables.item_name',
                    'account_receivables.balance',
                    'account_receivables.date',
                    'consumer_infos.customerName',
                    'consumer_infos.cluster'
                )
                ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'account_receivables.account_id')
                
                ->where('account_receivables.account_type', 'Penalty')
                ->where('account_receivables.item_name', $item_name)
                ->where('account_receivables.account_id', $account_id)
                ->where('account_receivables.isPaid', 0)
                ->where('account_receivables.balance', '>', 0)
                ->first();
            
        
                if ($penalty) {
                    
                    $penaltyDate = Carbon::parse($penalty->date);
                    $asofDate = Carbon::parse($asof_date);
                    
                    $daysDifference = 0;
                
                    while ($penaltyDate->lessThan($asofDate)) {
                        if ($penaltyDate->dayOfWeek !== Carbon::SATURDAY && $penaltyDate->dayOfWeek !== Carbon::SUNDAY) {
                            $daysDifference++;
                        }
                        $penaltyDate->addDay();
                    }
                    
                    if ($daysDifference > 2) {
                            $surcharge = $penalty->balance;
                        
        
                            $watershed = DB::table('account_receivables')
                            ->select(
                                'account_receivables.account_id',
                                'account_receivables.item_name',
                                'account_receivables.balance',
                                'account_receivables.date',
                                'consumer_infos.customerName',
                                'consumer_infos.cluster'
                            )
                            ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'account_receivables.account_id')
                            ->where('account_receivables.account_type', 'Watershed')
                            ->where('account_receivables.item_name', $item_name)
                            ->where('account_receivables.account_id', $account_id)
                            ->where('account_receivables.isPaid', 0)
                            ->where('account_receivables.balance', '>', 0)
                            ->first();
        
                        $watershed_balance = $watershed ? $watershed->balance : 0;
                    
                    
                        $total = $water_bill_balance + $surcharge + $watershed_balance;

                        $grand_water_bill += $water_bill_balance;
                        $grand_surcharge += $surcharge;
                        $grand_watershed += $watershed_balance;
                        $grand_total += $total;
                    
                        $userKey = $account_id;
                        $asofdate = $asof_date;
                        
                        if (!isset($disconnectionNotices[$userKey])) {
                    
                            $disconnectionNotices[$userKey] = [
                            
                                'cluster' => $cluster,
                                'customerName' => $customerName,
                                'location' => $location,
                                'account_id' => $account_id,
                                'water_bills' => [],
                            
                            ];
                        }
                        
                        $disconnectionNotices[$userKey]['water_bills'][] = [
                            'month_delinquent' => $item_name,
                            'water_rental' => number_format($water_bill_balance, 2),
                            'surcharge' => number_format($surcharge, 2),
                            'watershed' => number_format($watershed_balance, 2),
                            'total' => number_format($total, 2),
                        ];
                        
                    }
                    // else{
                    //     return response()->json([
                    //         'status' => 500,
                    //         'message' => 'No notice of disconnection in this cluster'
                    //     ]);
                    // }
                
                }else{
                    $currentDate = Carbon::now()->format('Y-m-d');
            
                    $waterbill = DB::table('account_receivables')
                        ->select('id', 'account_type', 'item_name', 'balance', 'date')
                        ->where('balance', '!=', 0)
                        ->where('account_id', $account_id)
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
                    if ($penalty) {
                
                        $penaltyDate = Carbon::parse($penalty->date);
                        $asofDate = Carbon::parse($asof_date);
                        
                        $daysDifference = 0;
                    
                        while ($penaltyDate->lessThan($asofDate)) {
                            if ($penaltyDate->dayOfWeek !== Carbon::SATURDAY && $penaltyDate->dayOfWeek !== Carbon::SUNDAY) {
                                $daysDifference++;
                            }
                            $penaltyDate->addDay();
                        }
                        
                        if ($daysDifference > 2) {
                                $surcharge = $penalty->balance;
                            
            
                                $watershed = DB::table('account_receivables')
                                ->select(
                                    'account_receivables.account_id',
                                    'account_receivables.item_name',
                                    'account_receivables.balance',
                                    'account_receivables.date',
                                    'consumer_infos.customerName',
                                    'consumer_infos.cluster'
                                )
                                ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'account_receivables.account_id')
                                ->where('account_receivables.account_type', 'Watershed')
                                ->where('account_receivables.item_name', $item_name)
                                ->where('account_receivables.account_id', $account_id)
                                ->where('account_receivables.isPaid', 0)
                                ->where('account_receivables.balance', '>', 0)
                                ->first();
            
                            $watershed_balance = $watershed ? $watershed->balance : 0;
                        
                        
                            $total = $water_bill_balance + $surcharge + $watershed_balance;
        
                            $grand_water_bill += $water_bill_balance;
                            $grand_surcharge += $surcharge;
                            $grand_watershed += $watershed_balance;
                            $grand_total += $total;
                        
                            $userKey = $account_id;
                            $asofdate = $asof_date;
                            
                            if (!isset($disconnectionNotices[$userKey])) {
                        
                                $disconnectionNotices[$userKey] = [
                                
                                    'cluster' => $cluster,
                                    'customerName' => $customerName,
                                    'location' => $location,
                                    'account_id' => $account_id,
                                    'water_bills' => [],
                                
                                ];
                            }
                            
                            $disconnectionNotices[$userKey]['water_bills'][] = [
                                'month_delinquent' => $item_name,
                                'water_rental' => number_format($water_bill_balance, 2),
                                'surcharge' => number_format($surcharge, 2),
                                'watershed' => number_format($watershed_balance, 2),
                                'total' => number_format($total, 2),
                            ];
                            
                        }
                        // else{
                        //     return response()->json([
                        //         'status' => 500,
                        //         'message' => 'No notice of disconnection in this cluster'
                        //     ]);
                        // }
                    
                    }
                }
            
            }

        if($disconnectionNotices){
            return view('billing.disconnection-list', compact('disconnectionNotices', 'grand_water_bill','grand_surcharge','grand_watershed','grand_total','asofdate'));
        }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => 'No Notice of Disconnection!'
                ]);
            }
        }
    
}
