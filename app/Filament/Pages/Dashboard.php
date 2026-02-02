<?php

namespace App\Filament\Pages;

use App\Filament\Resources\VehicleResource\Widgets\VehicleStatsWidget;
use App\Filament\Resources\VehicleResource\Widgets\FatturatoChartWidget;
use App\Filament\Resources\VehicleResource\Widgets\FatturatoAnnualeWidget;
use App\Filament\Resources\VehicleResource\Widgets\UltimiVeicoliWidget;
use App\Filament\Resources\VehicleResource\Widgets\ArchiviateChartWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationGroup = 'Generale';
    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            VehicleStatsWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            FatturatoChartWidget::class,
            FatturatoAnnualeWidget::class,
            ArchiviateChartWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            UltimiVeicoliWidget::class,
        ];
    }
}
