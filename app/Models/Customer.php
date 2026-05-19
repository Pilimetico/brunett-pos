<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'document_number', 'first_name', 'last_name',
        'phone', 'whatsapp', 'email', 'city', 'province', 'address',
        'is_member_active', 'membership_expires_at',
        'has_credit', 'credit_limit', 'credit_used', 'notes', 'is_active'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
