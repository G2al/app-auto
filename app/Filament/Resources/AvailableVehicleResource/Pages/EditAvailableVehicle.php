<?php

namespace App\Filament\Resources\AvailableVehicleResource\Pages;

use App\Filament\Resources\AvailableVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvailableVehicle extends EditRecord
{
    protected static string $resource = AvailableVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
