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

		private $total_clicks;

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
			if( $total_clicks == null )
			{
				$total_clicks = 0;
				foreach ( $this->records as $record )
				{
					$total_clicks += $record['record_clicks'];
				}
			}
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
	}

?>
