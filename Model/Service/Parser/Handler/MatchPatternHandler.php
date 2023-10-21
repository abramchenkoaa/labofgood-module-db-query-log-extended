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
