<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2020, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	/**
	*
	* Translator
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Translator
	{
		public $locale;
		public $domain;

		private $strings_array = array();

		public function SetLocale( string $locale, string $domain = 'forward' ) : void
		{
			$this->locale = $locale;
			$this->domain = $domain;
		}

		public function Init() : void
		{
			if( $this->locale == NULL )
				$this->SetLanguage();

			if( file_exists( APPPATH . '/languages/' . $this->locale.'.json' ) )
				if( self::IsValid( APPPATH . '/languages/' . $this->locale.'.json' ) )
					$this->strings_array = json_decode( file_get_contents( APPPATH . '/languages/' . $this->locale.'.json'), true );
		}

		private static function IsValid($file) : bool
		{
			return true;
		}

		private function SetLanguage() : void
		{
			if( $this->locale == null )
			{
				$this->locale = $this->ParseLanguage();

				switch ( substr( strtolower( $this->locale ), 0, 2) )
				{
					case 'pl':
						$this->locale = 'pl_PL';
						break;
					
					default:
						$this->locale = 'en_US';
						break;
				}
			}
		}

		private function ParseLanguage() : string
		{
			$lang = '';
			$langs = array();

			preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), $matches, PREG_SET_ORDER);
			foreach($matches as $match)
			{
				list($a, $b) = explode('-', $match[1]) + array('', '');
				$value = isset($match[2]) ? (float) $match[2] : 1.0;
				$langs[$match[1]] = $value;

			}
			arsort($langs);

			if( count( $langs ) == 0 )
				return 'en_US';
			else
				return key($langs);
		}

		public function __($text)
		{
			if( array_key_exists( $text, $this->strings_array ) )
				return $this->strings_array[$text];
			else
				return $text;
		}

		public function _e($text)
		{
			echo $this->__($text);
		}
	}
?>
