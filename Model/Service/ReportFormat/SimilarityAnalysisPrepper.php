<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
declare(strict_types=1);

namespace Labofgood\DbQueryLogExtended\Model\Service\ReportFormat;

use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportFormat\SimilarityAnalysisPrepperInterface;

/**
 * Class SimilarityAnalysisPrepper
 *
 * Used to prepare data for reports render.
 */
class SimilarityAnalysisPrepper implements SimilarityAnalysisPrepperInterface
{
    /**
     * @param string $sortKey
     * @param string[] $headers
     * @param array<string, array{'method': string, 'args'?: string[]}> $map
     * @param array{
     *     'fieldNumber': int,
     *     'rules': array{
     *         'criteria': array{
     *             'gteq': float,
     *             'color': string
     *         },
     *         'high': array{
     *              'gteq': float,
     *              'color': string
     *         },
     *         'warning': array{
     *              'gteq': float,
     *              'color': string
     *         }
     *     }
     * } $highlighting
     * @param string[][] $rows
     */
    public function __construct(
        private readonly string $sortKey,
        private readonly array $headers,
        private readonly array $map,
        private readonly array $highlighting,
        private array $rows = []
    ) {
    }

    /**
     * Return prepared data for similarity analysis report render
     *
     * @param array<int,array<string, array<int, array<string, string>>>> $analyzedData
     *
     * @return string[][]
     */
    public function forSimilarityReport(array $analyzedData):array
    {
        $this->resetRows();
        $this->rows[] = $this->headers;

        foreach ($analyzedData as $analyzedDataItem) {
            $tmpRows = [];

            foreach ($analyzedDataItem as $logs) {
                $record = $this->generateRecord($logs);
                $record = $this->highlightRecord($record);
                ksort($record);
                $tmpRows[$logs[0][$this->sortKey]] = $record;
            }

            ksort($tmpRows);

            foreach ($tmpRows as $tmpRow) {
                $this->rows[] = $tmpRow;
            }
        }

        return $this->rows;
    }

    /**
     * Reset collected rows.
     *
     * @return void
     */
    private function resetRows(): void
    {
        $this->rows = [];
    }

    /**
     * Generate report record.
     *
     * @param string[][] $logs
     *
     * @return string[]
     */
    private function generateRecord(array $logs): array
    {
        $record = [];

        foreach ($this->map as $recordKey => $callback) {
            $args = [$logs, ...($callback['args'] ?? [])];
            $record[(int) $recordKey] = (string) $this->{$callback['method']}(...$args);
        }

        return $record;
    }

    /**
     * Highlight record.
     *
     * @param string[] $record
     *
     * @return string[]
     */
    private function highlightRecord(array $record): array
    {
        $totalExecutionTime = $record[$this->highlighting['fieldNumber']];

        foreach ($this->highlighting['rules'] as $rule) {
            if ($totalExecutionTime >= $rule['gteq']) {
                foreach ($record as &$item) {
                    $item = sprintf(
                        '<style bgcolor="%s">%s</style>',
                        $rule['color'],
                        $item
                    );
                }

                unset($item);
                break;
            }
        }

        return $record;
    }

    /**
     * Map record key to record value.
     *
     * @param string[][] $logs
     * @param string $key
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function map(array $logs, string $key): string
    {
        return $logs[0][$key] ?? '';
    }

    /**
     * Get similar queries count.
     *
     * @param string[][] $logs
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function queriesCount(array $logs): string
    {
        return (string) count($logs);
    }

    /**
     * Get request uri or cli command line.
     *
     * @param string[][] $logs
     * @param string $key1
     * @param string $key2
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function requestUri(array $logs, string $key1, string $key2): string
    {
        return $logs[0][$key1] ?? $logs[0][$key2] ?? '';
    }

    /**
     * Get average sql query execution time.
     *
     * @param string[][] $logs
     * @param string $key
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function avgExecutionTime(array $logs, string $key): string
    {
        $sum = 0;
        foreach ($logs as $log) {
            $sum += (float) $log[$key];
        }

        return (string) round($sum / count($logs), 5);
    }

    /**
     * Get total execution time for similar queries.
     *
     * @param string[][] $logs
     * @param string $key
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function totalExecutionTime(array $logs, string $key): string
    {
        $sum = 0;
        foreach ($logs as $log) {
            $sum += (float) $log[$key];
        }

        return (string) $sum;
    }
}
