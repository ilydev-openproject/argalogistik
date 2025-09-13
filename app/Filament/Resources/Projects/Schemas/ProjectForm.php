<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Proyek & Klien')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Proyek')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('location')
                            ->label('Lokasi Proyek')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_name')
                            ->label('Nama Klien')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_address')
                            ->label('Alamat Klien')
                            ->nullable()
                            ->maxLength(255),
                        TextInput::make('total_rab')
                            ->label('Total RAB')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                    ])->columns(2),
            ]);
    }
}
