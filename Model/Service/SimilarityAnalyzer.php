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

namespace Labofgood\DbQueryLogExtended\Model\Service;

use Labofgood\DbQueryLogExtended\Api\Model\Service\SimilarityAnalyzerInterface;

/**
 * Class SimilarityAnalyzer
 *
 * Analyze similarity in logs.
 */
class SimilarityAnalyzer implements SimilarityAnalyzerInterface
{
    /**
     * @param string $keyForSimilarity
     */
    public function __construct(
        private readonly string $keyForSimilarity
    ) {
    }

    /**
     * Get the similarity in logs and return array of similar groups.
     *
     * @param array<int, array<string, string>> $logForAnalysis
     * @param float $similarity
     *
     * @return string[][][]
     */
    public function analyze(array $logForAnalysis, float $similarity = 0.9): array
    {
        $groups = [];
        $notAnalyzedLogs = [];

        foreach ($logForAnalysis as $log) {
            $found = false;

            if (!array_key_exists($this->keyForSimilarity, $log)) {
                $notAnalyzedLogs[] = $log;
                continue;
            }

            foreach ($groups as $index => $group) {
                $similar = $this->similarity($group[0][$this->keyForSimilarity], $log[$this->keyForSimilarity]);

                if ($similar > $similarity) {
                    $groups[$index][] = $log;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $groups[] = [$log];
            }
        }

        foreach ($notAnalyzedLogs as $log) {
            $groups[] = [$log];
        }

        return $groups;
    }

    /**
     * Calculate similarity between two lines based on Levenshtein distance.
     *
     * @param string $firstLine
     * @param string $secondLine
     *
     * @return float
     */
    private function similarity(string $firstLine, string $secondLine): float
    {
        $distance = levenshtein(strtoupper($firstLine), strtoupper($secondLine));
        $diff = max(strlen($firstLine), strlen($secondLine));

        return (float) (1 - ($distance / $diff));
    }
}
