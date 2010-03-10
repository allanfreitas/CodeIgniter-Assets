<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Additional custom CodeIgniter Inflector Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Daniel Ott
 * @link		http://danott.us
 */

// ------------------------------------------------------------------------

/**
 * Return the Twitter-style "relative time"
 *
 * Returns time() or its GMT equivalent based on the config file preference
 *
 * @access	public
 * @param	integer Unix timestamp
 * @return	string
 * @todo    Add future date support with "seconds away", "days away", etc.
 */
if ( ! function_exists('relative_time'))
{
	function relative_time($then)
	{
		// Need the date helper for the now() function
		$CI =& get_instance();
		$CI->load->helper('date');

		$diff = now() - strtotime($then);
		
		// If then is before now, $diff will be positive, and $then is in the past
		// If now is before then, $diff will be negative, and $then is in the future
		$direction = ($diff > 0) ? "ago" : "away";
		
		$diff = abs($diff);
		
		// It's a matter of seconds!
		if ($diff<60)
			return $diff . " " . pluralize("second", $diff) . " " . $direction;

		// It's a matter of minutes!
		$diff = round($diff/60);
		if ($diff<60)
			return $diff . " " . pluralize("minute", $diff) . " " . $direction;

		// It's a matter of hours!
		$diff = round($diff/60);
		if ($diff<24)
			return $diff . " " . pluralize("hour", $diff) . " " . $direction;

		// It's a matter of days!
		$diff = round($diff/24);
		if ($diff<7)
			return $diff . " " . pluralize("day", $diff) . " " . $direction;

		// It's a matter of weeks!
		$diff = round($diff/7);
		if ($diff<4)
			return $diff . " " . pluralize("week", $diff) . " " . $direction;
		
		// Forget about months and years, just say the date.
		return "on " . date("F j, Y", strtotime($then));
	}
}

/**
 * Pluralize a singular word
 *
 * CodeIgniter's built in inflector gives us a plural() function.
 * This is simply a wrapper around that, that does the actual pluralization
 * based on a passed in parameter of how many we're dealing with.
 *
 * @access	public
 * @param	string 
 * @param	integer
 * @param	string
 * @return	string
 */
if( ! function_exists('pluralize'))
{
	function pluralize($singular_word, $how_many = 2, $irregular_plural = null)
	{
		return ($how_many == 1) ? $singular_word : ((isset($irregular_plural)) ? $irregular_plural : plural($singular_word));
	}
}

/* End of file MY_inflector_helper.php */
/* Location: ./system/application/helpers/MY_inflector_helper.php */