<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;

class VehicleContractController extends Controller
{
    public function __invoke(Vehicle $vehicle)
    {
        $pdf = \PDF::loadView('pdf.vehicle-contract', [
            'vehicle' => $vehicle,
        ])->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'contratto-' . $vehicle->id . '-' . str($vehicle->license_plate ?? 'veicolo')
            ->replaceMatches('/[^A-Za-z0-9_-]+/', '-')
            ->trim('-')
            ->lower() . '.pdf';

        return $pdf->stream($filename);
    }
}
