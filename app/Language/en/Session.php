<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Session language settings
return [
    'missingDatabaseTable'   => '`sessionSavePath` must have a table name for the Database Session Handler to work.',
    'invalidSavePath'        => 'Session: The configured save path "{0}" is not a directory, does not exist, or cannot be created.',
    'writeProtectedSavePath' => 'Session: The configured save path "{0}" is not writable by the PHP process.',
    'emptySavePath'          => 'Session: No save path is configured.',
    'invalidSavePathFormat'  => 'Session: Invalid Redis save path format: "{0}"',
    'invalidSameSiteSetting' => 'Session: The SameSite setting must be None, Lax, Strict, or an empty string. Given: "{0}"',
];
