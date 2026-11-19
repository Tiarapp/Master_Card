<?php

namespace App\Services;

use App\Models\Mastercard;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Validation\ValidationException;

class MastercardFirebirdItemService
{
    public function parseCode(?string $code): array
    {
        $code = trim((string) $code);
        if (!preg_match('/^([LE])([A-Z0-9])([EF])\.([A-Z0-9]{2})\.([A-Z0-9]{2})\.([SW])([0-9]{2})\.([A-Z0-9]{4})([A-Z0-9])\.([A-Z0-9]{3})$/D', $code, $parts)) {
            throw ValidationException::withMessages([
                'generate' => 'Format kode barang Mastercard tidak sesuai. Periksa dan perbaiki kode sebelum generate.',
            ]);
        }

        return [
            'KodeBrg' => $code, 'Tujuan' => $parts[1], 'JenisProd' => $parts[2],
            'Eceran' => $parts[3], 'Merk' => $parts[4], 'Design' => $parts[5],
            'WeightSheet' => $parts[6], 'Packing' => $parts[7], 'WeightValue' => $parts[8],
            'Warna' => $parts[9], 'CustNick' => $parts[10],
        ];
    }

    public function generate(ConnectionInterface $connection, Mastercard $mastercard, array $input): void
    {
        $item = $this->parseCode($mastercard->kodeBarang);
        if (!trim((string) $mastercard->namaBarang)) {
            throw ValidationException::withMessages(['generate' => 'Nama barang Mastercard belum tersedia.']);
        }

        $connection->transaction(function () use ($connection, $mastercard, $input, $item) {
            if ($connection->getDriverName() === 'firebird') {
                $uniqueIndex = $connection->selectOne(
                    'SELECT FIRST 1 i.RDB$INDEX_NAME FROM RDB$INDICES i JOIN RDB$INDEX_SEGMENTS s ON s.RDB$INDEX_NAME = i.RDB$INDEX_NAME
                     WHERE TRIM(i.RDB$RELATION_NAME) = ? AND i.RDB$UNIQUE_FLAG = 1 AND COALESCE(i.RDB$INDEX_INACTIVE, 0) = 0
                     AND TRIM(s.RDB$FIELD_NAME) = ?
                     AND (SELECT COUNT(*) FROM RDB$INDEX_SEGMENTS x WHERE x.RDB$INDEX_NAME = i.RDB$INDEX_NAME) = 1',
                    ['TBarangConv', 'KodeBrg']
                );
                if (!$uniqueIndex) {
                    throw ValidationException::withMessages([
                        'generate' => 'Generate dibatalkan: database Firebird harus memiliki indeks unik aktif pada TBarangConv.KodeBrg untuk mencegah duplikat.',
                    ]);
                }
            }
            $existing = $connection->table('TBarangConv')->where('KodeBrg', $item['KodeBrg'])->first();
            if ($existing) {
                throw ValidationException::withMessages([
                    'generate' => 'Kode barang sudah ada di Firebird: ' . $existing->KodeBrg . ' - ' . $existing->NamaBrg . '. Tidak ada data yang diubah.',
                ]);
            }
            if ($connection->table('TPersediaan')->where('KodeBrg', $item['KodeBrg'])->exists()) {
                throw ValidationException::withMessages(['generate' => 'Persediaan untuk kode ini sudah ada di Firebird. Periksa data sebelum generate.']);
            }

            foreach (['TProdConv' => 'JenisProd', 'TMerkConv' => 'Merk', 'TWarnaConv' => 'Warna'] as $table => $field) {
                if (!$connection->table($table)->where('Kode', $item[$field])->exists()) {
                    throw ValidationException::withMessages(['generate' => "Kode {$field} {$item[$field]} tidak ditemukan pada master Firebird."]);
                }
            }

            $connection->table('TBarangConv')->insert(array_merge($item, [
                'NamaBrg' => mb_strtoupper(trim($mastercard->namaBarang)),
                'Satuan' => $input['satuan'], 'IsiPerKarton' => $input['isi'],
                'BeratStandart' => $input['berat'], 'BeratCRT' => $input['beratcrt'],
                'HargaJualRp' => $input['hargajual'], 'HargaJualUSD' => $input['hargausd'],
            ]));
            $connection->table('TPersediaan')->insert([
                'KodeBrg' => $item['KodeBrg'], 'Periode' => date('m/Y'),
                'SaldoAwalCrt' => 0, 'SaldoAwalKg' => 0, 'SaldoAkhirCrt' => 0, 'SaldoAkhirKg' => 0,
            ]);
        });
    }
}
