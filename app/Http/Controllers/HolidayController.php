<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use DB;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            if($request->ajax()){
                $HolidayView = DB::table('holidays')->select('id','holiday_name','holiday_date')
                ->get();
                return datatables()->of($HolidayView)->addIndexColumn()
                ->addColumn('action', function ($HolidayView) {
                    $button = '
                        <input type="hidden" id="account_' . $HolidayView->id . '" value="' . $HolidayView->holiday_name . '" data-name="' . $HolidayView->holiday_date . '" />
                        <button type="button" name="edit" onclick="editHoliday(' . $HolidayView->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                            <i class="fa fa-edit" ></i>
                            <span class="action-text" style="font-size:10px">Edit</span>
                        </button>
                        <button type="button" name="softDelete" onclick="holidayDelete(' . $HolidayView->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
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
    public function create(Request $request)
    {
        $holidayform = DB::table('holidays')->insert([
            'holiday_name' => $request->holiday_name,
            'holiday_date' => $request->holiday_date
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'successfully add holiday'
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
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Holiday::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        $updateHoliday = DB::table('holidays')->where('id', $request->id)->update([
            'holiday_name' =>$request->holiday_name,
            'holiday_date' =>$request->holiday_date
        ]);
       
        return response()->json([
            'status'=> 200,
            'message'=>'Success Update non-working days!!'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function Delete($id)
    {
        return view('confirm-delete', ['id' => $id]);
    }
    public function deleteHoliday($id)
        {
            try {
                $user = Holiday::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'non-working days deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'discount not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the holiday'], 500);
            }
        }
}
