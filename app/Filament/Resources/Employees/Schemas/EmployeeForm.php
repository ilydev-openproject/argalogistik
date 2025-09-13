<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Karyawan')
                    ->icon('heroicon-o-user')
                    ->columnSpanFull()
                    ->description('Masukkan data dasar karyawan dan upah harian.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Karyawan')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('role')
                                    ->label('Peran')
                                    ->native(false)
                                    ->options([
                                        'mandor' => 'Mandor',
                                        'tukang' => 'Tukang',
                                        'kenek' => 'Kenek',
                                    ])
                                    ->required(),
                                TextInput::make('upah_harian')
                                    ->label('Upah Harian')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ])
                    ]),
            ]);
    }
}
