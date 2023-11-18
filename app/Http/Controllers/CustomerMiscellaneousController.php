<?php

namespace App\Http\Controllers;

use App\Models\CustomerMiscellaneous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use DB;
class CustomerMiscellaneousController extends Controller
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
        // public function create(Request $request)
        // {
            
           
        //     $selectedItems = $request->input('selected_items');
        //     $account_id = $request->input('account_id'); 
        //     $customerName = $request->input('customerName');
            
        
        //     foreach ($selectedItems as $itemId) {
           
        //         $item = DB::table('miscellaneous_items')->select('miscellaneous_name', 'amount')->where('id', $itemId)->first();
        
        //         if ($item) {
          
        //             DB::table('customer_miscellaneouses')->insert([
        //                 'account_id' => $account_id,
        //                 'customerName' => $customerName,
        //                 'miscellaneous_name' => $item->miscellaneous_name,
        //                 'amount' => $item->amount
                       
        //             ]);
        //         }
        //     }
        
        //     return response()->json([
        //         'status' => 200,
        //         'message' => 'Items saved successfully'
        //     ]);
        // }
        public function create(Request $request)
        {
            $selectedItems = $request->input('selected_items');
            $account_id = $request->input('account_id');
            $customerName = $request->input('customerName');
        
            $duplicateItems = [];
        
          
            $addedItemNames = DB::table('customer_miscellaneouses')
                ->where('account_id', $account_id)
                ->pluck('miscellaneous_name')
                ->toArray();
        
            foreach ($selectedItems as $itemId) {
                $item = DB::table('miscellaneous_items')
                    ->select('miscellaneous_name', 'amount')
                    ->where('id', $itemId)
                    ->first();
        
                if ($item) {
                    $itemName = $item->miscellaneous_name;
        
                    if (!in_array($itemName, $addedItemNames)) {
                        // $createdAt = \Carbon\Carbon::now(); // Assuming you're using Carbon for timestamps
                        // $formattedDate = $createdAt->format('M Y');
                        DB::table('customer_miscellaneouses')->insert([
                            'account_id' => $account_id,
                            'customerName' => $customerName,
                            'miscellaneous_name' => $itemName,
                            'amount' => $item->amount,
                            'status' =>1,
                        ]);
                        // DB::table('account_receivables')->insert([
                        //     'account_id' => $account_id,
                       
                        //     'account_type' => $itemName,
                        //     'item_name' => $formattedDate,  
                        //     'balance' => $item->amount
                        // ]);
        
                  
                        $addedItemNames[] = $itemName;
                    } else {
                   
                        $duplicateItems[] = $itemName;
                    }
                }
            }
        
            if (!empty($duplicateItems)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'The following Miscellaneous items are already added for this customer: ' . implode(', ', $duplicateItems)
                ]);
            }
        
            return response()->json([
                'status' => 200,
                'message' => 'Items saved successfully'
            ]);
        }
        
        
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ListAddedItems(Request $request,$account_id)
    {

        if ($request->ajax()) {
            
            $consumerAddedItem = DB::table('customer_miscellaneouses')
                
                ->select('id','account_id','customerName','miscellaneous_name','amount')
                ->where('account_id',$account_id)   
                ->get();
    
            return datatables()->of($consumerAddedItem)->addIndexColumn()->make(true);
            }
        return view('billing.miscellaneous_list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerMiscellaneous  $customerMiscellaneous
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerMiscellaneous $customerMiscellaneous)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerMiscellaneous  $customerMiscellaneous
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerMiscellaneous $customerMiscellaneous)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerMiscellaneous  $customerMiscellaneous
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerMiscellaneous $customerMiscellaneous)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerMiscellaneous  $customerMiscellaneous
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerMiscellaneous $customerMiscellaneous)
    {
        //
    }
}
