<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encoder;
use App\Models\WaterBilling;
use App\Models\ConsumerInfo;
use App\Models\BillingRate;
use App\Models\AccountReceivable;
use dataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReadingController extends Controller
{
   //reading for all view
   public function viewReading(Request $request){

    $consumerReadings = DB::table('encoders')
        ->select(
            'encoders.id',
            'encoders.account_id',
            'consumer_infos.customerName',
            'encoders.Reader',
            'consumer_infos.cluster',
            'encoders.current_reading',
            'encoders.previous_reading',
            'encoders.from_reading_date',
            'encoders.date_delivered',
            'encoders.amount_bill',
            'encoders.volume'
        )
        ->join('consumer_infos', 'consumer_infos.account_id', '=', 'encoders.account_id')
        ->where('consumer_infos.status', '<>', 2)
        ->get();


    if($request->ajax()){
        return datatables()->of($consumerReadings)->addIndexColumn()
            
        ->addColumn('action', function($consumerReadings){
            $userRole = Auth::user()->role;
            if($userRole == 3){
                $button = '
                <input type="hidden" id="emp_'.$consumerReadings->id.'" value="'.$consumerReadings->customerName.'" data-name="'.$consumerReadings->Reader.'" />
                
                <button type="button" name="edit" onclick="editReading('.$consumerReadings->id.')" class="action-button accept btn btn-success btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm;padding-left: 3mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-edit"></i>  <span class="action-text" style="font-size:12px">Edit</span></button>
                <button type="button" name="softDelete" onclick="confirmDeleteReading(' . $consumerReadings->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-trash-o"></i>  <span class="action-text" style="font-size:8px">Delete</span></button>
                ';
                return $button;
            }elseif($userRole == 1 || $userRole == 0) {
                $button = '
                <input type="hidden" id="emp_'.$consumerReadings->id.'" value="'.$consumerReadings->customerName.'" data-name="'.$consumerReadings->Reader.'" />
                
                <button type="button" name="edit" onclick="editReading('.$consumerReadings->id.')" class="action-button accept btn btn-success btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm;padding-left: 3mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-edit"></i>  <span class="action-text" style="font-size:12px">Edit</span></button>
                <button type="button" name="softDelete" onclick="confirmDeleteReading(' . $consumerReadings->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-trash-o"></i>  <span class="action-text" style="font-size:8px">Delete</span></button>
                ';
                return $button;
            }
            else {
          
                return $consumerReadings->current_reading !== null
                    ? '<span class="badge badge-success"><i class="fa fa-check-circle"></i></span>'
                    : '<span class="badge badge-danger"><i class="fa fa-close"></i></span>';
            }
        })
        ->make(true);
    }

    return view ('billing.reading');
}   
 
    public function editreading($id)
    {
        if(request()->ajax())
        {
            $data = Encoder::findOrFail($id);
           
            return response()->json(['result' => $data]);
        }
    }
    public function updateReading(Request $request)
    {
        $billingrate = DB::table('billing_rates')->where('rate_case', $request->rate_case)
            ->where('classification', $request->classification)
            ->orderByDesc('id')
            ->first();
         
        $volume = 0;
        if($request->previous_reading > $request->current_reading){
            $volume = $request->previous_reading - $request->current_reading;
        }
        else{
            $volume = $request->current_reading - $request->previous_reading;
        }
      
        $amountBill = 0;
        $totalVolume = 0;

        if ($volume == 0) {
         
            if ($billingrate) { 
                   
                if ($volume <= 5 || $volume == 0 ) {
                    $totalVolume = $volume - $billingrate->minVol;
                    $amountBill = $totalVolume * $billingrate->increment + $billingrate->minAmount;
                
                } else {
                
                    $totalVolume = $volume - $billingrate->minVol;
                    $amountBill = $totalVolume * $billingrate->increment + $billingrate->minAmount;
                }
            }
        }else{
            if ($billingrate) { 
      
                if ($volume <= 5 || $volume == 0 ) {        
                    $totalVolume = $volume - $billingrate->minVol;
                    $amountBill = $totalVolume * $billingrate->increment + $billingrate->minAmount;
                } else {
                    $totalVolume = $volume - $billingrate->minVol;
                    $amountBill = $totalVolume * $billingrate->increment + $billingrate->minAmount;
                }
            }
        }
        $Readingform = DB::table('encoders')->where('id', $request->id)->update([
            'from_reading_date'=>$request->from_reading_date,
            'date_delivered'=>$request->date_delivered,
         
            'current_reading' => $request->current_reading,
            'amount_bill' => $amountBill,
            'volume' => $volume,
        ]);
        if($request->current_reading != 0){
            AccountReceivable::where('id', $request->id)->update([
               
                'account_type'=> 'Water Bill',
                'balance' => $amountBill,
                'date' => date('Y-m-d', strtotime($request->from_reading_date)),
                'item_name'=> date('M Y', strtotime($request->from_reading_date))
            ]);
        }
      
      
        if($volume > 0){
            
            AccountReceivable::where('id', $request->id)->update([
                
                'account_type'=> 'Watershed',
                'balance' => $volume,
                'date' => date('Y-m-d', strtotime($request->from_reading_date)),
                'item_name'=> date('M Y', strtotime($request->from_reading_date))
            ]);
        }if ($request->current_reading != 0) {
            AccountReceivable::where('account_id', $request->account_id)
                ->where('item_name', date('M Y', strtotime($request->from_reading_date)))
                ->where('account_type', 'Water Bill')
                ->update([
                    'balance' => $amountBill,
                    'date' => date('Y-m-d', strtotime($request->from_reading_date)),
                ]);
        }
        
        if ($volume > 0) {
            AccountReceivable::where('account_id', $request->account_id)
                ->where('item_name', date('M Y', strtotime($request->from_reading_date)))
                ->where('account_type', 'Watershed')
                ->update([
                    'balance' => $volume,
                    'date' => date('Y-m-d', strtotime($request->from_reading_date)),
                ]);
        }
        
       
        return response()->json([
            'status'=> 200,
            'message'=>'Success Update Info!!'
        ]);

    }
    public function delete($id)
    {
        return view('confirm-delete', ['id' => $id]);
    }

    public function readingDelete($id){
        try {
            $reading = Encoder::findOrFail($id);
            $reading->delete();
            return response()->json(['message' => 'Reading deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Reading not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the Reading'], 500);
        }
    }
}
