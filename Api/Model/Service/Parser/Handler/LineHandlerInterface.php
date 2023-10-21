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
