<?php

namespace App\Filament\Resources\SoldVehicleResource\Pages;

use App\Filament\Resources\SoldVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSoldVehicle extends ViewRecord
{
    protected static string $resource = SoldVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
