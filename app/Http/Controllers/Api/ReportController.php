<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $rows = $request->user()->expenses()
            ->selectRaw('category, SUM(amount) as total')
            ->whereBetween('spent_at', [$start, $end])
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $grandTotal = $rows->sum('total');

        return response()->json([
            'month'       => $month,
            'grand_total' => (float) $grandTotal,
            'breakdown'   => $rows->map(fn ($r) => [
                'category' => $r->category,
                'total'    => (float) $r->total,
            ]),
        ]);
    }
}
