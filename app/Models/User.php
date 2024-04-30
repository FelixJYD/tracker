<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'total_balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relación con los gastos del usuario
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Relación con los ingresos del usuario
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    // Método para calcular y actualizar el saldo total del usuario
    public function updateTotalBalance(): void
    {
        $totalExpenses = $this->expenses()->sum('amount');
        $totalIncomes = $this->incomes()->sum('amount');
        $this->total_balance = $totalIncomes - $totalExpenses;
        $this->save();
    }
}
