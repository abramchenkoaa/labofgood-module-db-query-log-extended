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
