<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::all();
        return response()->json($incomes);
    }

    public function show($id)
    {
        $income = Income::find($id);
        return response()->json($income);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $income = Income::create($request->all());

        return response()->json($income, 201);
    }

    public function update(Request $request, $id)
    {
        $income = Income::find($id);

        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $income->update($request->all());

        return response()->json($income, 200);
    }

    public function destroy($id)
    {
        $income = Income::find($id);
        $income->delete();

        return response()->json(null, 204);
    }
}
