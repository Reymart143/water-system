<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\ConsumerInfo;
use App\Models\BillingMonth;
use App\Models\PenaltyRate;
use App\Models\Encoder;
use App\Models\AccountReceivable;

class BillingStatementController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $billingStatement = DB::table('consumer_infos')
            ->select(
                'consumer_infos.meter',
                'consumer_infos.id', 
                'consumer_infos.account_id', 
                'consumer_infos.customerName', 
                'consumer_infos.rate_case', 
                'consumer_infos.classification', 
                'consumer_infos.cluster',
                DB::raw("CONCAT(consumer_infos.purok, ', ', consumer_infos.barangay, ', ', consumer_infos.municipality) AS location"),
                'consumer_infos.Province',
                'encoders.from_reading_date',
            )
            ->leftJoin('encoders', 'consumer_infos.account_id', '=', 'encoders.account_id')
            ->whereIn('consumer_infos.status', [0, 1])
            ->get();
    
            return datatables()->of($billingStatement)->addIndexColumn()
                ->addColumn('action', function ($billingStatement) {
                    $button = '
                        <input type="hidden" id="account_' . $billingStatement->id . '" value="' . $billingStatement->customerName . '" data-name="' . $billingStatement->rate_case . '" />
                        <button type="button" name="view" onclick="viewBillingStatement(' . $billingStatement->id . ')" class="action-button view btn btn-primary btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                            <i class="fa fa-eye"></i>
                            <span class="action-text" style="font-size:10px">View</span>
                        </button>
                    ';
    
                    return $button;
                })
                ->make(true);
        }
        return view('billing.billing-statement');
    }
    
    public function viewBillingStatement($id, Request $request)
        {
            $selectedMonthYear = $request->input('monthYear');

        
            $billingStatement = ConsumerInfo::select(
                'consumer_infos.id', 
                'consumer_infos.account_id', 
                'consumer_infos.customerName', 
                'consumer_infos.rate_case', 
                'consumer_infos.classification', 
                'consumer_infos.cluster',
                'consumer_infos.meter',
                'encoders.volume',
                'encoders.amount_bill',
                'encoders.previous_reading',
                'encoders.current_reading',
                'encoders.from_reading_date',
                'encoders.date_delivered',
                'encoders.Reader',
                DB::raw("CONCAT(consumer_infos.purok, ', ', consumer_infos.barangay, ', ', consumer_infos.municipality) AS location"),
            )->leftJoin('encoders', function ($join) use ($selectedMonthYear) {
                $join->on('consumer_infos.account_id', '=', 'encoders.account_id')
                    ->whereRaw('encoders.from_reading_date = (SELECT MAX(from_reading_date) FROM encoders WHERE encoders.account_id = consumer_infos.account_id AND DATE_FORMAT(encoders.from_reading_date, "%Y-%m") = ?)', [$selectedMonthYear]);
            })->find($id);
            $previous_reading = Encoder::where('current_reading' , $billingStatement->previous_reading)->where('account_id', $billingStatement->account_id)->select('from_reading_date as previous_from_reading_date')->first();
            $billingMonth = BillingMonth::where('status_bill_month', 1)
            ->first();
                    
            if ($billingMonth && $billingMonth->status_bill_month == 1) {
                
                $penaltyRate = PenaltyRate::where('penalty_name', $billingMonth->penalty_name)
                    ->orderByDesc('id')
                    ->first();

                if ($penaltyRate) {
                    $penaltyDays = $penaltyRate->penalty_days;
                    $dateDelivered = new \DateTime($billingStatement->date_delivered);
                    
                    
                    $dueDate = $dateDelivered->modify("+$penaltyDays days");
                    
                    
                    $formattedDueDate = $dueDate->format("Y-m-d");

                    
                    $billingStatement->due_date = $formattedDueDate;
                }
            }
      
                $waterBillArrears = number_format(
                    AccountReceivable::where('account_type', 'Water Bill')
                        ->where('account_id', $billingStatement->account_id)
                        ->where('isPaid', 0)
                        ->sum('balance'),
                    2 
                );

               
                $watershedArrears = number_format(
                    AccountReceivable::where('account_type', 'Watershed')
                        ->where('account_id', $billingStatement->account_id)
                        ->where('isPaid', 0)
                        ->sum('balance'),
                    2 
                );
                $Surcharge = number_format(
                    AccountReceivable::where('account_type', 'Penalty')
                        ->where('account_id', $billingStatement->account_id)
                        ->where('isPaid', 0)
                        ->sum('balance'),
                    2 
                );
                $Discount = number_format(
                    AccountReceivable::where('account_type', 'Discount')
                        ->where('account_id', $billingStatement->account_id)
                        
                        ->sum('balance'),
                    2 
                );
                $billingStatement->water_bill_arrears = $waterBillArrears;
                $billingStatement->watershed_arrears = $watershedArrears;
                $billingStatement->surcharge_arrears = $Surcharge;
                $billingStatement->discount_arrears = $Discount;
            return response()->json([
                'billingStatement'=>$billingStatement,
                'previous_reading'=>$previous_reading
            ]);
        }

}
