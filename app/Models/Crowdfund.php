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
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
