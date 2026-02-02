<?php

namespace App\Filament\Resources\VehicleResource\Widgets;

use App\Models\Vehicle;
use Carbon\Carbon;
use EightyNine\FilamentAdvancedWidget\AdvancedChartWidget;

class FatturatoAnnualeWidget extends AdvancedChartWidget
{
    protected static ?string $heading = 'Fatturato Annuale';
    protected static string $color = 'info';
    protected static ?string $icon = 'heroicon-o-chart-bar';
    protected static ?string $iconColor = 'info';
    protected static ?string $iconBackgroundColor = 'info';
    protected static ?string $label = 'Andamento per mesi';

    // 🔹 Rimosse le righe del badge

    public ?string $filter = '2025'; // Anno di default

    protected function getFilters(): ?array
    {
        return [
            '2023' => 'Anno 2023',
            '2024' => 'Anno 2024',
            '2025' => 'Anno 2025',
        ];
    }

    protected function getData(): array
    {
        $year = $this->filter ?? Carbon::now()->year;

        $months = [];
        $data = [];

        // Calcolo del fatturato mensile
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create($year, $month, 1)->format('M');
            $months[] = $monthName;

            $fatturato = Vehicle::where('status', 'archiviato')
                ->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)
                ->sum('sale_price');

            $data[] = round($fatturato / 1000, 1);
        }

        // Totale annuale in €
        $totaleAnnuale = Vehicle::where('status', 'archiviato')
            ->whereYear('updated_at', $year)
            ->sum('sale_price');

        $label = 'Fatturato (€k — €' . number_format($totaleAnnuale, 0, ',', '.') . ')';

        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.3,
                    'pointBackgroundColor' => 'rgb(59, 130, 246)',
                    'pointBorderColor' => 'rgb(59, 130, 246)',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
