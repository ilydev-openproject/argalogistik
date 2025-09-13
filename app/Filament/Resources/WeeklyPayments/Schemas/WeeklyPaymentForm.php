<?php

namespace App\Filament\Resources\WeeklyPayments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class WeeklyPaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->label('Proyek')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('week_number')
                    ->label('Minggu ke-')
                    ->numeric()
                    ->required(),
                TextInput::make('paid_amount')
                    ->label('Jumlah Dibayarkan')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                TextInput::make('total_allowance')
                    ->label('Total Tunjangan')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                TextInput::make('total_advance')
                    ->label('Total Bon')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                DatePicker::make('paid_date')
                    ->label('Tanggal Pembayaran')
                    ->required(),
            ]);
    }
}
