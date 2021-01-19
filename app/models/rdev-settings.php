<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	/**
	*
	* Model [Settings]
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Model extends Models
	{
		public function Footer()
		{
?>
	<script type="text/javascript" nonce="<?php echo $this->js_nonce; ?>">
            jQuery('#settings-form').on('submit', function(e) {
                e.preventDefault();

                jQuery.ajax({
                    url: forward.ajax,
                    type: 'post',
                    data: jQuery("#settings-form").serialize(),
                    success: function(e) {
                        if (e == 's01') {

                        } else {

                        }
                        console.log(e);
                    },
                    fail: function(xhr, textStatus, errorThrown) {
                        console.log(xhr);
                        console.log(textStatus);
                        console.log(errorThrown);

                    }
                });
            });
        </script>
<?php
		}
	}
