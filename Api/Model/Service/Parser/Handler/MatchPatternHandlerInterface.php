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
