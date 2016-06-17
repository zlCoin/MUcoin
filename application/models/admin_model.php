<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends Base_model {
    protected $_table_name = 'admin';
    protected $_key_id = 'admin_id';
    
	function get_all() {
		$this->set_order_by('ctime,DESC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }

	function get_all_toarray() {
		$where=array('dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$result_array=array();
		foreach($result as $key=>$val){
			$result_array[$val->admin_id]=$val->name;
		}
		return $result_array;
    }
	function query_data($search="",$limit="") 
	{
		if($search['keyword']!="")
			$this->set_or_like('user,name',$search['keyword']);
		$this->set_limit($limit);
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	
	function query_data_count($search=null)
	{
		if($search['keyword']!="")
			$this->set_or_like('user,name',$search['keyword']);
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

	function get_user($limit="") {
		if($limit!="")
			$this->set_limit($limit);
		$this->db->join('role','admin.role_id = role.role_id');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	function get_user_count() {
		$con["where"][] = array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_user_by_keyword($keyword) {
		if($keyword!="")
			$this->set_or_like('name',$keyword);
		$where=array('dtime'=>0);
		$result=$this->fetch(NULL, $where);
		$p=array();
		foreach($result as $key=>$val){
			$p[$val->admin_id]["name"]=urlencode($val->name);
		}
		return $p;
    }
	function update_data($data,$id) {
		$data['mtime']=time();
		$where[]=array($this->_key_id=>$id);
		return $this->update($data, $where);
	}
	function query_user($where,$keyword=null,$limit) 
	{
		$this->set_or_like('user,name',$keyword);
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }
	
	function query_user_count($where,$keyword=null)
	{
		$this->set_or_like('user,name',$keyword);
		$where['dtime']=0;
        $this->set_args_array($where);
        return $this->fetch_count();
	}
	
	function check_login_user($data) {
		if(!empty($data->user))
			$where['user'] = $data->user;
		if(!empty($data->password))
			$where['password'] = MD5($data->password);
		$where['dtime'] = 0;
		return $this->fetch(NULL, $where, NULL, 'row');
	}

	function get_user_info($id) {
		if(!empty($id))
			$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function update_user($data) {
		$value=array('role_id'=>$data['role_id'],'mtime'=>time());
		$where[]=array($this->_key_id=>$data['id']);
		return $this->update($value, $where);
	}
	function update_user_password($data){
		$value=array('password'=>md5($data['password']));
		$where[]=array($this->_key_id=>$data['id']);
		return $this->update($value, $where);
	
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
	
	public function check_add_user($user_name = null)
	{
		if($user_name == null)
		{
			return false;
		}
		$this->db->where('user',$user_name);
		if($this->fetch_row() == null)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    public function acl_login_handle()
    {
        $data = array();
        $data['login_ip'] = $this->input->ip_long();
        $data['ltime'] = time();
        $this->update($data);
    }
	
	
}