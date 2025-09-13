<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\MaterialTransactionItem;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MaterialTransactionsItemExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithEvents
{
    private $project;
    private $row = 1;
    private $images = [];

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function collection()
    {
        $items = MaterialTransactionItem::whereHas('transaction', function ($q) {
            $q->where('project_id', $this->project->id);
        })->with(['transaction.project'])->get();

        foreach ($items as $index => $item) {
            if ($item->transaction->receipt_photo) {
                $this->images[$index] = storage_path('app/public/' . $item->transaction->receipt_photo);
            }
        }

        return $items;
    }

    public function map($item): array
    {
        $this->row++;

        return [
            Carbon::parse($item->transaction->transaction_date)->format('d-m-Y'),
            $item->item_description,
            $item->unit,
            (float) $item->quantity,
            (float) $item->unit_price,
            (float) ($item->discount_amount ?? 0),
            (float) $item->total_price,
            $item->transaction->store_name ?? '-',
            '', // kolom foto
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Item',
            'Satuan',
            'Qty',
            'Harga Satuan',
            'Diskon',
            'Total Price',
            'Nama Toko',
            'Nota',
        ];
    }

    public function drawings()
    {
        $drawings = [];

        $logoPath = public_path('logo.png'); // letakkan logo di /public/logo.png
        if (file_exists($logoPath)) {
            $logo = new Drawing();
            $logo->setPath($logoPath);
            $logo->setHeight(80); // atur tinggi logo
            $logo->setCoordinates('A1');
            $drawings[] = $logo;
        }

        foreach ($this->images as $index => $path) {
            if (file_exists($path)) {
                $drawing = new Drawing();
                $drawing->setPath($path);
                $drawing->setHeight(80);
                $drawing->setCoordinates('I' . ($index + 2)); // karena tabel mulai di baris 12
                $drawings[] = $drawing;
            }
        }
        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tambahkan space 10 baris di atas
                $sheet->insertNewRowBefore(1, 10);

                // 🔹 Kop Laporan
                $sheet->setCellValue('B1', 'CV. ARGA JAYA KONSTRUKSI');
                $sheet->mergeCells('B1:I1');
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal('left');

                $sheet->setCellValue('B2', 'Office, Jl. Sukun Raya, Jatisari, RT1 RW2, Peganjaran, Bae, Kudus');
                $sheet->mergeCells('B2:I2');
                $sheet->getStyle('B2')->getAlignment()->setHorizontal('left');

                $sheet->setCellValue('B3', 'Telp 081311603422   email: argaarchitect@gmail.com');
                $sheet->mergeCells('B3:I3');
                $sheet->getStyle('B3')->getAlignment()->setHorizontal('left');

                $sheet->setCellValue('A5', 'LAPORAN KEUANGAN PROYEK');
                $sheet->mergeCells('A5:I5');
                $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');

                $sheet->setCellValue('A6', 'No: 001/AJK-LKP-J/III/' . now()->year);
                $sheet->mergeCells('A6:I6');
                $sheet->getStyle('A6')->getAlignment()->setHorizontal('center');

                // 🔹 Info proyek
                $sheet->setCellValue('A8', 'PROYEK : ' . ($this->project->name ?? '-'));
                $sheet->setCellValue('E8', 'OWNER : ' . ($this->project->client_name ?? '-'));
                $sheet->setCellValue('A9', 'LOKASI : ' . ($this->project->location ?? '-'));
                $sheet->setCellValue('E9', 'TAHUN : ' . now()->year);
                $sheet->setCellValue('A10', 'BULAN : ' . strtoupper(now()->translatedFormat('F')));

                // 🔹 Style Heading tabel
                $sheet->getStyle('A11:I11')->getFont()->setBold(true);
                $sheet->getStyle('A11:I11')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A11:I11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // 🔹 Auto width semua kolom
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // 🔹 Border untuk isi tabel
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A12:I' . $highestRow)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Format angka dengan ribuan separator
                $sheet->getStyle('F12:I' . $highestRow)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Rata kanan untuk angka
                $sheet->getStyle('F12:I' . $highestRow)
                    ->getAlignment()
                    ->setHorizontal('right');
            },
        ];
    }
}
