<?php

namespace App\Http\Controllers;

use App\Models\BillingRate;
use Illuminate\Http\Request;
use DB;
class BillingRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBillingRate(Request $request)
    {
        if($request->ajax()){
            $billingrateview = DB::table('billing_rates')->select('id','billingrate_name','rate_case','classification','minVol','maxVol','minAmount','increment')
            ->get();
            return datatables()->of($billingrateview)->addIndexColumn()
            ->addColumn('action', function ($billingrateview) {
                $button = '
                    <input type="hidden" id="account_' . $billingrateview->id . '" value="' . $billingrateview->rate_case . '" data-name="' . $billingrateview->classification . '" />
                    <button type="button" name="edit" onclick="editbillingrate(' . $billingrateview->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                        <i class="fa fa-edit" ></i>
                        <span class="action-text" style="font-size:10px">Edit</span>
                    </button>
                    <button type="button" name="softDelete" onclick="billingrateconfirmDelete(' . $billingrateview->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
                        <i class="fa fa-trash-o"></i>
                        <span class="action-text" style="font-size:10px">Delete</span>
                    </button>
                ';
                return $button;
            })
            ->make(true);
        }
        return view('about-rate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBillingRate(Request $request)
    {
        $billingrateForm = DB::table('billing_rates')->insert([
            'billingrate_name' => $request->billingrate_name,
            'rate_case' => $request->rate_case,
            'classification' => $request->classification,
            'minVol' => $request->minVol,
            'maxVol' => $request->maxVol,
            'minAmount' => $request->minAmount,
            'increment' => $request->increment
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'success',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BillingRate  $billingRate
     * @return \Illuminate\Http\Response
     */
    public function show(BillingRate $billingRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillingRate  $billingRate
     * @return \Illuminate\Http\Response
     */
    public function editBillingrate($id)
    {
       
        if(request()->ajax())
        {
            $data = BillingRate::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BillingRate  $billingRate
     * @return \Illuminate\Http\Response
     */
    public function updateBillingrate(Request $request)
    {
   
            $updateBillingrate = DB::table('billing_rates')->where('id', $request->id)->update([
                'billingrate_name' => $request->billingrate_name,
                'rate_case' => $request->rate_case,
                'classification' => $request->classification,
                'minVol' => $request->minVol,
                'maxVol' => $request->maxVol,
                'minAmount' => $request->minAmount,
                'increment' => $request->increment
            ]);
           
            return response()->json([
                'status'=> 200,
                'message'=>'Success Update rate!!'
            ]);
    
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillingRate  $billingRate
     * @return \Illuminate\Http\Response
     */
    public function Delete($id)
    {
        return view('confirm-delete', ['id' => $id]);
    }
    public function billingrateDelete($id)
        {
            try {
                $user = BillingRate::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'Customer deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'User not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the user'], 500);
            }
        }
}
