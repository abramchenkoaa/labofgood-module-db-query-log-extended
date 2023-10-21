<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Labofgood\DbQueryLogExtended\Api\Model\Service\Parser;

use Magento\Framework\Exception\FileSystemException;

/**
 * Parse query logs file.
 *
 * @interface QueryLogParserInterface
 */
interface QueryLogParserInterface
{
    /**
     * Parse query logs file.
     *
     * @param string $filePath
     *
     * @return array<int, array<string, string>>
     * @throws FileSystemException
     */
    public function parse(string $filePath): array;
}
