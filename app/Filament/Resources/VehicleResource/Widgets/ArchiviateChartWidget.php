<?php

namespace App\Filament\Resources\VehicleResource\Widgets;

use App\Models\Vehicle;
use Carbon\Carbon;
use EightyNine\FilamentAdvancedWidget\AdvancedChartWidget;

class ArchiviateChartWidget extends AdvancedChartWidget
{
    protected static ?string $heading = 'Veicoli Archiviati e Guadagno';
    protected static string $color = 'info';
    protected static ?string $icon = 'heroicon-o-archive-box';
    protected static ?string $iconColor = 'info';
    protected static ?string $label = 'Andamento giornaliero archiviazioni';
    protected static string $view = 'filament.widgets.archiviate-chart-widget';

    protected int | string | array $columnSpan = 'full';

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

        if (! isset($monthNames[$selectedMonth])) {
            $selectedMonth = Carbon::now()->month;
        }

        $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth;
        $days = [];
        $archiviati = [];
        $guadagni = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $archiveDate = Carbon::create($selectedYear, $selectedMonth, $day);
            $days[] = $day;

            $count = Vehicle::where('status', 'archiviato')
                ->whereDate('archive_date', $archiveDate)
                ->count();

            $profit = Vehicle::where('status', 'archiviato')
                ->whereDate('archive_date', $archiveDate)
                ->selectRaw('SUM(COALESCE(sale_price, 0) - COALESCE(total_cost, 0)) as profit')
                ->value('profit') ?? 0;

            $archiviati[] = $count;
            $guadagni[] = round($profit / 1000, 1);
        }

        $totArchiviati = array_sum($archiviati);
        $totGuadagno = Vehicle::where('status', 'archiviato')
            ->whereMonth('archive_date', $selectedMonth)
            ->whereYear('archive_date', $selectedYear)
            ->selectRaw('SUM(COALESCE(sale_price, 0) - COALESCE(total_cost, 0)) as profit')
            ->value('profit') ?? 0;

        return [
            'datasets' => [
                [
                    'label' => 'Veicoli Archiviati (' . $totArchiviati . ')',
                    'data' => $archiviati,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension' => 0.3,
                    'yAxisID' => 'y1',
                ],
                [
                    'label' => 'Guadagno (€k - €' . number_format($totGuadagno, 0, ',', '.') . ')',
                    'data' => $guadagni,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'tension' => 0.3,
                    'yAxisID' => 'y2',
                ],
            ],
            'labels' => $days,
            'options' => [
                'scales' => [
                    'y1' => [
                        'type' => 'linear',
                        'position' => 'left',
                        'title' => ['display' => true, 'text' => 'Numero veicoli'],
                    ],
                    'y2' => [
                        'type' => 'linear',
                        'position' => 'right',
                        'title' => ['display' => true, 'text' => 'Guadagno (€k)'],
                        'grid' => ['drawOnChartArea' => false],
                    ],
                ],
            ],
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
