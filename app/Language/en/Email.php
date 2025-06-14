<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Email language settings
return [
    'mustBeArray'          => 'The email validation method must pass an array.',
    'invalidAddress'       => 'Invalid email address: "{0}"',
    'attachmentMissing'    => 'Unable to locate the following email attachment: "{0}"',
    'attachmentUnreadable' => 'Unable to open this attachment: "{0}"',
    'noFrom'               => 'Unable to send email without a "From" header.',
    'noRecipients'         => 'You must include recipients: To, Cc, or Bcc',
    'sendFailurePHPMail'   => 'Unable to send email using PHP mail(). Your server may not be configured to send email using this method.',
    'sendFailureSendmail'  => 'Unable to send email using PHP Sendmail. Your server may not be configured to send email using this method.',
    'sendFailureSmtp'      => 'Unable to send email using PHP SMTP. Your server may not be configured to send email using this method.',
    'sent'                 => 'Your message has been successfully sent using the following protocol: "{0}"',
    'noSocket'             => 'Unable to open a socket to Sendmail. Please check your settings.',
    'noHostname'           => 'You did not specify an SMTP hostname.',
    'SMTPError'            => 'The following SMTP error was encountered: "{0}"',
    'noSMTPAuth'           => 'Error: You must assign an SMTP username and password.',
    'failedSMTPLogin'      => 'Failed to send AUTH LOGIN command. Error: "{0}"',
    'SMTPAuthUsername'     => 'Failed to authenticate username. Error: "{0}"',
    'SMTPAuthPassword'     => 'Failed to authenticate password. Error: "{0}"',
    'SMTPDataFailure'      => 'Unable to send data: "{0}"',
    'exitStatus'           => 'Exit status code: "{0}"',
];
