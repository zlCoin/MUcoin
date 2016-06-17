<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(! function_exists('my_area')){
	function my_area($id)
	{		
		$CI = & get_instance();
		$CI->load->model('area_model');
		$area=$CI->area_model->get_parent_area($id);		
		return $area;
	}		
}
if(! function_exists('my_area_name')){
	function my_area_name($id)
	{		
		$CI = & get_instance();
		$CI->load->model('area_model');
		$area=$CI->area_model->get_row_byid($id);		
		return $area->area_name;
	}		
}
if(!function_exists('my_membe_id_byuser')){
	function my_member_id_byuser($user)
	{		
		$CI = & get_instance();
		$CI->load->model('member_model');
		$member=$CI->member_model->get_row_byuser($user);
		if(!empty($member)){
			return $member->member_id;
		}else{
			return 0;
		}
	}		
}
if(!function_exists('my_user_bymembe_id')){
	function my_user_bymembe_id($id)
	{		
		$CI = & get_instance();
		$CI->load->model('member_model');
		$member=$CI->member_model->get_row_byid($id);
		if(!empty($member)){
			return $member->user;
		}else{
			return 0;
		}
	}		
}
if(!function_exists('my_get_row_bymember_idandymd')){
	function my_get_row_bymember_idandymd($member_id,$ymd)
	{		
		$CI = & get_instance();
		$CI->load->model('management_model');
		$management=$CI->management_model->get_row_bymember_idandymd($member_id,$ymd);
		if(!empty($management)){
			return $management;
		}else{
			return 0;
		}
	}		
}
if(!function_exists('my_membe_id_byuser')){
	function my_member_byuser($user)
	{		
		$CI = & get_instance();
		$CI->load->model('member_model');
		$member=$CI->member_model->get_row_byuser($user);
		if(!empty($member)){
			return $member;
		}else{
			return 0;
		}
	}		
}
if(!function_exists('my_system_switch')){
	function my_system_switch()
	{		
		$CI = & get_instance();
		$CI->load->model('system_switch_model');
		return $CI->system_switch_model->get_row_byid(1);
	}		
}
if ( ! function_exists('fun_get_member_management_bonus'))
{
	function fun_get_member_management_bonus($member_id,$parent_id_count,$key,$level,$cap_amount,$time)
	{
			$CI = & get_instance();
			$CI->load->model('free_stock_model');
			$member_day_dividend=$CI->free_stock_model->get_management($key,$level+$parent_id_count,$level,$time);
			//echo $CI->db->last_query();echo "<br/>";
			$member_day_dividend_array=array();			
			foreach($member_day_dividend  as $key=>$row){		
				if(isset($member_day_dividend_array[$row->level-$level][$row->member_id]))
					$member_day_dividend_array[$row->level-$level][$row->member_id]+=$row->day_dividend;
				else
					$member_day_dividend_array[$row->level-$level][$row->member_id]=$row->day_dividend;
			}
			//print_r($member_day_dividend_array);die();
			if(isset($member_day_dividend_array[1])){
				$member_level_1_count=count($member_day_dividend_array[1]);
				if($member_level_1_count>10)
					$member_level_1_count=10;
			}else
				return 0;
			//echo $member_level_1_count;echo "<br/>";
			$day_dividend=0;
			foreach($member_day_dividend_array  as $key=>$member_level){	
					if($member_level_1_count<$key){
						break;
					}
					foreach($member_level as $key1=>$value)
						$day_dividend+=$value*( ((10-$key)/100)+0.01);			
			}
		//echo $day_dividend;
		//	die();
			if($day_dividend>$cap_amount)
				return $cap_amount;
			else
				return $day_dividend==""?"0":$day_dividend;
	}

}


if(!function_exists('my_get_member_keyandlevel')){
	function my_get_member_keyandlevel($id,$level=1)
	{		
		$CI = & get_instance();
		$CI->load->model('member_model');
		$member=$CI->member_model->get_row_byid($id);
		$key = "";
		$level = 1;
		while($member->parent_id!=0)
		{
			if($key=="")
				$key = $member->parent_id."-".$id;
			else
				$key=$member->parent_id."-".$key;
			$member=$CI->member_model->get_row_byid($member->parent_id);
			$level++;
		}
		$keyandlevel['key']=$key;
		$keyandlevel['key_comma'] = str_replace('-', ',', $key);
		$keyandlevel['level']=$level;
		//print_r($keyandlevel);die();
		return $keyandlevel;
	}
 
}