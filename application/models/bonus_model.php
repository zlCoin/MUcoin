<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     jike
 * @author      hyw
 * @copyright   hyw copyright (c) 2014
 * @filesource
 */
class Bonus_model extends Base_model {
    protected $_table_name = 'bonus';
    protected $_key_id = 'bonus_id';

    
	function get_all() {
		$this->set_order_by('ctime,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	function query_data($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id',$search['keyword']);
		if(isset($search['member_id'])  &&  $search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

	function query_data_groupbyymd($search=null,$limit="") 
	{
		
		$this->db->select('y as y,m as m,d as d,ymd as ymd,member_id as member_id,sum(dividend) as dividend,sum(management)  as management');
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$this->db->group_by("ymd");
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_groupbyymd_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id',$search['keyword']);
		if(isset($search['member_id'])  &&  $search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
		$this->db->group_by("ymd");
        return $this->fetch_count();
	}
	function get_row_byymd_count() {
		$con["where"][]=array('ymd'=>date("Ymd"),'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_data_bylimit($limit){
		$this->set_order_by('ctime,DESC');
		$this->set_limit($limit);
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
	}
	function get_row_byid($id) {
		if(!empty($id))
			$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
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
		$value=array('dtime'=>time());
		return $this->update($value, $where);
	}
	
}