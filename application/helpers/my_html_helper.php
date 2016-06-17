<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter HTML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/html_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Heading
 *
 * Generates an HTML heading tag.  First param is the data.
 * Second param is the size of the heading tag.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	string
 */
if ( ! function_exists('heading'))
{
	function heading($data = '', $h = '1', $attributes = '')
	{
		$attributes = ($attributes != '') ? ' '.$attributes : $attributes;
		return "<h".$h.$attributes.">".$data."</h".$h.">";
	}
}

// ------------------------------------------------------------------------

/**
 * Unordered List
 *
 * Generates an HTML unordered list from an single or multi-dimensional array.
 *
 * @access	public
 * @param	array
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('ul'))
{
	function ul($list, $attributes = '')
	{
		return _list('ul', $list, $attributes);
	}
}

// ------------------------------------------------------------------------

/**
 * Ordered List
 *
 * Generates an HTML ordered list from an single or multi-dimensional array.
 *
 * @access	public
 * @param	array
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('ol'))
{
	function ol($list, $attributes = '')
	{
		return _list('ol', $list, $attributes);
	}
}

// ------------------------------------------------------------------------

/**
 * Generates the list
 *
 * Generates an HTML ordered list from an single or multi-dimensional array.
 *
 * @access	private
 * @param	string
 * @param	mixed
 * @param	mixed
 * @param	integer
 * @return	string
 */
if ( ! function_exists('_list'))
{
	function _list($type = 'ul', $list, $attributes = '', $depth = 0)
	{
		// If an array wasn't submitted there's nothing to do...
		if ( ! is_array($list))
		{
			return $list;
		}

		// Set the indentation based on the depth
		$out = str_repeat(" ", $depth);

		// Were any attributes submitted?  If so generate a string
		if (is_array($attributes))
		{
			$atts = '';
			foreach ($attributes as $key => $val)
			{
				$atts .= ' ' . $key . '="' . $val . '"';
			}
			$attributes = $atts;
		}
		elseif (is_string($attributes) AND strlen($attributes) > 0)
		{
			$attributes = ' '. $attributes;
		}

		// Write the opening list tag
		$out .= "<".$type.$attributes.">\n";

		// Cycle through the list elements.  If an array is
		// encountered we will recursively call _list()

		static $_last_list_item = '';
		foreach ($list as $key => $val)
		{
			$_last_list_item = $key;

			$out .= str_repeat(" ", $depth + 2);
			$out .= "<li>";

			if ( ! is_array($val))
			{
				$out .= $val;
			}
			else
			{
				$out .= $_last_list_item."\n";
				$out .= _list($type, $val, '', $depth + 4);
				$out .= str_repeat(" ", $depth + 2);
			}

			$out .= "</li>\n";
		}

		// Set the indentation for the closing tag
		$out .= str_repeat(" ", $depth);

		// Write the closing list tag
		$out .= "</".$type.">\n";

		return $out;
	}
}

// ------------------------------------------------------------------------

/**
 * Generates HTML BR tags based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if ( ! function_exists('br'))
{
	function br($num = 1)
	{
		return str_repeat("<br />", $num);
	}
}

// ------------------------------------------------------------------------

/**
 * Image
 *
 * Generates an <img /> element
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('img'))
{
	function img($src = '', $index_page = FALSE)
	{
		if ( ! is_array($src) )
		{
			$src = array('src' => $src);
		}

		// If there is no alt attribute defined, set it to an empty string
		if ( ! isset($src['alt']))
		{
			$src['alt'] = '';
		}

		$img = '<img';

		foreach ($src as $k=>$v)
		{

			if ($k == 'src' AND strpos($v, '://') === FALSE)
			{
				$CI =& get_instance();

				if ($index_page === TRUE)
				{
					$img .= ' src="'.$CI->config->site_url($v).'"';
				}
				else
				{
					$img .= ' src="'.$CI->config->slash_item('base_url').$v.'"';
				}
			}
			else
			{
				$img .= " $k=\"$v\"";
			}
		}

		$img .= '/>';

		return $img;
	}
}

// ------------------------------------------------------------------------

/**
 * Doctype
 *
 * Generates a page document type declaration
 *
 * Valid options are xhtml-11, xhtml-strict, xhtml-trans, xhtml-frame,
 * html4-strict, html4-trans, and html4-frame.  Values are saved in the
 * doctypes config file.
 *
 * @access	public
 * @param	string	type	The doctype to be generated
 * @return	string
 */
if ( ! function_exists('doctype'))
{
	function doctype($type = 'xhtml1-strict')
	{
		global $_doctypes;

		if ( ! is_array($_doctypes))
		{
			if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/doctypes.php'))
			{
				include(APPPATH.'config/'.ENVIRONMENT.'/doctypes.php');
			}
			elseif (is_file(APPPATH.'config/doctypes.php'))
			{
				include(APPPATH.'config/doctypes.php');
			}

			if ( ! is_array($_doctypes))
			{
				return FALSE;
			}
		}

		if (isset($_doctypes[$type]))
		{
			return $_doctypes[$type];
		}
		else
		{
			return FALSE;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Link
 *
 * Generates link to a CSS file
 *
 * @access	public
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	rel
 * @param	string	type
 * @param	string	title
 * @param	string	media
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if ( ! function_exists('link_tag'))
{
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();

		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k=>$v)
			{
				if ($k == 'href' AND strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$link .= "$k=\"$v\" ";
				}
			}

			$link .= "/>";
		}
		else
		{
			if ( strpos($href, '://') !== FALSE)
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.$CI->config->site_url($href).'" ';
			}
			else
			{
				$link .= 'href="'.$CI->config->slash_item('base_url').$href.'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media	!= '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title	!= '')
			{
				$link .= 'title="'.$title.'" ';
			}

			$link .= '/>';
		}


		return $link;
	}
}

// ------------------------------------------------------------------------

/**
 * Generates meta tags from an array of key/values
 *
 * @access	public
 * @param	array
 * @return	string
 */
if ( ! function_exists('meta'))
{
	function meta($name = '', $content = '', $type = 'name', $newline = "\n")
	{
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($name))
		{
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		}
		else
		{
			// Turn single array into multidimensional
			if (isset($name['name']))
			{
				$name = array($name);
			}
		}

		$str = '';
		foreach ($name as $meta)
		{
			$type		= ( ! isset($meta['type']) OR $meta['type'] == 'name') ? 'name' : 'http-equiv';
			$name		= ( ! isset($meta['name']))		? ''	: $meta['name'];
			$content	= ( ! isset($meta['content']))	? ''	: $meta['content'];
			$newline	= ( ! isset($meta['newline']))	? "\n"	: $meta['newline'];

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Generates non-breaking space entities based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if ( ! function_exists('nbs'))
{
	function nbs($num = 1)
	{
		return str_repeat("&nbsp;", $num);
	}
}

if ( ! function_exists('html_a'))
{
	function html_a($name='',$href = '',$onclick="",$purview= '')
	{
		if($purview == '')
			return '<a  href="'.$href.'" />'.$name.'</a>';
	}
}

if ( ! function_exists('html_submit'))
{
	function html_submit($name='',$value = '',$purview= '')
	{
		if($purview == '')
			return '<input name="'.$name.'" type="submit" value="'.$value.'" class="inser_btn" />';
	}
}

if ( ! function_exists('html_button'))
{
	function html_button($name='',$id='',$onclick="",$purview= '')
	{
		if($purview == '')
			return '<button id=="'.$id.'" type="button" onclick="'.$onclick.'">'.$name.'</button>';
	}
}

if ( ! function_exists('html_menu'))
{
	function html_menu($i)
	{
		$CI = & get_instance();
		include(APPPATH.'config/config.php');
		$uri_string=$CI->session->flashdata("source_url");
		if($uri_string!="")
		{
			$u=explode("/",$uri_string);
			return $u[$i];
		}else{			
			return $CI->uri->segment($i+$config['html_meun']);
		}
	}
}
if ( ! function_exists('html_limit'))
{
	function html_limit($page)
	{
		$config['per_page'] = 15;
		$config['page']=$config['per_page']*($page-1);
		return $config['per_page'].",".$config['page'];
	}
}
if ( ! function_exists('html_limit1'))
{
	function html_limit1($page)
	{
		$config['per_page'] = 10;
		$config['page']=$config['per_page']*($page-1);
		return $config['per_page'].",".$config['page'];
	}
}
if ( ! function_exists('html_limit2'))
{
	function html_limit2($page)
	{
		$per_page = 15;
		$page_nubmer=$per_page*$page;	
		return $per_page.",".$page_nubmer;
	}
}
if ( ! function_exists('html_num'))
{
	function html_num($total_rows)
	{
		$per_page = 15;
		return ceil($total_rows / $per_page);
	}
}
if ( ! function_exists('html_pagination'))
{
	function html_pagination($page,$total_rows,$parameter)
	{
		$CI = & get_instance();
		$config['per_page'] = 15;
		$config['current_page'] =$page;
		$config['page']=$config['per_page']*($page-1);
		$config['total_rows'] = $total_rows;
		$segs = $CI->uri->segment_array();
		//print_r($segs);
		//echo count($segs);
		$url="";
		foreach ($segs as $key=>$segment)
		{
			if(is_numeric($segment) || $segment=="index"){
				break;
			}else{
				//if($key==count($segs) && $segs==$page){
				//	echo $key;
				//	break;

				//}
				if($url=="")
					$url.=$segment;
				else
					$url.="/".$segment;
			}
		}
		
		if($parameter!=""){
			$config['url'] = $url."/";
			$config['parameter'] =$parameter;
		}else{
			$config['url'] = $url."/index";
			$config['parameter'] =$parameter;
		}
		$config['num_pages'] = ceil($config['total_rows'] / $config['per_page']);
		if($page-1>0)
			$config['page_up'] =$page-1;
		else
			$config['page_up'] =1;
		if($page+1<$config['num_pages'])
			$config['page_down'] =$page+1;
		else
			$config['page_down'] =$config['num_pages'];
		$limit =$config['per_page'].",".$config['page'];
		return $CI->load->view("admin/pagination", $config, true);
	}
}

if ( ! function_exists('html_pagination1'))
{
	function html_pagination1($page,$total_rows,$parameter)
	{
		$CI = & get_instance();
		$config['per_page'] = 10;
		$config['current_page'] =$page;
		$config['page']=$config['per_page']*($page-1);
		$config['total_rows'] = $total_rows;
		$segs = $CI->uri->segment_array();
		//print_r($segs);
		//echo count($segs);
		$url="";
		foreach ($segs as $key=>$segment)
		{
			if(is_numeric($segment) || $segment=="index"){
				break;
			}else{
				//if($key==count($segs) && $segs==$page){
				//	echo $key;
				//	break;

				//}
				if($url=="")
					$url.=$segment;
				else
					$url.="/".$segment;
			}
		}
		
		if($parameter!=""){
			$config['url'] = $url."/";
			$config['parameter'] =$parameter;
		}else{
			$config['url'] = $url."/index";
			$config['parameter'] =$parameter;
		}
		$config['num_pages'] = ceil($config['total_rows'] / $config['per_page']);
		if($page-1>0)
			$config['page_up'] =$page-1;
		else
			$config['page_up'] =1;
		if($page+1<$config['num_pages'])
			$config['page_down'] =$page+1;
		else
			$config['page_down'] =$config['num_pages'];
		$limit =$config['per_page'].",".$config['page'];
		return $CI->load->view("/pagination", $config, true);
	}
}

if ( ! function_exists('html_pagination2'))
{
	function html_pagination2($page,$total_rows,$parameter)
	{
		$CI = & get_instance();
		$config['per_page'] = 15;
		$config['current_page'] =$page;
		$config['page']=$config['per_page']*($page-1);
		$config['total_rows'] = $total_rows;
		$config['url'] = '/admin/goods/under';
		if($parameter!="")
			$config['parameter'] =urlencode($parameter);
		else
			$config['parameter'] =$parameter;
		$config['num_pages'] = ceil($config['total_rows'] / $config['per_page']);
		if($page-1>0)
			$config['page_up'] =$page-1;
		else
			$config['page_up'] =1;
		if($page+1<$config['num_pages'])
			$config['page_down'] =$page+1;
		else
			$config['page_down'] =$config['num_pages'];
		$limit =$config['per_page'].",".$config['page'];
		return $CI->load->view("/manage_pagination", $config, true);
	}
}
if ( ! function_exists('html_zeroize'))
{
	function html_zeroize($i)
	{
		if($i=="" || $i==0)
			return "";
		if($i==0)
			return "00";
		if($i>9)
		{
			return $i;
		}else{			
			return "0".$i;
		}
	}
}
if ( ! function_exists('html_select_tree'))
{
	function html_select_tree($t,$i,$tab,$id="")
	{
		$n="";
		for($j=0;$j<$tab;$j++)
			$n.="&nbsp;&nbsp;";
		$selected="";
		$tab++;
		foreach($t[$i] as $k=>$v){
			if(isset($t[$k]) && is_array($t[$k])){
				if($id==$k)
					$selected="selected";
				else
					$selected="";
				
				echo "<option value=".$k." ".$selected." >".$n.$v."</option>";
				html_select_tree($t,$k,$tab,$id);
			}else{
				if($id==$k)
					$selected="selected";
				else
					$selected="";
				echo "<option value=".$k." ".$selected.">".$n.$v."</option>";
			}
		}
	}
}
if ( ! function_exists('html_custom_menus'))
{
	function html_custom_menus($menus,$i,$tab)
	{
		$tab++;
		foreach($menus[$i] as $key=>$row){
			
			
			if(isset($menus[$key]) && is_array($menus[$key])){
				echo '<tr>
						<td class="hidden-480"><img width="9" height="9" border="0" onclick="rowClicked(this)" style="margin-left:'.$tab.'em" id="icon_0_6" src="/images/menu_nofollow.gif">&nbsp;'.$row->menu.'</td>
						<td class="hidden-480">'.$row->action.'</td>
						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<a href="'.site_url('admin/custom_menus/modify/'.$row->weixin_menu_id).'" class="btn btn-xs btn-info">
									<i class="icon-edit bigger-120"></i>
								</a>
								<a href="'.site_url('admin/custom_menus/delete/'.$row->weixin_menu_id).'" class="btn btn-xs btn-danger">
									<i class="icon-trash bigger-120"></i>
								</a>
							</div>
						</td>
					</tr>';				
				html_custom_menus($menus,$key,$tab);
			}else{
				echo '<tr>
						<td class="hidden-480"><img width="9" height="9" border="0" onclick="rowClicked(this)" style="margin-left:'.$tab.'em" id="icon_0_6" src="/images/menu_nofollow.gif">&nbsp;'.$row->menu.'</td>
						<td class="hidden-480">'.$row->action.'</td>
						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<a href="'.site_url('admin/custom_menus/modify/'.$row->weixin_menu_id).'" class="btn btn-xs btn-info">
									<i class="icon-edit bigger-120"></i>
								</a>
								<a href="'.site_url('admin/custom_menus/delete/'.$row->weixin_menu_id).'" class="btn btn-xs btn-danger">
									<i class="icon-trash bigger-120"></i>
								</a>
							</div>
						</td>
					</tr>';				
			}
		}
		
	}
}
/* End of file html_helper.php */
/* Location: ./system/helpers/html_helper.php */