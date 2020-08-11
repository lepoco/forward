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
	* Model [Dashboard]
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Model extends Models
	{
		private int $total_clicks = -1;

		private string $new_record = '';

		private array $last_visitors = array();

		private array $records = array();

		private array $translator;

		protected function Init() : void
		{
			$this->GetRecords();
			$this->GetLastVisitors();

			$this->translator = array(
				'e1'  => $this->__('Something went wrong!'),
				'e7'  => $this->__('You must provide a URL!'),
				'e8'  => $this->__('A record with this ID already exists!'),
				'e10' => $this->__('The URL you entered is not valid!')
			);
		}

		private function GetRecords() : void
		{
			if( empty( $this->records ))
			{
				$query = $this->Forward->Database->query( "SELECT * FROM forward_records WHERE record_active = true ORDER BY record_id DESC" )->fetchAll();
			
				if( !empty( $query ) )
				{
					$this->records = $query;
				}
			}
		}

		private function GetLastVisitors() : void
		{
			$records = $this->Forward->Database->query( "SELECT visitor_origin_id, visitor_language_id FROM forward_statistics_visitors ORDER BY visitor_id DESC LIMIT ?", $this->Forward->Options->Get( 'latest_visitors_limit', 200 ) )->fetchAll();

			if( !empty( $records ) )
			{
				$languages = $this->Forward->Database->query( "SELECT * FROM forward_statistics_languages" )->fetchAll();
				$origins = $this->Forward->Database->query( "SELECT * FROM forward_statistics_origins" )->fetchAll();

				$this->last_visitors = $records;
			}
		}

		public function TotalClicks() : int
		{
			if( $this->total_clicks == -1 )
			{
				$this->total_clicks = 0;
				foreach ( $this->records as $record )
				{
					$this->total_clicks += $record['record_clicks'];
				}
			}

			return $this->total_clicks;
		}

		public function TopReferrer() : string
		{
			$origins = array();
			$origin = $this->__( 'Unknown' );

			foreach ( $this->last_visitors as $visitor )
				if( isset( $origins[ $visitor[ 'visitor_origin_id' ] ] ) )
					$origins[ $visitor[ 'visitor_origin_id' ] ]++;
				else
					$origins[ $visitor[ 'visitor_origin_id' ] ] = 1;

			arsort( $origins );

			$query = $this->Forward->Database->query( "SELECT origin_name FROM forward_statistics_origins WHERE origin_id = ?", key( $origins ) )->fetchArray();

			if( !empty( $query ) )
				switch ( $query[ 'origin_name' ]  )
				{
					case 'direct':
						$origin = $this->__( 'Email, SMS, Direct' );
						break;
					case 'www.youtube.com':
						$origin = 'YouTube';
						break;
					case 'www.facebook.com':
						$origin = 'Facebook';
						break;
					default:
						$origin = $query[ 'origin_name' ];
						break;
				}

			return $origin;
		}

		public function TopLanguage() : string
		{
			$languages = array();
			$language = $origin = $this->__( 'Unknown' );

			foreach ( $this->last_visitors as $visitor )
				if( isset( $languages[ $visitor[ 'visitor_language_id' ] ] ) )
					$languages[ $visitor[ 'visitor_language_id' ] ]++;
				else
					$languages[ $visitor[ 'visitor_language_id' ] ] = 1;

			arsort( $languages );
			$query = $this->Forward->Database->query( "SELECT language_name FROM forward_statistics_languages WHERE language_id = ?", key( $languages ) )->fetchArray();

			if( !empty( $query ) )
				switch ( substr( strtolower( $query[ 'language_name' ] ), 0, 2) )
				{
					case 'en':
						$language = $this->__( 'English' );
						break;
					case 'pl':
						$language = $this->__( 'Polish' );
						break;
					default:
						$language = $query[ 'language_name' ];
						break;
				}

			return $language;
		}

		public function Records() : array
		{
			return $this->records;
		}

		public function ShortUrl( $url ) : string
		{
			if( $url > 15)
			{
				return substr( $url, 0, 15) . '...';
			}
			else
			{
				return $url;
			}
		}

		public function NewRecord() : string
		{
			if( $this->new_record == '')
				$this->new_record = strtoupper( Crypter::BaseSalter(6) );

			return $this->new_record;
		}

		public function Header()
		{
			//Translator
			$html  = "\t\t" . "<script type=\"text/javascript\" nonce=\"$this->js_nonce\">" . PHP_EOL . "\t\t\t" . 'let translator = {';
			$c = 0;
			foreach ( $this->translator as $key => $value )
			{
				$c++;
				$html .= ($c > 1 ? ' ,' : '') . $key . ': "' . $value . '"';
			}
			$html .= '};';

			//Records
			$html .= PHP_EOL . "\t\t\t" . 'let records = {'; $c = 0;
			foreach ( $this->records as $r )
			{
				$c++;
				$html .= PHP_EOL . ($c > 1 ? ', ' : '') . $r['record_id'] . ': [' . $r['record_id'] . ',' . $r['record_author'] . ',"' . $r['record_name'] . '","' . $r['record_display_name'] . '","' . $r['record_url'] . '","' . $r['record_updated'] . '","' . $r['record_created'] . '"]';
			}
			$html .= '};';

			echo $html . PHP_EOL . "\t\t</script>" . PHP_EOL;
		}
	}

?>
