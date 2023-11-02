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

use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\Handler\MatchPatternHandlerInterface;

/**
 * Class MatchPatternHandler
 *
 * Checks if the current line matches the designated regex pattern.
 */
class MatchPatternHandler implements MatchPatternHandlerInterface
{
    /**
     * @var array<int, mixed>|null
     */
    protected ?array $matches = null;

    /**
     * @param string $pattern
     */
    public function __construct(
        private readonly string $pattern
    ) {
    }

    /**
     * @inheritDoc
     */
    public function pregMatch(string $line): bool
    {
        $result = preg_match($this->pattern, $line, $this->matches);

        return $result === 1;
    }

    /**
     * @inheritDoc
     */
    public function resetMatches(): void
    {
        $this->matches = null;
    }
}
