<?php

namespace App\Services;

use App\Models\AlokasiKaret;
use App\Models\Karet;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Mastercard;
use App\Models\Opi_M;
use App\Models\RealisasiKirim;
use App\Models\Tracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Throwable;

class RealisasiKirimImporter
{
    private $opiSelector;

    public function __construct(RealisasiKirimOpiSelector $opiSelector)
    {
        $this->opiSelector = $opiSelector;
    }

    public function import(array $rows, string $user): array
    {
        $result = ['imported' => 0, 'duplicates' => 0, 'duplicate_rows' => [], 'errors' => [], 'substitutions' => []];

        foreach ($rows as $row) {
            $rowContext = 'Baris ' . $row['row'] . ' (SJ: ' . ($row['sj'] !== '' ? $row['sj'] : '(kosong)') .
                ', Kontrak: ' . ($row['kontrak'] !== '' ? $row['kontrak'] : '(kosong)') . ')';
            if ($row['errors']) {
                $result['errors'][] = $rowContext . ': ' . implode(' ', $row['errors']);
                continue;
            }

            try {
                $outcome = DB::transaction(function () use ($row, $user) {
                    return $this->importRow($row, $user);
                });
                if ($outcome['duplicate']) {
                    $result['duplicates']++;
                    $result['duplicate_rows'][] = 'Baris ' . $row['row'] . ': SJ ' . $row['sj'] . ', kontrak ' . $row['kontrak'] . '.';
                } else {
                    $result['imported']++;
                    if ($outcome['substitution']) {
                        $result['substitutions'][] = 'Baris ' . $row['row'] . ': OPI ' .
                            ($row['opi'] ?: '(kosong)') . ' diganti menjadi ' . $outcome['substitution'] . '.';
                    }
                }
            } catch (ValidationException $e) {
                $result['errors'][] = $rowContext . ': ' . implode(' ', $e->validator->errors()->all());
            } catch (Throwable $e) {
                report($e);
                $result['errors'][] = $rowContext . ': gagal disimpan karena kesalahan sistem. Periksa log aplikasi.';
            }
        }

        return $result;
    }

    private function importRow(array $row, string $user): array
    {
        $contracts = Kontrak_M::where('kode', $row['kontrak'])->whereNull('deletedAt')->lockForUpdate()->get();
        if ($contracts->count() !== 1) {
            $this->fail('Kontrak tidak ditemukan atau nomor kontrak tidak unik: ' . $row['kontrak'] . '.');
        }
        $contract = $contracts->first();

        if (RealisasiKirim::where('kontrak_m_id', $contract->id)->where('nomer_sj', $row['sj'])->exists()) {
            return ['duplicate' => true, 'substitution' => null];
        }

        $opis = Opi_M::where('kontrak_m_id', $contract->id)
            ->whereNull('deletedAt')
            ->where('nama', 'not like', '%CANCEL%')
            ->where('nama', '!=', 'PENDING')
            ->lockForUpdate()
            ->get();
        try {
            $selection = $this->opiSelector->select($opis, $row['opi']);
        } catch (InvalidArgumentException $e) {
            $this->fail($e->getMessage());
        }
        $opi = $selection['opi'];
        $substitution = $selection['substitution'];

        $details = Kontrak_D::where('kontrak_m_id', $contract->id)->whereNull('deletedAt')->lockForUpdate()->get();
        if ($details->count() !== 1) {
            $this->fail('Kontrak harus memiliki tepat satu detail untuk menghitung sisa dan status realisasi.');
        }
        $detail = $opi->kontrak_d_id ? $details->firstWhere('id', $opi->kontrak_d_id) : ($details->count() === 1 ? $details->first() : null);
        if (!$detail || ($opi->mc_id && $opi->mc_id != $detail->mc_id)) {
            $this->fail('Detail kontrak untuk OPI tidak ditemukan atau tidak sesuai.');
        }
        if ($detail->pcsKontrak === null) {
            $this->fail('Jumlah kontrak atau sisa kirim belum tersedia.');
        }
        $mc = Mastercard::find($detail->mc_id);
        if (!$mc || $mc->gramSheetBoxKontrak === null) {
            $this->fail('Mastercard atau berat standar kontrak tidak ditemukan.');
        }

        $qty = $row['qty'];
        RealisasiKirim::create([
            'kontrak_m_id' => $contract->id,
            'opi_id' => $opi->id,
            'tanggal_kirim' => $row['tanggal'],
            'nomer_sj' => $row['sj'],
            'mod' => $row['mod'],
            'qty_kirim' => $qty,
            'kg_kirim' => $qty * $mc->gramSheetBoxKontrak,
            'createdBy' => $user,
        ]);

        $opi->pcsDt = $opi->pcsDt + $qty;
        if ($opi->jumlahOrder <= $opi->pcsDt) {
            $opi->status_opi = 'closed';
        }
        $opi->timestamps = false;
        $opi->save();

        $karet = Karet::where('mc_id', $detail->mc_id)->orderBy('id', 'desc')->lockForUpdate()->first();
        if ($karet) {
            $allocation = $karet->gsm * $karet->alokasi * $qty;
            AlokasiKaret::create([
                'karet_id' => $karet->id,
                'mc_id' => $detail->mc_id,
                'tanggal_kirim' => $row['tanggal'],
                'pcs' => $qty,
                'alokasi_harga' => $allocation,
            ]);
            $karet->sisa = $karet->sisa - $allocation;
            $karet->save();
        }

        $detail->pcsSisaKirim = $detail->pcsSisaKirim - $qty;
        $detail->save();

        Tracking::create([
            'user' => $user,
            'tipe' => 'Realisasi Kirim',
            'event' => 'Tambah Realisasi Kirim SJ ' . $row['sj'] . ' (import Excel)',
            'before' => '-',
            'after' => 'SJ: ' . $row['sj'] . ', Qty: ' . $qty . ' pcs',
        ]);

        if (RealisasiKirim::where('kontrak_m_id', $contract->id)->sum('qty_kirim') >= $detail->pcsKontrak) {
            $contract->status = 3;
            $contract->save();
            DB::table('opi_m')->where('kontrak_m_id', $contract->id)->update(['status_opi' => 'closed']);
        }

        return ['duplicate' => false, 'substitution' => $substitution];
    }

    private function fail(string $message): void
    {
        throw ValidationException::withMessages(['row' => $message]);
    }
}
