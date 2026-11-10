<?php

namespace App\Exports;

use App\Models\ExportRequest;
use App\Models\Opi_M;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Throwable;

class OpiHistoryQueuedExport implements FromQuery, WithMapping, WithHeadings, WithCustomChunkSize, WithEvents, ShouldQueue
{
    public $timeout = 900;
    public $tries = 1;

    private $filters;
    private $exportRequestId;

    public function __construct(array $filters, int $exportRequestId)
    {
        $this->filters = $filters;
        $this->exportRequestId = $exportRequestId;
    }

    public function chunkSize(): int
    {
        return 250;
    }

    public function query()
    {
        $f = $this->filters;

        $query = Opi_M::query()
            ->with([
                'kontrakm',
                'dt',
                'kontrakd.mc.colorcombine',
                'kontrakd.mc.box',
                'kontrakd.mc.substanceproduksi.lineratas',
                'kontrakd.mc.substanceproduksi.flute1',
                'kontrakd.mc.substanceproduksi.linertengah',
                'kontrakd.mc.substanceproduksi.flute2',
                'kontrakd.mc.substanceproduksi.linerbawah',
                'kontrakd.mc.substancekontrak.lineratas',
                'kontrakd.mc.substancekontrak.flute1',
                'kontrakd.mc.substancekontrak.linertengah',
                'kontrakd.mc.substancekontrak.flute2',
                'kontrakd.mc.substancekontrak.linerbawah',
            ])
            ->whereIn('status_opi', ['Proses', 'closed']);

        if (!empty($f['search'])) {
            $search = $f['search'];
            $query->where(function ($query) use ($search) {
                $query->whereHas('kontrakm', function ($q) use ($search) {
                    $q->where('customer_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('poCustomer', 'LIKE', '%' . $search . '%')
                        ->orWhere('kode', 'LIKE', '%' . $search . '%');
                })
                    ->orWhere('NoOPI', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('mc', function ($q) use ($search) {
                        $q->where('kode', 'LIKE', '%' . $search . '%')
                            ->orWhere('namaBarang', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        if (!empty($f['warna'])) {
            $warna = $f['warna'];
            $query->whereHas('mc.colorcombine', function ($q) use ($warna) {
                $q->where('nama', 'LIKE', '%' . $warna . '%');
            });
        }

        if (!empty($f['date_start'])) {
            $query->whereDate('updated_at', '>=', $f['date_start']);
        }

        if (!empty($f['date_end'])) {
            $query->whereDate('updated_at', '<=', $f['date_end']);
        }

        // id sebagai pembeda terakhir agar pembagian per bagian tidak menggandakan/melewatkan baris
        return $query->orderBy('updated_at', 'desc')
            ->orderBy('NoOPI', 'desc')
            ->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return (new OpiExport([]))->headings();
    }

    public function map($item): array
    {
        try {
            return array_values((new OpiExport([]))->row($item));
        } catch (Throwable $e) {
            report($e);

            return [$item->id, $item->NoOPI, 'Data tidak lengkap: ' . $e->getMessage()];
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                for ($row = 2; $row <= $lastRow; $row++) {
                    $status = strtolower(trim((string) $sheet->getCell('C' . $row)->getValue()));
                    $color = $status === 'proses' ? '198754' : ($status === 'complete' ? '0D6EFD' : null);

                    if ($color) {
                        $style = $sheet->getStyle('C' . $row);
                        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
                        $style->getFont()->getColor()->setRGB('FFFFFF');
                    }
                }
            },
        ];
    }

    public function failed(Throwable $e): void
    {
        report($e);

        ExportRequest::whereKey($this->exportRequestId)->update([
            'status' => ExportRequest::FAILED,
            'error' => mb_substr($e->getMessage(), 0, 500),
            'updated_at' => now(),
        ]);
    }
}
