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

namespace Labofgood\DbQueryLogExtended\Model\Service\Facade;

use Labofgood\DbQueryLogExtended\Api\Model\Service\Facade\SimilarityAnalysisFacadeInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\LogRecordsCombinerInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\QueryLogParserInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportFormat\SimilarityAnalysisPrepperInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportGeneratorInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\SimilarityAnalyzerInterface;
use Magento\Framework\Exception\FileSystemException;

/**
 * Class SimilarityAnalysisFacade
 *
 * Used to execute similarity analysis and generate report from db.log.
 */
class SimilarityAnalysisFacade implements SimilarityAnalysisFacadeInterface
{
    /**
     * @param QueryLogParserInterface $queryLogParser
     * @param SimilarityAnalyzerInterface $similarityAnalyzer
     * @param ReportGeneratorInterface $reportGenerator
     * @param LogRecordsCombinerInterface $logRecordsCombiner
     * @param SimilarityAnalysisPrepperInterface $reportFormatPrepper
     */
    public function __construct(
        private readonly QueryLogParserInterface $queryLogParser,
        private readonly SimilarityAnalyzerInterface $similarityAnalyzer,
        private readonly ReportGeneratorInterface $reportGenerator,
        private readonly LogRecordsCombinerInterface $logRecordsCombiner,
        private readonly SimilarityAnalysisPrepperInterface $reportFormatPrepper
    ) {
    }

    /**
     * Execute similarity analysis and generate report from db.log.
     *
     * @param string $pathToFile
     *
     * @return string
     * @throws FileSystemException
     */
    public function execute(string $pathToFile): string
    {
        $parsedData = $this->queryLogParser->parse($pathToFile);
        $preparedData = $this->logRecordsCombiner->combine($parsedData);
        $analyzedData = [];

        foreach ($preparedData as $preparedDataItem) {
            $analyzedData[] = $this->similarityAnalyzer->analyze($preparedDataItem);
        }

        $reportData = $this->reportFormatPrepper->forSimilarityReport($analyzedData);

        return $this->reportGenerator->generate($reportData);
    }
}
