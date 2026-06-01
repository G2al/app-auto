<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 🚀 OTTIMIZZATO - Una sola query invece di 3
        $documents = $this->record->documents()
            ->select('category', 'file_path')
            ->get()
            ->groupBy('category');

        // Assegna i file per categoria
        $data['libretto_files'] = $documents->get('libretto', collect())->pluck('file_path')->toArray();
        $data['riparazione_files'] = $documents->get('riparazione', collect())->pluck('file_path')->toArray();
        $data['atto_vendita_files'] = $documents->get('atto_vendita', collect())->pluck('file_path')->toArray();
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Rimuoviamo i file dai dati principali del veicolo
        unset($data['libretto_files'], $data['riparazione_files'], $data['atto_vendita_files']);
        return $data;
    }

    protected function afterSave(): void
    {
        $this->saveDocuments();
    }

    private function saveDocuments(): void
    {
        $data = $this->form->getState();
        
        // Prima rimuovi tutti i documenti esistenti
        $this->record->documents()->delete();
        
        // Poi salva i nuovi
        if (isset($data['libretto_files'])) {
            $this->saveDocumentCategory('libretto', $data['libretto_files']);
        }
        
        if (isset($data['riparazione_files'])) {
            $this->saveDocumentCategory('riparazione', $data['riparazione_files']);
        }
        
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
