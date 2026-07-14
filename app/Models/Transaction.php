<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'transaction_category_id', 'transaction_classification_id',
        'type', 'amount', 'description', 'date', 'attachment_path',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class, 'transaction_category_id');
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(TransactionClassification::class, 'transaction_classification_id');
    }

    public function scopeIngresos(Builder $query): Builder
    {
        return $query->where('type', 'ingreso');
    }

    public function scopeEgresos(Builder $query): Builder
    {
        return $query->where('type', 'egreso');
    }

    public function scopeDelMes(Builder $query, ?int $month = null, ?int $year = null): Builder
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }

    public function scopeDelAnio(Builder $query, ?int $year = null): Builder
    {
        $year = $year ?? now()->year;

        return $query->whereYear('date', $year);
    }
}
