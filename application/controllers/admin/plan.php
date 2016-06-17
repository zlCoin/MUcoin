<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("保本计划","jquery,login");
		$this->load->model('plan_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->plan_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->plan_model->query_data($search,$limit);
		$this->load->view('/admin/plan_list',$html);
	}
	public function confirm($id){			
		$this->load->model('plan_model');
		$row=$this->plan_model->get_row_byid($id);
		if($row->state==0){			
			$this->load->model('member_model');
			$member_data['lock']=0;
			$return_result=$this->member_model->update_data($member_data,$row->member_id);
			if($return_result>0){		
				$data['cftime']=time();
				$data['state']=1;
				$this->plan_model->update_data($data,$id);
				redirect("admin/shop_pay");
			}else{							
				redirect("admin/plan");
			}
		}else{							
			redirect("admin/plan");
		}
	}	
	public function payment($id){
		$html=$this->admin_init("付款","jquery,login,validate");			
		$this->load->model('plan_model');
		$html['row']=$this->plan_model->get_row_byid($id);
		$this->load->model('member_model');
		$html['member']=$this->member_model->get_row_byid($html['row']->member_id);
		$this->config->load('cai1pay', TRUE);
        $html['config'] = $this->config->item('cai1pay');
		$this->load->view('/admin/plan_payment',$html);
	}
	
}

/* End of file plan_list.php */
/* Location: ./application/controllers/admin/plan_list.php */