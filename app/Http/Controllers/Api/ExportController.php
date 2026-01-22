<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function csv(Request $request): StreamedResponse
    {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $expenses = $request->user()->expenses()
            ->whereBetween('spent_at', [$start, $end])
            ->orderBy('spent_at')
            ->get(['spent_at','category','note','amount']);

        $filename = "expenses-{$month}.csv";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->streamDownload(function () use ($expenses) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date','Category','Note','Amount']);
            foreach ($expenses as $e) {
                fputcsv($out, [
                    $e->spent_at->format('Y-m-d'),
                    $e->category,
                    $e->note,
                    number_format($e->amount, 2, '.', ''),
                ]);
            }
            fclose($out);
        }, $filename, $headers);
    }

    public function pdf(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $user = $request->user();
        $expenses = $user->expenses()
            ->whereBetween('spent_at', [$start, $end])
            ->orderBy('spent_at')
            ->get();

        $pdf = Pdf::loadView('exports.expenses', compact('expenses','user','start','end','month'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("expenses-{$month}.pdf");
    }
}
