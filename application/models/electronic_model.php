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
class Electronic_model extends Base_model {
    protected $_table_name = 'electronic';
    protected $_key_id = 'electronic_id';

    
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
		if(isset($search['member_id']))			
			$where['member_id']=$search['member_id'];
		if(isset($search['type']) && $search['type']!="")			
			$where['type']=$search['type'];
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))
			$con["where"][]=array('member_id'=>$search['member_id']);
		if(isset($search['type']) && $search['type']!="")
			$con["where"][]=array('type'=>$search['type']);
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

	function query_data_transfer($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))			
			$where['member_id']=$search['member_id'];
		if(isset($search['type']) && $search['type']!="")			
			$where['type']=$search['type'];
		$this->set_limit($limit);
		$where['transfer']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_transfer_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))
			$con["where"][]=array('member_id'=>$search['member_id']);
		if(isset($search['type']) && $search['type']!="")
			$con["where"][]=array('type'=>$search['type']);
		$con["where"][]=array('transfer'=>0,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

	function query_data_get($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);		
		$type_array=array("buy_electronic","cash_to_electronic","electronic_to_electronic","cash_currency_market");
		$this->db->where_in('type',$type_array);
		$where['transfer']=1;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_get_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))
			$con["where"][]=array('member_id'=>$search['member_id']);
		$type_array=array("buy_electronic","cash_to_electronic","electronic_to_electronic");
		$this->db->where_in('type',$type_array);
		$con["where"][]=array('transfer'=>1,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

	function query_data_consumption($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);		
		$type_array=array("sell_electronic","electronic_consume","electronic_buy_free_stock","electronic_activation","electronic_re_cast","electronic_to_electronic");
		$this->db->where_in('type',$type_array);
		$where['transfer']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_consumption_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']))
			$con["where"][]=array('member_id'=>$search['member_id']);
		$type_array=array("sell_electronic","electronic_consume","electronic_buy_free_stock","electronic_activation","electronic_to_electronic");
		$this->db->where_in('type',$type_array);
		$con["where"][]=array('transfer'=>0,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

	function get_member_transfer0($id,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		$this->set_limit($limit);
		$where['member_id']=$id;
		$where['transfer']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	

	function get_member_transfer1($id,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		$this->set_limit($limit);
		$where['member_id']=$id;
		$where['transfer']=1;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
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
	
}