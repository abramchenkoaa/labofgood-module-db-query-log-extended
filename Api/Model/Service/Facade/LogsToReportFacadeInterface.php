<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Labofgood\DbQueryLogExtended\Api\Model\Service\Facade;

/**
 * Parse db.log and generate report from.
 *
 * @interface LogsToReportFacadeInterface
 */
interface LogsToReportFacadeInterface
{
    /**
     * Generate report from db.log.
     *
     * @param string $pathToFile
     * @param string|null $outputFile
     *
     * @return string
     */
    public function execute(string $pathToFile, ?string $outputFile = null): string;
}
