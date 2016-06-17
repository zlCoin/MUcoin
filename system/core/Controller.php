<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

	public function init($title=null,$js=null,$css=null) {
		$CI = & get_instance();
		$html = array();
		$header['title'] = $title;
		$header['js'] = $this->str2array($js);
		$header['css'] = $this->str2array($css);
		$menu = array();
		$header['menu']=$CI->load->view("menu", $menu, true);
		$html['header']=$CI->load->view("header", $header, true);		
		$hint["success"]=$CI->session->flashdata('success_show');
		$hint["error"]=$CI->session->flashdata('error_show');
		$html['hint']=$CI->load->view("hint", $hint, true);
		$left = array();
		$html['left']=$CI->load->view("left", $left, true);
		$right = array();
		$html['right'] = $CI->load->view("right", $right, true);
		$footer = array();
		$html['footer']=$CI->load->view("footer", $footer, true);
		return $html;
	}

	public function admin_init($title=null,$js=null,$css=null) {
		$CI = & get_instance();
		$html = array();
		$header['title'] = $title;
		$header['js']=$this->str2array($js);
		$header['css']=$this->str2array($css);
		$menu=array();
		$header['admin_menu']=$CI->load->view("admin/menu", $menu, true);
		$header['admin_left']=$CI->load->view("admin/left", $menu, true);
		$html['admin_header']=$CI->load->view("admin/header", $header, true);
		$left=array();
		$html['admin_left']=$CI->load->view("admin/left", $left, true);
		$footer=array();
		$html['admin_footer']=$CI->load->view("admin/footer", $footer, true);
		return $html;
	}
	
	private function str2array($str)
    {
        $ret = explode(',', $str);
        return array_flip($ret);
    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */