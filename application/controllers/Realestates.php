<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realestates extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',resee,') !== false && in_array('RE',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['realestates'] = $this->Admin_mo->getjoinLeft('realestates.*,cg_d.cgtitle as cgtitle,ty_d.tytitle as tytitle,places.pccurrency as currency','realestates',array('cg_d'=>'realestates.recgid = cg_d.dcgid','ty_d'=>'realestates.retyid = ty_d.dtyid','users'=>'realestates.reeid = users.uid','places'=>'users.uplace = places.pcid'),array('cg_d.cglncode'=>$this->loginuser->ulang, 'ty_d.tylncode'=>$this->loginuser->ulang));
		$this->load->view('calenderdate');
		$this->load->view('headers/realestates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/realestates',$data);
		$this->load->view('footers/realestates');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'realestates';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/realestates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/realestates');
		$this->load->view('messages');
		}
	}
	
	public function rents()
	{
		if(strpos($this->loginuser->privileges, ',resee,') !== false && in_array('RE',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['rents'] = $this->Admin_mo->getjoinLeft('rents.*,realestates.retitle as retitle,places.pccurrency as currency','rents',array('realestates'=>'rents.reid = realestates.reid','users'=>'rents.oid = users.uid','places'=>'users.uplace = places.pcid'),array('realestates.retype'=>'rent'));
		$this->load->view('calenderdate');
		$this->load->view('headers/rents',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/rents',$data);
		$this->load->view('footers/rents');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'rents';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/rents',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/rents');
		$this->load->view('messages');
		}
	}
	
	public function buys()
	{
		if(strpos($this->loginuser->privileges, ',resee,') !== false && in_array('RE',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['buys'] = $this->Admin_mo->getjoinLeft('buys.*,realestates.retitle as retitle,places.pccurrency as currency','buys',array('realestates'=>'buys.reid = realestates.reid','users'=>'buys.oid = users.uid','places'=>'users.uplace = places.pcid'),array('realestates.retype'=>'buy'));
		$this->load->view('calenderdate');
		$this->load->view('headers/buys',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/buys',$data);
		$this->load->view('footers/buys');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'buys';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/buys',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/buys');
		$this->load->view('messages');
		}
	}
	
	public function books()
	{
		if(strpos($this->loginuser->privileges, ',resee,') !== false && in_array('RE',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['books'] = $this->Admin_mo->getjoinLeft('books.*,realestates.retitle as retitle,places.pccurrency as currency','books',array('realestates'=>'books.reid = realestates.reid','users'=>'books.oid = users.uid','places'=>'users.uplace = places.pcid'),array());
		$this->load->view('calenderdate');
		$this->load->view('headers/books',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/books',$data);
		$this->load->view('footers/books');
		$this->load->view('messages');
		}
		else
		{
		$data['title'] = 'books';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/books',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/books');
		$this->load->view('messages');
		}
	}
	
	public function activate()
	{
		if($this->Admin_mo->update('realestates', array('reactive'=>$_POST['act'], 'reuid'=>$this->session->userdata('uid'), 'retime'=>time()), array('reid'=>$_POST['id']))) echo 1;
		else echo 0;
	}
	/*
	public function add()
	{
		if(strpos($this->loginuser->privileges, ',cgadd,') !== false && in_array('CG',$this->sections))
		{
		$data['admessage'] = '';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
		if(!empty($data['langs']))
		{
			$this->load->view('headers/category-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/category-add',$data);
			$this->load->view('footers/category-add');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'categories';
			$data['admessage'] = 'youhavenoprivls';
			$this->load->view('headers/categories',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/categories');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'categories';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/categories',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/categories');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',cgadd,') !== false && in_array('CG',$this->sections))
		{
		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
			$this->config->set_item('language', $this->loginuser->ulang);
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		//$this->form_validation->set_rules('titlear', 'lang:titlear' , 'trim|required|max_length[255]|is_unique[categories.cgtitlear]');
		foreach(set_value('title') as $lang => $title) { $this->form_validation->set_rules('title['.$lang.']', 'lang:title'.$lang , 'trim|required|max_length[255]'); }
		$this->form_validation->set_rules('service', 'lang:service' , 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$data['system'] = $this->mysystem;
			$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
			$this->load->view('headers/category-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/category-add',$data);
			$this->load->view('footers/category-add');
			$this->load->view('messages');
		}
		else
		{
			//foreach(set_value('lang') as $lang) { echo $lang; }
			$set_arr = array('cguid'=>$this->session->userdata('uid'), 'cgtype'=>set_value('service'), 'cgactive'=>set_value('active'), 'cgtime'=>time());
			$cgid = $this->Admin_mo->set('categories', $set_arr);
			if(empty($cgid))
			{
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('categories/add', 'refresh');
			}
			else
			{
				foreach(set_value('title') as $lang => $title) { $cg_d = $this->Admin_mo->set('cg_d', array('dcgid'=>$cgid, 'cgtitle'=>$title, 'cglncode'=>$lang)); }
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('categories', 'refresh');
			}
		}
		//redirect('categories/add', 'refresh');
		}
		else
		{
		$data['title'] = 'categories';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/categories',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/categories');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',cgedit,') !== false && in_array('CG',$this->sections))
		{
		$id = abs((int)($id));
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$data['category'] = $this->Admin_mo->getrow('categories',array('cgid'=>$id));
		if(!empty($data['category']))
		{
			$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
			$cg_ds = $this->Admin_mo->getwhere('cg_d',array('dcgid'=>$id));
			foreach($cg_ds as $cg_d) { $data['cg_ds'][$cg_d->cglncode] = $cg_d->cgtitle; }
			$this->load->view('headers/category-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/category-edit',$data);
			$this->load->view('footers/category-edit');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'categories';
			$data['admessage'] = 'youhavenoprivls';
			$this->load->view('headers/categories',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/categories');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'categories';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/categories',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/categories');
		$this->load->view('messages');
		}
	}
	
	public function editcategory($id)
	{
		if(strpos($this->loginuser->privileges, ',cgedit,') !== false && in_array('CG',$this->sections))
		{
		$id = abs((int)($id));
		if($id != '')
		{
		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
				$this->config->set_item('language', $this->loginuser->ulang);
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			foreach(set_value('title') as $lang => $title) { $this->form_validation->set_rules('title['.$lang.']', 'lang:title'.$lang , 'trim|required|max_length[255]'); }
			$this->form_validation->set_rules('service', 'lang:service' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['system'] = $this->mysystem;
				$data['category'] = $this->Admin_mo->getrow('categories',array('cgid'=>$id));
				$data['langs'] = $this->Admin_mo->getwhere('langs',array('lnactive'=>'1'));
				$cg_ds = $this->Admin_mo->getwhere('cg_d',array('dcgid'=>$id));
				foreach($cg_ds as $cg_d) { $data['cg_ds'][$cg_d->cglncode] = $cg_d->cgtitle; }
				$this->load->view('headers/category-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/category-edit',$data);
				$this->load->view('footers/category-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				$update_array = array('cguid'=>$this->session->userdata('uid'), 'cgtype'=>set_value('service'), 'cgactive'=>set_value('active'), 'cgtime'=>time());
				if($this->Admin_mo->update('categories', $update_array, array('cgid'=>$id)))
				{
					$this->Admin_mo->del('cg_d', array('dcgid'=>$id));
					foreach(set_value('title') as $lang => $title) { $cg_d = $this->Admin_mo->set('cg_d', array('dcgid'=>$id, 'cgtitle'=>$title, 'cglncode'=>$lang)); }
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				}
				else
				{
					$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				}
				redirect('categories', 'refresh');
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('categories', 'refresh');
		}
		//redirect('categories', 'refresh');
		}
		else
		{
		$data['title'] = 'categories';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/categories',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/categories');
		$this->load->view('messages');
		}
	}
	*/
	public function del($id)
	{
		$id = abs((int)($id));
		if(strpos($this->loginuser->privileges, ',redelete,') !== false && in_array('RE',$this->sections))
		{
		$realestate = $this->Admin_mo->getrow('realestates', array('reid'=>$id));
		if(!empty($realestate))
		{
			$this->Admin_mo->del('realestates', array('reid'=>$id));
			$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			redirect('realestates', 'refresh');
		}
		else
		{
			$data['title'] = 'realestates';
			$data['admessage'] = 'youhavenoprivls';
			$data['system'] = $this->mysystem;
			$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
			$this->config->set_item('language', $this->loginuser->ulang);
			$this->load->view('headers/realestates',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/realestates');
			$this->load->view('messages');
		}
		}
		else
		{
		$data['title'] = 'realestates';
		$data['admessage'] = 'youhavenoprivls';
		$data['system'] = $this->mysystem;
		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);
		$this->config->set_item('language', $this->loginuser->ulang);
		$this->load->view('headers/realestates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/realestates');
		$this->load->view('messages');
		}
	}
	
	public function imageSize()
	{
		if ($_FILES['img']['size'] > 1024000)
		{
			//$this->form_validation->set_message('imageSize', 'يجب ان يكون حجم الصورة 1 ميجا او اقل');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function imageType()
	{
		if (!in_array(strtoupper(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION)),array('JPG','JPEG','PNG','JIF','BMP','TIF')))
		{
			//$this->form_validation->set_message('imageType', 'يجب ان يكون نوع الملف المرفوع واحد من هذه الانواع : JPG,JPEG,PNG,JIF,BMP,TIF');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function uploadimg($inputfilename,$image_director,$image_director_thumb,$newname)
	{
		$file_extn = pathinfo($_FILES[$inputfilename]['name'], PATHINFO_EXTENSION);
		if(!is_dir($image_director)) $create_image_director = mkdir($image_director);
		$name = $newname.".".$file_extn;
		if(move_uploaded_file($_FILES[$inputfilename]["tmp_name"], $image_director.$name))
		{
			if($image_director_thumb != '')
			{
				$this->load->library('Resize');
				$this->resize->construct($image_director.$name);
				$this->resize->resizeImage(275, 275, 'exact');
				$this->resize->saveImage($image_director_thumb.$name, 100);
			}
			return $name;
		}
		else return '';
	}
}