<?php

namespace App\Models;

use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'donation_count',
        'level_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

}
