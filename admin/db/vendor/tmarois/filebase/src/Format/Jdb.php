<?php  namespace Filebase\Format;


class Jdb implements FormatInterface
{
    /**
     * @return string
     */
    public static function getFileExtension()
    {
        return 'jsdb.php';
    }

    /**
     * @param array $data
     * @param bool $pretty
     * @return string
     * @throws FormatException
     */
    public static function encode($data = [], $pretty = true)
    {
        $options = 0;
        if ($pretty == true) {
            $options = JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE;
        }

        $encoded = json_encode($data, $options);
        if ($encoded === false) {
            throw new EncodingException(
                "json_encode: '" . json_last_error_msg() . "'",
                0,
                null,
                $data
            );
        }

        return '<?php die("No script kiddies please!");/*'.$encoded.'*/?>';
    }

    /**
     * @param $data
     * @return mixed
     * @throws FormatException
     */
    public static function decode($data)
    {
        $decoded = substr($data, 41);
        $decoded = substr($decoded, 0, -4);
        $decoded = json_decode($decoded, true);

        if ($data !== false && $decoded === null) {
            throw new DecodingException(
                "json_decode: '" . json_last_error_msg() . "'",
                0,
                null,
                $data
            );
        }

        return $decoded;
    }
}
