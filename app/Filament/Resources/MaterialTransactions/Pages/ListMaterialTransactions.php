<?php

namespace App\Filament\Resources\MaterialTransactions\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use App\Filament\Resources\MaterialTransactions\MaterialTransactionResource;

class ListMaterialTransactions extends ListRecords
{
    protected static string $resource = MaterialTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('7xl'),
        ];
    }
}
