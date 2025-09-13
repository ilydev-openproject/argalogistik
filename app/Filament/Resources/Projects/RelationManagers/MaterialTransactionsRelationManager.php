<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use App\Models\MaterialTransaction;
use Filament\Schemas\Components\Grid;
use App\Models\MaterialTransactionItem;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\MaterialTransactions\MaterialTransactionResource;
use Filament\Forms\Components\Textarea;

class MaterialTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'materialTransactions';

    protected static ?string $relatedResource = MaterialTransactionResource::class;
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Nota')
                    ->columns(2)
                    ->schema([
                        TextInput::make('store_name')
                            ->label('Nama Toko')
                            ->required(),
                        DatePicker::make('transaction_date')
                            ->label('Tanggal')
                            ->native(false)
                            ->required(),
                        Grid::make()
                            ->columnSpanFull()
                            ->schema([
                                FileUpload::make('receipt_photo')
                                    ->label('Foto Nota')
                                    ->disk('receipts')
                                    ->image()
                                    ->nullable(),
                                Textarea::make('notes')
                                    ->label('Keterangan')
                            ]),
                    ]),

                Repeater::make('items')
                    ->label('Daftar Item Belanja')
                    ->relationship('items')
                    ->schema([
                        TextInput::make('item_description')
                            ->label('Uraian')
                            ->required()
                            ->columnSpan(2), // lebih lebar

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('quantity')
                            ->label('Vol')
                            ->numeric()
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, $set, $get) =>
                                $set('total_price', ($get('quantity') * $get('unit_price')) - $get('discount_amount'))
                            )
                            ->columnSpan(1),

                        TextInput::make('unit_price')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, $set, $get) =>
                                $set('total_price', ($get('quantity') * $get('unit_price')) - $get('discount_amount'))
                            )
                            ->columnSpan(1),

                        TextInput::make('discount_amount')
                            ->label('Diskon')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, $set, $get) =>
                                $set('total_price', ($get('quantity') * $get('unit_price')) - $get('discount_amount'))
                            )
                            ->columnSpan(1),

                        TextInput::make('total_price')
                            ->label('Total Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->readOnly()
                            ->columnSpan(1),
                    ])
                    ->columns(7) // grid 7 kolom biar muat dengan span
                    ->defaultItems(1)
                    ->collapsible()
            ])
            ->columns(1);
    }
    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->modalWidth('7xl'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('7xl'), // perbesar modal edit
            ]);
    }
}
