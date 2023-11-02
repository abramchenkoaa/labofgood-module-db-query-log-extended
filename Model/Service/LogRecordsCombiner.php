<?php
/**
 * Copyright © 2023 Anton Abramchenko. All rights reserved.
 *
 * Redistribution and use permitted under the BSD-3-Clause license.
 * For full details, see COPYING.txt.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Anton Abramchenko
 * @license   See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Labofgood\DbQueryLogExtended\Model\Service;

use Labofgood\DbQueryLogExtended\Api\Model\Service\LogRecordsCombinerInterface;

/**
 * Class LogRecordsCombiner
 *
 * Used to combine log records.
 */
class LogRecordsCombiner implements LogRecordsCombinerInterface
{
    /**
     * @param string $fieldName
     */
    public function __construct(
        private readonly string $fieldName
    ) {
    }

    /**
     * Combine log records.
     *
     * @param array<int, array<string>> $records
     *
     * @return array<string, array<int, array<string>>>
     */
    public function combine(array $records): array
    {
        $combinedRecords = [];

        foreach ($records as $record) {
            if (!array_key_exists($this->fieldName, $record)) {
                continue;
            }

            $combinedRecords[$record[$this->fieldName]][] = $record;
        }

        return $combinedRecords;
    }
}
