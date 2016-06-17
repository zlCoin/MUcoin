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
class Free_stock_model extends Base_model {
    protected $_table_name = 'free_stock';
    protected $_key_id = 'free_stock_id';

    
	function get_all() {
		$this->set_order_by('ctime,ASC');
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
    }
	function query_data($search=null,$limit="") 
	{
		$this->set_order_by('ctime,DESC');
		if(isset($search['keyword']) && $search['keyword']!="")
			$this->set_or_like('member_id,user,no',$search['keyword']);		
		if(isset($search['member_id']) && $search['member_id']!="")
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
    }
	
	function query_data_count($search=null)
	{
		if(isset($search['keyword']) && $search['keyword']!="")
			$this->set_or_like('member_id,user,no',$search['keyword']);
		if(isset($search['member_id']) && $search['member_id']!="")
			$con["where"][]=array('member_id'=>$search['member_id']);
		$con["where"][]=array('dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function	get_member_count($member_id,$time)
	{
		$this->db->select('sum(number) as number');
       $where=array('member_id'=>$member_id,'time <'=>$time,'dtime'=>0);
		return $this->fetch(NULL, $where,NULL,'row');
	}

	function	max_number_bymember_id($member_id)
	{
		$this->db->select('max(time) as time');
        $where=array('member_id'=>$member_id,'dtime'=>0);
		$row=$this->fetch(NULL, $where,NULL,'row');
		return $row->time;
	}
	function get_data_bylimit($limit){
		$this->set_order_by('ctime,DESC');
		$this->set_limit($limit);
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
	}
	function get_dividend_member_bymember_id($time,$member_id,$date){
		$this->set_order_by('member_id,DESC');
		$where['time <']=$time;
		$where['member_id']=$member_id;
		$where['expiration_date >=']=time();
		$where['ymd  <>']=$date;
		$where['lock']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
	}

	function get_dividend_member($time,$limit=""){
		$this->db->select('free_stock_id as free_stock_id,parent_id_count as parent_id_count,member_id as member_id,user as user,time as time,number as number,day_dividend  as day_dividend,clue as clue,level as level,no as no,cumulative_dividend as cumulative_dividend,ctime as ctime');
		$this->set_order_by('member_id,DESC');
		$this->set_limit($limit);
		$where['time <']=$time;
		$where['expiration_date >=']=mktime(0, 0, 0,date("m"), date("d"), date("Y"));
		$where['ymd  <>']=date("Ymd");
		$where['lock']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
	}

	function get_day_dividend_count($time){
		$con["where"][]=array('ymd <>'=>date("Ymd"),'time <'=>$time,'dtime'=>0,'lock'=>0,'expiration_date >='=>mktime(0, 0, 0,date("m"), date("d"), date("Y")));
        $this->set_args_array($con);
        return $this->fetch_count();
	}

	function  get_management($clue_value,$level_value,$level,$time){
		$this->db->select('member_id as member_id,level as level,day_dividend as day_dividend');
		$this->db->like('clue', $clue_value."-", 'after');
		$this->set_order_by('level,ASC');
		$where['level <=']=$level_value;
		$where['time <']=$time;
		$where['expiration_date >=']=mktime(0, 0, 0,date("m"), date("d"), date("Y"));
		$where['lock']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
	}
	function get_no_count($no){
		$con["where"][]=array('no'=>$no,'dtime'=>0);
        $this->set_args_array($con);
        return $this->fetch_count();
	}
	function get_day_dividend_bymember_array($member){
		$this->db->select('sum(day_dividend) as day_dividend,member_id as member_id');
		$this->db->where_in('member_id', $member);
		$this->db->group_by("member_id"); 
		$where=array('dtime'=>0);
		return $this->fetch(NULL, $where);
	}
	function get_row_byid($id) {
		if(!empty($id))
			$where[$this->_key_id]=$id;
		$where['dtime']=0;
		return $this->fetch(NULL, $where,NULL,'row');
	}
	function dividend($dividend,$time,$dividend_time,$id) {		
		$this->db->set('cumulative_dividend', 'cumulative_dividend+'.$dividend, FALSE);
		$this->db->set('time', 'time+1', FALSE);
		if($time+1>=$dividend_time)
			$data['state']=1;			
		$data['ymd']=date("Ymd");
		$where[]=array($this->_key_id=>$id);
		return $this->update($data, $where);
	}
	function add_parent_id_count($member_id) {
		$this->db->set('parent_id_count', 'parent_id_count+1', FALSE);
		$where[]=array("member_id"=>$member_id);
		return $this->update($data, $where);
	}
	function update_repair_data(){
		$sql1="update q_member m set m.expiration_date='0' where m.expiration_date is null;";
		$this->db->query($sql1);
		$sql2="update q_member m set m.lock='0' where m.lock is null;";
		$this->db->query($sql2);
		$sql3="update q_free_stock s inner join q_member m on s.member_id = m.member_id set s.expiration_date = m.expiration_date,s.lock = m.lock";
		$this->db->query($sql3);
	}
	function update_lock($member_id){
		$data['lock']=1;	
		$where[]=array("member_id"=>$member_id);
		return $this->update($data, $where);
	}
	function update_unlocking($member_id){
		$data['lock']=0;	
		$where[]=array("member_id"=>$member_id);
		return $this->update($data, $where);
	}
	function update_expiration_date($expiration_date,$member_id) {
		$data['expiration_date']=$expiration_date;
		$where[]=array("member_id"=>$member_id);
		return $this->update($data, $where);
	}
	function update_re_cast($data,$id) {
		$this->db->set('re_cast_number', 're_cast_number+1', FALSE);
		$data['mtime']=time();
		$where[]=array($this->_key_id=>$id);
		return $this->update($data, $where);
	}
	function update_data_batch($data,$id) {
		$this->db->update_batch($this->_table_name, $data, $id);
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
	
	function check_user_stock($user_id,$number)
	{
		$sql="select sum(s.number) as s_number from q_free_stock s where s.member_id= " . $user_id . " and s.time <> 44;";
		
		$query = $this->db->query($sql);
		$row = $query->row();
		
		if (isset($row))
		{
			$max_stock=$this->get_allow_buy_stock_count($user_id);
	
			//用户已购买数量+本次购买数量 必须小于 最大允许购买数量
			if ($max_stock >= ($row->s_number + $number) )
			{ 
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	
	function  get_allow_buy_stock_count($user_id){
		//推荐人不是冻结状态,且在有效期内
		$sql="select count(1) as pcount from q_member m where m.lock=0 and from_unixtime(m.expiration_date) >= now() and m.parent_id=". $user_id . "; ";		
		
		$query = $this->db->query($sql);
		$row = $query->row();

		/*
			直推5个，才给加到5股，直推10以上才给加到10股

			直推4个，不给加股
		*/
		if (isset($row))
		{	
			if (isset($row))
			{	if ($row->pcount >= 10)
				{
					return 10;
				}
				else if ($row->pcount >= 5)
				{
					return 5;
				}
				else
				{
					return 2;
				}
			}
			
			return 2;
		}
		else
		{
			return 2;
			
		}
	}
	
}