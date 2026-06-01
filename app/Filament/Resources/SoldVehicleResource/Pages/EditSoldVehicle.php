<?php

namespace App\Filament\Resources\SoldVehicleResource\Pages;

use App\Filament\Resources\SoldVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoldVehicle extends EditRecord
{
    protected static string $resource = SoldVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            \App\Filament\Actions\VehicleContractPdfAction::page(),
            $this->getCancelFormAction(),
        ];
    }
}
