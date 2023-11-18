<?php

namespace App\Http\Controllers;

use App\Models\BillingMonth;
use Illuminate\Http\Request;
use DB;

class BillingMonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $bill_month = DB::table('billing_months')->insert([
            'billingmonth_date' =>$request->billingmonth_date,
            'billingrate_name' =>$request->billingrate_name,
            'penalty_name'=>$request->penalty_name,
            'discount_name' =>$request->discount_name,
            // 'trustfund_name' =>$request->trustfund_name,
            'status_bill_month' =>$request->status_bill_month 
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $billingmonthview = DB::table('billing_months')->select('id', 'billingrate_name', 'penalty_name', 'discount_name', 'status_bill_month', 'billingmonth_date')
                ->get();
    
            return datatables()->of($billingmonthview)->addIndexColumn()
                ->addColumn('action', function ($billingmonthview) {
                    $button = '<input type="hidden" id="account_' . $billingmonthview->id . '" value="' . $billingmonthview->billingrate_name . '" data-name="' . $billingmonthview->penalty_name . '" />';
    
                    if ($billingmonthview->status_bill_month == 1) {
                        $button .= '
                        <button type="button" name="show" onclick="show(' . $billingmonthview->id . ')" class="action-button accept btn btn-info     btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                            <i class="fa fa-eye"></i>
                            <span class="action-text" style="font-size: 10px">Show</span>
                        </button>
                       
                    ';
                        $button .= '
                            <button type="button" name="deactivate" onclick="deactivate(' . $billingmonthview->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                                <i class="fa fa-close"></i>
                                <span class="action-text" style="font-size: 10px">Deac.</span>
                            </button>
                        ';
                      
                    } else {
                        $button .= '
                             
                            <button type="button" name="activate" onclick="activate(' . $billingmonthview->id . ')" class="action-button accept btn btn-primary btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                                <i class="fa fa-check"></i>
                                <span class="action-text" style="font-size: 10px">Act.</span>
                            </button>
                            <button type="button" name="softDelete" onclick="billingmonthconfirmDelete(' . $billingmonthview->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                                <i class="fa fa-trash-o"></i>
                                <span class="action-text" style="font-size:10px">Del.</span>
                            </button>
                        ';
                    }
    
                    $button .= '
                        <button type="button" name="edit" onclick="editbillingmonth(' . $billingmonthview->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                            <i class="fa fa-edit"></i>
                            <span class="action-text" style="font-size: 10px">Edit.</span>
                        </button>
                       
                    ';
                    
    
                    return $button;
                })
                ->make(true);
        }
        return view('billing.billingmonth');
    }
    
public function activate(Request $request)
{
    $id = $request->input('id');
    $activate = $request->input('status_bill_month');
    
    $statusact = BillingMonth::findOrFail($id);
    $statusact->status_bill_month = $activate;
    $statusact->save();

    return response()->json(['message' => 'status updated successfully'], 200);
}

public function deactivate(Request $request)
{
    $id = $request->input('id');
    $Deactivate = $request->input('status_bill_month');
    
    $statusdeact = BillingMonth::findOrFail($id);
    $statusdeact->status_bill_month = $Deactivate;
    $statusdeact->save();

    return response()->json(['message' => 'status updated successfully'], 200);
}
public function checkStatusExists()
{
  
    $statusExists = DB::table('billing_months')->where('status_bill_month', 1)->exists();

    return response()->json(['status_exists' => $statusExists]);
}
public function show($id) {
    $billingData = DB::table('billing_months')
        ->select('billingrate_name', 'penalty_name', 'discount_name')
        ->where('id', $id)
        ->orderByDesc('id')
        ->first();

    $billingrateData = DB::table('billing_rates')
        ->select('id','billingrate_name','rate_case','classification','minVol','maxVol','minAmount','increment')
        ->where('billingrate_name', $billingData->billingrate_name)
        ->get();
        
    $penaltyData = DB::table('penalty_rates')
       ->select('id','penalty_name','penalty_percent','penalty_days')
        ->where('penalty_name', $billingData->penalty_name)
        ->get();
      
    $discountData = DB::table('discount_rates')
        ->select('id','discount_name','discount_percent','discount_days')
        ->where('discount_name', $billingData->discount_name)
        ->get();

    return response()->json([
        'billingrate_name' => $billingrateData,
        'penalty_name' => $penaltyData,
        'discount_name' => $discountData,
    ]);
}
public function Delete($id)
    {
        return view('confirm-delete', ['id' => $id]);
    }
    public function billingMonthDelete($id)
        {
            try {
                $user = BillingMonth::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'Rate deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'User not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the rate'], 500);
            }
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillingMonth  $billingMonth
     * @return \Illuminate\Http\Response
     */

        public function editbillingmonth($id)
        {
           
            if(request()->ajax())
            {
                $data = BillingMonth::findOrFail($id);
                return response()->json(['result' => $data]);
            }
        }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BillingMonth  $billingMonth
     * @return \Illuminate\Http\Response
     */
    public function updateBillingMonth(Request $request)
    {
   
            $updateBillingmonth = DB::table('billing_months')->where('id', $request->id)->update([
                
                'billingrate_name' =>$request->billingrate_name,
                'penalty_name'=>$request->penalty_name,
                'discount_name' =>$request->discount_name,
                // 'trustfund_name' =>$request->trustfund_name,
                // 'status_bill_month' =>$request->status_bill_month 
            ]);
           
            return response()->json([
                'status'=> 200,
                'message'=>'Success Update rate!!'
            ]);
    
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillingMonth  $billingMonth
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingMonth $billingMonth)
    {
        //
    }
}
