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
class Qqfile_model extends Base_model {
    protected $_table_name = 'qqfile';
    protected $_key_name = 'qqfile_id';
	
    function get_all() {
		$where=array("dtime"=>0);
		return $this->fetch(NULL, $where);
    }
	function get_all_toarray() {
		$where=array('dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$p=array();
		foreach($result as $key=>$val){
			$p[$val->file_type_id]=$val->name;
		}
		return $p;
    }
	
	function query_data($keyword="",$limit="") 
	{
		$this->set_or_like('file',$keyword);
		$this->set_limit($limit);
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	
	function query_data_count($keyword=null)
	{
		$this->set_or_like('file',$keyword);
		$con["where"][] = array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_byid_torow($id) {
		if(!empty($id))
			$where[$this->_key_name]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function get_row_byqquuid($qquuid) {
		$where["qquuid"]=$qquuid;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function update_data($data,$id) {
		$data['mtime']=time();
		$where[]=array($this->_key_name=>$id);
		return $this->update($data, $where);
	}
	function add($data) {		
		$data['ctime']=time();
		return $this->insert ( $data );
	}

	function delete_byid($id) {
		$where[]=array($this->_key_name=>$id);
		$value['dtime']=time();
		return $this->update($value, $where);
	}
		
}