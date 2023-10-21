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

use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportFormat\PrepperInterface;

/**
 * Class Prepper
 *
 * Used to prepare data for reports render.
 */
class Prepper implements PrepperInterface
{
    /**
     * @param string[] $headers
     * @param array<string, array{'method': string, 'args'?: string[]}> $map
     * @param string[][] $rows
     */
    public function __construct(
        private readonly array $headers,
        private readonly array $map,
        private array $rows = []
    ) {
    }

    /**
     * Return prepared data for report render.
     *
     * @param array<string, array<int, array<string>>> $records
     *
     * @return string[][]
     */
    public function forReport(array $records): array
    {
        $this->resetRows();
        $this->rows[] = $this->headers;

        foreach ($records as $logs) {
            foreach ($logs as $log) {
                $record = $this->generateRecord($log);
                ksort($record);
                $this->rows[] = $record;
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
     * @param string[] $log
     *
     * @return string[]
     */
    private function generateRecord(array $log): array
    {
        $record = [];

        foreach ($this->map as $recordKey => $callback) {
            $args = [$log, ...($callback['args'] ?? [])];
            $record[(int) $recordKey] = (string) $this->{$callback['method']}(...$args);
        }

        return $record;
    }

    /**
     * Map record key to record value.
     *
     * @param string[] $log
     * @param string $key
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function map(array $log, string $key): string
    {
        return $log[$key] ?? '';
    }

    /**
     * Get request uri or cli command line.
     *
     * @param string[] $log
     * @param string $key1
     * @param string $key2
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function requestUri(array $log, string $key1, string $key2): string
    {
        return $log[$key1] ?? $log[$key2] ?? '';
    }
}
