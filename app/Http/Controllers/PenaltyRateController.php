<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\PenaltyRate;

class PenaltyRateController extends Controller
{
    public function addPenaltyRate(Request $request){
        $penaltyform = DB::table('penalty_rates')->insert([
            'penalty_name' =>$request->penalty_name,
            'penalty_percent' =>$request->penalty_percent,
            'penalty_days' =>$request->penalty_days,
        ]);
         return response()->json([
            'status' => 200,
            'message' => 'success created rate'
        ]);
    }
    public function indexPenaltyRate(Request $request){
        if($request->ajax()){
            $penaltyrateview = DB::table('penalty_rates')->select('id','penalty_name','penalty_percent','penalty_days')
            ->get();
            return datatables()->of($penaltyrateview)->addIndexColumn()
            ->addColumn('action', function ($penaltyrateview) {
                $button = '
                    <input type="hidden" id="account_' . $penaltyrateview->id . '" value="' . $penaltyrateview->penalty_name . '" data-name="' . $penaltyrateview->penalty_percent . '" />
                    <button type="button" name="edit" onclick="editpenaltyrate(' . $penaltyrateview->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                        <i class="fa fa-edit" ></i>
                        <span class="action-text" style="font-size:10px">Edit</span>
                    </button>
                    <button type="button" name="softDelete" onclick="PenaltyrateconfirmDelete(' . $penaltyrateview->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
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
    public function editPenaltyrate($id)
    {
       
        if(request()->ajax())
        {
            $data = PenaltyRate::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }
    public function updatePenaltyrate(Request $request)
    {
   
            $updatePenaltyrate = DB::table('penalty_rates')->where('id', $request->id)->update([
                'penalty_name' =>$request->penalty_name,
                'penalty_percent' =>$request->penalty_percent,
                'penalty_days' =>$request->penalty_days
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
    public function penaltyrateDelete($id)
        {
            try {
                $user = PenaltyRate::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'Penalty deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'Penalty not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the Penalty'], 500);
            }
        }
}
