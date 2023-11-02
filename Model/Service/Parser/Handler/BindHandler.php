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

namespace Labofgood\DbQueryLogExtended\Model\Service\Parser\Handler;

use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\Handler\MultilineHandlerInterface;
use Magento\Framework\Filesystem\DriverInterface as File;

/**
 * Class BindHandler
 *
 * Extract bind data from multiline text and add it to current entry.
 */
class BindHandler extends MatchPatternHandler implements MultilineHandlerInterface
{
    /**
     * @param string $pattern
     * @param string $key
     * @param File $file
     */
    public function __construct(
        string $pattern,
        private readonly string $key,
        private readonly File $file
    ) {
        parent::__construct($pattern);
    }

    /**
     * @inheritDoc
     */
    public function handle(array $currentSection, mixed $handle): array
    {
        if ($this->matches) {
            $bindContent = '';
            while (($bindLine = $this->file->fileReadLine($handle, 0, PHP_EOL)) !== false) {
                $bindLine = trim($bindLine);
                if ($bindLine === ')') {
                    break;
                }
                $bindContent .= $bindLine;
            }

            $currentSection[$this->key] = $bindContent;
        }

        return $currentSection;
    }
}
