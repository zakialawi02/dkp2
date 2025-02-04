<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// HTTP language settings
return [
    // CurlRequest
    'missingCurl'     => 'CURL must be enabled to use the CURLRequest class.',
    'invalidSSLKey'   => 'Unable to set SSL Key. {0} is not a valid file.',
    'sslCertNotFound' => 'SSL certificate not found at: "{0}"',
    'curlError'       => '"{0}" : "{1}"',

    // IncomingRequest
    'invalidNegotiationType' => '"{0}" is not a valid negotiation type. Must be one of: media, charset, encoding, language.',

    // Message
    'invalidHTTPProtocol' => 'Invalid HTTP Protocol version. Must be one of: "{0}"',

    // Negotiate
    'emptySupportedNegotiations' => 'You must provide an array of supported values for all Negotiations.',

    // RedirectResponse
    'invalidRoute' => 'Route for "{0}" cannot be found.',

    // DownloadResponse
    'cannotSetBinary'        => 'When setting a filepath, binary cannot be set.',
    'cannotSetFilepath'      => 'When setting binary, filepath cannot be set: "{0}"',
    'notFoundDownloadSource' => 'Download source body not found.',
    'cannotSetCache'         => 'Cache is not supported for downloads.',
    'cannotSetStatusCode'    => 'Changing the status code for downloads is not supported. code: "{0}", reason: "{1}"',

    // Response
    'missingResponseStatus' => 'HTTP response is missing a status code',
    'invalidStatusCode'     => '"{0}" is not a valid HTTP return status code',
    'unknownStatusCode'     => 'Unknown HTTP status code provided without a message: "{0}"',

    // URI
    'cannotParseURI'       => 'Unable to parse URI: "{0}"',
    'segmentOutOfRange'    => 'URI segment request is out of range: "{0}"',
    'invalidPort'          => 'Port must be between 0 and 65535. Given: "{0}"',
    'malformedQueryString' => 'Query string must not include URI fragments.',

    // Page Not Found
    'pageNotFound'       => 'Page Not Found',
    'emptyController'    => 'No Controller specified.',
    'controllerNotFound' => 'Controller or its method not found: "{0}"::"{1}"',
    'methodNotFound'     => 'Controller method not found: "{0}"',
    'localeNotSupported' => 'Locale "{0}" is not supported',

    // CSRF
    'disallowedAction' => 'The action you requested is not allowed.',

    // Uploaded file moving
    'alreadyMoved' => 'The uploaded file has already been moved.',
    'invalidFile'  => 'The original file is not a valid file.',
    'moveFailed'   => 'Unable to move file "{0}" to "{1}" ("{2}")',

    'uploadErrOk'        => 'File successfully uploaded.',
    'uploadErrIniSize'   => 'File "%s" exceeds your upload_max_filesize setting.',
    'uploadErrFormSize'  => 'File "%s" exceeds the form upload limit.',
    'uploadErrPartial'   => 'File "%s" was only partially uploaded.',
    'uploadErrNoFile'    => 'No file was uploaded.',
    'uploadErrCantWrite' => 'File "%s" cannot be written to disk.',
    'uploadErrNoTmpDir'  => 'File cannot be uploaded: temporary directory missing.',
    'uploadErrExtension' => 'File upload was stopped by a PHP extension.',
    'uploadErrUnknown'   => 'File "%s" was not uploaded due to an unknown error.',

    // SameSite setting
    'invalidSameSiteSetting' => 'SameSite setting must be None, Lax, Strict, or empty string. Given: "{0}"',
];
