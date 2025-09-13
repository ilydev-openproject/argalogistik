<?php

namespace App\Filament\Resources\LogisticUsers;

use App\Filament\Resources\LogisticUsers\Pages\CreateLogisticUser;
use App\Filament\Resources\LogisticUsers\Pages\EditLogisticUser;
use App\Filament\Resources\LogisticUsers\Pages\ListLogisticUsers;
use App\Filament\Resources\LogisticUsers\Schemas\LogisticUserForm;
use App\Filament\Resources\LogisticUsers\Tables\LogisticUsersTable;
use App\Models\LogisticUser;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LogisticUserResource extends Resource
{
    protected static ?string $model = LogisticUser::class;
    protected static ?string $navigationLabel = 'Pekerja Logistik';
    protected static string|UnitEnum|null $navigationGroup = 'Material';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'LogisticUser';

    public static function form(Schema $schema): Schema
    {
        return LogisticUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogisticUsersTable::configure($table);
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
            'index' => ListLogisticUsers::route('/'),
            // 'create' => CreateLogisticUser::route('/create'),
            // 'edit' => EditLogisticUser::route('/{record}/edit'),
        ];
    }
}
