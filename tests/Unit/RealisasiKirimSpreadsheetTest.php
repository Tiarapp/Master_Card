<?php

namespace Tests\Unit;

use App\Imports\RealisasiKirimSpreadsheet;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

class RealisasiKirimSpreadsheetTest extends TestCase
{
    private function sheet(): \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
    {
        $sheet = (new Spreadsheet())->getActiveSheet();
        $sheet->fromArray([['TGL SJ', 'NO SJ', 'MOD', 'KONTRAK', 'PCS', 'OPI']], null, 'A1');

        return $sheet;
    }

    public function test_reads_sample_format_and_preserves_opi_leading_zero(): void
    {
        $sheet = $this->sheet();
        $sheet->fromArray([['06/11/2026', 'SJ-1', 'MOD-1', 'K-1', 14400, '09846F']], null, 'A2');

        $rows = (new RealisasiKirimSpreadsheet())->rows($sheet);

        $this->assertSame('2026-11-06', $rows[0]['tanggal']);
        $this->assertSame('09846F', $rows[0]['opi']);
        $this->assertSame(14400, $rows[0]['qty']);
        $this->assertSame([], $rows[0]['errors']);
    }

    public function test_excel_serial_date_and_empty_opi_are_supported(): void
    {
        $sheet = $this->sheet();
        $sheet->fromArray([[46332, 'SJ-1', 'MOD-1', 'K-1', 1, null]], null, 'A2');

        $rows = (new RealisasiKirimSpreadsheet())->rows($sheet);

        $this->assertSame('2026-11-06', $rows[0]['tanggal']);
        $this->assertSame('', $rows[0]['opi']);
        $this->assertSame([], $rows[0]['errors']);
    }

    public function test_invalid_rows_and_formulas_are_reported_with_excel_row_number(): void
    {
        $sheet = $this->sheet();
        $sheet->fromArray([['31/02/2026', '', 'MOD-1', 'K-1', 1.5, '=1+1']], null, 'A3');

        $rows = (new RealisasiKirimSpreadsheet())->rows($sheet);

        $this->assertSame(3, $rows[0]['row']);
        $this->assertCount(4, $rows[0]['errors']);
    }

    public function test_missing_header_is_rejected(): void
    {
        $sheet = $this->sheet();
        $sheet->setCellValue('F1', 'OTHER');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('OPI');
        (new RealisasiKirimSpreadsheet())->rows($sheet);
    }

    public function test_duplicate_header_is_rejected(): void
    {
        $sheet = $this->sheet();
        $sheet->setCellValue('G1', 'OPI');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('OPI');
        (new RealisasiKirimSpreadsheet())->rows($sheet);
    }
}
