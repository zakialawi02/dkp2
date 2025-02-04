<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Images language settings
return [
    'sourceImageRequired'    => 'You must specify a source image in your preferences.',
    'gdRequired'             => 'The GD image library is required to use this feature.',
    'gdRequiredForProps'     => 'Your server must support the GD image library to determine image properties.',
    'gifNotSupported'        => 'GIF images are often not supported due to licensing restrictions. You may need to use JPG or PNG images instead.',
    'jpgNotSupported'        => 'JPG images are not supported.',
    'pngNotSupported'        => 'PNG images are not supported.',
    'webpNotSupported'       => 'WEBP images are not supported.',
    'fileNotSupported'       => 'The given file is not a supported image type.',
    'unsupportedImageCreate' => 'Your server does not support the GD functions required to process this image type.',
    'jpgOrPngRequired'       => 'The image resizing protocol specified in your preferences works only with JPEG or PNG images.',
    'rotateUnsupported'      => 'Image rotation seems to be unsupported by your server.',
    'libPathInvalid'         => 'The path to your image library is incorrect. Please set the correct path in your image preferences. "{0}", string)',
    'imageProcessFailed'     => 'Image processing failed. Please verify that your server supports the selected protocol and that the path to your image library is correct.',
    'rotationAngleRequired'  => 'A rotation angle is required to rotate the image.',
    'invalidPath'            => 'The path to the image is incorrect.',
    'copyFailed'             => 'Image copy failed.',
    'missingFont'            => 'Unable to find a font to use.',
    'saveFailed'             => 'Unable to save the image. Make sure the image and file directories are writable.',
    'invalidDirection'       => 'The flip direction must be either `vertical` or `horizontal`. Given: "{0}"',
    'exifNotSupported'       => 'Reading EXIF data is not supported by this PHP installation.',
];
