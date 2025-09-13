<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Carbon\Carbon;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Exports\MaterialTransactionsItemExport;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\MaterialTransactionItems\MaterialTransactionItemResource;

class MaterialTransactionItemRelationManager extends RelationManager
{
    protected static string $relationship = 'materialTransactionItems';
    protected static ?string $title = 'Item Logistik';

    protected static ?string $relatedResource = MaterialTransactionItemResource::class;
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Informasi Nota')
                    ->columns(2)
                    ->schema([
                        TextInput::make('store_name')->label('Nama Toko')->required(),
                        DatePicker::make('transaction_date')->label('Tanggal')->native(false)->required(),
                        FileUpload::make('receipt_photo')->label('Foto Nota')->image()->columnSpanFull()->nullable(),
                    ]),

                Repeater::make('items')
                    ->label('Daftar Item Belanja')
                    ->relationship('transaction')
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
                            ->live()
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
                            ->live(debounce: 500)
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
                            ->live(debounce: 500)
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
                Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        $project = $this->getOwnerRecord(); // 👈 ambil parent Project dari Relation Manager
                        return Excel::download(
                            new MaterialTransactionsItemExport($project),
                            'laporan-proyek-' . $project->name . '-' . Carbon::now() . '.xlsx'
                        );
                    }),
            ]);
    }
}
