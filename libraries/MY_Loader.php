<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter MY_Loader Class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Daniel Ott
 * @version     0.1
 * @link        http://codeigniter.com/wiki/Unobtrusive_XHR/
 *
 * In a default implementation of CodeIgniter, just drop this file in
 * ~/system/application/libraries/, and it will be completely ready to work.
 */

/**
 * We'll use one file extension globally. If someone has other needs they can
 * change this or build on the library.
 */
if (!defined('XHR_EXTENSION')) define('XHR_EXTENSION', 'json');


class MY_Loader extends CI_Loader {

    function MY_Loader() {
        parent::CI_Loader();
	
		/**
		 * Set an internal variable to know if the current controller request
		 * was made with XmlHttpRequest.
		 * Found at: http://codeigniter.com/forums/viewthread/59450/#292979
		 */
		$this->is_xhr = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest");
    }

	/**
	 * This function has been modified in MY_Loader to automatically load the
	 * JSON version of a view, if the request was made through XMLHTTPRequest.
	 * Example $this->load->view('home/create_event') would originally load 
	 * home/create_event.php, now it would open home/create_event.json.php
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @param   bool
	 * @return	void
	 * @todo	Optional fourth parameter that would override this functionality
	 */
	function view($view, $vars = array(), $return = FALSE, $ignore_xhr = FALSE)
	{

		// Only overloading things that are requested with XmlHttpRequest
		if($this->is_xhr && !$ignore_xhr)
		{
			/**
			 * Build the modified view's path in the most forgiving way. This
			 * will create the correct path if the .php extension is included
			 * or left out of the original call to $this->load->view()
			 */
			$modified_view = pathinfo($view, PATHINFO_DIRNAME) . "/" . pathinfo($view, PATHINFO_FILENAME) . "." . XHR_EXTENSION . ".php";
		
			/**
			 * Overloading the view will only take place if the new view file
			 * actually exists. Haven't tested this extensively in the field,
			 * may have to cut this part if there are performance hits.
			 */
			if( file_exists($this->_ci_view_path . $modified_view) )
			{
				log_message('debug', 'My_Loader detected XHR and a corresponding template. Now loading view: ' . $modified_view);
				$view = $modified_view;
			}
		}
	
		// Call as usual, the original or modified view.
		return parent::view($view, $vars, $return);
	}
}

/* End of file MY_Loader.php */
/* Location: ./system/application/libraries/My_Loader.php */