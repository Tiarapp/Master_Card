<?php

namespace App\Services;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class RealisasiKirimOpiSelector
{
    public function select(Collection $opis, string $number): array
    {
        $matched = $opis->filter(function ($opi) use ($number) {
            return $number !== '' && strcasecmp(trim($opi->nama), $number) === 0;
        });
        if ($matched->count() > 1) {
            throw new InvalidArgumentException('Nomor OPI tidak unik pada kontrak: ' . $number . '.');
        }
        if ($matched->count() === 1) {
            return ['opi' => $matched->first(), 'substitution' => null];
        }
        if ($opis->count() === 1) {
            $opi = $opis->first();
            return ['opi' => $opi, 'substitution' => $opi->nama];
        }

        throw new InvalidArgumentException('OPI tidak cocok; kontrak memiliki ' . $opis->count() . ' OPI yang dapat dipilih. Periksa kolom OPI.');
    }
}
