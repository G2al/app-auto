<?php

namespace App\Filament\Resources\VehicleResource\Widgets;

use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VehicleStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = Vehicle::selectRaw('
            COUNT(*) as total,
            COUNT(CASE WHEN status = "disponibile" THEN 1 END) as disponibili,
            COUNT(CASE WHEN status = "venduto" THEN 1 END) as venduti,
            COUNT(CASE WHEN status = "archiviato" THEN 1 END) as archiviati,
            SUM(CASE WHEN status = "disponibile" THEN total_cost ELSE 0 END) as capitale_disponibili
        ')->first();

        return [
            Stat::make('Totale Veicoli', $stats->total)
                ->description('Tutti i veicoli in sistema')
                ->descriptionIcon('heroicon-m-truck')
                ->color('primary'),

            Stat::make('Disponibili', $stats->disponibili)
                ->description('Pronti per la vendita')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('In Arrivo', Vehicle::where('status', 'in_arrivo')->count())
                ->description('Veicoli in arrivo')
                ->descriptionIcon('heroicon-o-truck')
                ->chart([3, 5, 8, 2, 12, 6, 9])
                ->color('info'),

            Stat::make('Venduti', $stats->venduti)
                ->description('Transazioni completate')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),

            Stat::make('Archiviati', $stats->archiviati)
                ->description('Veicoli archiviati')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('gray'),

            Stat::make(
                'Capitale a Terra',
                '€' . number_format($stats->capitale_disponibili ?? 0, 0, ',', '.')
            )
                ->description('Capitale investito nei veicoli disponibili')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('success'),
        ];
    }
}
