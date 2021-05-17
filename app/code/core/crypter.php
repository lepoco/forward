<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward\Core;

defined('ABSPATH') or die('No script kiddies please!');

final class Crypter
{

    /**
     * Encrypts data depending on the selected method, default password
     *
     * @access   public
     * @param    string $string
     * @param    string $type
     * @return   string
     */
    public static function encrypt(
        string $text,
        ?string $type = 'password'
    ): string {
        switch ($type) {
            case 'password':
                return (defined('FORWARD_ALGO') ? password_hash(hash_hmac('sha256', $text, PASSWORD_SALT), FORWARD_ALGO) : '');

            case 'nonce':
                return (defined('NONCE_SALT') ? hash_hmac('sha1', $text, NONCE_SALT) : '');
                break;

            case 'token':
                return (defined('SESSION_SALT') ? hash_hmac('sha256', $text, SESSION_SALT) : '');
                break;

            default:
                return hash_hmac('sha256', $text, self::salter(60));
        }
    }

    /**
     * Compares encrypted data with those in the database
     *
     * @access   public
     * @param    string $text
     * @param    string $compare_text
     * @param    string $type
     * @param    bool   $plain
     * @return   bool
     */
    public static function compare(
        string $text,
        string $compare_text,
        string $type = 'password',
        bool $plain = true
    ): bool {
        switch ($type) {
            case 'password':
                if (password_verify(($plain ? hash_hmac('sha256', $text, PASSWORD_SALT) : $text), $compare_text)) {
                    return true;
                } else {
                    return false;
                }

            case 'nonce':
                if (($plain ? hash_hmac('sha1', $text, NONCE_SALT) : $text) == $compare_text) {
                    return true;
                } else {
                    return false;
                }

            case 'token':
                if (($plain ? hash_hmac('sha256', $text, SESSION_SALT) : $text) == $compare_text) {
                    return true;
                } else {
                    return false;
                }

            default:
                return false;
        }
    }

    /**
     * Generates a pseudo-random string
     *
     * @access   public
     * @param    int $length
     * @return   string
     */
    public static function salter(int $length, ?string $pattern = 'ULNS'): string
    {
        self::sRandSeed();

        if (empty($pattern)) {
            $pattern = 'ULNS';
        }
        $pattern = strtoupper($pattern);

        $characters = '';
        if (strpos($pattern, 'U') !== false) {
            $characters .= 'GHIJKLMNOPQRSTUVWXYZABCDEF';
        }

        if (strpos($pattern, 'L') !== false) {
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        }

        if (strpos($pattern, 'N') !== false) {
            $characters .= '0123456789';
        }

        if (strpos($pattern, 'S') !== false) {
            $characters .= '!@#$%^&*()_+-={}[];:,.<>?|~';
        }

        $rand = '';
        for ($i = 0; $i < $length; $i++) {
            $rand .= $characters[mt_rand(0, strlen($characters) - 1)]; //Mersenne Twist
        }

        return $rand;
    }


    /**
     * Generates a pseudo-random seed
     *
     * @access   private
     * @return   void
     */
    private static function sRandSeed(): void
    {
        $characters = '+MNT%#aefbcklmnQRSX67D*&^YZ_oJKLUVWpqijP-=@.z012345EFrstuvdg,?!ABChwxy89GHIO';
        $crx = '';
        for ($i = 0; $i < 50; $i++) {
            $crx .= $characters[mt_rand(0, 75)];
        }

        $rand = intval(crc32(self::buildSeed() . '@' . $crx) * 2147483647);
        mt_srand($rand);
    }

    /**
     * Flips a random seed based on the timecode
     *
     * @access   private
     * @return   int
     */
    private static function buildSeed(): int
    {
        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
    }
}
