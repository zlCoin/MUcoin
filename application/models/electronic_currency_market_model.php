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
class Electronic_currency_market_model extends Base_model {
    protected $_table_name = 'electronic_currency_market';
    protected $_key_id = 'electronic_currency_market_id';

    
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

	function query_data_state($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")			
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$where['state']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_state_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('state'=>0,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

		function query_data_member($search=null,$type=0,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']) && $type==1){		
			$where['member_id']=$search['member_id'];
			$where['state !=']=2;
		}
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_member_count($search=null,$type=0)
	{
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id']) && $type==1){
			$con["where"][]=array('state !='=>2,'member_id'=>$search['member_id']);
		}
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

		function query_data_buyer($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if($search['keyword']!="")
			$this->set_or_like('member_id,user',$search['keyword']);
		if(isset($search['member_id'])){		
			$where['buyer_id']=$search['member_id'];			
		}
		$this->set_limit($limit);
		$where['state !=']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }	
	function query_data_buyer_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('buyer_id,user',$search['keyword']);
		if(isset($search['member_id'])){
			$con["where"][]=array('buyer_id'=>$search['member_id']);
		}
		$con["where"][]=array('state !='=>0,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function check_buyer_number($id=null){
		$t=time()-7*86400;
		$con["where"][]=array('member_id '=>$id,'state'=>2,'cftime >='=>$t,'dtime'=>0);
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
	
}