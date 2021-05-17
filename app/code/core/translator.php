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

final class Translator
{
    private const LOCALES = array(
        'en_US',
        'pl_PL',
        'de_DE'
    );

    public string $locale = '';
    public string $domain = '';

    private $strings_array = array();

    public function setLocale(string $locale, string $domain = 'forward'): void
    {
        $this->locale = $locale;
        $this->domain = $domain;
    }

    public function init(): void
    {
        if ($this->locale == NULL) {
            $this->setLanguage();
        }

        //Final check if language exists
        $present = false;
        foreach (self::LOCALES as $locale) {
            if ($this->locale == $locale) {
                $present = true;
            }
        }

        if (!$present) {
            $this->locale = 'en_US';
        }

        if (
            file_exists(APPPATH . '/languages/' . $this->locale . '.json')
            && self::isValid(APPPATH . '/languages/' . $this->locale . '.json')
        ) {
            $this->strings_array = json_decode(file_get_contents(APPPATH . '/languages/' . $this->locale . '.json'), true);
        }
    }

    private static function isValid($file): bool
    {
        return true;
    }

    private function setLanguage(): void
    {
        if ($this->locale == null) {
            $this->locale = $this->parseLanguage();

            switch (substr(strtolower($this->locale), 0, 2)) {
                case 'pl':
                    $this->locale = 'pl_PL';
                    break;

                default:
                    $this->locale = 'en_US';
                    break;
            }
        }
    }

    private function parseLanguage(): string
    {
        $lang = '';
        $langs = array();

        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            list($a, $b) = explode('-', $match[1]) + array('', '');
            $value = isset($match[2]) ? (float) $match[2] : 1.0;
            $langs[$match[1]] = $value;
        }
        arsort($langs);

        if (count($langs) == 0) {
            return 'en_US';
        } else {
            return key($langs);
        }
    }

    public function __($text): ?string
    {
        if (array_key_exists($text, $this->strings_array)) {
            return $this->strings_array[$text];
        } else {
            return $text;
        }
    }

    public function _e($text): void
    {
        echo $this->__($text);
    }
}
