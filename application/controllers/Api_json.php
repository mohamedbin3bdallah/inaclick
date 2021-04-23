<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
    {
		parent::__construct();
		$this->sections = array();
		$sections = $this->Admin_mo->getwhere('sections',array('scactive'=>'1'));
		if(!empty($sections))
		{
			foreach($sections as $section) { $this->sections[$section->scid] = $section->sccode; }
		}
	}
	
	public function login()
	{
		//header('Content-Type: application/json');
		//header('Content-Type: text/html; charset=utf-8');

		$response = array('data'=>'');
		if(in_array('U',$this->sections))
		{
			//$_POST = '{"email":"aaaaa@aaaaa.com","password":"123123"}';
			//$request = json_decode($_POST);
			$request = json_decode(file_get_contents('php://input'));
			if(isset($request) && !empty($request))
			{
				if(isset($request->email,$request->password))
				{
					$data = $this->Admin_mo->getrow('users',array('uemail'=>str_replace(array('"',"'",' '), '',$request->email),'uutid'=>'5'));
					if(isset($data) && !empty($data))
					{
						if(password_verify($request->password, $data->upassword))
						{
							if($data->uactive == '1')
							{
								$response['message'] = 'user_exist';
								$response['data'] = array('id'=>$data->uid,'name'=>$data->uname);
								$response['code'] = '1';
							}
							else { $response['message'] = 'user_not_active'; $response['code'] = '6'; }
						}
						else { $response['message'] = 'password_not_match'; $response['code'] = '5'; }
					}
					else { $response['message'] = 'user_not_exist'; $response['code'] = '0'; }
				}
				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }
			}
			else { $response['message'] = 'request_error'; $response['code'] = '3'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}

	public function register()
	{
		$response = array('data'=>'');
		if(in_array('U',$this->sections))
		{
			$request = $_POST;
			//$request = json_decode(file_get_contents('php://input'));
			if(isset($request) && !empty($request))
			{
				if(isset($request->name,$request->username,$request->password,$request->email,$request->mobile,$request->address))
				{
					$username = $this->Admin_mo->exist('users',' where username like "'.str_replace(array('"',"'",' '), '',$request->username).'"','');
					$email = $this->Admin_mo->exist('users',' where uemail like "'.str_replace(array('"',"'",' '), '',$request->email).'"','');
					$mobile = $this->Admin_mo->exist('users',' where umobile like "'.str_replace(array('"',"'",' '), '',$request->mobile).'"','');
					if($username == 0 && $email == 0 && $mobile == 0)
					{
						$verificationCode = mt_rand(11111,99999);
						$set_arr = array('uutid'=>5, 'uname'=>str_replace(array('"',"'"), '',$request->name), 'username'=>str_replace(array('"',"'",' '), '',$request->username), 'uemail'=>str_replace(array('"',"'",' '), '',$request->email), 'umobile'=>str_replace(array('"',"'",' '), '',$request->mobile), 'uaddress'=>$request->address, 'upassword'=>password_hash($request->password, PASSWORD_BCRYPT, array('cost'=>10)), 'ucode'=>$verificationCode, 'utime'=>time());
						$uid = $this->Admin_mo->set('users', $set_arr);
						if(empty($uid))
						{
							$response['message'] = 'somthing_wrong';
							$response['code'] = '5';
						}
						else
						{
							$response['message'] = 'success';
							$response['data'] = 'Activation link: '.base_url().'frontend/active/'.$request->username.'/'.$verificationCode;
							$response['code'] = '1';
						}
					}
					else
					{
						if($username != 0) $response['message'][] = 'username_exist';
						if($email != 0) $response['message'][] = 'email_exist';
						if($mobile != 0) $response['message'][] = 'mobile_exist';
						$response['code'] = '0';
					}
				}
				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }
			}
			else { $response['message'] = 'request_error'; $response['code'] = '3'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function forgotpassword()
	{
		$response = array('data'=>'');
		if(in_array('U',$this->sections))
		{
			//$request = json_decode($_POST);
			//$request = json_decode(file_get_contents('php://input'));
			$request = $_POST;
			if(isset($request) && !empty($request))
			{
				if(isset($request->email))
				{
					$email = $this->Admin_mo->exist('users',' where uemail like "'.str_replace(array('"',"'",' '), '',$request->email).'"','');
					if($email != 0)
					{
						$newpassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+') , 0 , 9);
						if($this->Admin_mo->update('users', array('upassword'=>password_hash($newpassword, PASSWORD_BCRYPT, array('cost'=>10)),'uuid'=>0,'utime'=>time()), array('uemail'=>$request->email)))
						{
							$response['message'] = 'success';
							$response['data'] = 'New Password: '.$newpassword;
							$response['code'] = '1';
						}
						else
						{
							$response['message'] = 'somthing_wrong';
							$response['code'] = '5';
						}
					}
					else
					{
						$response['message'] = 'email_not_exist';
						$response['code'] = '0';
					}
				}
				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }
			}
			else { $response['message'] = 'request_error'; $response['code'] = '3'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function services()
	{
		$response = array('data'=>'');
		if(in_array('CG',$this->sections))
		{
			$data = $this->Admin_mo->getwhere('categories',array('cgactive'=>'1'));
			if(isset($data) && !empty($data))
			{
				$response['message'] = 'data_exist';
				$response['image'] = base_url().$this->config->item('categories_folder');
				$response['thumb'] = base_url().$this->config->item('categories_thumb_folder');
				$response['data'] = $data;
				$response['code'] = '1';
			}
			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function projects()
	{
		$response = array('data'=>'');
		if(in_array('PR',$this->sections))
		{
			$data = $this->Admin_mo->getjoinLeft('products.*,categories.cgtitleen as categoryen,categories.cgtitlear as categoryar','products',array('categories'=>'products.prcgid = categories.cgid'),array('cgactive'=>'1','practive'=>'1'));
			if(isset($data) && !empty($data))
			{
				$response['message'] = 'data_exist';
				$response['image'] = base_url().$this->config->item('products_folder');
				$response['thumb'] = base_url().$this->config->item('products_thumb_folder');
				$response['data'] = $data;
				$response['code'] = '1';
			}
			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function faq()
	{
		$response = array('data'=>'');
		if(in_array('FA',$this->sections))
		{
			$data = $this->Admin_mo->getwhere('faq',array('faactive'=>'1'));
			if(isset($data) && !empty($data))
			{
				$response['message'] = 'data_exist';
				$response['data'] = $data;
				$response['code'] = '1';
			}
			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function about()
	{
		$response = array('data'=>'');
		if(in_array('AB',$this->sections))
		{
			$data = $this->Admin_mo->getrow('about',array('abid'=>'1'));
			if(isset($data) && !empty($data))
			{
				$response['message'] = 'data_exist';
				$response['data'] = $data;
				$response['code'] = '1';
			}
			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function plans()
	{
		$response = array('data'=>'');
		if(in_array('PL',$this->sections))
		{			$system = $this->Admin_mo->getrow('system',array('id'=>'1'));		
			$data = $this->Admin_mo->getjoinLeft('plans.*,categories.cgtitleen as categoryen,categories.cgtitlear as categoryar','plans',array('categories'=>'plans.plcgid = categories.cgid'),array('cgactive'=>'1','plactive'=>'1'));
			if(isset($data) && !empty($data))
			{
				$response['message'] = 'data_exist';
				$response['data'] = $data;								$response['currency'] = $system->currency;								$response['payemail'] = $system->payemail;
				$response['code'] = '1';
			}
			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}
	
	public function contact()
	{
		$response = array();
		if(in_array('MG',$this->sections))
		{
			//$request = json_decode($_POST);
			$request = json_decode(file_get_contents('php://input'));
			if(isset($request) && !empty($request))
			{
				if(isset($request->id,$request->name,$request->email,$request->title,$request->body))
				{
					$set_arr = array('mgeid'=>$request->id, 'mgname'=>$request->name, 'mgemail'=>$request->email, 'mgtitle'=>$request->title, 'mgbody'=>$request->body, 'mgtime'=>time());
					$mgid = $this->Admin_mo->set('messages', $set_arr);
					if(!empty($mgid))
					{
						$response['message'] = 'success';
						$response['code'] = '1';
					}
					else { $response['message'] = 'somthing_wrong'; $response['code'] = '5'; }
				}
				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }
			}
			else { $response['message'] = 'request_error'; $response['code'] = '3'; }
		}
		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }
		
		echo json_encode($response);
	}			public function pay()	{		$response = array('data'=>'');		if(in_array('OD',$this->sections))		{			//$request = json_decode($_POST);			$request = json_decode(file_get_contents('php://input'));			if(isset($request) && !empty($request))			{				if(isset($request->id,$request->plan,$request->price))				{					$system = $this->Admin_mo->getrow('system',array('id'=>'1'));										$odnumber = substr(str_shuffle('0123456789') , 0 , 15);										$odcode = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 25);					$set_arr = array('odeid'=>$request->id,'odplid'=>$request->plan,'odprice'=>$request->price,'odnumber'=>$odnumber,'odcode'=>$odcode,'odtype'=>'waiting_pay','odtime'=>time());					$odid = $this->Admin_mo->set('orders', $set_arr);					if(!empty($odid))					{						$response['data'] = $odid;												$response['order_number'] = $odnumber;												$response['order_code'] = $odcode;												$response['currency'] = $system->currency;										$response['payemail'] = $system->payemail;												$response['message'] = 'success';						$response['code'] = '1';					}					else { $response['message'] = 'somthing_wrong'; $response['code'] = '5'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}			public function paynow()	{		$response = array('data'=>'');		if(in_array('OD',$this->sections))		{			//$request = json_decode($_POST);			$request = json_decode(file_get_contents('php://input'));			if(isset($request) && !empty($request))			{				if(isset($request->id,$request->name,$request->email,$request->mobile,$request->wsup,$request->service,$request->description))				{															$onnumber = substr(str_shuffle('0123456789') , 0 , 15);										$set_arr = array('oneid'=>$request->id,'oncgid'=>$request->service,'onname'=>$request->name,'onnumber'=>$onnumber,'onemail'=>$request->email,'ondesc'=>$request->description,'onmobile'=>$request->mobile,'onwasup'=>$request->wsup,'ontype'=>'waiting_pay','ontime'=>time());					$odid = $this->Admin_mo->set('ordersnow', $set_arr);					if(!empty($odid))					{						$response['data'] = $odid;												$response['order_number'] = $onnumber;																						$response['payemail'] = $this->config->item('email_sender');												$response['message'] = 'success';						$response['code'] = '1';					}					else { $response['message'] = 'somthing_wrong'; $response['code'] = '5'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}			public function pay_success()	{		$response = array();		if(in_array('OD',$this->sections))		{			//$request = json_decode($_POST);			$request = json_decode(file_get_contents('php://input'));			if(isset($request) && !empty($request))			{				if(isset($request->id,$request->code))				{					$system = $this->Admin_mo->getrow('system',array('id'=>'1'));					$order = $this->Admin_mo->getrow('orders',array('odcode'=>$request->code,'odeid'=>$request->id));					if(!empty($order))					{						if($this->Admin_mo->update('orders', array('odtype'=>'success_pay','odcode'=>''), array('odid'=>$order->odid,'odcode'=>$request->code,'odeid'=>$request->id)))						{													$response['message'] = 'success';							$response['code'] = '1';						}												else { $response['message'] = 'somthing_wrong'; $response['code'] = '5'; }					}										else { $response['message'] = 'code_error'; $response['code'] = '0'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}			public function orders()	{		$response = array('data'=>array('orders'=>'','ordersnow'=>''));		if(in_array('OD',$this->sections))		{			//$request = json_decode($_POST);			//$request = json_decode(file_get_contents('php://input'));			$request = $_POST;			if(isset($request) && !empty($request))			{				if(isset($request->id))				{					$system = $this->Admin_mo->getrow('system',array('id'=>'1'));										$orders = $this->Admin_mo->getjoinLeft('orders.odplid as plans,orders.odnumber as number,orders.odprice as price,orders.odtype as status','orders',array(),array('odeid'=>$request->id));										$ordersnow = $this->Admin_mo->getjoinLeft('ordersnow.ondesc as ondesc,ordersnow.onid as onid,ordersnow.onprice as onprice,ordersnow.onnumber as onnumber,ordersnow.ontype as ontype,categories.cgtitleen as cgtitleen,categories.cgtitlear as cgtitlear','ordersnow',array('categories'=>'ordersnow.oncgid=categories.cgid'),array('ordersnow.oneid'=>$request->id));					if(!empty($orders) || !empty($ordersnow))					{						$response['data']['orders'] = $orders;												$response['data']['ordersnow'] = $ordersnow;												$response['currency'] = $system->currency;												$response['message'] = 'success';						$response['code'] = '1';					}										else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}			public function socialmedia()	{		$response = array('data'=>'');		if(in_array('SM',$this->sections))		{						$data = $this->Admin_mo->getjoinLeft('smfacebook as facebook,smgoogleplus as googleplus,smtwitter as twitter,sminstagram as instagram,smyoutube as youtube,smlinkedin as linkedin','contact',array(),array('smactive'=>'1','ctid'=>'1'));			if(isset($data) && !empty($data))			{				$response['message'] = 'data_exist';				$response['data'] = $data[0];				$response['code'] = '1';			}			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}			public function contactinfo()	{		$response = array('data'=>'');		if(in_array('CT',$this->sections))		{						$data = $this->Admin_mo->getjoinLeft('ctaddressen as address_en,ctaddressar as address_ar,ctphone as phone,ctmobile as mobile,ctemail as email,ctmap as map','contact',array(),array('ctactive'=>'1','ctid'=>'1'));			if(isset($data) && !empty($data))			{				$response['message'] = 'data_exist';				$response['data'] = $data[0];				$response['code'] = '1';			}			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}
}