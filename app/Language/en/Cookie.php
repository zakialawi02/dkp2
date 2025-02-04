<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Cookie language settings
return [
    'invalidExpiresTime'    => 'The "{0}" type is invalid for the "Expires" attribute. Expected: string, integer, DateTimeInterface object.',
    'invalidExpiresValue'   => 'The cookie expiration time is invalid.',
    'invalidCookieName'     => 'The cookie name "{0}" contains invalid characters.',
    'emptyCookieName'       => 'The cookie name cannot be empty.',
    'invalidSecurePrefix'   => 'Using the "__Secure-" prefix requires the "Secure" attribute to be set.',
    'invalidHostPrefix'     => 'Using the "__Host-" prefix requires the "Secure" attribute to be set, must not have a "Domain" attribute, and "Path" must be set to "/".',
    'invalidSameSite'       => 'The SameSite value must be None, Lax, Strict, or an empty string, given "{0}".',
    'invalidSameSiteNone'   => 'Using the "SameSite=None" attribute requires the "Secure" attribute to be set.',
    'invalidCookieInstance' => 'Class "{0}" expects the cookie array to be an instance of "{1}", but got "{2}" at index "{3}".',
    'unknownCookieInstance' => 'Cookie object with the name "{0}" and prefix "{1}" was not found in the collection.',
];
