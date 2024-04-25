<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'description' => fake()->sentence,
            'amount' => fake()->numberBetween(10, 100),
            'date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
