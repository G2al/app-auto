<?php

namespace App\Filament\Resources\ArchivedVehicleResource\Pages;

use App\Filament\Resources\ArchivedVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListArchivedVehicles extends ListRecords
{
    protected static string $resource = ArchivedVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            '2025' => Tab::make('2025')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('archive_date', 2025)),
            '2026' => Tab::make('2026')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('archive_date', 2026)),
        ];
    }
}
