<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     jike
 * @author      hyw
 * @copyright   hyw copyright (c) 2014
 * @filesource
 */
class Login_log_model extends Base_model
{
    var $_table_name = 'login_log'; //Table Name
	var $_key_id = 'login_log_id';
    var $msg_lang = '';

    public function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * 登录插入
	 *
	 * @user 用户名
	 * @password 密码
	 * @start 状态 0正常 1密码错误 2锁定
	 * @type 用户类型
	 *
	 * question 暂时没有ip地址解析成实际地址模块，留空
	 */
	public function login_insert($insert_data)	{
		$insert_data['ip'] = "";
		$insert_data['int_ltime'] = time();
		$insert_data['ltime'] = date('Y-m-d H:i:s',$insert_data['int_ltime']);
		//print_r($insert_data);die();
		return $this->insert($insert_data);
	}

	function get_last_login_row($log_name)
	{
		$this->db->select('*');
		$this->db->where('name',$log_name);
		$this->db->order_by('login_log_id','desc');
		return $this->fetch_row();
	}
}
/* End of file base_model.php */
/* Location: ./system/application/models/base_model.php */
