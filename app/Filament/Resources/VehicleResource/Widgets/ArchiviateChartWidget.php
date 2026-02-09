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

    protected int | string | array $columnSpan = 'full';


    public ?string $filter = 'ottobre'; // mese di default

    protected function getFilters(): ?array
    {
        return [
            'gennaio' => 'Gennaio 2025',
            'febbraio' => 'Febbraio 2025',
            'marzo' => 'Marzo 2025',
            'aprile' => 'Aprile 2025',
            'maggio' => 'Maggio 2025',
            'giugno' => 'Giugno 2025',
            'luglio' => 'Luglio 2025',
            'agosto' => 'Agosto 2025',
            'settembre' => 'Settembre 2025',
            'ottobre' => 'Ottobre 2025',
            'novembre' => 'Novembre 2025',
            'dicembre' => 'Dicembre 2025',
        ];
    }

    protected function getData(): array
    {
        $monthMapping = [
            'gennaio' => 1, 'febbraio' => 2, 'marzo' => 3, 'aprile' => 4,
            'maggio' => 5, 'giugno' => 6, 'luglio' => 7, 'agosto' => 8,
            'settembre' => 9, 'ottobre' => 10, 'novembre' => 11, 'dicembre' => 12
        ];

        $selectedMonth = $monthMapping[$this->filter] ?? Carbon::now()->month;
        $year = 2025;

        $daysInMonth = Carbon::create($year, $selectedMonth, 1)->daysInMonth;
        $days = [];
        $archiviati = [];
        $guadagni = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $day;

            // 🔹 Conteggio veicoli archiviati nel giorno
            $count = Vehicle::where('status', 'archiviato')
                ->whereDate('archive_date', Carbon::create($year, $selectedMonth, $day))
                ->count();

            // 🔹 Guadagno netto del giorno
            $profit = Vehicle::where('status', 'archiviato')
                ->whereDate('archive_date', Carbon::create($year, $selectedMonth, $day))
                ->selectRaw('SUM(COALESCE(sale_price,0) - COALESCE(total_cost,0)) as profit')
                ->value('profit') ?? 0;

            $archiviati[] = $count;
            $guadagni[] = round($profit / 1000, 1); // espresso in migliaia €
        }

        // 🔹 Totali del mese
        $totArchiviati = array_sum($archiviati);
        $totGuadagno = Vehicle::where('status', 'archiviato')
            ->whereMonth('archive_date', $selectedMonth)
            ->whereYear('archive_date', $year)
            ->selectRaw('SUM(COALESCE(sale_price,0) - COALESCE(total_cost,0)) as profit')
            ->value('profit') ?? 0;

        $labelGuadagno = 'Guadagno (€k - €' . number_format($totGuadagno, 0, ',', '.') . ')';
        $labelArchiviati = 'Veicoli Archiviati (' . $totArchiviati . ')';

        return [
            'datasets' => [
                [
                    'label' => $labelArchiviati,
                    'data' => $archiviati,
                    'borderColor' => 'rgb(59,130,246)',
                    'backgroundColor' => 'rgba(59,130,246,0.2)',
                    'tension' => 0.3,
                    'yAxisID' => 'y1',
                ],
                [
                    'label' => $labelGuadagno,
                    'data' => $guadagni,
                    'borderColor' => 'rgb(34,197,94)',
                    'backgroundColor' => 'rgba(34,197,94,0.2)',
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
}
