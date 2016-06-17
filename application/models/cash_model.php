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
class Cash_model extends Base_model {
    protected $_table_name = 'cash';
    protected $_key_id = 'cash_id';

    
	function get_all() {
		$this->set_order_by('ctime,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	function query_data($search=null,$limit="") 
	{
		$this->set_order_by('cash_id,DESC');
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
		$this->set_order_by('cash_id,DESC');
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
	function update_cash_currency_byymd($cash_currency,$member_id){
		$this->db->set('cash_currency', 'cash_currency+'.$cash_currency, FALSE);
		$data['mtime']=time();
		$where[]=array("ymd"=>date("Ymd"),"member_id"=>$member_id);
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
		$value=array('dtime'=>time());
		return $this->update($value, $where);
	}

	function get_all_cash_currency($MemberArray){
		$this->db->where('member_id in ('.$MemberArray.')');
		$this->db->select_sum('cash_currency');
		$query = $this->db->get($this->_table_name);
		$RowArray = $query->row_array();
		return empty($RowArray['cash_currency']) ? 0 : $RowArray['cash_currency'];
	}

	/**
	 *	获取当天所有动态奖金
	 */
	function get_current_cash_all(){
		$TopTime = strtotime(date('Y-m-d',time()));
		$BottomTime = strtotime(date('Y-m-d',strtotime('+1 day')));
		$this->db->where("ctime >= $TopTime and ctime < $BottomTime and dtime = 0");
		$this->db->select_sum("cash_currency");
		$query = $this->db->get($this->_table_name);
		$RowArray = $query->row_array();
		return empty($RowArray['cash_currency']) ? 0 : $RowArray['cash_currency'];
	}
}