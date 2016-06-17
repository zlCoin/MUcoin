<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_data extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("导入数据","jquery,login");
		$this->load->view('/import_data',$html);
	}
	public function data_submit(){
		set_time_limit(0);
		/*
		执行sql 

		(1)导入用户表
		insert into q_member(user,parent_user,password,password1,name,id,mobile,email,qq,electronic_currency,cash_currency,free_currency,free_gold,question1,answer1,question2,answer2,question3,answer3,grade,state,otime,atime,ctime) select loginname,rid,pwd1,pwd2,truename,identityid,tel,email,qq,amount,inputamount,zzqianbao,zzamount,question,answer,question2,answer2,question3,answer3,xing,states,onlinetime,jihuotime,addtime from users;

		(2)导入自由股表
		insert into q_free_stock(user,no,number,day_dividend,time,cumulative_dividend,ymd,ctime) select userid,bianhao,shuliang,riamount,allcishu,allfenhong,fhdate,addtime from stock;

		
		*/
		//修复用户数据
		/*
		$this->db=$this->load->database('default', TRUE);
		$this->load->model('member_model');
		$search['parent_id']=null;
		$member_array=array();
		for($i=0;$i<1;$i++){
			$update_member_data=array();
			$list=$this->member_model->query_data($search,"1000,0") ;
			foreach($list as $key=>$row){			
				if(isset($member_array[$row->parent_user])){
					$update_member_data[$key]['parent_id']=$member_array[$row->parent_user];
				}else{				
					$update_member_data[$key]['parent_id']=my_member_id_byuser($row->parent_user);
					$member_array[$row->parent_user]=$update_member_data[$key]['parent_id'];
				}
				if(strtotime("$row->otime")<mktime(0,0,0,12,10,2015)){
					$update_member_data[$key]['expiration_date']=0;
				}else{
					$update_member_data[$key]['expiration_date']=strtotime("$row->otime")+2592000;
				}
				$update_member_data[$key]['otime']=strtotime("$row->otime");
				$update_member_data[$key]['atime']=strtotime("$row->atime");
				$update_member_data[$key]['ctime']=strtotime("$row->ctime");
				$update_member_data[$key]['member_id']=$row->member_id;
			}
			unset($list);
			if(!empty($update_member_data))
					$this->member_model->update_data_batch($update_member_data,'member_id');
			echo $i;
		}*/

		//生成用户关系		
		
		$this->db=$this->load->database('default', TRUE);
		$this->load->model('member_model');
		$search["level"]=0;
		for($i=0;$i<10;$i++){
			$update_member_data=array();
			$list=$this->member_model->query_data($search,"1000,0") ;
			//	echo $this->db->last_query();
			foreach($list as $key=>$row){	
				$keyandlevel=my_get_member_keyandlevel($row->member_id);
				$update_member_data[$key]['key']=$keyandlevel['key'];
				$update_member_data[$key]['level']=$keyandlevel['level'];
				$update_member_data[$key]['member_id']=$row->member_id;
				//print_r($update_member_data);die();
			}
			unset($list);
			if(!empty($update_member_data))
					$this->member_model->update_data_batch($update_member_data,'member_id');
		//echo $this->db->last_query();
		//echo "OK";die();
			//echo $i;
	}

		//修复自由股数据
		/*
		$this->db=$this->load->database('default', TRUE);
		$this->load->model('member_model');
		$this->load->model('free_stock_model');
		$search['member_id']=0;
		$member_array=array();
		$member_id_array=array();
		for($i=0;$i<20;$i++){
			$update_free_stock_data=array();
			$update_member_free_stock_data=array();
			$list=$this->free_stock_model->query_data($search,"1000,0") ;
			foreach($list as $key=>$row){
				if(isset($member_array[$row->user])){
					$member=$member_array[$row->user];				
				}else{
					$member=my_member_byuser($row->user);
					$member_array[$row->user]=$member;
				}
				$update_free_stock_data[$key]['member_id']=$member->member_id;
				if(isset($member_id_array[$member->member_id])){
					$update_free_stock_data[$key]['member_id']=$member_id_array[$member->member_id];
				}else{
					$update_free_stock_data[$key]['member_id']=$this->member_model->check_user_byparent_id_count($row->member_id);
					$member_id_array[$member->member_id]=$update_free_stock_data[$key]['member_id'];
				}
				$update_free_stock_data[$key]['key']=$member->key;
				$update_free_stock_data[$key]['level']=$member->level;
				$update_free_stock_data[$key]['ctime']=strtotime("$row->ctime");
				if($row->ymd!="")
					$update_free_stock_data[$key]['ymd']=str_replace("-", "", $row->ymd);
				$update_free_stock_data[$key]['free_stock_id']=$row->free_stock_id;
				$update_member_free_stock_data[$key]['free_stock']=$row->number;
				$update_member_free_stock_data[$key]['member_id']=$row->member_id;
			}
			unset($list);			
			if(!empty($update_free_stock_data))
					$this->free_stock_model->update_data_batch($update_free_stock_data,'free_stock_id');
			if(!empty($update_member_free_stock_data))
					$this->member_model->add_free_stock_batch($update_member_free_stock_data,'member_id');
			echo $i;
		}
		*/
		/*
		调整表结构字段
		(1)用户表
		字段:otime,atime,ctime改变整形int(11)
		(2)自由股表
		字段:ctime改变整形int(11),ymd改成varchar(8)
		*/
		echo "OK";die();
	}
	
}

/* End of file import_data.php */
/* Location: ./application/controllers/import_data.php */