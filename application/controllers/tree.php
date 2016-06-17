<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tree extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		fun_check_member_state();	// 限制激活操作
		$this->load->model('member_model');
		$this->member_id = $this->login_lib->member_id();
    }

	public function index($page=1,$parameter=""){
		$html=$this->init("全体队友","jquery,login");
		$member = $this->member_model->get_row_byid($this->member_id);
		$search['keyword']=$this->input->post('keyword');
		$search['key'] = $member->key;
		$search['state'] = 1;
		$search['member_id'] = $member->member_id;
		$html['keyword']=$search['keyword'];
		$total_rows = $this->member_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->member_model->query_data($search,$limit);
		$html['level']=$member->level;
		$this->load->view('/tree_list',$html);
	}

	public function Graphical(){
		$html=$this->init("团队结构","jquery");
		$this->load->view('/tree_graphical_list',$html);
	}

	public function GraphicalAjax($member_id = null){
		header('Content-Type:application/json; charset=utf-8');
		$map = array();
		if (empty($member_id)){
			$map['member_id'] = $this->member_id;
		}else{
			$map['parent_id'] = $member_id;
		}
		$memberArray = $this->member_model->my_team($map);
		$data = array();
		foreach ($memberArray as $key => $value) {
			$nextMember = $this->member_model->my_team(array('parent_id'=>$value->member_id));
			$data[$key]['id'] = $value->member_id;
			$data[$key]['inode'] = $nextMember ? true : false;
			$data[$key]['open'] = false;
			$data[$key]['icon'] = $nextMember ? 'folder' : 'file';
			$data[$key]['label'] = $value->user;
			$data[$key]['type'] = $nextMember ? 'Folder' : 'Text';
			$data[$key]['state'] = $value->state ? '已激活' : '未激活';
		}
		exit(json_encode($data));
	}
}
/* End of file tree.php */
/* Location: ./application/controllers/tree.php */