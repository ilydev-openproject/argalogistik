<?php

namespace App\Filament\Resources\WeeklyPayments;

use App\Filament\Resources\WeeklyPayments\Pages\CreateWeeklyPayment;
use App\Filament\Resources\WeeklyPayments\Pages\EditWeeklyPayment;
use App\Filament\Resources\WeeklyPayments\Pages\ListWeeklyPayments;
use App\Filament\Resources\WeeklyPayments\Schemas\WeeklyPaymentForm;
use App\Filament\Resources\WeeklyPayments\Tables\WeeklyPaymentsTable;
use App\Models\WeeklyPayment;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WeeklyPaymentResource extends Resource
{
    protected static ?string $model = WeeklyPayment::class;
    protected static string|UnitEnum|null $navigationGroup = 'Tim';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?string $modelLabel = 'Pembayaran Tim';

    protected static ?string $recordTitleAttribute = 'Gaji Mingguan';

    public static function form(Schema $schema): Schema
    {
        return WeeklyPaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeeklyPaymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWeeklyPayments::route('/'),
            // 'create' => CreateWeeklyPayment::route('/create'),
            // 'edit' => EditWeeklyPayment::route('/{record}/edit'),
        ];
    }
}
