<?php

namespace App\Filament\Resources\LogisticUsers\Pages;

use App\Filament\Resources\LogisticUsers\LogisticUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogisticUsers extends ListRecords
{
    protected static string $resource = LogisticUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
