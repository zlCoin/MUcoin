<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package     jike
 * @author      hyw
 * @copyright   hyw copyright (c) 2014
 * @filesource
 */
class Management_model extends Base_model {
    protected $_table_name = 'management';
    protected $_key_id = 'management_id';
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
		if($search['member_id']!="")			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id',$search['keyword']);
		if($search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

		function query_data_groupbyymd($search=null,$limit="") 
	{
			
		$this->db->select('y as y,m as m,d as d,cash as cash,free_gold as free_gold');
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id',$search['keyword']);
		if($search['member_id']!="")			
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
		if($search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('dtime'=>0);
		$this->db->group_by("ymd");
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_data_byymd($ymd){
		$this->set_order_by('ctime,ASC');
		$where=array('ymd'=>$ymd,'dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$result_array=array();
		foreach($result as $key=>$row){
			$result_array[$row->member_id]=$row->money;
		}
		return $result_array;
	}
	function get_data_bylimit($limit){
		$this->set_order_by('ctime,DESC');
		$this->set_limit($limit);
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
	}
	function get_row_bymember_idandymd($member_id,$ymd) {
		$where['member_id']=$member_id;
		$where['ymd']=$ymd;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_byid($id) {
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