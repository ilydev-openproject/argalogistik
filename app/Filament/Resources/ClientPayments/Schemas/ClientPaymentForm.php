<?php

namespace App\Filament\Resources\ClientPayments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class ClientPaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pembayaran')
                    ->icon('heroicon-o-banknotes')
                    ->description('Isi detail pembayaran yang diterima dari klien.')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('project_id')
                            ->label('Proyek')
                            ->relationship('project', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('step')
                            ->label('Tahap Pembayaran ke-')
                            ->numeric()
                            ->required(),
                        TextInput::make('amount')
                            ->label('Jumlah')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        DatePicker::make('paid_date')
                            ->label('Tanggal Pembayaran')
                            ->native(false)
                            ->required(),
                        FileUpload::make('proof_of_transfer')
                            ->label('Bukti Transfer')
                            ->image()
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
