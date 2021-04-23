<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

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
		$this->mysystem = $this->Admin_mo->getrow('system',array('id'=>'1'));
	    if(!$this->session->userdata('uid'))
	    { 
			redirect('home');
	    }
		else
		{
			$this->loginuser = $this->Admin_mo->getrowjoinLeftLimit('users.*,usertypes.utprivileges as privileges,langs.lndir as dir','users',array('usertypes'=>'users.uutid=usertypes.utid','langs'=>'users.ulang=langs.lncode'),array('users.uid'=>$this->session->userdata('uid')),'');
			$this->sections = array();
			$sections = $this->Admin_mo->getwhere('sections',array('scactive'=>'1'));
			if(!empty($sections))
			{
				foreach($sections as $section) { $this->sections[$section->scid] = $section->sccode; }
			}
		}
	}

	public function index()
	{
		if(strpos($this->loginuser->privileges, ',odsee,') !== false && in_array('OD',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); $data['employees'] = array(); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$plans = $this->Admin_mo->get('plans'); $data['plans'] = array(); $pltitle = 'pltitle'.$this->mysystem->langs; foreach($plans as $plan) { $data['plans'][$plan->plid] = $plan->$pltitle; }
		$data['orders'] = $this->Admin_mo->get('orders');
		//$data['orders'] = $this->Admin_mo->getjoinLeft('orders.*,categories.cgtitle'.$this->mysystem->langs.' as category','plans',array('categories'=>'plans.plcgid = categories.cgid'),array());
		$this->load->view('calenderdate');
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/orders',$data);
		$this->load->view('footers/orders');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'orders';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/orders');
		$this->load->view('messages');
		}
	}
	
	public function ordersnow()
	{
		if(strpos($this->loginuser->privileges, ',odsee,') !== false && in_array('OD',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid]['name'] = $employee->uname; $data['employees'][$employee->uid]['email'] = $employee->uemail; $data['employees'][$employee->uid]['phone'] = $employee->umobile; }
		$data['orders'] = $this->Admin_mo->getjoinLeft('ordersnow.*,categories.cgtitle'.$this->mysystem->langs.' as category','ordersnow',array('categories'=>'ordersnow.oncgid = categories.cgid'),array());
		$this->load->view('calenderdate');
		$this->load->view('headers/ordersnow',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/ordersnow',$data);
		$this->load->view('footers/ordersnow');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'ordersnow';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/ordersnow',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/ordersnow');
		$this->load->view('messages');
		}
	}

	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',odedit,') !== false && in_array('OD',$this->sections))
		{
		$id = abs((int)($id));
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$plans = $this->Admin_mo->get('plans'); $data['plans'] = array(); $pltitle = 'pltitle'.$this->mysystem->langs; foreach($plans as $plan) { $data['plans'][$plan->plid] = $plan->$pltitle; }
		$orders = $this->Admin_mo->getjoinLeft('orders.*,users.uname as user','orders',array('users'=>'orders.odeid = users.uid'),array('orders.odid'=>$id));
		$data['order'] = $orders[0];
		if(!empty($data['order']))
		{
			$data['categories'] = $this->Admin_mo->getwhere('categories',array('cgactive'=>'1'));
			$this->load->view('headers/order-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/order-edit',$data);
			$this->load->view('footers/order-edit');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'orders';
			$data['admessage'] = 'youhavenoprivls';
			$this->load->view('headers/orders',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/orders');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'orders';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/orders');
		$this->load->view('messages');
		}
	}
	
	public function editnow($id)
	{
		if(strpos($this->loginuser->privileges, ',odedit,') !== false && in_array('OD',$this->sections))
		{
		$id = abs((int)($id));
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$orders = $this->Admin_mo->getjoinLeft('ordersnow.*,users.uname as user,users.uemail as email,users.umobile as mobile,categories.cgtitle'.$this->mysystem->langs.' as category','ordersnow',array('users'=>'ordersnow.oneid = users.uid','categories'=>'ordersnow.oncgid = categories.cgid'),array('ordersnow.onid'=>$id));
		$data['order'] = $orders[0];
		if(!empty($data['order']))
		{
			//$data['categories'] = $this->Admin_mo->getwhere('categories',array('cgactive'=>'1'));
			$this->load->view('headers/ordernow-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/ordernow-edit',$data);
			$this->load->view('footers/order-edit');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'ordersnow';
			$data['admessage'] = 'youhavenoprivls';
			$this->load->view('headers/ordersnow',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/ordersnow');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'ordersnow';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/ordersnow',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/ordersnow');
		$this->load->view('messages');
		}
	}
	
	public function editorder($id)
	{
		if(strpos($this->loginuser->privileges, ',odedit,') !== false && in_array('OD',$this->sections))
		{
		$id = abs((int)($id));
		if($id != '')
		{
		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('status', 'lang:status' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['system'] = $this->mysystem;
				$plans = $this->Admin_mo->get('plans'); $data['plans'] = array(); $pltitle = 'pltitle'.$this->mysystem->langs; foreach($plans as $plan) { $data['plans'][$plan->plid] = $plan->$pltitle; }
				$orders = $this->Admin_mo->getjoinLeft('orders.*,users.uname as user','orders',array('users'=>'orders.odeid = users.uid'),array('orders.odid'=>$id));
				$data['order'] = $orders[0];
				$this->load->view('headers/order-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/order-edit',$data);
				$this->load->view('footers/order-edit');
				$this->load->view('messages');
			}
			else
			{
				$update_array = array('oduid'=>$this->session->userdata('uid'), 'odtype'=>set_value('status'), 'odtime'=>time());
				if(set_value('status') == 'success_pay' || set_value('status') == 'cancel_pay')	$update_array = array('odtype'=>'');
				if($this->Admin_mo->update('orders', $update_array, array('odid'=>$id)))
				{
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				}
				else
				{
					$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				}
				redirect('orders', 'refresh');			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('orders', 'refresh');
		}
		//redirect('orders', 'refresh');
		}
		else
		{
		$data['title'] = 'orders';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/orders');
		$this->load->view('messages');
		}
	}

	public function editordernow($id)
	{
		if(strpos($this->loginuser->privileges, ',odedit,') !== false && in_array('OD',$this->sections))
		{
		$id = abs((int)($id));
		if($id != '')
		{
		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
			$this->config->set_item('language', $this->loginuser->ulang);
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('status', 'lang:status' , 'trim|required');
			$this->form_validation->set_rules('price', 'lang:price' , 'trim|required|numeric');
			if($this->form_validation->run() == FALSE)
			{
				$data['system'] = $this->mysystem;
				$orders = $this->Admin_mo->getjoinLeft('ordersnow.*,users.uname as user,users.uemail as email,users.umobile as mobile,categories.cgtitle'.$this->mysystem->langs.' as category','ordersnow',array('users'=>'ordersnow.oneid = users.uid','categories'=>'ordersnow.oncgid = categories.cgid'),array('ordersnow.onid'=>$id));
				$data['order'] = $orders[0];
				$this->load->view('headers/ordernow-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/ordernow-edit',$data);
				$this->load->view('footers/order-edit');
				$this->load->view('messages');
			}
			else
			{
				$update_array = array('onuid'=>$this->session->userdata('uid'), 'onprice'=>set_value('price'), 'ontype'=>set_value('status'), 'ontime'=>time());
				if($this->Admin_mo->update('ordersnow', $update_array, array('onid'=>$id)))
				{
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				}
				else
				{
					$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				}
				redirect('orders/ordersnow', 'refresh');			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('orders/ordersnow', 'refresh');
		}
		//redirect('orders', 'refresh');
		}
		else
		{
		$data['title'] = 'orders';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/orders');
		$this->load->view('messages');
		}
	}
	
	public function del($id)
	{
		$id = abs((int)($id));
		if(strpos($this->loginuser->privileges, ',oddelete,') !== false && in_array('OD',$this->sections))
		{
		$order = $this->Admin_mo->getrow('orders', array('odid'=>$id));
		if(!empty($order))
		{
			$this->Admin_mo->del('orders', array('odid'=>$id));
			$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			redirect('orders', 'refresh');
		}
		else
		{
			$data['title'] = 'orders';
			$data['admessage'] = 'youhavenoprivls';
			$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
			$this->load->view('headers/orders',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/orders');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'orders';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/orders');
		$this->load->view('messages');
		}
	}
	
	public function delnow($id)
	{
		$id = abs((int)($id));
		if(strpos($this->loginuser->privileges, ',oddelete,') !== false && in_array('OD',$this->sections))
		{
		$order = $this->Admin_mo->getrow('ordersnow', array('onid'=>$id));
		if(!empty($order))
		{
			$this->Admin_mo->del('ordersnow', array('onid'=>$id));
			$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			redirect('orders/ordersnow', 'refresh');
		}
		else
		{
			$data['title'] = 'ordersnow';
			$data['admessage'] = 'youhavenoprivls';
			$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
			$this->load->view('headers/ordersnow',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/ordersnow');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'ordersnow';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/ordersnow',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/ordersnow');
		$this->load->view('messages');
		}
	}
}