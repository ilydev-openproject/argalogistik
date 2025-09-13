<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\MaterialTransaction;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialTransactionsExport implements FromCollection, WithHeadings, WithMapping, WithDrawings
{
    private $row = 1;
    private $images = [];

    public function collection()
    {
        $data = MaterialTransaction::all();
        foreach ($data as $index => $trx) {
            if ($trx->receipt_photo) {
                $this->images[$index] = storage_path('app/public/' . $trx->receipt_photo);
            }
        }
        return $data;
    }

    public function map($transaction): array
    {
        $this->row++; // keep track row
        return [
            $transaction->project->name ?? '-',
            Carbon::parse($transaction->transaction_date)->format('d-m-Y'),
            $transaction->store_name,
            $transaction->notes,
            $transaction->items->map(fn($i) => $i->item_description)->join(", "),
            $transaction->items->sum('total_price'),
            'foto di kolom', // placeholder
        ];
    }

    public function headings(): array
    {
        return ['Proyek', 'Tanggal', 'Nama Toko', 'Catatan', 'Item', 'Total Belanja', 'Nota'];
    }

    public function drawings()
    {
        $drawings = [];
        foreach ($this->images as $index => $path) {
            if (file_exists($path)) {
                $drawing = new Drawing();
                $drawing->setPath($path);
                $drawing->setHeight(80);
                $drawing->setCoordinates('G' . ($index + 2)); // kolom G, mulai baris ke-2
                $drawings[] = $drawing;
            }
        }
        return $drawings;
    }
}
