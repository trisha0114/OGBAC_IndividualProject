<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'contact_number',
        'address',
        'user_id',
    ];

   public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
}