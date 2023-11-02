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

namespace Labofgood\DbQueryLogExtended\Plugin\Db\Logger;

use Magento\Framework\App\Request\Http;
use Magento\Framework\DB\Logger\LoggerAbstract;

/**
 * Class File
 *
 * Add additional information to the query log.
 */
class File
{
    /**
     * @param Http $request
     * @param int $counter
     * @param string $cliCommandLine
     * @param string $requestUriLine
     * @param string $uidLine
     */
    public function __construct(
        private readonly Http $request,
        private int $counter = 1,
        private string $cliCommandLine = '',
        private string $requestUriLine = '',
        private string $uidLine = ''
    ) {
    }

    /**
     * Add additional information to the query log (cli command line or request uri and record number).
     *
     * @param LoggerAbstract $subject
     * @param string $message
     * @param string $type
     * @param string $sql
     * @param array<string, string|int|float|bool> $bind
     * @param \Zend_Db_Statement_Pdo|null $result
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetStats(
        LoggerAbstract $subject,
        string $message,
        $type,
        $sql,
        $bind = [],
        $result = null
    ): string {
        $nl   = "\n";
        $additionalMessage = $this->getUidLine() . $nl;
        $additionalMessage .= $this->getRecordNumber() . $nl;

        if (PHP_SAPI === 'cli') {
            $additionalMessage .= $this->getCliCommandLine();
        } else {
            $additionalMessage .= $this->getRequestUriLine();
        }

        $additionalMessage .= $nl;

        return $additionalMessage . $message;
    }

    /**
     * Get record number.
     *
     * @return string
     */
    private function getRecordNumber(): string
    {
        return sprintf('RECORD: %d', $this->counter++);
    }

    /**
     * Get CLI command line.
     *
     * @return string
     */
    private function getCliCommandLine(): string
    {
        if (!$this->cliCommandLine) {
            $this->cliCommandLine = 'CLI COMMAND: '
                . implode(' ', $this->request->getServer('argv', []));
        }

        return $this->cliCommandLine;
    }

    /**
     * Get request URI line.
     *
     * @return string
     */
    private function getRequestUriLine(): string
    {
        if (!$this->requestUriLine) {
            $this->requestUriLine = 'REQUEST URI: ' . $this->request->getRequestUri();
        }

        return $this->requestUriLine;
    }

    /**
     * Get UID line.
     *
     * @return string
     */
    private function getUidLine(): string
    {
        if (!$this->uidLine) {
            $this->uidLine = 'UID: ' . uniqid('db_', true);
        }

        return $this->uidLine;
    }
}
