<?php

namespace App\Filament\Actions;

use App\Models\Vehicle;
use Filament\Actions\Action as PageAction;
use Filament\Forms\Components\Actions\Action as FormAction;

class VehicleContractPdfAction
{
    public static function form(): FormAction
    {
        return FormAction::make('contract_pdf')
            ->label('Contratto PDF')
            ->icon('heroicon-o-document-text')
            ->color('info')
            ->url(fn (?Vehicle $record): ?string => self::url($record))
            ->openUrlInNewTab()
            ->visible(fn (?Vehicle $record): bool => self::isAvailable($record));
    }

    public static function page(): PageAction
    {
        return PageAction::make('contract_pdf')
            ->label('Contratto PDF')
            ->icon('heroicon-o-document-text')
            ->color('info')
            ->url(fn (?Vehicle $record): ?string => self::url($record))
            ->openUrlInNewTab()
            ->visible(fn (?Vehicle $record): bool => self::isAvailable($record));
    }

    private static function url(?Vehicle $record): ?string
    {
        return self::isAvailable($record) ? route('vehicles.contract', $record) : null;
    }

    private static function isAvailable(?Vehicle $record): bool
    {
        return (bool) $record?->exists;
    }
}
