<?php
namespace Nerdstorm\FileMime;

/**
 * Inspects data for common formats using Linux specific tools.
 */
class MimeHelper
{
    static $finfo = null;

    /**
     * Get MIME-type from a file in the file system.
     *
     * @param  string $filepath
     * @return array
     */
    public static function guessMimeType($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception('File doesn\'t exist ' . $filepath);
        }

        if (null === self::$finfo) {
            self::$finfo = finfo_open(FILEINFO_MIME_TYPE);
        }

        return finfo_file(self::$finfo, $filepath);
    }

    /**
     * Get the file extension from the file in the filesystem.
     * If there are more than one matching extension,
     * returning array will have each extension.
     *
     * @param  string $filepath
     * @return array
     */
    public static function guessExtensionFromFilePath($filepath)
    {
        $mime_type = self::guessMimetype($filepath);

        if (empty($mime_type)) {
            throw new UnexpectedValueException('empty MIME-type');
        }

        return MimeTypes::getExtension($mime_type);
    }

    /**
     * Get the file extension from the MIME-type. If there are more than
     * one matching extension, returning array will have each extension.
     *
     * @param  string $mimetype
     * @return array
     */
    public static function guessExtensionFromMimeType($mimetype)
    {
        if (empty($mime_type)) {
            throw new UnexpectedValueException('empty MIME-type');
        }

        return MimeTypes::getExtension($mime_type);
    }
}
