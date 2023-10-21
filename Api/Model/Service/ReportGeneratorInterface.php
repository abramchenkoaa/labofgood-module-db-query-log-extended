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

use Magento\Framework\Exception\FileSystemException;

/**
 * Used to generate report in xlsx format.
 *
 * @interface ReportGeneratorInterface
 */
interface ReportGeneratorInterface
{
    /**
     * Generate report.
     *
     * @param string[][] $records
     *
     * @return string
     * @throws FileSystemException
     */
    public function generate(array $records): string;

    /**
     * Set path info.
     *
     * @param string|null $outputFile
     *
     * @return $this
     */
    public function setOutputDirectory(string $outputFile = null): self;
}
