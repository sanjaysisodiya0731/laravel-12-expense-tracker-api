<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Expenses ({{ $month }})</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 6px; }
    th { background: #f3f3f3; text-align: left; }
    h3 { margin-bottom: 6px; }
  </style>
</head>
<body>
  <h3>Expenses Report - {{ $month }}</h3>
  <p>User: {{ $user->name }} ({{ $user->email }})</p>
  <p>Period: {{ $start->toDateString() }} to {{ $end->toDateString() }}</p>

  <table>
    <thead>
    <tr>
      <th>Date</th>
      <th>Category</th>
      <th>Note</th>
      <th style="text-align:right;">Amount (₹)</th>
    </tr>
    </thead>
    <tbody>
    @php $sum = 0; @endphp
    @foreach ($expenses as $e)
      @php $sum += $e->amount; @endphp
      <tr>
        <td>{{ $e->spent_at->format('Y-m-d') }}</td>
        <td>{{ $e->category }}</td>
        <td>{{ $e->note }}</td>
        <td style="text-align:right;">{{ number_format($e->amount, 2) }}</td>
      </tr>
    @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" style="text-align:right;">Total</th>
        <th style="text-align:right;">{{ number_format($sum, 2) }}</th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
