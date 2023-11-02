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
namespace Labofgood\DbQueryLogExtended\Api\Model\Service\ReportFormat;

/**
 * Used to prepare data for reports render.
 *
 * @interface PrepperInterface
 */
interface PrepperInterface
{
    /**
     * Return prepared data for report render.
     *
     * @param array<string, array<int, array<string>>> $records
     *
     * @return string[][]
     */
    public function forReport(array $records): array;
}
