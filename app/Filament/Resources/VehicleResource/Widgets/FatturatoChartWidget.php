<?php

namespace App\Filament\Resources\VehicleResource\Widgets;

use App\Models\Vehicle;
use Carbon\Carbon;
use EightyNine\FilamentAdvancedWidget\AdvancedChartWidget;

class FatturatoChartWidget extends AdvancedChartWidget
{
    protected static ?string $heading = 'Fatturato Mensile';
    protected static string $color = 'success';
    protected static ?string $icon = 'heroicon-o-banknotes';
    protected static ?string $iconColor = 'success';
    protected static ?string $label = 'Andamento giornaliero';
    protected static string $view = 'filament.widgets.fatturato-chart-widget';

    public ?string $yearFilter = null;
    public ?string $monthFilter = null;

    public function mount(): void
    {
        parent::mount();

        $now = Carbon::now();
        $availableYears = array_keys($this->getYearFilters());

        $this->yearFilter ??= in_array((string) $now->year, $availableYears, true)
            ? (string) $now->year
            : (string) (end($availableYears) ?: $now->year);

        $this->monthFilter ??= (string) $now->month;
    }

    protected function getData(): array
    {
        $monthNames = $this->getMonthNames();
        $selectedYear = (int) ($this->yearFilter ?? Carbon::now()->year);
        $selectedMonth = (int) ($this->monthFilter ?? Carbon::now()->month);

        if (!isset($monthNames[$selectedMonth])) {
            $selectedMonth = Carbon::now()->month;
        }

        $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth;
        $days = [];
        $data = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $day;
            $fatturato = Vehicle::where('status', 'archiviato')
                ->whereDate('archive_date', Carbon::create($selectedYear, $selectedMonth, $day))
                ->sum('sale_price');
            $data[] = round($fatturato / 1000, 1);
        }

        // ðŸ”¹ Totale del mese (in euro)
        $fatturatoTotale = Vehicle::where('status', 'archiviato')
            ->whereMonth('archive_date', $selectedMonth)
            ->whereYear('archive_date', $selectedYear)
            ->sum('sale_price');

        // ðŸ”¹ Imposta la legenda con il totale accanto
        $label = 'Fatturato (€k - €' . number_format($fatturatoTotale, 0, ',', '.') . ')';

        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'tension' => 0.3,
                    'pointBackgroundColor' => 'rgb(34, 197, 94)',
                    'pointBorderColor' => 'rgb(34, 197, 94)',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $days,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getYearFilters(): array
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

    protected function getMonthFilters(): array
    {
        $filters = [];
        foreach ($this->getMonthNames() as $monthNumber => $monthName) {
            $filters[(string) $monthNumber] = $monthName;
        }

        return $filters;
    }

    protected function getMonthNames(): array
    {
        return [
            1 => 'Gennaio',
            2 => 'Febbraio',
            3 => 'Marzo',
            4 => 'Aprile',
            5 => 'Maggio',
            6 => 'Giugno',
            7 => 'Luglio',
            8 => 'Agosto',
            9 => 'Settembre',
            10 => 'Ottobre',
            11 => 'Novembre',
            12 => 'Dicembre',
        ];
    }
}
