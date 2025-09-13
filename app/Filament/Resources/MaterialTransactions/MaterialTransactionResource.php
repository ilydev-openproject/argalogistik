<?php

namespace App\Filament\Resources\MaterialTransactions;

use UnitEnum;
use App\Filament\Resources\MaterialTransactions\Pages\ListMaterialTransactions;
use App\Filament\Resources\MaterialTransactions\Schemas\MaterialTransactionForm;
use App\Filament\Resources\MaterialTransactions\Tables\MaterialTransactionsTable;
use App\Models\MaterialTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaterialTransactionResource extends Resource
{
    protected static ?string $model = MaterialTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;
    protected static string|UnitEnum|null $navigationGroup = 'Material';
    protected static ?string $modelLabel = 'Logistik';
    protected static ?string $pluralModelLabel = 'Logistik';

    protected static ?string $recordTitleAttribute = 'Logistik';

    public static function form(Schema $schema): Schema
    {
        return MaterialTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialTransactionsTable::configure($table);
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
            'index' => ListMaterialTransactions::route('/'),
            // 'create' => CreateMaterialTransaction::route('/create'),
            // 'edit' => EditMaterialTransaction::route('/{record}/edit'),
        ];
    }
}
