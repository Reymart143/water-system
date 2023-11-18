<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'customerName',
        'connectionDate',
        'rate_case',
        'classification',
        'cluster',
        'consumerName2',
        'trade1',
        'trade2',
        'concessionerName',
        'meter',
        'region',
        'municipality',
        'barangay',
        'purok',
        'Province',
        'status',
        'updatestatusDate'
    ];
     public function library()
    {
        return $this->belongsTo(Library::class, 'category_id');
    }
    // public function bill(){
    //     return $this->belongsTo(WaterBilling::class, 'bill_id');
    // }
    public function encoders()
    {
        return $this->hasMany(Encoder::class, 'account_id', 'account_id');
    }
    public function consumer_reading(){
        $reading = Encoder::where('account_id', $this->account_id)->orderByDesc('id')->first();
        
        $status = null;
        if($reading){
        $toReadingDate = date('Y-m-d', strtotime($reading->to_reading_date));
        $current_date = date('Y-m-d');
            if($current_date >= $toReadingDate ){
                $status = 0;

            }else{
                $status = $reading->status_reading;
            }
       
        }else{
            $status = 0;
        }
        return $status;
    }
    // public function getLocationAttribute()
    //     {
    //         return $this->attributes['purok'] . ', ' . $this->attributes['barangay'] . ', ' . $this->attributes['municipality'];
    //     }
    public function treasurerReceipts()
    {
        return $this->hasMany(TreasurerReceipt::class, 'consumer_infos_id', 'id');
    }
    public function AccountReceivable()
    {
        return $this->hasMany(AccountReceivable::class, 'consumer_infos_account_id', 'account_id');
    }
    public function consumerLedgers()
    {
        return $this->hasMany(ConsumerLedger::class, 'consumer_infos_account_id', 'account_id');
    }

    public function customerMiscellaneous()
    {
        return $this->hasMany(CustomerMiscellaneous::class, 'consumer_infos_account_id', 'account_id');
    }

}
