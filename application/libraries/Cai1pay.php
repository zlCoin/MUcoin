<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type:text/html;charset=utf-8");
define('PHPEXCEL_ROOT', dirname(__FILE__) . '/');
class Cai1pay {
	function __construct() {
		$this->CI = & get_instance();
		$this->CI->config->load('cai1pay', TRUE);
        $this->config = $this->CI->config->item('cai1pay');
    }

	function pay($data) {
		//提交地址
		$form_url = 'https://payment.cai1pay.com/gateway.aspx'; //正式环境
		$returnurl = site_url('/pay/return_url');
		$serverurl = site_url('/pay/notify_url');
		//交易账户号
		$Mer_code = $this->config['mer_code'];

		//商户证书：登陆http://merchant.ips.com.cn/商户后台下载的商户证书内容
		$Mer_key =$this->config['mer_key'];

		//商户订单编号
		$Billno =$data->no;

		//订单金额(保留2位小数)
		$Amount = number_format($data->money, 2, '.', '');

		//$Amount = number_format(0.1, 2, '.', '');
		//订单日期
		$Date = date('Ymd');

		//币种
		$Currency_Type = $this->config['currency_type'];

		//支付卡种
		$Gateway_Type = $this->config['gateway_type'];

		//语言
		$Lang =$this->config['lang'];

		//支付结果成功返回的商户URL
		$Merchanturl = $returnurl;

		//商户数据包
		$Attach = "";

		//订单支付接口加密方式
		$OrderEncodeType =$this->config['order_encode_type'];

		//交易返回接口加密方式 
		$RetEncodeType = $this->config['ret_encode_type'];

		//返回方式
		$Rettype = $this->config['rettype'];

		//Server to Server 返回页面URL
		$ServerUrl = $serverurl;

		//订单支付接口的Md5摘要，原文=订单号+金额+日期+支付币种+商户证书 
		$SignMD5 = md5($Billno . $Amount . $Date . $Currency_Type . $Mer_key);
?>
		<html>
		  <head>
			<title>支付跳转......</title>
			<meta http-equiv="content-Type" content="text/html; charset=gb2312" />
		  </head>
		  <body>
			<form action="<?php echo $form_url ?>" method="post" id="frm1">
			  <input type="hidden" name="MerCode" value="<?php echo $Mer_code ?>">
			  <input type="hidden" name="MerOrderNo" value="<?php echo $Billno ?>">
			  <input type="hidden" name="Amount" value="<?php echo $Amount ?>" >
			  <input type="hidden" name="OrderDate" value="<?php echo $Date ?>">
			  <input type="hidden" name="Currency" value="<?php echo $Currency_Type ?>">
			  <input type="hidden" name="GatewayType" value="<?php echo $Gateway_Type ?>">
			  <input type="hidden" name="Language" value="<?php echo $Lang ?>">
			  <input type="hidden" name="ReturnUrl" value="<?php echo $Merchanturl ?>">
			  <input type="hidden" name="GoodsInfo" value="<?php echo $Attach ?>">
			  <input type="hidden" name="OrderEncodeType" value="<?php echo $OrderEncodeType ?>">
			  <input type="hidden" name="RetEncodeType" value="<?php echo $RetEncodeType ?>">
			  <input type="hidden" name="Rettype" value="<?php echo $Rettype ?>">
			  <input type="hidden" name="ServerUrl" value="<?php echo $ServerUrl ?>">
			  <input type="hidden" name="SignMD5" value="<?php echo $SignMD5 ?>">
			</form>
			<script language="javascript">
			  document.getElementById("frm1").submit();
			</script>
		  </body>
		</html>
<?
	}

	public function notify_url(){
		header("Content-type:text/html;charset=utf-8");
		
		//----------------------------------------------------
		//  接收数据
		//  Receive the data
		//----------------------------------------------------
		$billno = $_POST['MerOrderNo'];
		$amount = $_POST['Amount'];
		$mydate = $_POST['OrderDate'];
		$succ = $_POST['Succ'];
		$msg = $_POST['Msg'];
		$attach = $_POST['GoodsInfo'];
		$ipsbillno = $_POST['SysOrderNo'];
		$retEncodeType = $_POST['RetencodeType'];
		$currency_type = $_POST['Currency'];
		$signature = $_POST['Signature'];

		$content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
		$cert =$this->config['mer_key'];
		$signature_1ocal = md5($content . $cert);

		if ($signature_1ocal == $signature)
		{
			if ($succ == 'Y')
			{
				
				$this->CI->load->model('pay_model');			
			    $pay=$this->CI->pay_model->get_row_byno($billno);
				if($pay->state==0 && $amount==$pay->money){
					$data['trade_no']=$ipsbillno;
					$data['ptime']=time();
					$data['state']=1;
					$this->CI->pay_model->update_pay($data,$billno);
					$this->CI->load->model('member_model');
					$member=$this->CI->member_model->get_row_byid($pay->member_id);					
					$etime=$pay->number*86400;
					if($member->expiration_date==0 ||  $member->expiration_date==NULL || $member->expiration_date<time()){
						$etime+=time();
					}else{
						$etime+=$member->expiration_date;
					}
					$this->CI->member_model->management_fees($etime,$pay->member_id);					
					$this->CI->load->model('free_stock_model');
					$this->CI->free_stock_model->update_expiration_date($etime,$pay->member_id);
				}
				
			}
			else
			{
			
				
				
			}
		}
		else
		{
			
			
		}
		

	}
	public function return_url(){
		header("Content-type:text/html;charset=utf-8");		
		$billno = $_GET['MerOrderNo'];
		$amount = $_GET['Amount'];
		$mydate = $_GET['OrderDate'];
		$succ = $_GET['Succ'];
		$msg = $_GET['Msg'];
		$attach = $_GET['GoodsInfo'];
		$ipsbillno = $_GET['SysOrderNo'];
		$retEncodeType = $_GET['RetencodeType'];
		$currency_type = $_GET['Currency'];
		$signature = $_GET['Signature'];

		$content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
		$cert =$this->config['mer_key'];
		$signature_1ocal = md5($content . $cert);

		if ($signature_1ocal == $signature)
		{
			if ($succ == 'Y')
			{
				
				$this->CI->load->model('pay_model');			
			    $pay=$this->CI->pay_model->get_row_byno($billno);
				if($pay->state==0){
					$data['trade_no']=$ipsbillno;
					$data['ptime']=time();
					$data['state']=1;
					$this->CI->pay_model->update_pay($data,$billno);
					$this->CI->load->model('member_model');
					$member=$this->CI->member_model->get_row_byid($pay->member_id);					
					$etime=$pay->number*86400;
					if($member->expiration_date==0 ||  $member->expiration_date==NULL || $member->expiration_date<time()){
						$etime+=time();
					}else{
						$etime+=$member->expiration_date;
					}
					$this->CI->member_model->management_fees($etime,$pay->member_id);
					$this->CI->load->model('free_stock_model');
					$this->CI->free_stock_model->update_expiration_date($etime,$pay->member_id);
				}		
				redirect('/pay/success/'.$pay->pay_id);
			}
			else
			{
				redirect('/pay/fail/2');
			}
		}
		else
		{
			
			redirect('/pay/fail/1');
				
		}
	}
	

}