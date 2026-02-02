<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVehicle extends CreateRecord
{
    protected static string $resource = VehicleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Rimuoviamo i file dai dati principali del veicolo
        unset($data['libretto_files'], $data['riparazione_files'], $data['atto_vendita_files']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->saveDocuments();
    }

    private function saveDocuments(): void
    {
        $data = $this->form->getState();
        
        // Salva libretto
        if (isset($data['libretto_files'])) {
            $this->saveDocumentCategory('libretto', $data['libretto_files']);
        }
        
        // Salva riparazione
        if (isset($data['riparazione_files'])) {
            $this->saveDocumentCategory('riparazione', $data['riparazione_files']);
        }
        
        // Salva atto vendita
        if (isset($data['atto_vendita_files'])) {
            $this->saveDocumentCategory('atto_vendita', $data['atto_vendita_files']);
        }
    }

    private function saveDocumentCategory(string $category, array $files): void
    {
        foreach ($files as $file) {
            $this->record->documents()->create([
                'category' => $category,
                'filename' => basename($file),
                'original_name' => basename($file),
                'file_path' => $file,
                'file_type' => str_contains(mime_content_type(storage_path('app/public/' . $file)), 'image') ? 'image' : 'pdf',
                'mime_type' => mime_content_type(storage_path('app/public/' . $file)),
                'file_size' => filesize(storage_path('app/public/' . $file)),
                'is_auto_generated' => false,
            ]);
        }
    }
}