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

    public ?string $filter = null;

    public function mount(): void
    {
        parent::mount();

        $now = Carbon::now();
        $availableYears = array_keys($this->getFilters() ?? []);

        $this->filter ??= in_array((string) $now->year, $availableYears, true)
            ? (string) $now->year
            : (string) (end($availableYears) ?: $now->year);
    }

    protected function getFilters(): ?array
    {
        $years = Vehicle::where('status', 'archiviato')
            ->whereNotNull('archive_date')
            ->selectRaw('YEAR(archive_date) as year')
            ->distinct()
            ->orderBy('year')
            ->pluck('year')
            ->map(fn ($year) => (int) $year)
            ->filter()
            ->values();

        if ($years->isEmpty()) {
            $years = collect([Carbon::now()->year]);
        }

        return $years
            ->mapWithKeys(fn (int $year) => [(string) $year => 'Anno ' . $year])
            ->all();
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
                ->whereMonth('archive_date', $month)
                ->whereYear('archive_date', $year)
                ->sum('sale_price');

            $data[] = round($fatturato / 1000, 1);
        }

        // Totale annuale in €
        $totaleAnnuale = Vehicle::where('status', 'archiviato')
            ->whereYear('archive_date', $year)
            ->sum('sale_price');

        $label = 'Fatturato (€k - €' . number_format($totaleAnnuale, 0, ',', '.') . ')';

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
