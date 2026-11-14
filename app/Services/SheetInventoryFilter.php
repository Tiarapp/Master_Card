<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Validation\ValidationException;

class SheetInventoryFilter
{
    private const COLUMNS = ['nama', 'saldo_primer', 'saldo_sekunder'];
    private const PRIMER_OPERATORS = [
        'contains' => null,
        'eq' => '=',
        'ne' => '<>',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
    ];

    public function parseSearch($input): array
    {
        if (!is_array($input)) {
            throw ValidationException::withMessages(['search' => 'Format pencarian tidak valid.']);
        }

        $searches = [];
        foreach (self::COLUMNS as $key) {
            if (!array_key_exists($key, $input) || $input[$key] === '' || $input[$key] === null) {
                continue;
            }
            if (!is_string($input[$key]) || mb_strlen($input[$key]) > 200) {
                throw ValidationException::withMessages(['search' => 'Pencarian harus berupa teks maksimal 200 karakter.']);
            }
            $searches[$key] = $input[$key];
        }

        $operator = $input['saldo_primer_operator'] ?? 'contains';
        if (!is_string($operator) || !array_key_exists($operator, self::PRIMER_OPERATORS)) {
            throw ValidationException::withMessages(['search' => 'Operator Saldo Primer tidak valid.']);
        }
        if ($operator !== 'contains') {
            if (isset($searches['saldo_primer']) && (!preg_match('/^-?\d+(?:\.\d+)?$/D', $searches['saldo_primer'])
                || !is_finite((float) $searches['saldo_primer']))) {
                throw ValidationException::withMessages(['search' => 'Nilai Saldo Primer harus berupa angka; gunakan titik untuk desimal tanpa pemisah ribuan.']);
            }
            $searches['saldo_primer_operator'] = $operator;
        }

        return $searches;
    }

    public function applySearch(Builder $query, array $searches): Builder
    {
        foreach ($searches as $key => $search) {
            if ($key === 'saldo_primer_operator') {
                continue;
            }
            $operator = $searches['saldo_primer_operator'] ?? 'contains';
            if ($key === 'saldo_primer' && $operator !== 'contains') {
                $query->whereRaw('ROUND("TPersediaanConv"."SaldoAkhirP", 0) '
                    . self::PRIMER_OPERATORS[$operator] . ' CAST(? AS DOUBLE PRECISION)', [$search]);
                continue;
            }
            $matchNull = mb_stripos('(Kosong)', $search) !== false;
            if ($key === 'nama') {
                $column = '"TBarang"."NamaBrg"';
                $expression = $column;
            } else {
                $column = $key === 'saldo_primer'
                    ? '"TPersediaanConv"."SaldoAkhirP"'
                    : '"TPersediaanConv"."SaldoAkhirS"';
                $precision = $key === 'saldo_primer' ? 0 : 2;
                $expression = $query->getConnection()->getDriverName() === 'sqlite'
                    ? "printf('%.{$precision}f', ROUND({$column}, {$precision}))"
                    : "CAST(CAST(ROUND({$column}, {$precision}) AS DECIMAL(18, {$precision})) AS VARCHAR(40))";
                $search = str_replace(',', '', $search);
            }

            if ($search === '') {
                $query->whereRaw('1 = 0');
                continue;
            }
            $pattern = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], mb_strtoupper($search)) . '%';
            $query->where(function (Builder $query) use ($column, $expression, $pattern, $matchNull) {
                $query->whereRaw("{$column} IS NOT NULL AND UPPER({$expression}) LIKE ? ESCAPE '!'", [$pattern]);
                if ($matchNull) {
                    $query->orWhereRaw("{$column} IS NULL");
                }
            });
        }

        return $query;
    }
}
