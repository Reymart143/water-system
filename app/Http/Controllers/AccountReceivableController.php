<?php

namespace App\Http\Controllers;

use App\Models\AccountReceivable;
use Illuminate\Http\Request;
use DB;

class AccountReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $accountReceivable = DB::table('consumer_infos')
                ->whereIn('consumer_infos.status', [0, 1])
                ->get();
    
            return datatables()->of($accountReceivable)->addIndexColumn()
                ->addColumn('action', function ($accountReceivable) {
                    $url = route('collection.perUserAccount-receivables', ['account_id' => $accountReceivable->account_id]);
    
                    $button = '
                        <a href="' . $url . '" class="action-button btn btn-success btn-sm fetch-details" style="padding-top: 1mm; padding-bottom: 1mm; padding-left: 3mm; padding-right: 3mm; font-size: 9px;">
                        <i class="fa-solid fa-cash-register fa-2x"></i>
                            <span class="action-text" style="font-size:9px">Acc.Rec</span>
                        </a>
                    ';
    
                    return $button;
                })
                ->make(true);
        }
    
        return view('collection.treasurer-account-receivables');
    }
    
    public function perUserAccRec(Request $request, $account_id)
        {
            $user = DB::table('consumer_infos')
            ->select('customerName', 'account_id')
            ->where('account_id', $account_id)
        
            ->first();
             $ledgerConsumer = DB::table('account_receivables')->select('id','date','account_type','balance','item_name','isPaid')->where('account_id', $user->account_id)->get();
              $totalIsPaid = DB::table('account_receivables')->whereNot('balance', 0)->where('isPaid',1)->where('account_id', $user->account_id)->count();
              $totalIsNotPaid = DB::table('account_receivables')->whereNot('balance', 0)->where('isPaid',0)->where('account_id', $user->account_id)->count();
            return view('collection.perUserAccount-receivables', compact('user','ledgerConsumer','totalIsPaid','totalIsNotPaid'));
        }
    
       
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountReceivable  $accountReceivable
     * @return \Illuminate\Http\Response
     */
    public function show(AccountReceivable $accountReceivable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountReceivable  $accountReceivable
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountReceivable $accountReceivable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountReceivable  $accountReceivable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountReceivable $accountReceivable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountReceivable  $accountReceivable
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountReceivable $accountReceivable)
    {
        //
    }
}
