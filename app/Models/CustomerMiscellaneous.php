<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMiscellaneous extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'customerName',
        'miscellaneous_name',
        'amount',
        'status'
    ];
    public function ConsumerInfo()
    {
        return $this->hasOne(ConsumerInfo::class, 'consumer_infos_id', 'id');
    }
}
