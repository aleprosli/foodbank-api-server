<?php

namespace App\Models;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
    ];

    public function donor()
    {
        return $this->hasOne(Donor::class);
    }
}
