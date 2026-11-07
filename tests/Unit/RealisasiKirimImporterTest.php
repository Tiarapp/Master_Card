<?php

namespace Tests\Unit;

use App\Services\RealisasiKirimImporter;
use App\Services\RealisasiKirimOpiSelector;
use PHPUnit\Framework\TestCase;

class RealisasiKirimImporterTest extends TestCase
{
    public function test_invalid_row_error_includes_sj_and_contract(): void
    {
        $importer = new RealisasiKirimImporter(new RealisasiKirimOpiSelector());
        $result = $importer->import([
            ['row' => 2, 'sj' => 'SJ-123', 'kontrak' => 'K-456', 'errors' => ['PCS harus diisi.']],
        ], 'tester');

        $this->assertSame(
            ['Baris 2 (SJ: SJ-123, Kontrak: K-456): PCS harus diisi.'],
            $result['errors']
        );
    }

    public function test_missing_sj_and_contract_are_identified(): void
    {
        $importer = new RealisasiKirimImporter(new RealisasiKirimOpiSelector());
        $result = $importer->import([
            ['row' => 3, 'sj' => '', 'kontrak' => '', 'errors' => ['NO SJ wajib diisi.', 'KONTRAK wajib diisi.']],
        ], 'tester');

        $this->assertSame(
            ['Baris 3 (SJ: (kosong), Kontrak: (kosong)): NO SJ wajib diisi. KONTRAK wajib diisi.'],
            $result['errors']
        );
    }
}
