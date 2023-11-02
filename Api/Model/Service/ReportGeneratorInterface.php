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
