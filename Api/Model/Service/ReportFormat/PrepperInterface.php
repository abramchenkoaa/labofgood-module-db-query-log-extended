<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
