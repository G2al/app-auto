<?php

namespace App\Filament\Resources\VehicleResource\Widgets;

use App\Models\Vehicle;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use EightyNine\FilamentAdvancedWidget\AdvancedTableWidget as BaseWidget;

class UltimiVeicoliWidget extends BaseWidget
{
    protected static ?string $heading = 'Ultimi Veicoli Aggiunti';
    protected static ?string $description = 'Veicoli inseriti negli ultimi 7 giorni';
    protected int | string | array $columnSpan = 'full'; // Occupa tutto lo spazio

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Vehicle::query()
                    ->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->orderBy('created_at', 'desc')
                    ->limit(10) // Mostra solo gli ultimi 10
            )
            ->columns([
                TextColumn::make('brand_model')
                    ->label('Veicolo')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-truck'),

                TextColumn::make('license_plate')
                    ->label('Targa')
                    ->searchable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('purchase_price')
                    ->label('Prezzo Acquisto')
                    ->money('EUR')
                    ->sortable()
                    ->color('success'),

                TextColumn::make('sale_price')
                    ->label('Prezzo Vendita')
                    ->money('EUR')
                    ->sortable()
                    ->color('primary'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'disponibile',
                        'warning' => 'venduto',
                        'secondary' => 'archiviato',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'disponibile',
                        'heroicon-o-banknotes' => 'venduto',
                        'heroicon-o-archive-box' => 'archiviato',
                    ]),

                TextColumn::make('created_at')
                    ->label('Aggiunto il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->color('gray')
                    ->icon('heroicon-m-calendar'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated(false); // No pagination per widget
    }
}