<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['amount','category','spent_at','note'];

    protected $casts = [
        'spent_at' => 'date',
        'amount'   => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
