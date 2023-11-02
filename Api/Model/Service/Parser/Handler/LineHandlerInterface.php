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
 * Extract data from line and add it to current entry.
 *
 * @interface LineHandlerInterface
 */
interface LineHandlerInterface extends MatchPatternHandlerInterface
{
    /**
     * Extract log data from line.
     *
     * @param array<string, string> $currentSection
     *
     * @return array<string, string>
     */
    public function handle(array $currentSection): array;
}
