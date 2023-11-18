<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountReceivable extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'account_type',
        'item_name',
        'balance',
        'date',
        'isPaid'
    ];
    public function ConsumerInfo(){
        return $this->hasOne(ConsumerInfo::class, 'consumer_infos_account_id', 'account_id');
    }
   
}
