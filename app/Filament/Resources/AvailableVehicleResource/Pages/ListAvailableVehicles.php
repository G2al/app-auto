<?php

namespace App\Filament\Resources\AvailableVehicleResource\Pages;

use App\Filament\Resources\AvailableVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use PDF; // Aggiungi questo
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer as XLSXWriter;

class ListAvailableVehicles extends ListRecords
{
    protected static string $resource = AvailableVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportPdf')
                ->label('Scarica Listino PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    $vehicles = \App\Models\Vehicle::where('status', 'disponibile')
                        ->select('brand_model', 'license_plate', 'registration_year', 'km', 'color', 'fuel_type', 'sale_price')
                        ->orderBy('brand_model')
                        ->get();
                    
                    $pdf = \PDF::loadView('pdf.listino-veicoli', compact('vehicles'))
                        ->setPaper('a4', 'landscape')
                        ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
                    
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'listino-veicoli-disponibili.pdf', [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
            Actions\Action::make('exportExcel')
                ->label('Scarica Listino Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('info')
                ->action(function () {
                    $vehicles = \App\Models\Vehicle::where('status', 'disponibile')
                        ->select('brand_model', 'license_plate', 'registration_year', 'km', 'color', 'fuel_type', 'sale_price')
                        ->orderBy('brand_model')
                        ->get();

                    $tempPath = tempnam(sys_get_temp_dir(), 'listino-veicoli-');
                    $xlsxPath = $tempPath . '.xlsx';
                    rename($tempPath, $xlsxPath);

                    $writer = new XLSXWriter();
                    $writer->openToFile($xlsxPath);
                    $writer->addRow(Row::fromValues(['Marca / Modello', 'Targa', 'Anno', 'Chilometri', 'Colore', 'Alimentazione', 'Prezzo Vendita']));

                    foreach ($vehicles as $vehicle) {
                        $writer->addRow(Row::fromValues([
                            $vehicle->brand_model,
                            $vehicle->license_plate,
                            $vehicle->registration_year,
                            $vehicle->km,
                            $vehicle->color,
                            $vehicle->fuel_type,
                            $vehicle->sale_price ?? 0,
                        ]));
                    }

                    $writer->close();

                    return response()
                        ->download($xlsxPath, 'listino-veicoli-disponibili.xlsx')
                        ->deleteFileAfterSend(true);
                }),
        ];
    }
}
