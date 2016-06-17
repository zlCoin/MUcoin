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
class Area_model extends Base_model {
    protected $_table_name = 'area';
    protected $_key_id = 'area_id';
	
    function get_all() {
		$this->set_order_by('area_id,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }	
	function get_area_byid($id){
		$this->set_order_by('area_id,ASC');
		$where=array('parent_id'=>$id,'dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$result_array=array();
		foreach($result as $key=>$val){
			$result_array[$val->area_id]=$val->area_name;
		}
		return $result_array;
	}
	function get_all_toarray() {
		$this->set_order_by('area_id,ASC');
		$where=array('dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$result_array=array();
		foreach($result as $key=>$val){
			$result_array[$val->area_id]=$val->area_name;
		}
		return $result_array;
    }

	function get_parent_area($id){
		$this->set_order_by('sort,DESC');
		$where=array('parent_id'=>$id,'dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$result_array=array();
		foreach($result as $key=>$val){
			$result_array[$val->area_id]=$val->area_name;
		}
		return $result_array;
	}
	
	function query_data($search="",$limit="") 
	{
		foreach($search as $key=>$val){
			if($key=="keyword")
				$this->set_or_like('area_name',$val);
			else
				$where[$key]=$val;
		}
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }
	
	function query_data_count($search=null)
	{
		foreach($search as $key=>$val){
			if($key=="keyword")
				$this->set_or_like('area_name',$val);
			else
				$con["where"][] = array($key=>$val);
		}
		$con["where"][] = array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_byid_torow($id) {
		if(!empty($id))
			$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_byname($name){
		$where['area_name']=$name;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_byid($id){
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
		$value['dtime']=time();
		return $this->update($value, $where);
	}
		
}