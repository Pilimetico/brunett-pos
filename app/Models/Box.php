<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'opening_balance', 'closing_balance', 'expected_balance',
        'difference', 'opened_at', 'closed_at', 'status', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(BoxMovement::class);
    }
}
