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
