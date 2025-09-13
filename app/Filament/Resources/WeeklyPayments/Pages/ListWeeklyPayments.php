<?php

namespace App\Filament\Resources\WeeklyPayments\Pages;

use App\Filament\Resources\WeeklyPayments\WeeklyPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeeklyPayments extends ListRecords
{
    protected static string $resource = WeeklyPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
