@php
    use Filament\Support\Facades\FilamentView;

    $color = $this->getColor();
    $heading = $this->getHeading();
    $description = $this->getDescription();
    $label = $this->getLabel();

    $monthFilters = $this->getMonthFilters();
    $yearFilters = $this->getYearFilters();

    $icon = $this->getIcon();
    $iconColor = $this->getIconColor();
    $iconBackgroundColor = filled($this->getIconBackgroundColor()) ? match ($this->getIconBackgroundColor()) {
        'primary' => 'bg-primary-200 dark:bg-primary-950',
        'secondary' => 'bg-secondary-200 dark:bg-secondary-950',
        'success' => 'bg-success-200 dark:bg-success-950',
        'danger' => 'bg-danger-200 dark:bg-danger-950',
        'warning' => 'bg-warning-200 dark:bg-warning-950',
        'info' => 'bg-info-200 dark:bg-info-950',
        default => 'bg-gray-200 dark:bg-gray-950',
    } : "";

    $badge = $this->getBadge();
    $badgeColor = $this->getBadgeColor();
    $badgeIcon = $this->getBadgeIcon();
    $badgeIconPosition = $this->getBadgeIconPosition();
    $badgeSize = $this->getBadgeSize();
@endphp

<x-filament-widgets::widget class="fi-wi-chart">
    <x-advanced-widgets::section :description="$description" :heading="$heading" :icon="$icon" :iconColor="$iconColor"
        :iconBackgroundColor="$iconBackgroundColor" :label="$label" :badge="$badge" :badgeColor="$badgeColor"
        :badgeIcon="$badgeIcon" :badgeIconPosition="$badgeIconPosition" :badgeSize="$badgeSize">
        @if ($monthFilters || $yearFilters)
            <x-slot name="headerEnd">
                <div class="flex items-center gap-2 sm:-my-2">
                    @if ($monthFilters)
                        <x-filament::input.wrapper inline-prefix wire:target="monthFilter" class="w-max">
                            <x-filament::input.select inline-prefix wire:model.live="monthFilter">
                                @foreach ($monthFilters as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    @endif

                    @if ($yearFilters)
                        <x-filament::input.wrapper inline-prefix wire:target="yearFilter" class="w-max">
                            <x-filament::input.select inline-prefix wire:model.live="yearFilter">
                                @foreach ($yearFilters as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    @endif
                </div>
            </x-slot>
        @endif

        <div @if ($pollingInterval = $this->getPollingInterval()) wire:poll.{{ $pollingInterval }}="updateChartData" @endif>
            <div @if (FilamentView::hasSpaMode()) ax-load="visible"
                @else
                    ax-load @endif
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('chart', 'filament/widgets') }}"
                wire:ignore x-data="chart({
                    cachedData: @js($this->getCachedData()),
                    options: @js($this->getOptions()),
                    type: @js($this->getType()),
                })" x-ignore @class([
                    match ($color) {
                        'gray' => null,
                        default => 'fi-color-custom',
                    },
                    is_string($color) ? "fi-color-{$color}" : null,
                ])>
                <canvas x-ref="canvas"
                    @if ($maxHeight = $this->getMaxHeight()) style="max-height: {{ $maxHeight }}" @endif></canvas>

                <span x-ref="backgroundColorElement" @class([
                    match ($color) {
                        'gray' => 'text-gray-100 dark:text-gray-800',
                        default => 'text-custom-50 dark:text-custom-400/10',
                    },
                ]) @style([
                    \Filament\Support\get_color_css_variables($color, shades: [50, 400], alias: 'widgets::chart-widget.background') => $color !== 'gray',
                ])></span>

                <span x-ref="borderColorElement" @class([
                    match ($color) {
                        'gray' => 'text-gray-400',
                        default => 'text-custom-500 dark:text-custom-400',
                    },
                ]) @style([
                    \Filament\Support\get_color_css_variables($color, shades: [400, 500], alias: 'widgets::chart-widget.border') => $color !== 'gray',
                ])></span>

                <span x-ref="gridColorElement" class="text-gray-200 dark:text-gray-800"></span>
                <span x-ref="textColorElement" class="text-gray-500 dark:text-gray-400"></span>
            </div>
        </div>
    </x-advanced-widgets::section>
</x-filament-widgets::widget>
