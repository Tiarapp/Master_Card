<?php

namespace Tests\Unit;

use App\Services\RealisasiKirimOpiSelector;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RealisasiKirimOpiSelectorTest extends TestCase
{
    private function opis(array $names): Collection
    {
        return new Collection(array_map(function ($name) {
            return (object) ['nama' => $name];
        }, $names));
    }

    public function test_matching_opi_is_preferred_when_contract_has_multiple(): void
    {
        $result = (new RealisasiKirimOpiSelector())->select($this->opis(['001F', '002F']), '002F');

        $this->assertSame('002F', $result['opi']->nama);
        $this->assertNull($result['substitution']);
    }

    public function test_single_opi_is_suggested_automatically_when_no_match(): void
    {
        $result = (new RealisasiKirimOpiSelector())->select($this->opis(['001F']), '999F');

        $this->assertSame('001F', $result['opi']->nama);
        $this->assertSame('001F', $result['substitution']);
    }

    public function test_multiple_opis_without_match_are_not_selected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new RealisasiKirimOpiSelector())->select($this->opis(['001F', '002F']), '999F');
    }

    public function test_no_opi_cannot_be_selected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new RealisasiKirimOpiSelector())->select($this->opis([]), '');
    }

    public function test_duplicate_matching_opis_are_not_selected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new RealisasiKirimOpiSelector())->select($this->opis(['001F', '001F']), '001F');
    }
}
