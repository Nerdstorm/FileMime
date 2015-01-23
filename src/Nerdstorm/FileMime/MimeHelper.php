<?php
namespace Nerdstorm\FileMime;

/**
 * Inspects data for common formats using Linux specific tools.
 */
class MimeHelper
{
    static $finfo = null;

    public static function guessMimetype($filepath)
    {
        if (null === self::$finfo) {
            self::$finfo = finfo_open(FILEINFO_MIME_TYPE);
        }

        return finfo_file(self::$finfo, $filepath);
    }

    public static function guessExtensionFilePath($filepath)
    {
        $mime_type = self::guessMimetype($filepath);

        if (empty($mime_type)) {
            throw new UnexpectedValueException('empty MIME-type');
        }

        return MimeTypes::getExtension($mime_type);
    }
}
