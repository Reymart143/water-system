<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasurerReceipt extends Model
{
    use HasFactory;
    protected $fillable =[
        'Total_Amount_Water_bill',
        'account_id',
        'receiptID',
        'customerName',
        'receiptcurrentDate',
        'stub_no',
        'or_number',
        'rate_case',
        'cash',
        'drawee_Checkbox',
        'drawee_input',
        'drawee_number',
        'draweeDate',
        'money_checkbox',
        'money_order_number',
        'money_order_date',
        'collector'
    ];
    public function consumerInfo()
    {
        return $this->belongsTo(ConsumerInfo::class, 'consumer_infos_id', 'id');
    }
    public function consumerLedger()
    {
        return $this->belongsTo(ConsumerLedger::class, 'consumer_ledgers_id', 'id');
    }
}
