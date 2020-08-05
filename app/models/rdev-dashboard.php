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

		protected function Init() : void
		{
			$this->GetRecords();
		}

		private function GetRecords() : void
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_records" )->fetchAll();
			
			if( !empty( $query ) )
			{
				$this->records = $query;
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
