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
