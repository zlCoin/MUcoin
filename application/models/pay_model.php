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
class Pay_model extends Base_model {
    protected $_table_name = 'pay';
    protected $_key_id = 'pay_id';
	
    function get_all() {
		$this->set_order_by('ctime,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }

	function query_data($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user,no',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$where['state']=1;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user,no',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")			
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('state'=>1,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	
	function get_row_byid($id) {
		if(!empty($id))
			$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_byno($no) {
		$where['no']=$no;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_bytrade_no($no) {
		$where['trade_no']=$no;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function update_pay($data,$no) {
		$where[]=array('no'=>$no);
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

	function delete_byid($id) {
		$where[]=array($this->_key_id=>$id);
		$value['dtime']=time();
		return $this->update($value, $where);
	}
		
}