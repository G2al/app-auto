<?php

namespace App\Filament\Resources\InArrivoVehicleResource\Pages;

use App\Filament\Resources\InArrivoVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInArrivoVehicles extends ListRecords
{
    protected static string $resource = InArrivoVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
