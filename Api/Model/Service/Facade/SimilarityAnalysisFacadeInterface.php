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
namespace Labofgood\DbQueryLogExtended\Api\Model\Service\Facade;

/**
 * Used to execute similarity analysis and generate report from db.log.
 *
 * @interface SimilarityAnalysisFacadeInterface
 */
interface SimilarityAnalysisFacadeInterface
{
    /**
     * Execute similarity analysis and generate report from db.log.
     *
     * @param string $pathToFile
     *
     * @return string
     */
    public function execute(string $pathToFile): string;
}
