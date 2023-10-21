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

namespace Labofgood\DbQueryLogExtended\Model\Service\Parser;

use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\Handler\LineHandlerInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\Handler\MultilineHandlerInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\QueryLogParserInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DriverInterface as File;

/**
 * Class QueryLogParser
 *
 * Parse query logs file.
 */
class QueryLogParser implements QueryLogParserInterface
{
    /**
     * @param array<int, LineHandlerInterface|MultilineHandlerInterface> $handlers
     * @param File $file
     * @param string $newSectionPattern
     */
    public function __construct(
        private readonly array $handlers,
        private readonly File $file,
        private readonly string $newSectionPattern
    ) {
    }

    /**
     * Parse query logs file.
     *
     * @param string $filePath
     *
     * @return array<int, array<string, string>>
     * @throws FileSystemException
     */
    public function parse(string $filePath): array
    {
        $parsedSections = [];
        $currentSection = [];
        $handle = $this->file->fileOpen($filePath, 'r');
        // phpcs:disable
        while (($line = stream_get_line($handle, 0, PHP_EOL)) !== false) {
            // phpcs:enable
            $line = trim($line);
            if ($currentSection && $this->isNewSection($line)) {
                $parsedSections[] = $currentSection;
                $currentSection = [];
            }

            foreach ($this->handlers as $handler) {
                if ($handler->pregMatch($line)) {
                    if ($handler instanceof MultilineHandlerInterface) {
                        $currentSection = $handler->handle($currentSection, $handle);
                    } else {
                        $currentSection = $handler->handle($currentSection);
                    }

                    $handler->resetMatches();
                    break;
                }
            }
        }

        if ($currentSection) {
            $parsedSections[] = $currentSection;
        }

        $this->file->fileClose($handle);

        return $parsedSections;
    }

    /**
     * Check if the line is a start of new section.
     *
     * @param string $line
     *
     * @return bool
     */
    private function isNewSection(string $line): bool
    {
        return preg_match($this->newSectionPattern, $line) === 1;
    }
}
