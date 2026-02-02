<?php

namespace App\Filament\Resources\ArchivedVehicleResource\Pages;

use App\Filament\Resources\ArchivedVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArchivedVehicle extends ViewRecord
{
    protected static string $resource = ArchivedVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
