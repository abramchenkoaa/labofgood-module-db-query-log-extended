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
declare(strict_types=1);

namespace Labofgood\DbQueryLogExtended\Console\Command;

use Labofgood\DbQueryLogExtended\Api\Model\Service\Facade\SimilarityAnalysisFacadeInterfaceFactory as FacadeFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyleFactory;

/**
 * Class SimilarityAnalysis
 *
 * Command for similarity analysis of queries in the log file.
 */
class SimilarityAnalysis extends Command
{
    /**
     * List of command arguments
     */
    private const PATH_TO_FILE = 'path_to_file';

    /**
     * @param State $state
     * @param SymfonyStyleFactory $styleFactory
     * @param FacadeFactory $facadeFactory
     * @param string|null $name
     */
    public function __construct(
        private readonly State $state,
        private readonly SymfonyStyleFactory $styleFactory,
        private readonly FacadeFactory $facadeFactory,
        string $name = null
    ) {
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('labofgood:dev:query-log:similarity-analysis');
        $this->setDescription(
            'Command for similarity analysis of queries in the log file.'
        );

        $this->addOption(
            self::PATH_TO_FILE,
            null,
            InputOption::VALUE_REQUIRED,
            'Path to the log file.'
        );

        $this->setHelp(
            <<<HELP
Example:
    --path_to_file - Path to the log file.
<comment>php bin/magento labofgood:dev:db_query_log:similarity_analysis --path_to_file=/path/to/file</comment>
HELP
        );

        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->state->emulateAreaCode(
            Area::AREA_FRONTEND,
            [$this, 'executeCommand'],
            [$input, $output]
        );

        return Cli::RETURN_SUCCESS;
    }

    /**
     * Get orders statistic by provided options.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function executeCommand(InputInterface $input, OutputInterface $output): void
    {
        $styledIo = $this->styleFactory->create(
            [
                'input' => $input,
                'output' => $output
            ]
        );

        try {
            $pathToFile = $input->getOption(self::PATH_TO_FILE);
            $generatedFile = $this->facadeFactory->create()->execute($pathToFile);
            $styledIo->success('Similarity analysis completed successfully. Generated File: ' . $generatedFile);
        } catch (\Throwable $exception) {
            $styledIo->error($exception->getMessage());
            $styledIo->error($exception->getTraceAsString());
        }
    }
}
