<?php

namespace App\Filament\Resources\WeeklyPayments\Tables;

use App\Models\Project;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;

class WeeklyPaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Proyek')
                    ->sortable(),
                TextColumn::make('week_number')
                    ->label('Minggu ke-')
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->label('Jumlah Bayar')
                    ->money('idr')
                    ->sortable(),
                TextColumn::make('total_allowance')
                    ->label('Tunjangan')
                    ->money('idr'),
                TextColumn::make('total_advance')
                    ->label('Bon')
                    ->money('idr'),
                TextColumn::make('paid_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('project_id')
                    ->label('Proyek')
                    ->options(Project::pluck('name', 'id'))
                    ->searchable()
                    ->native(false),

                // Filter berdasarkan rentang tanggal
                Filter::make('paid_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('Dari tanggal')
                            ->native(false),
                        DatePicker::make('until')
                            ->label('Sampai tanggal')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('paid_date', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('paid_date', '<=', $data['until']));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
