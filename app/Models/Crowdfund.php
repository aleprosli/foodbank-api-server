<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crowdfund extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
        'target',
        'gps_location',
        'user_id',
        'total_donation'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getTargetUncompletedAttribute()
    {
        return $this->whereRaw('target > total_donation')->get();
    }

    public function getTargetCompletedAttribute()
    {
        return $this->whereRaw('target = total_donation')->get();
    }

    public function getEmergencyFundAttribute()
    {
        return $this->where('category_id',4)->get();
    }
}
