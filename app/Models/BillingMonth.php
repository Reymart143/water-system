<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingMonth extends Model
{
    use HasFactory;
    protected $fillable = [
       'billingmonth_date',
       'billingrate_name',
       'penalty_name',
       'discount_name',
       'trustfund_name',
       'status_bill_month',
    ];
}
