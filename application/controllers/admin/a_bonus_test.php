<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class A_bonus extends CI_Controller {
	function __construct()
    {
       parent::__construct();
    }
	public function index() {
		$html=$this->admin_init("开始积分赠送","jquery,login,validate");		
		$this->load->model('a_bonus_model');
		$a_bonus=$this->a_bonus_model->get_row_byymd();
		//查询当天是否已经插入记录
		if(!empty($a_bonus)==0){
			//如果没有 那么插入记录 start==insrt
			$html['a_bonus_id']=$this->a_bonus_model->start();
			$html['state']=0;
		}else{
			$html['a_bonus_id']=$a_bonus->a_bonus_id;
			$html['state']=$a_bonus->state;
		}
        //html 输出变量
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
       //$system_set->dividend_time=44次   总共分44次分完
		//配置文件作用是 读取 q_system_set  基本配置
		 //获取 统计要赠送的数量 人数
		$this->load->model('free_stock_model');
		//SELECT COUNT(*) AS `numrows` FROM (`q_free_stock`) WHERE `ymd` <> '20160419' AND `time` < '44' AND `dtime` = 0 AND `lock` = 0 AND `expiration_date` >= 1460995200
		//没有到期的 大于等于当前时间的 统计
		$html['free_stock_count']=$this->free_stock_model->get_day_dividend_count($system_set->dividend_time);
       // echo $this->db->last_query();echo "<br/>";
        //已赠送条数统计
		$this->load->model('bonus_model');
		$html['bonus_count']=$this->bonus_model->get_row_byymd_count();
       // echo $this->db->last_query();echo "<br/>";
		$this->load->model('system_switch_model');
		//系统设置  返回是一个数组
		$html['system_switch']=$this->system_switch_model->get_row_byid(1);	
		 //echo $this->db->last_query();echo "<br/>";
		$this->free_stock_model->update_repair_data();//更新用户表
		//update q_member m set m.expiration_date='0' where m.expiration_date is null;
		//update q_member m set m.lock='0' where m.lock is null;
		//update q_free_stock s inner join q_member m on s.member_id = m.member_id set s.expiration_date = m.expiration_date,s.lock = m.lock
        //是否插入了最新日期记录
		
		$this->load->model('management_day_model');
		$management_member_row=$this->management_day_model->get_member_id_byymd(date("Ymd"));
		//SELECT * FROM (`q_management_day`) WHERE `ymd` = '20160419' AND `dtime` = 0 
		//查询今天是否有执行记录
		// echo $this->db->last_query();echo "<br/>";
		if(empty($management_member_row)){
			$this->management_day_model->add_ymd(date("Ymd"));
		}
		$this->load->view('/admin/a_bonus',$html);
	}
	public function member() {
		$html=$this->admin_init("开始积分赠送","jquery,login,validate,date");			
		$this->load->view('/admin/a_bonus_member',$html);
	}
	//提交并处理  函数开始赠送积分
	public function member_submit(){
		set_time_limit(0);//时间执行函数  0 直到程序执行完才停止
		header("Content-type: text/html; charset=utf-8");
		$this->load->model('member_model');		
		$user=trim($this->input->post('user'));		
		$ymd=trim($this->input->post('ymd'));
		if($user==""){			
			echo "帐号不能为空";die();
		}
		$member=$this->member_model->get_row_byuser($user);
		echo "积分赠送会员：".$member->user;echo "<br/>";
		$this->load->model('system_switch_model');
		$system_switch=$this->system_switch_model->get_row_byid(1);
		if($system_switch->day_dividend==0){
			echo "系统暂停积分赠送";die();
		}

		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		$w=date("w");
		if($w=="6" || $w=="0" || $w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5"){				
				$dividend=0;
				$management=0;
				$this->load->model('free_stock_model');
				 $this->load->model('bonus_model');
				 $this->load->model('management_model');				 				
				 $this->load->model('member_model');
				 $this->load->model('cash_model');
				 $this->load->model('free_gold_model');
				 $this->load->model('dividend_model');
				$free_stock_list=$this->free_stock_model->get_dividend_member_bymember_id($system_set->dividend_time,$member->member_id,$ymd);
				echo "积分赠送数据：";
				print_r($free_stock_list);echo "<br/>";
				//echo $this->db->last_query();echo "<br/>";die();
				$bonus_data=array();
				$dividend_management=array();
				$data_dividend=array();			
				$management_data=array();
				$cash_data=array();
				$free_gold_data=array();
				$dividend_data=array();
				$member_array=array();
				$member_id_array=array();
				$all_dividend=0;
				foreach($free_stock_list as $key=>$row){						
					$bonus_data[$key]['member_id']=$row->member_id;
					$bonus_data[$key]['user']=$row->user;
					$bonus_data[$key]['dividend']=$row->day_dividend;
					$bonus_data[$key]['management']=0;					
					$bonus_data[$key]['ymd']=date("Ymd");
					$bonus_data[$key]['y']=date("Y");
					$bonus_data[$key]['m']=date("m");
					$bonus_data[$key]['d']=date("d");
					$bonus_data[$key]['ctime']=time();						
			
					//************************************更新自由股表
					$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$bonus_data[$key]['dividend'];
					$data_dividend[$key]["ymd"]=date("Ymd");
					$data_dividend[$key]["time"]=$row->time+1;
					if($row->time+1>=$system_set->dividend_time)
						$data_dividend[$key]["state"]=1;
					$data_dividend[$key]["free_stock_id"]=$row->free_stock_id;
					//*************************************	
					$dividend_data[$key]['member_id']=$row->member_id;					
					$dividend_data[$key]['user']=$row->user;						
					$dividend_data[$key]['no']=$row->no;								
					$dividend_data[$key]['number']=$row->number;								
					$dividend_data[$key]['day_dividend']=$row->day_dividend;								
					$dividend_data[$key]['time']=$row->time+1;								
					$dividend_data[$key]['cumulative_dividend']=$row->cumulative_dividend+$row->day_dividend;	
					$dividend_data[$key]['btime']=$row->ctime;	
					$dividend_data[$key]['ymd']=date("Ymd");	
					$dividend_data[$key]['y']=date("Y");		
					$dividend_data[$key]['m']=date("m");		
					$dividend_data[$key]['d']=date("d");						
					$dividend_data[$key]['ctime']=time();			
					//*************************************	会员数据
					$member_id_array[$row->member_id]=$row->member_id;
					$member_array[$row->member_id]['member_id']=$row->member_id;
					$member_array[$row->member_id]['user']=$row->user;
					$member_array[$row->member_id]['clue']=trim($row->clue);
					$member_array[$row->member_id]['level']=$row->level;
					if(isset($member_array[$row->member_id]['day_dividend']))
						$member_array[$row->member_id]['day_dividend']+=$row->day_dividend;
					else
						$member_array[$row->member_id]['day_dividend']=$row->day_dividend;
					$all_dividend+=$bonus_data[$key]['dividend'];
				}
				unset($free_stock_list);
				$all_management=0;
				if(!empty($member_array)){					
					foreach($member_array  as $member_key=>$member_row){
						$management=fun_get_member_management_bonus($member_row['member_id'],10,$member_row['clue'],$member_row['level'],$system_set->cap_amount,$system_set->dividend_time);
						echo "管理奖：";
						echo $management;echo "<br/>";
						$cash_currency=0;
						$free_gold=0;	
						if($management>0){
								$cash_currency=$management*0.7;
								$free_gold=$management*0.3;				
								$management_data[$member_key]['member_id']=$member_row['member_id'];
								$management_data[$member_key]['money']=$management;
								$management_data[$member_key]['cash']=$cash_currency;
								$management_data[$member_key]['free_gold']=$free_gold;
								$management_data[$member_key]['type']="a_bonus";
								$management_data[$member_key]['ymd']=date("Ymd");
								$management_data[$member_key]['y']=date("Y");
								$management_data[$member_key]['m']=date("m");
								$management_data[$member_key]['d']=date("d");
								$management_data[$member_key]['ctime']=time();
								//echo $this->db->last_query();echo "<br/>";							

								if($free_gold>0){
									$free_gold_data[$member_key]['member_id']=$member_row['member_id'];					
									$free_gold_data[$member_key]['user']=$member_row['user'];				
									$free_gold_data[$member_key]['type']="a_bonus";				
									$free_gold_data[$member_key]['free_gold']=$free_gold;		
									$free_gold_data[$member_key]['ymd']=date("Ymd");	
									$free_gold_data[$member_key]['y']=date("Y");		
									$free_gold_data[$member_key]['m']=date("m");		
									$free_gold_data[$member_key]['d']=date("d");	
									$free_gold_data[$member_key]['ctime']=time();
								}

								$all_management+=$management;
						
						}
						//********************************************
						$cash_data[$member_key]['member_id']=$member_row['member_id'];	
						$cash_data[$member_key]['user']=$member_row['user'];			
						$cash_data[$member_key]['type']="a_bonus";				
						$cash_data[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;		
						$cash_data[$member_key]['ymd']=date("Ymd");	
						$cash_data[$member_key]['y']=date("Y");		
						$cash_data[$member_key]['m']=date("m");		
						$cash_data[$member_key]['d']=date("d");
						$cash_data[$member_key]['ctime']=time();
						//************************************更新用户表
						$dividend_management[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
						$dividend_management[$member_key]['free_gold']=$free_gold;
						$dividend_management[$member_key]['member_id']=$member_row['member_id'];						
						//************************************
					}
					/*if(!empty($bonus_data))
						$this->bonus_model->add_batch($bonus_data);
					if(!empty($data_dividend))
						$this->free_stock_model->update_data_batch($data_dividend,'free_stock_id');
					if(!empty($management_data))
						$this->management_model->add_batch($management_data);
					if(!empty($cash_data))
						$this->cash_model->add_batch($cash_data);
					if(!empty($free_gold_data))
						$this->free_gold_model->add_batch($free_gold_data);
					if(!empty($dividend_data))
						$this->dividend_model->add_batch($dividend_data);					
					if(!empty($dividend_management))
						$this->member_model->add_management_batch($dividend_management,'member_id');	*/
					//echo $this->db->last_query();echo "<br/>";
				}				
				echo "OK";			
				die();
		}else{			
			echo "今天暂停积分赠送";die();
		}
	}	
	public function a_bonus_submit($a_bonus_id){
		set_time_limit(0);
		$this->load->model('a_bonus_model');
		$this->load->model('system_switch_model');
        //后台配置 开关停止赠送 0 1开通
		$system_switch=$this->system_switch_model->get_row_byid(1);
		if($system_switch->day_dividend==0){//配置开关 1 关闭暂停
			header("Content-type: text/html; charset=utf-8");
			echo "系统暂停积分赠送";die();
		}
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		 //echo $this->db->last_query();echo "<br/>";
		$w=date("w");//$w=="6" || $w=="0" ||  周六周日不送
		if($w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5"){				
				$dividend=0;
				$management=0;
				$this->load->model('free_stock_model');
				 $this->load->model('bonus_model');//
				 $this->load->model('management_model');//管理积分赠送记录自由金现金记录				
				 $this->load->model('member_model');//用户表更新
				 $this->load->model('cash_model');//现金积分
				 $this->load->model('free_gold_model');//自由金记录
				 $this->load->model('dividend_model');
				 $this->load->model('management_day_model');
	$management_data=array();
	$cash_data=array();
				 // for($i=0;$i<8;$i++){		
					 //根源 从q_free_stock表查出记录
					$free_stock_list=$this->free_stock_model->get_dividend_member($system_set->dividend_time,'');
					// var_dump($free_stock_list);
					// echo $this->db->last_query();echo "<br/>";
					// die();
					
					$free_stock_list_a = ARRAY();
					foreach ($free_stock_list as $key => $val) {
						if (!isset($free_stock_list_a[$val->member_id])) $free_stock_list_a[$val->member_id] = 0;
						$free_stock_list_a[$val->member_id] += $val->number;
					}
					

					$bonus_data=array();
					$dividend_management=array();
					$data_dividend=array();			
					
					
					$free_gold_data=array();
					$dividend_data=array();
					$member_array=array();
					$member_id_array=array();
					$all_dividend=0;
					foreach($free_stock_list as $key=>$row){
						$bonus_data[$key]['member_id']=$row->member_id;
						$bonus_data[$key]['user']=$row->user;
						$bonus_data[$key]['dividend']=$row->day_dividend;//每天赠送数
						$bonus_data[$key]['management']=0;					
						$bonus_data[$key]['ymd']=date("Ymd");
						$bonus_data[$key]['y']=date("Y");
						$bonus_data[$key]['m']=date("m");
						$bonus_data[$key]['d']=date("d");
						$bonus_data[$key]['ctime']=time();						

						//************************************更新自由股表
						//更新自由固表   累加赠送次数  总赠送积分数  更新赠送时间 如果出局 state=1
						$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$bonus_data[$key]['dividend'];//赠送总数累加
						$data_dividend[$key]["ymd"]=date("Ymd");//更新时间
						$data_dividend[$key]["time"]=$row->time+1;//次数加1
						if($row->time+1>=$system_set->dividend_time)  //是否超过
						$data_dividend[$key]["state"]=1;//超过后就出局了 state默认为0
						$data_dividend[$key]["free_stock_id"]=$row->free_stock_id;
						//*************************************	
					    //从自由故查询记录循环出所有记录 并赋值到 积分赠送明细表 循环插入
						//q_dividend表
                        //$dividend_data[$key]['free_stock_id']=$row->free_stock_id;
						$dividend_data[$key]['member_id']=$row->member_id;
						$dividend_data[$key]['user']=$row->user;						
						$dividend_data[$key]['no']=$row->no;								
						$dividend_data[$key]['number']=$row->number;								
						$dividend_data[$key]['day_dividend']=$row->day_dividend;								
						$dividend_data[$key]['time']=$row->time+1;
						//账户结余积分
						$dividend_data[$key]['cumulative_dividend']=$row->cumulative_dividend+$row->day_dividend;	
						$dividend_data[$key]['btime']=$row->ctime;	
						$dividend_data[$key]['ymd']=date("Ymd");
						$dividend_data[$key]['y']=date("Y");		
						$dividend_data[$key]['m']=date("m");		
						$dividend_data[$key]['d']=date("d");						
						$dividend_data[$key]['ctime']=time();								
						//*************************************	会员数据
						$member_id_array[$row->member_id]=$row->member_id;
						$member_array[$row->member_id]['member_id']=$row->member_id;
						$member_array[$row->member_id]['user']=$row->user;
						$member_array[$row->member_id]['clue']=trim($row->clue);
						$member_array[$row->member_id]['level']=$row->level;
						if(isset($member_array[$row->member_id]['day_dividend']))
							$member_array[$row->member_id]['day_dividend']+=$row->day_dividend;
						else
							$member_array[$row->member_id]['day_dividend']=$row->day_dividend;
						$all_dividend+=$bonus_data[$key]['dividend'];
					}
					// unset($free_stock_list);

					$all_management=0;
					if(!empty($member_array)){
						$management_member_row=$this->management_day_model->get_member_id_byymd(date("Ymd"));
                       //查询每天的
						if(isset($member_array[$management_member_row->member_id])){
							$this->cash_model->update_cash_currency_byymd($member_array[$management_member_row->member_id]['day_dividend'],$management_member_row->member_id);
							$this->member_model->add_cash($member_array[$management_member_row->member_id]['day_dividend'],$management_member_row->member_id);
							unset($member_array[$management_member_row->member_id]);
						}
						//echo $this->db->last_query();echo "<br/>";die();
						foreach($member_array  as $member_key=>$member_row){
							$management=fun_get_member_management_bonus($member_row['member_id'],10,$member_row['clue'],$member_row['level'],$system_set->cap_amount,$system_set->dividend_time);
							//echo $management."dddddddddddddddddddddddddddddddd<br>";
							$cash_currency=0;
							$free_gold=0;	
							if($management>0){
									$cash_currency=$management*0.7;
									$free_gold=$management*0.3;				
									$management_data[$member_key]['member_id']=$member_row['member_id'];
									$management_data[$member_key]['money']=$management;
									$management_data[$member_key]['cash']=$cash_currency;
									$management_data[$member_key]['free_gold']=$free_gold;
									$management_data[$member_key]['type']="a_bonus";
									$management_data[$member_key]['ymd']=date("Ymd");
									$management_data[$member_key]['y']=date("Y");
									$management_data[$member_key]['m']=date("m");
									$management_data[$member_key]['d']=date("d");
									$management_data[$member_key]['ctime']=time();

									//echo $this->db->last_query();echo "<br/>";							
									if($free_gold>0){
										$free_gold_data[$member_key]['member_id']=$member_row['member_id'];					
										$free_gold_data[$member_key]['user']=$member_row['user'];				
										$free_gold_data[$member_key]['type']="a_bonus";				
										$free_gold_data[$member_key]['free_gold']=$free_gold;		
										$free_gold_data[$member_key]['ymd']=date("Ymd");	
										$free_gold_data[$member_key]['y']=date("Y");		
										$free_gold_data[$member_key]['m']=date("m");		
										$free_gold_data[$member_key]['d']=date("d");	
										$free_gold_data[$member_key]['ctime']=time();
									}

									$all_management+=$management;
							
							}
							//********************************************
							$cash_data[$member_key]['member_id']=$member_row['member_id'];	
							$cash_data[$member_key]['user']=$member_row['user'];			
							$cash_data[$member_key]['type']="a_bonus";				
							$cash_data[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;		
							$cash_data[$member_key]['ymd']=date("Ymd");	
							$cash_data[$member_key]['y']=date("Y");		
							$cash_data[$member_key]['m']=date("m");		
							$cash_data[$member_key]['d']=date("d");
							$cash_data[$member_key]['ctime']=time();
							//************************************更新用户表
						$dividend_management[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
							$dividend_management[$member_key]['free_gold']=$free_gold;
							$dividend_management[$member_key]['member_id']=$member_row['member_id'];
							//************************************
						}
					}


			
					//echo "OK";
				   // die();
					// if(!empty($bonus_data))

						// $this->bonus_model->add_batch($bonus_data);
					
					
					/*if(!empty($data_dividend))
						$this->free_stock_model->update_data_batch($data_dividend,'free_stock_id');
					if(!empty($management_data))
						$this->management_model->add_batch($management_data);
					if(!empty($cash_data))
						$this->cash_model->add_batch($cash_data);
					if(!empty($free_gold_data))
						$this->free_gold_model->add_batch($free_gold_data);
					if(!empty($dividend_data))
						$this->dividend_model->add_batch($dividend_data);					
					if(!empty($dividend_management))
						$this->member_model->add_management_batch($dividend_management,'member_id');	
					$this->management_day_model->update_date(end($member_id_array),date("Ymd"));
					*/
					//echo $this->db->last_query();echo "<br/>";
				// }
				// echo 'abc';
				$this->a_bonus_model->test($free_stock_list_a, 'bonus_data', $bonus_data, 'member_id', 'ymd');
				$this->a_bonus_model->test($free_stock_list_a, 'management_data', $management_data, 'member_id', 'ymd');
				$this->a_bonus_model->test($free_stock_list_a, 'cash_data', $cash_data, 'member_id', 'ymd' );
				$this->a_bonus_model->test($free_stock_list_a, 'free_gold_data', $free_gold_data, 'member_id', 'ymd' );
				$this->a_bonus_model->test($free_stock_list_a, 'dividend_data', $dividend_data, 'member_id', 'ymd' );

echo $this->db->last_query();echo "<br/>";
 die;





				$this->a_bonus_model->end($all_dividend,$all_management,$a_bonus_id);	
				echo "OK";			
				die();
		}else{			
			header("Content-type: text/html; charset=utf-8");
			echo "今天暂停积分赠送";die();
		}
		//	redirect("admin/a_bonus_record");
	}
}
/* End of file a_bonus.php*/
/* Location: ./application/controllers/admin/a_bonus.php */