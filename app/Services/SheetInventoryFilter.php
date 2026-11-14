<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SheetInventoryFilter
{
    public const COLUMNS = [
        'nama' => 'TBarang.NamaBrg',
        'saldo_primer' => 'ROUND("TPersediaanConv"."SaldoAkhirP", 0)',
        'saldo_sekunder' => 'ROUND("TPersediaanConv"."SaldoAkhirS", 2)',
    ];

    public function parse(array $input): array
    {
        $filters = [];
        foreach (self::COLUMNS as $key => $column) {
            $filter = $input[$key] ?? null;
            if ($filter === null) {
                continue;
            }
            if (!is_array($filter) || !in_array($filter['mode'] ?? null, ['include', 'exclude'], true)
                || !is_array($filter['values'] ?? [])) {
                throw ValidationException::withMessages(['filters' => 'Format filter tidak valid.']);
            }
            $values = [];
            foreach ($filter['values'] ?? [] as $encoded) {
                if (!is_string($encoded)) {
                    throw ValidationException::withMessages(['filters' => 'Nilai filter tidak valid.']);
                }
                $value = json_decode($encoded, true);
                if (json_last_error() !== JSON_ERROR_NONE || ($value !== null && !is_string($value))
                    || ($key !== 'nama' && $value !== null && !is_numeric($value))) {
                    throw ValidationException::withMessages(['filters' => 'Nilai filter tidak valid.']);
                }
                $values[] = $value;
            }
            $filters[$key] = ['mode' => $filter['mode'], 'values' => $values];
        }
        return $filters;
    }

    public function apply(Builder $query, array $filters, ?string $except = null): Builder
    {
        foreach ($filters as $key => $filter) {
            if ($key === $except) {
                continue;
            }
            $column = $key === 'nama' ? self::COLUMNS[$key] : DB::raw(self::COLUMNS[$key]);
            $values = array_values(array_filter($filter['values'], function ($value) {
                return $value !== null;
            }));
            $hasNull = in_array(null, $filter['values'], true);
            $include = $filter['mode'] === 'include';

            if (!$values && !$hasNull) {
                if ($include) {
                    $query->whereRaw('1 = 0');
                }
                continue;
            }

            $query->where(function (Builder $query) use ($key, $column, $values, $hasNull, $include) {
                if ($include) {
                    foreach (array_chunk($values, 500) as $chunk) {
                        $this->applyValues($query, $key, $column, $chunk, true);
                    }
                    if ($hasNull) {
                        $query->orWhereNull($column);
                    }
                } else {
                    foreach (array_chunk($values, 500) as $chunk) {
                        $this->applyValues($query, $key, $column, $chunk, false);
                    }
                    if ($hasNull) {
                        $query->whereNotNull($column);
                    } elseif ($values) {
                        $query->orWhereNull($column);
                    }
                }
            });
        }
        return $query;
    }

    private function applyValues(Builder $query, string $key, $column, array $values, bool $include): void
    {
        if ($key === 'nama') {
            $include ? $query->orWhereIn($column, $values) : $query->whereNotIn($column, $values);
            return;
        }

        $precision = $key === 'saldo_primer' ? 0 : 2;
        $parameters = implode(', ', array_fill(0, count($values), "CAST(? AS DECIMAL(18, {$precision}))"));
        $operator = $include ? 'IN' : 'NOT IN';
        $query->whereRaw(self::COLUMNS[$key] . " {$operator} ({$parameters})", $values, $include ? 'or' : 'and');
    }
}
