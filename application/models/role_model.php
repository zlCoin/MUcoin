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
class Role_model extends Base_model {
    protected $_table_name = 'role';
    protected $_key_id = 'role_id';
	
    function get_all() {
		$this->set_order_by('sequence,ASC');
		$where=array("dtime"=>0);
		return $this->fetch(NULL, $where);
    }

	function get_all_toarray() {
		$this->set_order_by('sequence,ASC');
		$where=array('dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$p=array();
		foreach($result as $key=>$val){
			$p[$val->role_id]=$val->name;
		}
		return $p;
    }
	function get_role_byid($id) {
		if(!empty($id))
			$where[$this->_key_id]=$id;
		$where["dtime"]=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function query_data($search="",$limit="") 
	{
		if($search['keyword']!="")
			$this->set_or_like('name',$search['keyword']);
		$this->set_limit($limit);
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('name',$search['keyword']);
		$con["where"][] = array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
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
	function update_purview($data,$id){
		$value=array('purview'=>$data['purview'],'mtime'=>time());
		$where[]=array($this->_key_id=>$id);
		return $this->update($value, $where);
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