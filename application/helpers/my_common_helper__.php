<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('fun_collection_mode'))
{
	function fun_collection_mode()
	{
		$CI = & get_instance();
		//$_collection_mode['1']="支付宝";
		//$_collection_mode['2']="财付通";
		//$_collection_mode['3']="交通银行";
		//$_collection_mode['4']="工商银行";
		$_collection_mode['5']="农业银行";
		//$_collection_mode['6']="建设银行";
		//$_collection_mode['7']="中国银行";
		//$_collection_mode['8']="招商银行";
		return $_collection_mode;		
	}

}
if ( ! function_exists('fun_electronic_type'))
{
	function fun_electronic_type()
	{
		$CI = & get_instance();
		$_electronic_type['electronic_to_electronic']="电子积分转帐";
		$_electronic_type['sell_electronic']="电子积分出售";
		$_electronic_type['buy_electronic']="电子积分购买";
		$_electronic_type['cash_to_electronic']="现金积分转电子积分";
		$_electronic_type['electronic_consume']="电子积分消费";
		$_electronic_type['electronic_buy_free_stock']="购买自由股";
		$_electronic_type['electronic_activation']="激活";
		$_electronic_type['electronic_re_cast']="复投";
		$_electronic_type['cash_currency_market']="现金积分市场";
		return $_electronic_type;		
	}

}
if ( ! function_exists('fun_free_gold_type'))
{
	function fun_free_gold_type()
	{
		$CI = & get_instance();
		$_free_gold_type['a_bonus']="积分赠送";
		return $_free_gold_type;		
	}

}
if ( ! function_exists('fun_cash_type'))
{
	function fun_cash_type()
	{
		$CI = & get_instance();
		$_cash_type['cash_to_electronic']="现金积分转电子积分";
		$_cash_type['cash_to_shopping']="现金积分转购物积分";
		$_cash_type['sell_cash']="现金积分出售";
		$_cash_type['buy_cash']="现金积分购买";
		$_cash_type['recommend']="推荐奖";
		$_cash_type['a_bonus']="积分赠送";
		$_cash_type['exchange']="积分兑换";
		$_cash_type['cash_to_shopping_back']="现金积分转购物积分失败";
		return $_cash_type;		
	}

}

if ( ! function_exists('fun_electronic_currency_market_state'))
{
	function fun_electronic_currency_market_state()
	{
		$CI = & get_instance();
		$_state[0]="等待交易";
		$_state[1]="等待付款";
		$_state[2]="交易成功";
		return $_state;		
	}

}
if ( ! function_exists('fun_cash_currency_market_state'))
{
	function fun_cash_currency_market_state()
	{
		$CI = & get_instance();
		$_state[0]="等待交易";
		$_state[1]="等待付款";
		$_state[2]="交易成功";
		return $_state;		
	}

}

if ( ! function_exists('fun_free_currency_market_state'))
{
	function fun_free_currency_market_state()
	{
		$CI = & get_instance();
		$_state[0]="等待交易";
		$_state[1]="等待付款";
		$_state[2]="交易成功";
		return $_state;		
	}

}

if ( ! function_exists('fun_activation_code_state'))
{
	function fun_activation_code_state()
	{
		$CI = & get_instance();
		$_state[0]="未激活";
		$_state[1]="激活";
		$_state[2]="失效";
		return $_state;		
	}

}

if ( ! function_exists('fun_question_answer'))
{
	function fun_question_answer()
	{
		$CI = & get_instance();
		$_question_answer['1']="您母亲的姓名是？";
		$_question_answer['2']="您父亲的姓名是？";
		$_question_answer['3']="您配偶的姓名是？";
		$_question_answer['4']="您的出生地是？";
		$_question_answer['5']="您高中班主任的名字是？";
		$_question_answer['6']="您初中班主任的名字是？";
		$_question_answer['7']="您小学班主任的名字是？";
		$_question_answer['8']="您的小学校名是？";
		$_question_answer['9']="您的学号（或工号）是？";
		$_question_answer['10']="您父亲的生日是？";
		$_question_answer['11']="您母亲的生日是？";
		$_question_answer['12']="您配偶的生日是？";
		return $_question_answer;		
	}
}
if ( ! function_exists('fun_datetime_to_int'))
{
	function fun_datetime_to_int($dt)
	{
		$CI = & get_instance();
		$dt_array=explode(" ",$dt);
		$date_str=$dt_array[0];
		$time_str=$dt_array[1];
		$date_array=explode("-",$date_str);
		$y=preg_replace('/^0/','',$date_array[0]);
		$m=preg_replace('/^0/','',$date_array[1]);
		$d=preg_replace('/^0/','',$date_array[2]);
		$time_array=explode(":",$time_str);
		$hour=preg_replace('/^0/','',$time_array[0]);
		$minute=preg_replace('/^0/','',$time_array[1]);
		$dint=mktime($hour,$minute,0,$m,$d,$y);	
		return mktime($hour,$minute,0,$m,$d,$y);	
		
	}

}
if ( ! function_exists('fun_check_password2'))
{
	function fun_check_password2() { 
		$CI = & get_instance();
		$page = my_menu();
		$member_password2=$CI->login_lib->get_member_password2();
		if($member_password2=="" || $member_password2!=$page){
			$type=$CI->login_lib->login_member_type();			
			if($type!="admin")
			redirect('/password2/login/'.$page);
		}
	}
}
if ( ! function_exists('fun_check_expiration_date2'))
{
	function fun_check_expiration_date2() { 
		$CI = & get_instance();
		$page=my_menu();
		$member_expiration_date=$CI->login_lib->member_expiration_date();
		if($member_expiration_date<time()){
			$type=$CI->login_lib->login_member_type();			
			if($type!="admin")
			redirect('/expiration_date2/check/'.$page);
		}
	}
}
if ( ! function_exists('fun_is_mobile'))
{
	function fun_is_mobile() { 
		$CI = & get_instance();
		$user_agent = $_SERVER['HTTP_USER_AGENT']; 
		$mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte"); 
		$is_mobile = false; 
		foreach ($mobile_agents as $device) { 
			if (stristr($user_agent, $device)) { 
				$is_mobile = true; 
				break; 
			}
		} 
		//return $is_mobile; 
		return false;
	}
}

if ( ! function_exists('fun_switch_package'))
{
	function fun_switch_package()
	{
		$CI = & get_instance();
		$packages['0'] = array('version'=>'普通版','numbs'=>2000);
		$packages['1'] = array('version'=>'中级版','numbs'=>5000);
		$packages['2'] = array('version'=>'高级版','numbs'=>10000);
		$packages['3'] = array('version'=>'商务版','numbs'=>50000);
		$packages['4'] = array('version'=>'贵宾版','numbs'=>100000);
		return $packages;		
	}
}

if ( ! function_exists('fun_member_level'))
{
	function fun_member_level()
	{
		$CI = & get_instance();
		$level['0'] = array('level'=>'1','numbs'=>3,'performance'=>100000);	// 10W
		$level['1'] = array('level'=>'2','numbs'=>2,'performance'=>1000000); // 100W
		$level['2'] = array('level'=>'3','numbs'=>3,'performance'=>5000000); // 500W
		$level['3'] = array('level'=>'4','numbs'=>2,'performance'=>15000000); // 1500W
		$level['4'] = array('level'=>'5','numbs'=>3,'performance'=>50000000); // 5000W
		return $level;		
	}
}

//管理奖提成
if ( ! function_exists('fun_switch_level_gl'))
{
	function fun_switch_level_gl()
	{
		$CI = & get_instance();
		$level_gl['0'] = array('grade'=>'1','version'=>'一星','numbs'=>0.1);
		$level_gl['1'] = array('grade'=>'2','version'=>'二星','numbs'=>0.15);
		$level_gl['2'] = array('grade'=>'3','version'=>'三星','numbs'=>0.2);
		$level_gl['3'] = array('grade'=>'4','version'=>'四星','numbs'=>0.25);
		$level_gl['4'] = array('grade'=>'5','version'=>'五星','numbs'=>0.3);
		return $level_gl;		
	}
}

