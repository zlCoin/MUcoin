<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation_code extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("充值卡密码","jquery,login,validate");			
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->model('activation_code_model');
		$search['keyword']=$this->input->post('keyword');
		$search['activation_member_id']=$id;
		$html['keyword']=$search['keyword'];
		$total_rows = $this->activation_code_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->activation_code_model->query_data($search,$limit);
		$this->load->view('/activation_code',$html);
	}
	public function success($code=null){
			
		$html=$this->init("充值卡密码成功","jquery,validate");		
		$this->load->model('activation_code_model');			
		$html['code']=$this->activation_code_model->get_row_bycode($code);	
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($html['code']->activation_member_id);
		if($html['code']->state==1){
			$this->session->set_userdata('expiration_date',$html['row']->expiration_date);
		}
		$this->load->view('activation_code_success',$html);
	}
	public function submit()
	{
		
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$code=trim($this->input->post('code'));
		if($code!=""){
				$this->load->model('activation_code_model');
				$code_row=$this->activation_code_model->get_row_bycode($code);
				if(!empty($code_row)){
					if($code_row->state==0){
						$data['activation_member_id']=$member->member_id;
						$data['activation_user']=$member->user;
						$data['state']=1;			
						$data['remark']="缴纳管理费";
						$this->activation_code_model->update_activation($data,$code_row->activation_code_id);
						$etime=30*86400;						
						if($member->expiration_date==0 ||  $member->expiration_date==NULL || $member->expiration_date<time()){
							$etime+=time();
						}else{
							$etime+=$member->expiration_date;
						}
						$this->member_model->management_fees($etime,$member->member_id);
						redirect("activation_code/success/".$code);
					}else{
						if($code_row->state==1)
							$this->session->set_flashdata('error_show', '充值卡密码已经使用');
						else if($code_row->state==2)
							$this->session->set_flashdata('error_show', '充值卡密码无效');
						redirect("activation_code");
					}
				}else{
					$this->session->set_flashdata('error_show', '充值卡密码无效');
					redirect("activation_code");
				}
		}else{
			$this->session->set_flashdata('error_show', '充值卡密码失败');
			redirect("activation_code");
		}
	}
}

/* End of file activation_code.php */
/* Location: ./application/controllers/activation_code.php */