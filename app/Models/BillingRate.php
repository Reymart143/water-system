<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingRate extends Model
{
    use HasFactory;
    protected $fillable = [
       'billingrate_name',
       'rate_case',
       'classification',
       'minVol',
       'maxVol',
       'minAmount',
       'increment'
    ];
}
