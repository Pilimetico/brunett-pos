<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')->orderBy('expense_date', 'desc')->paginate(15);
        $categories = ExpenseCategory::where('is_active', true)->get();
        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required',
            'expense_date' => 'required|date',
        ]);

        Expense::create([
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
            'payment_method' => $request->payment_method ?? 'cash',
            'user_id' => 1, // Fixed for now, should be Auth::id()
        ]);

        return back()->with('success', 'Gasto registrado correctamente.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Gasto eliminado.');
    }
}
