<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Database language settings
return [
    'invalidEvent'                     => '"{0}" is not a valid Model Event callback.',
    'invalidArgument'                  => 'You must provide a valid "{0}".',
    'invalidAllowedFields'             => 'Allowed fields must be specified for the model: "{0}"',
    'emptyDataset'                     => 'No data found for "{0}".',
    'emptyPrimaryKey'                  => 'No primary key specified when attempting to create "{0}".',
    'failGetFieldData'                 => 'Failed to retrieve field data from the database.',
    'failGetIndexData'                 => 'Failed to retrieve index data from the database.',
    'failGetForeignKeyData'            => 'Failed to retrieve foreign key data from the database.',
    'parseStringFail'                  => 'Failed to parse the key string.',
    'featureUnavailable'               => 'Feature is unavailable for the database you are using.',
    'tableNotFound'                    => 'Table "{0}" not found in the current database.',
    'noPrimaryKey'                     => 'Model class "{0}" has not defined a Primary Key.',
    'noDateFormat'                     => 'Model class "{0}" does not have a valid dateFormat.',
    'fieldNotExists'                   => 'Field "{0}" does not exist.',
    'forEmptyInputGiven'               => 'Empty statement given for field "{0}"',
    'forFindColumnHaveMultipleColumns' => 'Only one column is allowed in the Column name.',
    'methodNotAvailable'               => 'Method "{1}" in "{0}" cannot be used. This is a `Query Builder` class method.',
];
