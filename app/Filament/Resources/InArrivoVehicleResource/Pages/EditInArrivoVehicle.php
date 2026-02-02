<?php

namespace App\Filament\Resources\InArrivoVehicleResource\Pages;

use App\Filament\Resources\InArrivoVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInArrivoVehicle extends EditRecord
{
    protected static string $resource = InArrivoVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
