<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerLedger extends Model
{
    use HasFactory;
     protected $fillable = [
        'customerName',
        'account_id',
        'transact_date',
        'particular',
        'or_no',
        'issuance',
        'collection',
        'balance'
     ];
     public function treasurerReceipts()
    {
        return $this->hasMany(TreasurerReceipt::class, 'consumer_ledgers_id', 'id');
    }
    public function ConsumerInfo()
    {
        return $this->hasOne(ConsumerInfo::class, 'consumer_ledgers_id', 'id');
    }
}
