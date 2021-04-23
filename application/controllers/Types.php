<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Types extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',tysee,') !== false && in_array('TY',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['preporders'] = $this->Admin_mo->getjoinLeft('types.*,ty_d.*,langs.lntitle as lang','ty_d',array('types'=>'ty_d.dtyid = types.tyid','langs'=>'ty_d.tylncode = langs.lncode'),array());
		if(!empty($data['preporders']))
		{
			for($i=0;$i<count($data['preporders']);$i++)
			{
				//$data['orders'][$data['preporders'][$i]->oid] = new stdClass();
				$data['types'][$data['preporders'][$i]->tyid]['tyid'] = $data['preporders'][$i]->tyid;
				$data['types'][$data['preporders'][$i]->tyid]['tyuid'] = $data['preporders'][$i]->tyuid;
				$data['types'][$data['preporders'][$i]->tyid]['tytime'] = $data['preporders'][$i]->tytime;
				$data['types'][$data['preporders'][$i]->tyid]['tytype'] = $data['preporders'][$i]->tytype;
				$data['types'][$data['preporders'][$i]->tyid]['tyactive'] = $data['preporders'][$i]->tyactive;
				
				$data['types'][$data['preporders'][$i]->tyid]['items'][$i]['did'] = $data['preporders'][$i]->did;
				$data['types'][$data['preporders'][$i]->tyid]['items'][$i]['lang'] = $data['preporders'][$i]->lang;
				$data['types'][$data['preporders'][$i]->tyid]['items'][$i]['tytitle'] = $data['preporders'][$i]->tytitle;
				$data['types'][$data['preporders'][$i]->tyid]['items'][$i]['tydesc'] = $data['preporders'][$i]->tydesc;
			}
		}
		$this->load->view('calenderdate');
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/types',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'types';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',tyadd,') !== false && in_array('TY',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
		if(!empty($data['langs']))
		{
			$this->load->view('headers/type-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/type-add',$data);
			$this->load->view('footers/type-add');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'types';
			$data['admessage'] = 'youhavenoprivls';
			$this->load->view('headers/types',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/types');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'types';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',tyadd,') !== false && in_array('TY',$this->sections))
		{
		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
			$this->config->set_item('language', $this->loginuser->ulang);
			$langs = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1')); foreach($langs as $lang) { $mylang[$lang->lncode] = $lang->lntitle; }
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		//$this->form_validation->set_rules('titlear', 'lang:titlear' , 'trim|required|max_length[255]|is_unique[categories.cgtitlear]');
		foreach(set_value('title') as $lang => $title) { $this->form_validation->set_rules('title['.$lang.']', $mylang[$lang] , 'trim|required|max_length[255]'); }
		$this->form_validation->set_rules('service', 'lang:service' , 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$data['system'] = $this->mysystem;
			$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
			$this->load->view('headers/type-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/type-add',$data);
			$this->load->view('footers/type-add');
			$this->load->view('messages');
		}
		else
		{
			//foreach(set_value('lang') as $lang) { echo $lang; }
			$set_arr = array('tyuid'=>$this->session->userdata('uid'), 'tytype'=>set_value('service'), 'tyactive'=>set_value('active'), 'tytime'=>time());
			$tyid = $this->Admin_mo->set('types', $set_arr);
			if(empty($tyid))
			{
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('types/add', 'refresh');
			}
			else
			{
				foreach(set_value('title') as $lang => $title) { $ty_d = $this->Admin_mo->set('ty_d', array('dtyid'=>$tyid, 'tytitle'=>$title, 'tydesc'=>set_value('desc')[$lang], 'tylncode'=>$lang)); }
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('types', 'refresh');
			}
		}
		//redirect('types/add', 'refresh');
		}
		else
		{
		$data['title'] = 'types';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',tyedit,') !== false && in_array('TY',$this->sections))
		{
		$id = abs((int)($id));
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$data['type'] = $this->Admin_mo->getrow('types',array('tyid'=>$id));
		if(!empty($data['type']))
		{
			$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
			$ty_ds = $this->Admin_mo->getwhere('ty_d',array('dtyid'=>$id));
			foreach($ty_ds as $ty_d) { $data['ty_ds'][$ty_d->tylncode]['title'] = $ty_d->tytitle; $data['ty_ds'][$ty_d->tylncode]['desc'] = $ty_d->tydesc; }
			$this->load->view('headers/type-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/type-edit',$data);
			$this->load->view('footers/type-edit');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'types';
			$data['admessage'] = 'youhavenoprivls';
			$this->load->view('headers/types',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/types');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'types';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
	}
	
	public function edittype($id)
	{
		if(strpos($this->loginuser->privileges, ',tyedit,') !== false && in_array('TY',$this->sections))
		{
		$id = abs((int)($id));
		if($id != '')
		{
		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
				$this->config->set_item('language', $this->loginuser->ulang);
				$langs = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1')); foreach($langs as $lang) { $mylang[$lang->lncode] = $lang->lntitle; }
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			foreach(set_value('title') as $lang => $title) { $this->form_validation->set_rules('title['.$lang.']', $mylang[$lang] , 'trim|required|max_length[255]'); }
			$this->form_validation->set_rules('service', 'lang:service' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['system'] = $this->mysystem;
				$data['type'] = $this->Admin_mo->getrow('types',array('tyid'=>$id));
				$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
				$ty_ds = $this->Admin_mo->getwhere('ty_d',array('dtyid'=>$id));
				foreach($ty_ds as $ty_d) { $data['ty_ds'][$ty_d->tylncode] = $ty_d->tytitle; }
				$this->load->view('headers/type-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/type-edit',$data);
				$this->load->view('footers/type-edit');
				$this->load->view('messages');
			}
			else
			{
				$update_array = array('tyuid'=>$this->session->userdata('uid'), 'tytype'=>set_value('service'), 'tyactive'=>set_value('active'), 'tytime'=>time());
				if($this->Admin_mo->update('types', $update_array, array('tyid'=>$id)))
				{
					$this->Admin_mo->del('ty_d', array('dtyid'=>$id));
					foreach(set_value('title') as $lang => $title) { $ty_d = $this->Admin_mo->set('ty_d', array('dtyid'=>$id, 'tytitle'=>$title, 'tydesc'=>set_value('desc')[$lang], 'tylncode'=>$lang)); }
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				}
				else
				{
					$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				}
				redirect('types', 'refresh');
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('types', 'refresh');
		}
		//redirect('types', 'refresh');
		}
		else
		{
		$data['title'] = 'types';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
	}

	public function del($id)
	{
		$id = abs((int)($id));
		if(strpos($this->loginuser->privileges, ',tydelete,') !== false && in_array('TY',$this->sections))
		{
		$category = $this->Admin_mo->getrow('types', array('tyid'=>$id));
		if(!empty($category))
		{
			$this->Admin_mo->del('types', array('tyid'=>$id));
			$this->Admin_mo->del('ty_d', array('dtyid'=>$id));
			$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			redirect('types', 'refresh');
		}
		else
		{
			$data['title'] = 'types';
			$data['admessage'] = 'youhavenoprivls';
			$data['system'] = $this->mysystem;
			$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
			$this->config->set_item('language', $this->loginuser->ulang);
			$this->load->view('headers/types',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/types');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'types';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/types',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/types');
		$this->load->view('messages');
		}
	}	
}