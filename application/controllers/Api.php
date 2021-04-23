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
			//$request = json_decode(file_get_contents('php://input'));
			$request = $_POST;
			if(isset($request) && !empty($request))
			{
				if(isset($request['mobile'],$request['key']))
				{
					$data = $this->Admin_mo->getrow('users',array('umobile'=>str_replace(array('"',"'",' '), '',$request['mobile'])));
					if(isset($data) && !empty($data))
					{
						if(password_verify($request['key'], $data->ukey))
						{
							if($data->uactive == '1')
							{
								$response['message'] = 'user_exist';
								$response['data'] = array('userid'=>$data->uid,'name'=>$data->uname,'usertype'=>$data->uutid);
								$response['code'] = '1';
							}
							else { $response['message'] = 'user_not_active'; $response['code'] = '6'; }
						}
						else { $response['message'] = 'wrong_key'; $response['code'] = '7'; }
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
			//$request = json_decode($_POST);
			//$request = json_decode(file_get_contents('php://input'));
			$request = $_POST;
			if(isset($request) && !empty($request))
			{
				if(isset($request['usertype'],$request['name'],$request['password'],$request['email'],$request['mobile'],$request['address'],$request['key']))
				{
					$email = $this->Admin_mo->exist('users',' where uemail like "'.str_replace(array('"',"'",' '), '',$request['email']).'"','');
					$mobile = $this->Admin_mo->exist('users',' where umobile like "'.str_replace(array('"',"'",' '), '',$request['mobile']).'"','');
					if($email == 0 && $mobile == 0)
					{
						$verificationCode = mt_rand(11111,99999);												$verificationCode2 = mt_rand(11111,99999);
						$set_arr = array('uutid'=>$request['usertype'], 'uname'=>str_replace(array('"',"'"), '',$request['name']), 'uemail'=>str_replace(array('"',"'",' '), '',$request['email']), 'umobile'=>str_replace(array('"',"'",' '), '',$request['mobile']), 'uaddress'=>$request['address'], 'upcid'=>$request['address'], 'upassword'=>password_hash($request['password'], PASSWORD_BCRYPT, array('cost'=>10)), 'ukey'=>password_hash($request['key'], PASSWORD_BCRYPT, array('cost'=>10)), 'ucode'=>$verificationCode, 'ucode2'=>$verificationCode2, 'utime'=>time());
						$uid = $this->Admin_mo->set('users', $set_arr);
						if(empty($uid))
						{
							$response['message'] = 'somthing_wrong';
							$response['code'] = '5';
						}
						else
						{
							$response['message'] = 'success';
							$response['verificationCode'] = $verificationCode;														$response['verificationCode2'] = $verificationCode2;
							$response['code'] = '1';
						}
					}
					else
					{
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
	}			public function active()	{		$response = array('data'=>'');		if(in_array('U',$this->sections))		{			//$request = json_decode($_POST);			//$request = json_decode(file_get_contents('php://input'));			$request = $_POST;			if(isset($request) && !empty($request))			{				if(isset($request['code'],$request['code2'],$request['key']))				{					//$email = $this->Admin_mo->exist('users',' where ucode like "'.str_replace(array('"',"'",' '), '',$request['code']).'" and ucode2 like "'.str_replace(array('"',"'",' '), '',$request['code2']).'"','');										$data = $this->Admin_mo->getrow('users',array('ucode'=>str_replace(array('"',"'",' '), '',$request['code']),'ucode2'=>str_replace(array('"',"'",' '), '',$request['code2'])));					if(isset($data) && !empty($data))					{						if(password_verify($request['key'], $data->ukey))						{							if($this->Admin_mo->update('users', array('ucode'=>'','ucode2'=>'','uuid'=>0,'utime'=>time()), array('uid'=>$data->uid)))							{								$response['message'] = 'success';								$response['data'] = array('userid'=>$data->uid,'name'=>$data->uname,'usertype'=>$data->uutid);								$response['code'] = '1';							}							else							{								$response['message'] = 'somthing_wrong';								$response['code'] = '5';							}						}													else { $response['message'] = 'wrong_key'; $response['code'] = '7'; }					}					else {	$response['message'] = 'wrong_code'; $response['code'] = '0'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }				echo json_encode($response);	}
	
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
				if(isset($request['email']))
				{
					$email = $this->Admin_mo->exist('users',' where uemail like "'.str_replace(array('"',"'",' '), '',$request['email']).'"','');
					if($email != 0)
					{
						$newpassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+') , 0 , 9);
						if($this->Admin_mo->update('users', array('upassword'=>password_hash($newpassword, PASSWORD_BCRYPT, array('cost'=>10)),'uuid'=>0,'utime'=>time()), array('uemail'=>$request['email'])))
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
	}			public function places()	{		$response = array('data'=>'');		if(in_array('CG',$this->sections))		{						$data = $this->Admin_mo->getjoinLeft('pcid as id,pctitle as title,pcphone as phone','places',array(),array('pcactive'=>'1'));			if(isset($data) && !empty($data))			{				$response['message'] = 'data_exist';				$response['data'] = $data;				$response['code'] = '1';			}			else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }		echo json_encode($response);	}		public function categories()	{		$response = array('data'=>'');		if(in_array('CG',$this->sections))		{						$request = $_POST;			if(isset($request) && !empty($request))			{				if(isset($request['key'],$request['lang'],$request['type']))				{										$data = $this->Admin_mo->getjoinLeft('categories.cgid as id,categories.cgcolor as color1,categories.cgcolor2 as color2,categories.cgimg as image,cg_d.cgtitle as title,cg_d.cgdesc as desc','cg_d',array('categories'=>'cg_d.dcgid = categories.cgid'),array('categories.cgtype'=>$request['type'],'categories.cgactive'=>'1','cg_d.cglncode'=>$request['lang']));					if(isset($data) && !empty($data))					{						$response['message'] = 'data_exist';						$response['image'] = base_url().$this->config->item('categories_folder');						$response['thumb'] = base_url().$this->config->item('categories_thumb_folder');						$response['data'] = $data;						$response['code'] = '1';					}					else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }		echo json_encode($response);	}		public function types()	{		$response = array('data'=>'');		if(in_array('TY',$this->sections))		{						$request = $_POST;			if(isset($request) && !empty($request))			{				if(isset($request['key'],$request['lang'],$request['type']))				{										$data = $this->Admin_mo->getjoinLeft('types.tyid as id,types.tyid as id,ty_d.tytitle as title,ty_d.tydesc as desc','ty_d',array('types'=>'ty_d.dtyid = types.tyid'),array('types.tytype'=>$request['type'],'types.tyactive'=>'1','ty_d.tylncode'=>$request['lang']));					if(isset($data) && !empty($data))					{						$response['message'] = 'data_exist';						$response['data'] = $data;						$response['code'] = '1';					}					else { $response['message'] = 'data_not_exist'; $response['code'] = '0'; }				}				else { $response['message'] = 'request_match_error'; $response['code'] = '4'; }			}			else { $response['message'] = 'request_error'; $response['code'] = '3'; }		}		else { $response['message'] = 'plugin_not_active'; $response['code'] = '2'; }		echo json_encode($response);	}
}