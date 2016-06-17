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
class Baodan_log_model extends Base_model {
    protected $_table_name = 'baodan_log';
    protected $_key_id = 'baodan_id';


	function add($data) {		
		$data['addtime']=time();
		return $this->insert ( $data );
	}

	function query_data($search="",$limit="")
	{
		$this->set_order_by('addtime,DESC');
		if(isset($search['member_id']))
			$where['member_id']=$search['member_id'];
		$this->set_limit($limit);
		return $this->fetch(NULL, $where);
    }

	function query_data_count($search=""){
		if(isset($search['member_id']))
			$con["where"][] = array('member_id'=>$search['member_id']);
        $this->set_args_array($con);
        return $this->fetch_count();
	}

 
}