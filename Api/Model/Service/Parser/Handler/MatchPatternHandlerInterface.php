<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\Handler;

/**
 * Checks if the current line matches the designated regex pattern.
 *
 * @interface MatchPatternHandlerInterface
 */
interface MatchPatternHandlerInterface
{
    /**
     * Does the current line match the pattern.
     *
     * @param string $line
     *
     * @return bool
     */
    public function pregMatch(string $line): bool;

    /**
     * Reset found by pregMatch matches.
     *
     * @return void
     */
    public function resetMatches(): void;
}
