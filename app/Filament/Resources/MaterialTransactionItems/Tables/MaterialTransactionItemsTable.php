<?php

namespace App\Filament\Resources\MaterialTransactionItems\Tables;

use App\Exports\MaterialTransactionsItemExport;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;

class MaterialTransactionItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction.project.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('transaction.store_name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('transaction.transaction_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('item_description')
                    ->label('Item')
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->money('idr')
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->label('Diskon')
                    ->money('idr')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->numeric()
                    ->money('idr')
                    ->sortable(),
                ImageColumn::make('transaction.receipt_photo')
                    ->label('Nota')
                    ->disk('receipts'),
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
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
