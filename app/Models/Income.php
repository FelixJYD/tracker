<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($income) {
            // Cuando se crea un nuevo ingreso, actualiza el saldo total del usuario asociado
            $income->user->updateTotalBalance();
        });
    }
}
