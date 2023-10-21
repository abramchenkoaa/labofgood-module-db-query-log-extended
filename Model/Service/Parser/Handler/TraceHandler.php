<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
class TraceHandler extends MatchPatternHandler implements MultilineHandlerInterface
{
    /**
     * @param string $pattern
     * @param string $key
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
            $traceContent = '';
            while (($traceLine = $this->file->fileReadLine($handle, 0, PHP_EOL)) !== false) {
                if (trim($traceLine) === '') {
                    break;
                }

                $traceContent .= $traceLine;
            }

            $currentSection[$this->key] = trim($traceContent);
        }

        return $currentSection;
    }
}
