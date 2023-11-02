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
