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
		private $records = array();

		private $total_clicks = -1;

		private $new_record = '';

		private $last_visitors = array();

		protected function Init() : void
		{
			$this->GetRecords();
			$this->GetLastVisitors();
		}

		private function GetRecords() : void
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_records" )->fetchAll();
			
			if( !empty( $query ) )
			{
				$this->records = $query;
			}
		}

		private function GetLastVisitors() : void
		{
			$query = $this->Forward->Database->query( "SELECT visitor_origin, visitor_language FROM forward_statistics_visitors ORDER BY visitor_id DESC LIMIT 100" )->fetchAll();
			
			if( !empty( $query ) )
			{
				$this->last_visitors = $query;
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
			$origins = array(
				'Direct' => 0,
				'Facebook' => 0,
				'YouTube' => 0
			);

			foreach ( $this->last_visitors as $visitor )
			{
				if(  trim( $visitor['visitor_origin'] ) === '' )
				{
					$origins['Direct']++;
					continue;
				}

				$origin = strtolower( $visitor['visitor_origin'] );

				if( strpos($origin, 'youtube'))
				{
					$origins['YouTube']++;
				}
			}

			arsort( $origins );

			return key( $origins );
		}

		public function TopLanguage() : string
		{
			$languages = array(
				'Polish' => 0,
				'English' => 0
			);

			foreach ( $this->last_visitors as $visitor )
			{
				$code = substr( strtolower( $visitor['visitor_language'] ), 0, 2);

				switch ( $code )
				{
					case 'pl':
						$languages['Polish']++;
						break;
					case 'en':
						$languages['English']++;
						break;
					
					default:
						if( isset( $languages[ $code ] ) )
							$languages[ $code ]++;
						else
							$languages[ $code ] = 1;
						break;
				}
			}

			arsort( $languages );

			return key( $languages );
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

		public function NewRecord()
		{
			if( $this->new_record == '')
				$this->new_record = strtoupper( Crypter::BaseSalter(6) );

			return $this->new_record;
		}
	}

?>
