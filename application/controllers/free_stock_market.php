<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_stock_market extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("自由股市场","jquery,login");
		$this->load->model('free_stock_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$total_rows = $this->free_stock_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->free_stock_model->query_data($search,$limit);
		$this->load->model('system_set_model');
		$html['system_set']=$this->system_set_model->get_row_byid(1);
		$this->load->view('/free_stock_market_list',$html);
	}
	public function re_cast($id){		
		$this->load->model('member_model');		
		$member_id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($member_id);
		$this->load->model('free_stock_model');
		$free_stock=$this->free_stock_model->get_row_byid($id);
		
		if (!$this->free_stock_model->check_user_stock($this->login_lib->member_id(),$free_stock->number))
		{			
			$this->session->set_flashdata("error_show", "复投失败,请先增加直推人再复投自由股!");
			redirect("free_stock_market");
		}
		
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		$electronic=$free_stock->number*$system_set->invest_limit;
		if($member->electronic_currency>=$electronic){
			$return_result=$this->member_model->minus_electronic($electronic,$member_id);
			if($return_result>0){
				$free_stock_data['time']=0;
				$free_stock_data['cumulative_dividend']=0;
				$free_stock_data['state']=0;
				$free_stock_data['ymd']=0;
				$free_stock_data['expiration_date']=$member->expiration_date;
				$return_result=$this->free_stock_model->update_re_cast($free_stock_data,$id);
				if($return_result>0){
					if($member->parent_id>0 || $member->parent_user!=""){							
						$member2=$this->member_model->get_row_byid($member->parent_id);
						$this->member_model->add_cash($system_set->bonus,$member->parent_id);
						$this->load->model('cash_model');
						$cash_data['member_id']=$member2->member_id;					
						$cash_data['user']=$member2->user;
						$cash_data['from_member_id']=$member->member_id;		
						$cash_data['from_user']=$member->user;			
						$cash_data['type']="recommend";				
						$cash_data['cash_currency']=$system_set->bonus;
						$cash_data['ymd']=date("Ymd");	
						$cash_data['y']=date("Y");		
						$cash_data['m']=date("m");		
						$cash_data['d']=date("d");	
						$this->cash_model->add($cash_data);
						$this->load->model('recommend_model');
						$recommend_data['member_id']=$member->parent_id;		
						$recommend_data['user']=$member2->user;
						$recommend_data['from_member_id']=$member->member_id;		
						$recommend_data['from_user']=$member->user;				
						$recommend_data['money']=$system_set->bonus;		
						$recommend_data['atime']=$data['atime'];	
						$recommend_data['ymd']=date("Ymd");	
						$recommend_data['y']=date("Y");		
						$recommend_data['m']=date("m");		
						$recommend_data['d']=date("d");						
						$this->recommend_model->add($recommend_data);
					}
					$this->load->model('electronic_model');
					$electronic_data['member_id']=$member->member_id;		
					$electronic_data['user']=$member->user;					
					$electronic_data['type']="electronic_re_cast";			
					$electronic_data['electronic_currency']=$electronic;		
					$electronic_data['ymd']=date("Ymd");	
					$electronic_data['y']=date("Y");		
					$electronic_data['m']=date("m");		
					$electronic_data['d']=date("d");						
					$this->electronic_model->add($electronic_data);
					$this->session->set_flashdata('success_show', '复投成功');
					redirect("free_stock_market");
				}else{
					
					$this->session->set_flashdata('error_show', '复投失败');
					redirect("free_stock_market");
				}
			}else{
					
					$this->session->set_flashdata('error_show', '复投失败');
					redirect("free_stock_market");
				}
		}else{
			$this->session->set_flashdata('error_show', '电子积分不足复投失败');
			redirect("free_stock_market");
		}
	}
}

/* End of file free_stock_market.php */
/* Location: ./application/controllers/admin/free_stock_market.php */