<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_account extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }

	public function index($page=1,$parameter="")
	{
		$html=$this->init("收款账号","jquery,login,validate");				
		$id = $this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row'] = $this->member_model->get_row_byid($id);
		$html['collection_mode'] = fun_collection_mode();
		$this->load->model('area_model');
		$html['province'] = $this->area_model->get_area_byid(1);
		if($html['row']->city != "")
			$html['city'] = $this->area_model->get_area_byid($html['row']->province);
		else
			$html['city'] = "";
		$this->load->view('/bank_account_modify',$html);
	}

	public function modify_submit(){
		$this->load->model('member_model');
		$id = $this->login_lib->member_id();
		$bankList = fun_collection_mode();
		$BankId = intval($this->input->post('collection_mode'));
		if (empty($bankList[$BankId])) {
			$this->session->set_flashdata('error_show', '提交失败');
			redirect("/bank_account");
		}
		$data['collection_mode'] = $BankId;
		$data['collection_bank'] = $bankList[$BankId];
		$data['id'] = $this->input->post('id');
		$data['account'] = $this->input->post('account');
		$data['bank']=$this->input->post('bank');
		$data['province'] = $this->input->post('province');
		$data['city'] = $this->input->post('city');
		if($id){
			$return_result = $this->member_model->update_data($data,$id);
			if($return_result > 0){
				$this->session->set_flashdata('success_show', '提交成功');
				redirect("/bank_account");
			}
		}
		$this->session->set_flashdata('error_show', '提交失败');
		redirect("/bank_account");
	}

	public function add() {
		$html=$this->init("收款账号新增","jquery,login,validate");
		$html['collection_mode'] = fun_collection_mode();
		$this->load->view('/bank_account_add',$html);
	}

	public function add_submit(){
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$data['collection_mode']=$this->input->post('collection_mode');
		$data['bank_name']=trim($this->input->post('bank_name'));
		$data['account']=$this->input->post('account');
		$data['bank']=$this->input->post('bank');
		
		//added by caiqian ,卡号必须6228开头
		if (substr($data['account'],0,4) <> "6228")
		{
			$this->session->set_flashdata('error_show', '请使用农行账号');
			redirect("bank_account");
		}
	
		//added by caiqian ,长度必须=19位
		if (strlen($data['account']) <> 19)
		{
			$this->session->set_flashdata('error_show', '收款人账号必须为19位!');
			redirect("bank_account");
		}
		
		//added by caiqian ,只允许数字,不允许空格
		if (!is_numeric($data['account']))
		{
			$this->session->set_flashdata('error_show', '收款人账号必须为纯数字,不允许空格和字符!');
			redirect("bank_account");
		}
		
		
		if($id!=""){
			$return_result=$this->member_model->update_data($data,$id);
			//echo $this->db->last_query();die();
			if($return_result>0){
				$this->session->set_flashdata('success_show', '提交成功');
				redirect("bank_account");
			}else{				
				$this->session->set_flashdata('error_show', '提交失败');
				redirect("bank_account");
			}
		}else{
			$this->session->set_flashdata('error_show', '提交失败');
			redirect("bank_account");
		}
	}

	public function delete($id=null)
	{
		$this->load->model('member_bank_model');
		if($id!=null)
		{
			$return_result=$this->member_bank_model->delete_byid($id);
			if($return_result){
				redirect("/bank_account");
			}else{
				redirect_error("收款账号删除失败!","/bank_account");
			}
		}else{
			redirect_error("收款账号删除没有指定ID!","/bank_account");
		}	
	}
}

/* End of file bank_account.php */
/* Location: ./application/controllers/admin/bank_account.php */