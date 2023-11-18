<?php

namespace App\Http\Controllers;

use App\Models\DiscountRate;
use Illuminate\Http\Request;
use DB;

class DiscountRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDiscountRate(Request $request){
        if($request->ajax()){
            $discountrateview = DB::table('discount_rates')->select('id','discount_name','discount_percent','discount_days')
            ->get();
            return datatables()->of($discountrateview)->addIndexColumn()
            ->addColumn('action', function ($discountrateview) {
                $button = '
                    <input type="hidden" id="account_' . $discountrateview->id . '" value="' . $discountrateview->discount_name . '" data-name="' . $discountrateview->discount_name . '" />
                    <button type="button" name="edit" onclick="editdiscountrate(' . $discountrateview->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                        <i class="fa fa-edit" ></i>
                        <span class="action-text" style="font-size:10px">Edit</span>
                    </button>
                    <button type="button" name="softDelete" onclick="DiscountrateconfirmDelete(' . $discountrateview->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
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
    public function addDiscountRate(Request $request){
        $penaltyform = DB::table('discount_rates')->insert([
            'discount_name' =>$request->discount_name,
            'discount_percent' =>$request->discount_percent,
            'discount_days' =>$request->discount_days,
        ]);
         return response()->json([
            'status' => 200,
            'message' => 'success created rate'
        ]);
    }
    public function editDiscountrate($id)
    {
       
        if(request()->ajax())
        {
            $data = DiscountRate::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }
    public function updateDiscountrate(Request $request)
    {
   
            $updateDiscountrate = DB::table('discount_rates')->where('id', $request->id)->update([
                'discount_name' =>$request->discount_name,
                'discount_percent' =>$request->discount_percent,
                'discount_days' =>$request->discount_days
            ]);
           
            return response()->json([
                'status'=> 200,
                'message'=>'Success Update rate!!'
            ]);
    
        
    }
    public function Delete($id)
    {
        return view('confirm-delete', ['id' => $id]);
    }
    public function discountrateDelete($id)
        {
            try {
                $user = DiscountRate::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'discount deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'discount not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the discount'], 500);
            }
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
     * @param  \App\Models\DiscountRate  $discountRate
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountRate $discountRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiscountRate  $discountRate
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountRate $discountRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiscountRate  $discountRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountRate $discountRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiscountRate  $discountRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountRate $discountRate)
    {
        //
    }
}
