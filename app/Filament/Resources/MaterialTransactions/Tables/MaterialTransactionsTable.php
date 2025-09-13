<?php

namespace App\Filament\Resources\MaterialTransactions\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;

class MaterialTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nama proyek
                TextColumn::make('project.name')
                    ->label('Proyek')
                    ->sortable(),

                // Nama toko (diulang untuk setiap item)
                TextColumn::make('store_name')
                    ->label('Nama Toko')
                    ->sortable(),

                // Tanggal transaksi (diulang untuk setiap item)
                TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                // Menampilkan catatan (diulang untuk setiap item)
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->sortable(),

                // Menampilkan item transaksi di setiap baris terpisah
                TextColumn::make('item_description')
                    ->label('Item Transaksi')
                    ->getStateUsing(function ($record) {
                        // Ambil data item terkait
                        $items = $record->items; // Relasi ke item
                        $output = '';

                        // Looping untuk setiap item dan menampilkan baris terpisah
                        foreach ($items as $item) {
                            $output .= "<div><strong>{$item->item_description}</strong> - {$item->quantity} {$item->unit} - " .
                                "Rp " . number_format($item->total_price, 0, ',', '.') . "</div>";
                        }

                        return $output;
                    })
                    ->html() // Menampilkan HTML
                    ->sortable(),

                // **Total Belanja** (menampilkan total harga semua item)
                TextColumn::make('items_sum_total_price')
                    ->label('Total Belanja')
                    ->getStateUsing(function ($record) {
                        return $record->items->sum('total_price');
                    })
                    ->money('idr')
                    ->sortable(),
                ImageColumn::make('receipt_photo')
                    ->disk('receipts')
                    ->label('Nota'),
            ])
            ->filters([
                Filter::make('transaction_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->native(false),
                        DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('transaction_date', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('transaction_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('7xl'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
