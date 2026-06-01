<?php

namespace App\Filament\Resources\ArchivedVehicleResource\Pages;

use App\Filament\Resources\ArchivedVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArchivedVehicle extends EditRecord
{
    protected static string $resource = ArchivedVehicleResource::class;

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
