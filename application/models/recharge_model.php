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
class Recharge_model extends Base_model {
    protected $_table_name = 'recharge';
    protected $_key_id = 'recharge_id';

    
	function get_all() {
		$this->set_order_by('ctime,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	function query_data($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		$con["where"][]=array('dtime'=>0);
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
	
	function delete_byid($id) {
		$where[]=array($this->_key_id=>$id);
		$value=array('dtime'=>time());
		return $this->update($value, $where);
	}
	
	function get_all_recharge_currency($MemberArray){
		$this->db->where('member_id in ('.$MemberArray.')');
		$this->db->select_sum('number');
		$query = $this->db->get($this->_table_name);
		$RowArray = $query->row_array();
		return empty($RowArray['number']) ? 0 : $RowArray['number'];
	}
	/**
	 *	获取当天所有充值奖金
	 */
	function get_current_recharge_all(){
		$TopTime = strtotime(date('Y-m-d',time()));
		$BottomTime = strtotime(date('Y-m-d',strtotime('+1 day')));
		$this->db->where("ctime >= $TopTime and ctime < $BottomTime and dtime = 0");
		$this->db->select_sum("number");
		$query = $this->db->get($this->_table_name);
		$RowArray = $query->row_array();
		return empty($RowArray['number']) ? 0 : $RowArray['number'];
	}
}