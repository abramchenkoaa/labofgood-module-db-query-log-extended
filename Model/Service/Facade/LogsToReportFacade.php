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

use Labofgood\DbQueryLogExtended\Api\Model\Service\Facade\LogsToReportFacadeInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\LogRecordsCombinerInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\Parser\QueryLogParserInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportFormat\PrepperInterface;
use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportGeneratorInterface;
use Magento\Framework\Exception\FileSystemException;

/**
 * Class LogsToReportFacade
 *
 * Used to generate report from db.log.
 */
class LogsToReportFacade implements LogsToReportFacadeInterface
{
    /**
     * @param QueryLogParserInterface $queryLogParser
     * @param ReportGeneratorInterface $reportGenerator
     * @param LogRecordsCombinerInterface $logRecordsCombiner
     * @param PrepperInterface $reportFormatPrepper
     */
    public function __construct(
        private readonly QueryLogParserInterface $queryLogParser,
        private readonly ReportGeneratorInterface $reportGenerator,
        private readonly LogRecordsCombinerInterface $logRecordsCombiner,
        private readonly PrepperInterface $reportFormatPrepper
    ) {
    }

    /**
     * Generate report from db.log.
     *
     * @param string $pathToFile
     * @param string|null $outputFile
     *
     * @return string
     * @throws FileSystemException
     */
    public function execute(string $pathToFile, ?string $outputFile = null): string
    {
        $parsedData = $this->queryLogParser->parse($pathToFile);
        $preparedData = $this->logRecordsCombiner->combine($parsedData);
        $reportData = $this->reportFormatPrepper->forReport($preparedData);

        return $this->reportGenerator
            ->setOutputDirectory($outputFile)
            ->generate($reportData);
    }
}
