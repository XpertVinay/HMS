<?php

namespace App\Services;

class BusinzoEstimateService
{
    public function getUiConfig(): array
    {
        return [
            'features_by_type' => config('businzo_estimate.features_by_type'),
            'short_type_labels' => config('businzo_estimate.short_type_labels'),
            'project_types' => array_keys(config('businzo_estimate.base_prices')),
        ];
    }

    /**
     * @param  list<string>  $features
     * @return array{
     *     total: int,
     *     total_min: int,
     *     total_max: int,
     *     total_min_formatted: string,
     *     total_max_formatted: string,
     *     type_label: string,
     *     complexity_label: string,
     *     timeline: string,
     *     currency: string
     * }
     */
    public function calculate(string $projectType, string $complexity, array $features): array
    {
        $basePrices = config('businzo_estimate.base_prices');
        $multipliers = config('businzo_estimate.complexity_multipliers');
        $featurePrices = config('businzo_estimate.feature_prices');
        $markup = config('businzo_estimate.range_markup', 1.2);

        $total = $basePrices[$projectType] * $multipliers[$complexity];

        foreach ($features as $feature) {
            if (isset($featurePrices[$feature])) {
                $total += $featurePrices[$feature];
            }
        }

        $total = (int) round($total);
        $totalMax = (int) round($total * $markup);

        return [
            'total' => $total,
            'total_min' => $total,
            'total_max' => $totalMax,
            'total_min_formatted' => $this->formatInr($total),
            'total_max_formatted' => $this->formatInr($totalMax),
            'type_label' => config("businzo_estimate.type_labels.{$projectType}"),
            'complexity_label' => config("businzo_estimate.complexity_labels.{$complexity}"),
            'timeline' => config("businzo_estimate.timelines.{$complexity}"),
            'currency' => 'INR',
        ];
    }

    private function formatInr(int $amount): string
    {
        return number_format($amount, 0, '.', ',');
    }
}
