<?php

namespace App\Filament\Resources\SoldVehicleResource\Pages;

use App\Filament\Resources\SoldVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoldVehicles extends ListRecords
{
    protected static string $resource = SoldVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
