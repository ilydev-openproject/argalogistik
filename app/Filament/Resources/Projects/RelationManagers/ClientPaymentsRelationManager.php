<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\ClientPayments\ClientPaymentResource;

class ClientPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'clientPayments';

    protected static ?string $relatedResource = ClientPaymentResource::class;

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Informasi Pembayaran')
                    ->icon('heroicon-o-banknotes')
                    ->description('Isi detail pembayaran yang diterima dari klien.')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('step')
                            ->label('Tahap Pembayaran ke-')
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
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('step')
                    ->label('Tahap ke-')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('idr')
                    ->sortable(),
                TextColumn::make('paid_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                ImageColumn::make('proof_of_transfer')
                    ->label('Bukti Transfer'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Buat Pembayaran Baru')
                    ->modalHeading('Buat Pembayaran Klien'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
