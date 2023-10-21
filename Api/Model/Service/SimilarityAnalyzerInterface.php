<?php
/**
 * Copyright © 2023 Labofgood. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author    Anton Abramchenko <anton.abramchenko@labofgood.com>
 * @copyright 2023 Labofgood
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Labofgood\DbQueryLogExtended\Api\Model\Service;

/**
 * Analyze similarity in logs.
 *
 * @interface SimilarityAnalyzer
 */
interface SimilarityAnalyzerInterface
{
    /**
     * Get the similarity in logs and return array of similar groups.
     *
     * @param array<int, array<string, string>> $logForAnalysis
     * @param float $similarity
     *
     * @return string[][][]
     */
    public function analyze(array $logForAnalysis, float $similarity = 0.9): array;
}
