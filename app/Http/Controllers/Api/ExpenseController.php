<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Filters: month=YYYY-MM OR from,to
        $query = $request->user()->expenses()->orderByDesc('spent_at')->orderByDesc('id');

        if ($request->filled('month')) {
            // e.g. 2025-08
            $start = Carbon::parse($request->input('month') . '-01')->startOfMonth();
            $end   = (clone $start)->endOfMonth();
            $query->whereBetween('spent_at', [$start, $end]);
        }

        if ($request->filled(['from','to'])) {
            $query->whereBetween('spent_at', [
                Carbon::parse($request->input('from'))->startOfDay(),
                Carbon::parse($request->input('to'))->endOfDay(),
            ]);
        }

        $perPage = (int) $request->input('per_page', 20);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount'   => ['required','numeric','min:0.01'],
            'category' => ['required','string','max:50'],
            'spent_at' => ['required','date'],
            'note'     => ['nullable','string','max:255'],
        ]);

        $expense = $request->user()->expenses()->create($data);

        return response()->json($expense, 201);
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'amount'   => ['sometimes','numeric','min:0.01'],
            'category' => ['sometimes','string','max:50'],
            'spent_at' => ['sometimes','date'],
            'note'     => ['nullable','string','max:255'],
        ]);

        $expense->update($data);

        return response()->json($expense);
    }

    public function destroy(Request $request, Expense $expense)
    {
        if ($expense->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $expense->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
