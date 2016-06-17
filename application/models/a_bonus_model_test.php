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
class A_bonus_model extends Base_model {
    protected $_table_name = 'a_bonus';
    protected $_key_id = 'a_bonus_id';
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

	//赠送积分 执行函数  时间条件
	function get_row_byymd() {
		$where['ymd']=date("Ymd");
		$where['dtime']=0;
 
		return $this->fetch(NULL, $where,NULL,'row');
	}	
	function get_row_byymd_count() {
		$con["where"][]=array('ymd'=>date("Ymd"),'state'=>1,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}



	function get_row_byid($id) {
		$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function start() {
		//$this->output->enable_profiler(TRUE);

		$data['ymd']=date("Ymd");
		$data['dividend']=0;
		$data['management']=0;
		$data['number']=0;
		$data['remark']="";
		$data['state']=0;
		$data['ctime']=time();
		return $this->insert ( $data );
	}
	function end($dividend,$management,$id) {				
		$this->db->set('dividend', 'dividend+'.$dividend, FALSE);
		$this->db->set('management', 'management+'.$management, FALSE);
		$data['mtime']=time();
		$where[]=array($this->_key_id=>$id);
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
		$value=array('dtime'=>time());
		return $this->update($value, $where);
	}

	function test($free_stock_list_a, $name, $management_data, $lbl1, $lbl2) {


		echo $name,'<br>';
			echo count($management_data),'<br>';
			$tmp = ARRAY();
			foreach ($management_data as $val) {
				$lbl = $val[$lbl1].'_'.$val[$lbl2];
				if (!isset($tmp[$lbl])) {
					$tmp[$lbl]['num'] = 0;
				}
				$tmp[$lbl]['num'] += 1;
				$tmp[$lbl]['member_id'] = $val['member_id'];
			}
			foreach ($tmp as $key =>$val) {
				if ($val['num'] > $free_stock_list_a[$val['member_id']]) echo $key,',',$val['num'],',',$free_stock_list_a[$val['member_id']],'<br>';
			}
			echo '<hr>';
	}
	
}