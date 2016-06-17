<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('my_permissios'))
{
	function my_permissios()
	{
		$CI = & get_instance();
		$user_purview=$CI->login_lib->purview();
		if($user_purview!="#all"){
			$segs = $CI->uri->segment_array();
			$tempDir = array();
			$i = 1;
			$j=1;
			for(; $i < count($segs); $i++)
			{
				$tempDir[] = $segs[$i];
				$j=$i+1;
				if(!is_dir(APPPATH.'controllers/'.implode('/', $tempDir)))
				{		
					$j--;
					break;
				}
			}
			if(isset($segs[$j+1]))
				$per=",".$segs[$j]."_".$segs[$j+1].",";
			else {
				$per=",".$segs[$j]."_index,";	
			}
			if(!strstr($user_purview,$per))
			{
				//echo $per;
				//echo $user_purview;
				//redirect("/access_control");
			}	
		}
	}
}

if(! function_exists('my_menu')){
	function my_menu($m=0){
		$CI = & get_instance();
		$segs = $CI->uri->segment_array();
		if(count($segs)>0){
			$tempDir = array();
			$j=1;
			for($i = 1; $i < count($segs); $i++)
			{
				$tempDir[] = $segs[$i];
				$j=$i+1;
				if(!is_dir(APPPATH.'controllers/'.implode('/', $tempDir)))
				{		
					$j--;
					break;
				}
			}
			if($segs[$j]=="password2" || $segs[$j]=="expiration_date2")	{		
				return $segs[count($segs)];
			}else{
				return $segs[$j];
			}
		}else{
			return "/";
		}
		
	}
}
if(! function_exists('check_broker_is_visible')){
	
	function check_broker_is_visible()
	{
		$CI = & get_instance();
		$user_purview=$CI->login_lib->purview();
		if(strstr($user_purview,"broker_is_visible"))
		{
			return true;
		}elseif($user_purview=="#all"){
			return true;
		}else{
			return false;
		}
	}

}
if ( ! function_exists('check_menu_permissios'))
{
	function check_menu_permissios($per)
	{
		$CI = & get_instance();
		$user_purview=$CI->login_lib->purview();
		if($user_purview!="#all"){
			if(strstr($user_purview,",".$per.","))
				return true;
			else
				return false;
		}else{
			return true;
		}
	}
}
if ( ! function_exists('check_top_menu_permissios'))
{
	function check_top_menu_permissios($per)
	{
		$CI = & get_instance();
		$user_purview=$CI->login_lib->purview();
		if($user_purview!="#all"){
			if(strstr($user_purview,",".$per."_"))
				return true;
			else
				return false;
		}else{
			return true;
		}
	}
}

if ( ! function_exists('get_all_permissios'))
{
	function get_all_permissios($dir="")
	{
		static $permissios_array = array();
		$permissios_name = "";
		if($dir!="")
			$dir.="/";
		$path=APPPATH.'controllers/admin/'.$dir;
		if(is_dir($path))
		{		
			if ($handle = opendir($path))
			{
				 while (false !== ($file = readdir($handle)))
				{
					 if ($file != "." && $file != "..")
					{
						if (is_file($path . $file))
						{
							$url=$path . $file;
							$controllers_name=explode(".",$file);
							$contents = file_get_contents($url);
							preg_match_all('/@zh="(.*)";/i',$contents,$array_name);
							$permissios_name =$array_name[1][0];
							preg_match_all('/public function(.*)\(/i',$contents,$array_mark);
							foreach($array_mark[1] as $key=>$val){
								if(trim($val)!="__construct"){
									$p['mark']=$controllers_name[0].'_'.trim($val);
									if(false !== strpos(trim($val),"index"))
										$p['name']=$permissios_name;
									else if(false !== strpos(trim($val),"added_do"))
										$p['name']="新增".$permissios_name."操作";
									else if(false !== strpos(trim($val),"added"))
										$p['name']="新增".$permissios_name;		
									else if(false !== strpos(trim($val),"modification_do"))
										$p['name']="修改".$permissios_name."操作";
									else if(false !== strpos(trim($val),"modification"))
										$p['name']="修改".$permissios_name;								
									else if(false !== strpos(trim($val),"delete"))
										$p['name']="删除".$permissios_name;

									if($controllers_name[0]=="main")
										$p['system_module']=5;
									else if($controllers_name[0]=="program")
										$p['system_module']=1;
									else if($controllers_name[0]=="column"  || $controllers_name[0]=="host" || $controllers_name[0]=="channel")
										$p['system_module']=2;
									else if($controllers_name[0]=="article" || $controllers_name[0]=="article_type")
										$p['system_module']=3;
									else if($controllers_name[0]=="system" || $controllers_name[0]=="about" || $controllers_name[0]=="business_cooperation" || $controllers_name[0]=="advertisers" || $controllers_name[0]=="announcement" || $controllers_name[0]=="star_business" || $controllers_name[0]=="window_advertising"  || $controllers_name[0]=="admin_status" || $controllers_name[0]=="article_status" || $controllers_name[0]=="role" || $controllers_name[0]=="purview" || $controllers_name[0]=="ad" || $controllers_name[0]=="adpositionid" || $controllers_name[0]=="ad_type")
										$p['system_module']=4;


									$permissios_array[]=$p;
								}
							}
							

						} elseif (is_dir($path . $file))
						{
							get_all_permissios($file);
						}
					}
				}
			}
			closedir($handle);
		}		
		return $permissios_array;
	}
}