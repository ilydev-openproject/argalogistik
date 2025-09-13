<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\Employee;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Employees\EmployeeResource;
use Filament\Resources\RelationManagers\RelationManager;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';
    protected static ?string $title = 'Tim Proyek';
    protected static ?string $relatedResource = EmployeeResource::class;
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Karyawan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Peran')
                    ->sortable()
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('upah_harian')
                    ->label('Upah Harian')
                    ->money('idr')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->label('Tambah Karyawan')
                    ->modalHeading('Tambah Karyawan ke Proyek')
                    // ->recordSelectSearchColumns(['name', 'role'])
                    ->modalSubmitActionLabel('Tambahkan')
                    ->attachAnother(false)
                    // ->preloadRecordSelect()
                    ->recordSelect(
                        fn(Select $select, RelationManager $livewire) => $select
                            ->label('Pilih Karyawan')
                            ->placeholder('Pilih karyawan')
                            ->options(
                                fn(): array => Employee::query()
                                    ->whereDoesntHave('projects')
                                    ->get() // Ambil seluruh objek Employee
                                    ->mapWithKeys(fn($employee) => [$employee->id => $employee->full_name]) // Gunakan mapWithKeys
                                    ->toArray()
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                    ),
                Action::make('absensi')
                    ->label('Absensi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->url(
                        fn(RelationManager $livewire): string =>
                        \App\Filament\Resources\Projects\ProjectResource::getUrl(
                            'attendance',
                            ['record' => $livewire->getOwnerRecord()->id] // kirim ID project
                        )
                    ),
            ])
            ->actions([
                DetachAction::make()
                    ->label('Hapus dari Proyek')
                    ->modalHeading('Hapus Karyawan dari Proyek') // Ganti judul modal konfirmasi
                    ->modalSubmitActionLabel('Hapus'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
