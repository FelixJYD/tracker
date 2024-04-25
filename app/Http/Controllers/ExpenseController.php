<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    public function show($id)
    {
        $expense = Expense::find($id);
        return response()->json($expense);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $expense = Expense::create($request->all());

        return response()->json($expense, 201);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);

        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $expense->update($request->all());

        return response()->json($expense, 200);
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        return response()->json(null, 204);
    }
}
