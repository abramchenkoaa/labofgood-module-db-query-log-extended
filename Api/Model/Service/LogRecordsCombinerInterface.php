<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Labofgood\DbQueryLogExtended\Api\Model\Service;

/**
 * Used to combine log records.
 *
 * @interface LogRecordsCombinerInterface
 */
interface LogRecordsCombinerInterface
{
    /**
     * Combine log records.
     *
     * @param array<int, array<string>> $records
     *
     * @return array<string, array<int, array<string>>>
     */
    public function combine(array $records): array;
}
