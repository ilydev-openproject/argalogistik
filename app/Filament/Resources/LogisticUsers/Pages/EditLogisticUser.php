<?php

namespace App\Filament\Resources\LogisticUsers\Pages;

use App\Filament\Resources\LogisticUsers\LogisticUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLogisticUser extends EditRecord
{
    protected static string $resource = LogisticUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
