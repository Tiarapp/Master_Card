<?php

namespace App\Imports;

use DateTimeImmutable;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RealisasiKirimSpreadsheet
{
    private const HEADERS = ['TGL SJ', 'NO SJ', 'MOD', 'KONTRAK', 'PCS', 'OPI'];
    private const MAX_ROWS = 2000;

    public function rows(Worksheet $sheet): array
    {
        $columns = [];
        foreach ($sheet->rangeToArray('A1:' . $sheet->getHighestDataColumn() . '1', null, false, false, true)[1] as $column => $value) {
            $heading = strtoupper(trim((string) $value));
            if (in_array($heading, self::HEADERS, true)) {
                if (isset($columns[$heading])) {
                    throw new InvalidArgumentException("Kolom {$heading} ditemukan lebih dari sekali.");
                }
                $columns[$heading] = $column;
            }
        }

        $missing = array_diff(self::HEADERS, array_keys($columns));
        if ($missing) {
            throw new InvalidArgumentException('Kolom wajib tidak ditemukan: ' . implode(', ', $missing) . '.');
        }

        $lastRow = $sheet->getHighestDataRow();
        if ($lastRow > self::MAX_ROWS + 1) {
            throw new InvalidArgumentException('Maksimal 2000 baris data per file.');
        }

        $rows = [];
        for ($number = 2; $number <= $lastRow; $number++) {
            $values = [];
            $formula = false;
            foreach ($columns as $heading => $column) {
                $cell = $sheet->getCell($column . $number);
                $formula = $formula || $cell->getDataType() === DataType::TYPE_FORMULA;
                $values[$heading] = $cell->getValue();
            }
            if (count(array_filter($values, function ($value) {
                return $value !== null && trim((string) $value) !== '';
            })) === 0) {
                continue;
            }

            $errors = [];
            if ($formula) {
                $errors[] = 'Kolom wajib tidak boleh berisi rumus Excel.';
            }
            $tanggal = $this->date($values['TGL SJ']);
            if (!$tanggal) {
                $errors[] = 'TGL SJ harus berupa tanggal valid (DD/MM/YYYY atau YYYY-MM-DD).';
            }
            foreach (['NO SJ', 'MOD', 'KONTRAK'] as $heading) {
                if (trim((string) $values[$heading]) === '') {
                    $errors[] = "{$heading} wajib diisi.";
                }
            }
            $qty = $values['PCS'];
            if (!is_numeric($qty) || (float) $qty <= 0 || floor((float) $qty) != (float) $qty || (float) $qty > 2147483647) {
                $errors[] = 'PCS harus berupa bilangan bulat positif.';
            }

            $rows[] = [
                'row' => $number,
                'tanggal' => $tanggal,
                'sj' => trim((string) $values['NO SJ']),
                'mod' => trim((string) $values['MOD']),
                'kontrak' => trim((string) $values['KONTRAK']),
                'qty' => is_numeric($qty) ? (int) $qty : null,
                'opi' => trim((string) $values['OPI']),
                'errors' => $errors,
            ];
        }

        if (!$rows) {
            throw new InvalidArgumentException('File tidak berisi baris data.');
        }

        return $rows;
    }

    private function date($value): ?string
    {
        if (is_numeric($value) && (float) $value >= 1 && (float) $value <= 2958465) {
            return Date::excelToDateTimeObject((float) $value)->format('Y-m-d');
        }

        $value = trim((string) $value);
        foreach (['d/m/Y', 'Y-m-d'] as $format) {
            $date = DateTimeImmutable::createFromFormat('!' . $format, $value);
            if ($date && $date->format($format) === $value) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }
}
