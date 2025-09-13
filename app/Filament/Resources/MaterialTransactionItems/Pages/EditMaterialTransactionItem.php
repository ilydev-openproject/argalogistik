<?php

namespace App\Filament\Resources\MaterialTransactionItems\Pages;

use App\Filament\Resources\MaterialTransactionItems\MaterialTransactionItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaterialTransactionItem extends EditRecord
{
    protected static string $resource = MaterialTransactionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
