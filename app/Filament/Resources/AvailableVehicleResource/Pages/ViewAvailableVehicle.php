<?php

namespace App\Filament\Resources\AvailableVehicleResource\Pages;

use App\Filament\Resources\AvailableVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAvailableVehicle extends ViewRecord
{
    protected static string $resource = AvailableVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
