<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class AgingAccountController extends Controller
{
    public function indexAging(Request $request) {
        if ($request->ajax()) {
            $today = now(); 
            $status = 2;
            $AgingReceivablecustomer = DB::table('account_receivables')
                ->select(
                    'consumer_infos.customerName', 
                    DB::raw('CONCAT(account_receivables.account_type, " ", account_receivables.item_name) as particular'),
                    'account_receivables.balance',
                    'account_receivables.date'
                )
                ->leftJoin('consumer_infos', 'consumer_infos.account_id', '=', 'account_receivables.account_id')
                ->whereNot('balance',0)
                ->whereNot('status',$status)
                ->where('account_receivables.isPaid',0)
                ->get();
    
           
            $agedBalancesByCustomer = $AgingReceivablecustomer->groupBy('customerName')->map(function ($customerRecords) use ($today) {
                return $customerRecords->sort(function ($a, $b) {
                    $order = ['Water Bill', 'Watershed', 'Penalty'];
                    $aIndex = array_search(explode(" ", $a->particular)[0], $order);
                    $bIndex = array_search(explode(" ", $b->particular)[0], $order);
                    return $aIndex - $bIndex;
                })->map(function ($record) use ($today) {
                    $balanceDate = Carbon::parse($record->date); 
                    $daysDifference = $today->diffInDays($balanceDate);
    
                    return [
                        'customerName' => $record->customerName,
                        'particular' => $record->particular,
                        'balance' => $record->balance,
                        'within30days' => ($daysDifference <= 30) ? $record->balance : null,
                        '31to60days' => ($daysDifference > 30 && $daysDifference <= 60) ? $record->balance : null,
                        '61to90days' => ($daysDifference > 60 && $daysDifference <= 90) ? $record->balance : null,
                        'Over90days' => ($daysDifference > 90) ? $record->balance : null,
                    ];
                });
            });
    
            return datatables()->of($agedBalancesByCustomer->collapse())->make(true);
        }
    
        return view('reports.aging-account-list');
    }
        
        
}
