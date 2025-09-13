<?php

namespace App\Filament\Resources\Projects\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Projects\ProjectResource;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('Summary')
                ->label('Laporan Ringkasan')
                ->icon('heroicon-o-chart-pie')
                ->url(fn() => ProjectResource::getUrl('summary', ['record' => $this->record])),
            // Action::make('Absensi')
            //     ->label('Absensi Harian')
            //     ->icon('heroicon-o-clipboard-document-check')
            //     ->url(fn() => ProjectResource::getUrl('attendance', ['record' => $this->record])),
        ];
    }
}
