<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
