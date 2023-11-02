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

namespace Labofgood\DbQueryLogExtended\Model\Service;

use Labofgood\DbQueryLogExtended\Api\Model\Service\ReportGeneratorInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\DriverInterface as File;
use Magento\Framework\Filesystem\Io\File as IoFile;
use Shuchkin\SimpleXLSXGen;

/**
 * Class ReportGenerator
 *
 * Used to generate report in xlsx format.
 */
class ReportGenerator implements ReportGeneratorInterface
{
    /**
     * @param DirectoryList $directoryList
     * @param File $file
     * @param string $generatedFileName
     */
    public function __construct(
        private readonly DirectoryList $directoryList,
        private readonly File $file,
        private readonly IoFile $ioFile,
        private readonly string $generatedFileName,
        private readonly string $extension = 'xlsx',
        private ?string $fileDir = null,
        private ?string $fileName = null
    ) {
    }

    /**
     * Generate report.
     *
     * @param string[][] $records
     *
     * @return string
     * @throws FileSystemException
     */
    public function generate(array $records): string
    {
        return $this->generateXlsx($records);
    }

    /**
     * Set path info.
     *
     * @param string|null $outputFile
     *
     * @return $this
     */
    public function setOutputDirectory(string $outputFile = null): self
    {
        $pathInfo = $this->ioFile->getPathInfo($outputFile);
        $this->fileDir = $pathInfo['dirname'];
        $this->fileName = $pathInfo['filename'] . $this->getExtension();

        return $this;
    }

    /**
     * Generate Xlsx report file.
     *
     * @param string[][] $records
     *
     * @return string
     * @throws FileSystemException
     */
    private function generateXlsx(array $records): string
    {
        $folder = $this->getFolderName();

        if ($this->file->isDirectory($folder) === false) {
            $this->file->createDirectory($folder);
        }

        $reportFile = $folder . DIRECTORY_SEPARATOR . $this->getReportName();
        SimpleXLSXGen::fromArray($records)->saveAs($reportFile);

        return $reportFile;
    }

    /**
     * Get default report name.
     *
     * @return string
     */
    private function getReportName(): string
    {
        if ($this->fileName) {
            return $this->fileName;
        }

        return $this->generatedFileName
            . date('Y-m-d\TH:i:s')
            . $this->getExtension();
    }

    /**
     * Get default reports folder.
     *
     * @return string
     * @throws FileSystemException
     */
    private function getFolderName(): string
    {
        if ($this->fileDir) {
            return $this->fileDir;
        }

        return $this->directoryList->getPath('var')
            . DIRECTORY_SEPARATOR
            . 'debug'
            . DIRECTORY_SEPARATOR
            . 'reports';
    }

    /**
     * Get default file extension.
     *
     * @return string
     */
    private function getExtension(): string
    {
        return '.' . $this->extension;
    }
}
