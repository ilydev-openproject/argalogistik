<?php

namespace App\Filament\Resources\WeeklyPayments\Pages;

use App\Filament\Resources\WeeklyPayments\WeeklyPaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWeeklyPayment extends EditRecord
{
    protected static string $resource = WeeklyPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
