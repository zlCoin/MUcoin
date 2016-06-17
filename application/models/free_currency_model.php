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
class  Free_currency_model extends Base_model {
    protected $_table_name = 'free_currency';
    protected $_key_id = 'free_currency_id';

    
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
		if(isset($search['member_id']) && $search['member_id']!="")			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
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
		return $this->insert ($data);
	}
	function delete_byid($id) {
		$where[]=array($this->_key_id=>$id);
		$value=array('dtime'=>time());
		return $this->update($value, $where);
	}

	// 获取老会员所有原始业绩
	function get_all_free_currency($MemberArray){
		$this->db->where('member_id in ('.$MemberArray.') and type = "old_a_bonus"');
		$this->db->select_sum('free_currency');
		$query = $this->db->get($this->_table_name);
		$RowArray = $query->row_array();
		return empty($RowArray['free_currency']) ? 0 : $RowArray['free_currency'];
	}
	
	/**
	 *	获取当天静态资产
	 */
	function get_current_free_all(){
		$TopTime = strtotime(date('Y-m-d',time()));
		$BottomTime = strtotime(date('Y-m-d',strtotime('+1 day')));
		$this->db->where("ctime >= $TopTime and ctime < $BottomTime and dtime = 0");
		$this->db->select_sum("free_currency");
		$query = $this->db->get($this->_table_name);
		$RowArray = $query->row_array();
		return empty($RowArray['free_currency']) ? 0 : $RowArray['free_currency'];
	}
}