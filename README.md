# Labofgood_DbQueryLogExtended module

## Overview
The `Labofgood_DbQueryLogExtended` module offers enhanced analysis capabilities for the `db.log` generated using Magento's command:
```bash
php bin/magento dev:query-log:enable
```
This module enriches the standard command functionalities by introducing:
- Extended information about queries added the record context (request uri or CLI command), record number, UID of process.
- Capability to export the log to an XLSX file format.
- A feature to do a similarity analysis of SQL queries and showcase them in a separate XLSX sheet.

## Prerequisites
 - PHP 8.1 or higher
 - Magento 2.4.5

## Dependencies
composer.json includes:
```
        "magento/module-developer": "100.4.*",
        "shuchkin/simplexlsxgen": "^1.3"
```

## Installation Steps
Please follow the instruction:

- Run `composer require labofgood/module-db-query-log-extended`
- Run `bin/magento setup:upgrade`

## Usage Guide

- To install, please adhere to the following steps:
```bash
php bin/magento dev:query-log:enable
```
- Browse the website or initiate a CLI command to populate db.log with queries.
- Run the following command to transform db.log into a XLSX file
```bash
php bin/magento labofgood:dev:query-log:convert-to-report --path_to_file=/var/www/html/var/debug/db.log
```
- For grouping similar queries and showcasing them in a separate XLSX sheet, run the following command:
```bash
php bin/magento labofgood:dev:query-log:similarity-analysis --path_to_file=/var/www/html/var/debug/db.log
```
- When done, deactivate the query log with:
```bash
php bin/magento dev:query-log:disable
```

## Uninstallation
To uninstall the module, run: `bin/magento module:uninstall Labofgood_DbQueryLogExtended`

## Credits
 - Anton Abramchenko <anton.abramchenko@labofgood.com>

## Licensing
This software is under the Open Software License (OSL 3.0). 
More details can be found at http://opensource.org/licenses/osl-3.0.php.