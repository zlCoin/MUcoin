<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     chuanqi
 * @subpackage  models
 * @category    models
 * @author      hyw
 * @copyright   copyright (c) 2012
 * @filesource
 */
class team_password_model extends Base_model {
    protected $_table_name = 'member';
    protected $_key_id = 'member_id';
	protected $_parent_id = 'parent_id';
	
   	
	public function get_TeamMember_byparentid($parent_id){
		$this->set_order_by('user,ASC');
		$where=array($this->_parent_id=>$parent_id);
		$result=$this->fetch(NULL, $where);
		$result_array=array();
		foreach($result as $key=>$val){
			$result_array[$val->member_id]=$val->user;
		}
		return $result_array;
	}
	
	public function get_user_bymember_id($member_id){
		$this->set_order_by('user,ASC');
		$where=array($this->_key_id=>$member_id);
		return $this->fetch(NULL, $where);			
	}
	
	function update_TeamMemberPwd($data,$parent_id,$member_id) {
		$data['mtime']=time();
		//add parent_id ,防止更新非直推人关系
		$where[]=array($this->_key_id=>$member_id,$this->_parent_id=>$parent_id);
		return $this->update($data, $where);
	}

		
}