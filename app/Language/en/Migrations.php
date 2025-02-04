<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Migration language settings
return [
    // Migration Runner
    'missingTable'  => 'The migration table must be set.',
    'disabled'      => 'Migration has been loaded but is disabled or misconfigured.',
    'notFound'      => 'Migration file not found: ',
    'batchNotFound' => 'Target batch not found: ',
    'empty'         => 'No Migration files found',
    'gap'           => 'There is a gap in the migration sequence near version number: ',
    'classNotFound' => 'Migration class "%s" could not be found.',
    'missingMethod' => 'Migration class is missing method "%s".',

    // Migration Command
    'migHelpLatest'   => "\t\tMigrate the database to the latest available migration.",
    'migHelpCurrent'  => "\t\tMigrate the database to the version set as 'current' in the configuration.",
    'migHelpVersion'  => "\tMigrate the database to version {v}.",
    'migHelpRollback' => "\tRollback all migrations 'down' to version 0.",
    'migHelpRefresh'  => "\t\tUninstall and rerun all migrations to refresh the database.",
    'migHelpSeed'     => "\tRun the seeder named [name].",
    'migCreate'       => "\tCreate a new migration file named [name]",
    'nameMigration'   => 'Give the migration file a name',
    'migNumberError'  => 'Migration number must be three digits and no spaces in the sequence.',
    'rollBackConfirm' => 'Are you sure you want to perform a rollback?',
    'refreshConfirm'  => 'Are you sure you want to refresh?',

    'latest'            => 'Running all new migrations...',
    'generalFault'      => 'Migration failed!',
    'migrated'          => 'Migration complete.',
    'migInvalidVersion' => 'An invalid version number was given.',
    'toVersionPH'       => 'Migrating to version %s...',
    'toVersion'         => 'Migrating to the current version...',
    'rollingBack'       => 'Rolling back all migrations...',
    'noneFound'         => 'No migrations found.',
    'migSeeder'         => 'Seeder name',
    'migMissingSeeder'  => 'You must provide a seeder name.',
    'nameSeeder'        => 'Give the seeder file a name',
    'removed'           => 'Rolling back: ',
    'added'             => 'Running: ',

    // Migrate Status
    'namespace' => 'Namespace',
    'filename'  => 'File name',
    'version'   => 'Version',
    'group'     => 'Group',
    'on'        => 'Migrated On: ',
    'batch'     => 'Batch',
];
