<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     jike
 * @subpackage  models
 * @category    models
 * @author      hyw
 * @copyright   copyright (c) 2012
 * @filesource
 */
class Activation_code_model extends Base_model {
    protected $_table_name = 'activation_code';
    protected $_key_id = 'activation_code_id';
	
    function get_all() {
		$this->set_order_by('ctime,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }

	function query_data($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('activation_user,code',$search['keyword']);
		if(isset($search['activation_member_id']) && $search['activation_member_id']!="")			
			$where['activation_member_id']=$search['activation_member_id'];
		if(isset($search['state']) && $search['state']!="")			
			$where['state']=$search['state'];
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('user,code',$search['keyword']);
		if(isset($search['activation_member_id']) && $search['activation_member_id']!="")			
			$con["where"][]=array('activation_member_id'=>$search['activation_member_id']);
		if(isset($search['state']) && $search['state']!="")			
			$con["where"][]=array('state'=>$search['state']);
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function check_code_bystate_count($code="")
	{
		$con["where"][]=array('code'=>$code,'state'=>0,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function check_code_count($code="")
	{
		$con["where"][]=array('code'=>$code,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_row_byid($id) {
		$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_bycode($code) {
		$where['code']=$code;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function update_invalid($id) {
		$data['state']=2;			
		$where[]=array($this->_key_id=>$id);
		return $this->update($data, $where);
	}
	function update_activation($data,$id) {
		$data['etime']=time();			
		$where[]=array($this->_key_id=>$id);
		return $this->update($data, $where);
	}
	function update_data($data,$id) {
		$data['mtime']=time();
		$where[]=array($this->_key_id=>$id);
		return $this->update($data, $where);
	}
	function add($data) {		
		$data['ctime']=time();
		return $this->insert ( $data );
	}
	function add_batch($data) {		
		$this->db->insert_batch($this->_table_name, $data);
	}
	function delete_byid($id) {
		$where[]=array($this->_key_id=>$id);
		$value['dtime']=time();
		return $this->update($value, $where);
	}
		
}