<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Labofgood\DbQueryLogExtended\Api\Model\Service\ReportFormat;

/**
 * Used to prepare data for reports render.
 *
 * @interface SimilarityAnalysisPrepperInterface
 */
interface SimilarityAnalysisPrepperInterface
{
    /**
     * Return prepared data for similarity analysis report render.
     *
     * @param array<int,array<string, array<int, array<string, string>>>> $analyzedData
     *
     * @return string[][]
     */
    public function forSimilarityReport(array $analyzedData): array;
}
