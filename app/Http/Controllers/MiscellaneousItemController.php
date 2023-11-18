<?php

namespace App\Http\Controllers;

use App\Models\MiscellaneousItem;
use Illuminate\Http\Request;
use DB;

class MiscellaneousItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $MiscellView = DB::table('miscellaneous_items')->select('id','miscellaneous_name','amount')
            ->get();
            return datatables()->of($MiscellView)->addIndexColumn()
            ->addColumn('action', function ($MiscellView) {
                $button = '
                    <input type="hidden" id="account_' . $MiscellView->id . '" value="' . $MiscellView->miscellaneous_name . '" data-name="' . $MiscellView->amount . '" />
                    <button type="button" name="edit" onclick="editMiscell(' . $MiscellView->id . ')" class="action-button accept btn btn-success btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 3mm; padding-right: 3mm;font-size: 10px;">
                        <i class="fa fa-edit" ></i>
                        <span class="action-text" style="font-size:10px">Edit</span>
                    </button>
                    <button type="button" name="softDelete" onclick="miscellDelete(' . $MiscellView->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 4mm;font-size: 10px;">
                        <i class="fa fa-trash-o"></i>
                        <span class="action-text" style="font-size:10px">Delete</span>
                    </button>
                ';
                return $button;
            })
            ->make(true);
        }
        return view('library.addlibrary');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
     
        $itemForm = MiscellaneousItem::insert([
            'miscellaneous_name' => $request->miscellaneous_name,
            'amount' => $request->amount
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'success add item'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // in customer miscellaneous item
    public function store(Request $request)
    {
    
        if ($request->ajax()) {
            $consumerItem = DB::table('consumer_infos')
                ->orderBy('consumer_infos.status', 'asc')
                ->whereNot('status',2)
                ->select('id', 'account_id', 'customerName', 'connectionDate','updatestatusDate', 'rate_case', 'classification', 'cluster', 'consumerName2', 'trade1', 'trade2', 'concessionerName', 'meter', 'status',
                    DB::raw("CONCAT(region, ', ', province, ', ', municipality, ', ', barangay, ', ', purok) AS location"), 
                    'Province')
                ->get();
    
            return datatables()->of($consumerItem)->addIndexColumn()
                ->addColumn('action', function ($consumerItem) {
                    $button = '
                    <input type="hidden" id="account_' . $consumerItem->id . '" value="' . $consumerItem->customerName . '" data-name="' . $consumerItem->consumerName2 . '" />
                    <button type="button" data-account-id="'. $consumerItem->account_id. '" name="view" onclick="addItem(this)" class="action-button view btn btn-primary btn-sm" style="padding-top: 3mm; padding-bottom: 3mm; padding-left: 5mm; padding-right: 5mm; font-size: 9px;">
                    <i class="fa fa-plus fa-1x"></i>
                    <span class="action-text" style="font-size: 9px">Add Item</span>
                </button>
                    ';


                    return $button;
                })
                ->make(true);
            }
        return view('billing.miscellaneous_list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Miscellaneous_item  $miscellaneous_item
     * @return \Illuminate\Http\Response
     */
    public function show(Miscellaneous_item $miscellaneous_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Miscellaneous_item  $miscellaneous_item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = MiscellaneousItem::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Miscellaneous_item  $miscellaneous_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $updateItem = DB::table('miscellaneous_items')->where('id', $request->id)->update([
            'miscellaneous_name' =>$request->miscellaneous_name,
            'amount' =>$request->amount
        ]);
       
        return response()->json([
            'status'=> 200,
            'message'=>'Success Update Item!!'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Miscellaneous_item  $miscellaneous_item
     * @return \Illuminate\Http\Response
     */
    public function Delete($id)
    {
        return view('confirm-delete', ['id' => $id]);
    }
    public function deleteItem($id)
        {
            try {
                $user = MiscellaneousItem::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'Items deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'discount not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the item'], 500);
            }
        }
}
