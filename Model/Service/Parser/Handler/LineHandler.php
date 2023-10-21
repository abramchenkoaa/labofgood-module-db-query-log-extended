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

use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\Handler\LineHandlerInterface;

/**
 * Class LineHandler
 *
 * Extract data from line and add it to current entry.
 */
class LineHandler extends MatchPatternHandler implements LineHandlerInterface
{
    /**
     * @param string $pattern
     * @param string $key
     */
    public function __construct(
        string $pattern,
        private readonly string $key
    ) {
        parent::__construct($pattern);
    }

    /**
     * @inheritDoc
     */
    public function handle(array $currentSection): array
    {
        if ($this->matches !== null && isset($this->matches[1])) {
            $currentSection[$this->key] = $this->matches[1];
        }

        return $currentSection;
    }
}
