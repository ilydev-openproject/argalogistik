<?php

namespace App\Filament\Resources\MaterialTransactionItems\Pages;

use App\Filament\Resources\MaterialTransactionItems\MaterialTransactionItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialTransactionItems extends ListRecords
{
    protected static string $resource = MaterialTransactionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
