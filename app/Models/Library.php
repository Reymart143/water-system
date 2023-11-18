<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'categoryaddedName',
     
       
    ];


     public function consumerInfos()
    {
        return $this->hasMany(ConsumerInfo::class, 'category_id'); 
    }
}
