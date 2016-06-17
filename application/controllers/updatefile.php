<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @package     sqmis
 * @author      hyw
 * @copyright   hyw copyright (c) 2012
 * @filesource
*/
class Updatefile extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
	public function index()
	{	
		$config=array();

		$config['file_type']=array("jpg","bmp","png","gif"); 
		$config['file_size']=1000; 

		$config['message']="上传成功";

		$config['name']=date("Ymd").mktime(); 

		$config['file_dir']="uploads/ckeditor"; 

		$config['site_url']="/";
		if(empty($_GET['CKEditorFuncNum']))
		   $this->mkhtml(1,"","错误的功能调用请求");
		$fn=$_GET['CKEditorFuncNum'];
		if(is_uploaded_file($_FILES['upload']['tmp_name']))
		{
		   //判断上传文件是否允许
		   $filearr=pathinfo($_FILES['upload']['name']);
		   $filetype=$filearr["extension"];
		   if(!in_array($filetype,$config['file_type']))
				$this->mkhtml($fn,"","错误的文件类型！");
		   if($_FILES['upload']['size']>$config["file_size"]*1024)
				$this->mkhtml($fn,"","上传的文件不能超过".$config["file_size"]."KB！");
		   $file_abso=$config["file_dir"]."/".$config['name'].".".$filetype;
		   $file_host=$_SERVER['DOCUMENT_ROOT'].$file_abso;
		  
		   if(move_uploaded_file($_FILES['upload']['tmp_name'],$file_abso))
		   {
				$this->mkhtml($fn,$config['site_url'].$file_abso,$config['message']);
		   }
		   else
		   {
				$this->mkhtml($fn,"","文件上传失败");
		   }
		}


	}

	function mkhtml($fn,$fileurl,$message)
	{
		$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
		exit($str);
	}
	public function fineuploader($dir="")
	{	
		$config=array();

		$config['file_type']=array("jpg","bmp","gif","png","doc"); 
		$config['file_size']=500; 

		$config['message']="上传成功";

		$config['name']=$this->input->post('qquuid');

		$config['file_dir']="uploads/".$dir; 

		$config['site_url']="/";
		$result=array();
		if(is_uploaded_file($_FILES['qqfile']['tmp_name']))
		{
		  $filearr=pathinfo($_FILES['qqfile']['name']);
		  $filetype=$filearr["extension"];
		  $filename=$config['name'].".".$filearr["extension"];
		  // if(!in_array($filetype,$config['file_type']))
				//$this->mkhtml($fn,"","错误的文件类型！");
		  // if($_FILES['qqfile']['size']>$config["file_size"]*1024)
				//$this->mkhtml($fn,"","上传的文件不能超过".$config["file_size"]."KB！");
		   $file_abso=$config["file_dir"]."/".$filename;
		  
		   if(move_uploaded_file($_FILES['qqfile']['tmp_name'],$file_abso))
		   {
			   	$this->load->model('qqfile_model');
				$data_file['qquuid']=$this->input->post('qquuid');
				$data_file['file']=$filename;
				$data_file['folder']=$dir;
				$this->qqfile_model->add($data_file);
				$result=array('success'=>true,'filename'=>$filename);
		   }
		   else
		   {
				$result=array('error'=> 'Could not save uploaded file.');
		   }
		}else{
			$result=array('error'=> 'is_uploaded_file.');
		}

		header("Content-Type: text/plain");  
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	}
	
	public function aduploads()
	{	
		$config=array();

		$config['file_type']=array("jpg","bmp","gif","flv","swf"); 
		$config['file_size']=5000; 

		$config['message']="上传成功";

		$config['name']="ad_".date("Ymd").mktime().rand(1000,100000); 
		$config['file_dir']="uploads/ad"; 

		$config['site_url']="/";
		$result=array();
		if(is_uploaded_file($_FILES['qqfile']['tmp_name']))
		{
		  $filearr=pathinfo($_FILES['qqfile']['name']);
		  $filetype=$filearr["extension"];
		  $filename=$config['name'].".".$filearr["extension"];
		  // if(!in_array($filetype,$config['file_type']))
				//$this->mkhtml($fn,"","错误的文件类型！");
		  // if($_FILES['qqfile']['size']>$config["file_size"]*1024)
				//$this->mkhtml($fn,"","上传的文件不能超过".$config["file_size"]."KB！");
		   $file_abso=$config["file_dir"]."/".$filename;
		  
		   if(move_uploaded_file($_FILES['qqfile']['tmp_name'],$file_abso))
		   {
				$result=array('success'=>true,'filename'=>$filename);
		   }
		   else
		   {
				$result=array('error'=> 'Could not save uploaded file.');
		   }
		}

		header("Content-Type: text/plain");  
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	}
	public function videouploads()
	{	
		$config=array();

		$config['file_type']=array("jpg","bmp","gif","flv"); 
		$config['file_size']=5000; 

		$config['message']="上传成功";

		$config['name']="video_".date("Ymd").mktime().rand(1000,100000); 
		$config['file_dir']="uploads/video"; 

		$config['site_url']="/";
		$result=array();
		if(is_uploaded_file($_FILES['qqfile']['tmp_name']))
		{
		  $filearr=pathinfo($_FILES['qqfile']['name']);
		  $filetype=$filearr["extension"];
		  $filename=$config['name'].".".$filearr["extension"];
		  // if(!in_array($filetype,$config['file_type']))
				//$this->mkhtml($fn,"","错误的文件类型！");
		  // if($_FILES['qqfile']['size']>$config["file_size"]*1024)
				//$this->mkhtml($fn,"","上传的文件不能超过".$config["file_size"]."KB！");
		   $file_abso=$config["file_dir"]."/".$filename;
		  
		   if(move_uploaded_file($_FILES['qqfile']['tmp_name'],$file_abso))
		   {
				$result=array('success'=>true,'filename'=>$filename);
		   }
		   else
		   {
				$result=array('error'=> 'Could not save uploaded file.');
		   }
		}

		header("Content-Type: text/plain");  
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	}
	public function mk_dir($dir, $mode = 0755) 
	{ 
		if (@is_dir($dir) || @mkdir($dir,$mode)) return true; 
		if (!$this->mk_dir(dirname($dir),$mode)) return false; 
		return @mkdir($dir,$mode); 
	} 
	
	
	public function deleteupload($d=""){
		//print_r($_POST);
		$qquuid=$this->input->post('qquuid');
		$this->load->model('qqfile_model');
		$qqfile=$this->qqfile_model->get_row_byqquuid($qquuid);
		$file="uploads/".$qqfile->folder."/".$qqfile->file;
		if (!unlink($file))
		{
		  	echo "删除失败!";
		}
		else
		{
			echo "删除成功!";
		}
	
	}


}

/* End of file updatefile.php */
/* Location: ./application/controllers/updatefile.php */