<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\AccountReceivable;
use App\Models\BillingMonth;
use DB;

class CreatePenalty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:penalty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    // public function handle()
    // {
    //     $PenaltyRate = BillingMonth::where('status_bill_month', 1)
    //         ->select('penalty_rates.penalty_name', 'penalty_rates.penalty_days', 'penalty_rates.penalty_percent')
    //         ->join('penalty_rates', 'billing_months.penalty_name', 'penalty_rates.penalty_name')
    //         ->first();

    //     $penalty_percentage = $PenaltyRate->penalty_percent / 100;
    //     $penalty_days = $PenaltyRate->penalty_days;
    //     $isPenalty = false;

    //     $holidays = DB::table('holidays')->pluck('holiday_date')->toArray();

    //     $consumers = DB::table('consumer_infos')
    //         ->select('account_id')
    //         ->whereNot('status', 2)
    //         ->get();

    //     foreach ($consumers as $consumer) {
    //         $account_receivable = AccountReceivable::where('account_id', $consumer->account_id)
    //             ->where('account_type', 'Water Bill')
    //             ->orderByDesc('id')
    //             ->first();

    //         if ($account_receivable) {
    //             $current_date = date('Y-m-d');
    //             $penalty_date = date('Y-m-d', strtotime($account_receivable->date . ' + ' . $penalty_days . ' weekdays'));

    //             // Skip holidays and weekends
    //             while (in_array($penalty_date, $holidays) || date('N', strtotime($penalty_date)) >= 6) {
    //                 $penalty_date = date('Y-m-d', strtotime($penalty_date . ' + 1 day'));
    //             }

    //             if ($current_date > $penalty_date) {
    //                 AccountReceivable::create([
    //                     'account_id' => $consumer->account_id,
    //                     'account_type' => 'Penalty',
    //                     'balance' => $account_receivable->balance * $penalty_percentage,
    //                     'item_name' => $account_receivable->date,
    //                     'date' => $penalty_date,
    //                 ]);
    //             }
    //         }
    //     }

    //     return Command::SUCCESS;
    // }

    
}
