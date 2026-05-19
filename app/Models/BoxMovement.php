<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoxMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'box_id', 'user_id', 'type', 'reason', 'person_involved',
        'amount', 'notes', 'evidence_path'
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
