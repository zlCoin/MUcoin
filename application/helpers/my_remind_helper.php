<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('remind'))
{
	function remind($is_success, $error_flashdata = null, $ret_url = null)
	{
		$CI = & get_instance();
		$is_success_str = $is_success ? 'success' : 'fail';
        $CI->session->set_flashdata("error",$error_flashdata);
        $CI->session->set_flashdata("return_url",$ret_url);   
        $CI = & get_instance();
        $method = $CI->router->fetch_method();
        if (strripos($method, 'ajax_') !== false)
        {
            if (isset($CI->db))
            {
                $CI->db->close();
            }
            die($error_flashdata);
        } else
        {
            redirect('remind' . $is_success_str);
        }
	}

}

if ( ! function_exists('admin_remind'))
{
	function admin_remind($is_success, $error_flashdata = null, $ret_url = null)
	{
		$CI = & get_instance();
		$is_success_str = $is_success ? 'success' : 'fail';
        $CI->session->set_flashdata("error",$error_flashdata);
        $CI->session->set_flashdata("return_url",$ret_url);   
		$uri_string = $CI->uri->uri_string();
		$CI->session->set_flashdata("source_url",$uri_string);
        $method = $CI->router->fetch_method();
        if (strripos($method, 'ajax_') !== false)
        {
            if (isset($CI->db))
            {
                $CI->db->close();
            }
            die($error_flashdata);
        } else
        {
            redirect('////' . $is_success_str);
        }
	}

}
if ( ! function_exists('redirect_succeed'))
{
	function redirect_succeed($msg = "", $go_to_url = "",$type="")
	{
		$CI = & get_instance();
        $CI->session->set_flashdata("msg",$msg);
        $CI->session->set_flashdata("go_to_url",$go_to_url);   
		//$uri_string = $CI->uri->uri_string();
		//$CI->session->set_flashdata("source_url",$uri_string);
        redirect('admin/succeed');
	}

}

if ( ! function_exists('redirect_error'))
{
	function redirect_error($msg = "", $go_to_url = "",$type="")
	{
		$CI = & get_instance();
        $CI->session->set_flashdata("msg",$msg);
        $CI->session->set_flashdata("go_to_url",$go_to_url);   
		$uri_string = $CI->uri->uri_string();
		$CI->session->set_flashdata("source_url",$uri_string);
        $method = $CI->router->fetch_method();
        if (strripos($method, 'ajax_') !== false)
        {
            if (isset($CI->db))
            {
                $CI->db->close();
            }
            die($msg);
        } else
        {
			if($type=="")
				redirect('/admin/error/');
			else
				if($type=="m")
					redirect('/error/');
				else
					redirect($type.'/error/');
        }
	}

}


