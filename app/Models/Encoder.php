<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encoder extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'status_reading',
        'reading_date',
        'Reader',
        'current_reading',
        'previous_reading',
       

    ];
    public function consumerInfo()
    {
        return $this->belongsTo(ConsumerInfo::class, 'account_id', 'account_id');
    }
    public function scopeByReaderName($query, $readerName)
    {
        return $query->where('reader_name', $readerName);
    }
   public function waterbilling(){
    return $this->hasMany(Waterbilling::class, 'account_id');
   }
}
