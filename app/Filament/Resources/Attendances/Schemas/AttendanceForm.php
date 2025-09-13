<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Catat Kehadiran Karyawan')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Isi data kehadiran harian, termasuk lembur.')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('project_id')
                                    ->label('Proyek')
                                    ->relationship('project', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Select::make('employee_id')
                                    ->label('Karyawan')
                                    ->relationship('employee', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('date')
                                    ->label('Tanggal')
                                    ->native(false)
                                    ->required(),
                                Select::make('status')
                                    ->label('Status Kehadiran')
                                    ->native(false)
                                    ->options([
                                        'Hadir Penuh' => 'Hadir Penuh',
                                        'Setengah Hari' => 'Setengah Hari',
                                        'Tidak Hadir' => 'Tidak Hadir',
                                    ])
                                    ->required(),
                                TextInput::make('overtime_hours')
                                    ->label('Lembur (Jam)')
                                    ->numeric()
                                    ->placeholder('Contoh: 1 atau 0.5')
                                    ->nullable(),
                            ]),
                    ]),
            ]);
    }
}
