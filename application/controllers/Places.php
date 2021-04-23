<?phpdefined('BASEPATH') OR exit('No direct script access allowed');class Places extends CI_Controller {	/**	 * Index Page for this controller.	 *	 * Maps to the following URL	 * 		http://example.com/index.php/welcome	 *	- or -	 * 		http://example.com/index.php/welcome/index	 *	- or -	 * Since this controller is set as the default controller in	 * config/routes.php, it's displayed at http://example.com/	 *	 * So any other public methods not prefixed with an underscore will	 * map to /index.php/welcome/<method_name>	 * @see http://codeigniter.com/user_guide/general/urls.html	 */	function __construct()    {		parent::__construct();		$this->mysystem = $this->Admin_mo->getrow('system',array('id'=>'1'));	    if(!$this->session->userdata('uid'))	    { 			redirect('home');	    }		else		{			$this->loginuser = $this->Admin_mo->getrowjoinLeftLimit('users.*,usertypes.utprivileges as privileges,langs.lndir as dir','users',array('usertypes'=>'users.uutid=usertypes.utid','langs'=>'users.ulang=langs.lncode'),array('users.uid'=>$this->session->userdata('uid')),'');			$this->sections = array();			$sections = $this->Admin_mo->getwhere('sections',array('scactive'=>'1'));			if(!empty($sections))			{				foreach($sections as $section) { $this->sections[$section->scid] = $section->sccode; }			}		}	}	public function index()	{		if(strpos($this->loginuser->privileges, ',pcsee,') !== false && in_array('PC',$this->sections))		{		$data['admessage'] = '';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }		$data['places'] = $this->Admin_mo->get('places');		$this->load->view('calenderdate');		//$data['users'] = $this->Admin_mo->rate('*','users',' where id <> 1');		$this->load->view('headers/places',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/places',$data);		$this->load->view('footers/places');		$this->load->view('messages');		}		else		{		$data['title'] = 'places';		$data['admessage'] = 'youhavenoprivls';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->load->view('headers/places',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/messages',$data);		$this->load->view('footers/places');		$this->load->view('messages');		}	}	public function add()	{		if(strpos($this->loginuser->privileges, ',pcadd,') !== false && in_array('PC',$this->sections))		{		$data['admessage'] = '';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		//$data['users'] = $this->Admin_mo->get('users');		$this->load->view('headers/place-add',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/place-add',$data);		$this->load->view('footers/place-add');		$this->load->view('messages');		}		else		{		$data['title'] = 'places';		$data['admessage'] = 'youhavenoprivls';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->load->view('headers/places',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/messages',$data);		$this->load->view('footers/places');		$this->load->view('messages');		}	}		public function create()	{		if(strpos($this->loginuser->privileges, ',utadd,') !== false && in_array('UT',$this->sections))		{		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');		$this->form_validation->set_rules('price', 'lang:price' , 'trim|required|max_length[255]|is_unique[usertypes.utname]');		if($this->form_validation->run() == FALSE)		{			//$data['admessage'] = 'validation error';			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';			$data['system'] = $this->mysystem;			$this->load->view('headers/place-add',$data);			$this->load->view('sidemenu',$data);			$this->load->view('topmenu',$data);			$this->load->view('admin/place-add',$data);			$this->load->view('footers/place-add');			$this->load->view('messages');		}		else		{			$set_arr = array('pcuid'=>$this->session->userdata('uid'), 'utname'=>set_value('name'), 'utactive'=>set_value('active'), 'uttime'=>time());			$utid = $this->Admin_mo->set('usertypes', $set_arr);			if(empty($utid))			{				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';				redirect('usertypes/add', 'refresh');			}			else			{				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';				redirect('usertypes', 'refresh');			}		}		//redirect('usertypes/add', 'refresh');		}		else		{		$data['title'] = 'usertypes';		$data['admessage'] = 'youhavenoprivls';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->load->view('headers/usertypes',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/messages',$data);		$this->load->view('footers/usertypes');		$this->load->view('messages');		}	}		public function edit($id)	{		if(strpos($this->loginuser->privileges, ',pcedit,') !== false && in_array('PC',$this->sections))		{		$id = abs((int)($id));		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$data['place'] = $this->Admin_mo->getrow('places',array('pcid'=>$id));		if(!empty($data['place']))		{			$place_ess = $this->Admin_mo->getwhere('places_es',array('pepcid'=>$id));									foreach($place_ess as $place_es) { $data['place_ess'][$place_es->pecateg][$place_es->petype] = $place_es->peprice; }						//$data['preporders'] = $this->Admin_mo->getjoinLeft('categories.*,cg_d.*,langs.lntitle as lang','cg_d',array('categories'=>'cg_d.dcgid = categories.cgid','langs'=>'cg_d.cglncode = langs.lncode'),array('categories.cgtype'=>$service));						$data['categories'] = $this->Admin_mo->getjoinLeft('categories.cgid as cgid,categories.cgcolor as cgcolor,cg_d.cgtitle as cgtitle','cg_d',array('categories'=>'cg_d.dcgid = categories.cgid'),array('cg_d.cglncode'=>$this->loginuser->ulang,'categories.cgtype'=>'VH','categories.cgactive'=>'1'));						//$data['categories'] = $this->Admin_mo->getwhere('categories',array('cgtype'=>'VH','cgactive'=>'1'));			$this->load->view('headers/place-edit',$data);			$this->load->view('sidemenu',$data);			$this->load->view('topmenu',$data);			$this->load->view('admin/place-edit',$data);			$this->load->view('footers/place-edit');			$this->load->view('messages');		}		else		{			$data['title'] = 'places';			$data['admessage'] = 'youhavenoprivls';			$this->load->view('headers/places',$data);			$this->load->view('sidemenu',$data);			$this->load->view('topmenu',$data);			$this->load->view('admin/messages',$data);			$this->load->view('footers/places');			$this->load->view('messages');		}		}		else		{		$data['title'] = 'places';		$data['admessage'] = 'youhavenoprivls';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->load->view('headers/places',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/messages',$data);		$this->load->view('footers/places');		$this->load->view('messages');		}	}		public function editplace($id)	{		if(strpos($this->loginuser->privileges, ',pcedit,') !== false && in_array('PC',$this->sections))		{		$id = abs((int)($id));		if($id != '')		{		    $this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);			$this->config->set_item('language', $this->loginuser->ulang);						$cg_ds = $this->Admin_mo->getwhere('cg_d',array('cglncode'=>$this->loginuser->ulang)); foreach($cg_ds as $cg_d) { $mylang[$cg_d->dcgid] = $cg_d->cgtitle; }			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');			//$this->form_validation->set_rules('price', 'lang:price' , 'trim|numeric');			//print_r(set_value('price'));			foreach(set_value('price') as $category => $places_ess)			{				foreach($places_ess as $type => $places_es)				{					$this->form_validation->set_rules('price['.$category.']['.$type.']', $mylang[$category].' - lang:'.$type, 'trim|required|numeric');				}			}			if($this->form_validation->run() == FALSE)			{				$data['system'] = $this->mysystem;								$place_ess = $this->Admin_mo->getwhere('places_es',array('pepcid'=>$id));										foreach($place_ess as $place_es) { $data['place_ess'][$place_es->pecateg][$place_es->petype] = $place_es->peprice; }				$data['place'] = $this->Admin_mo->getrow('places',array('pcid'=>$id));								$data['categories'] = $this->Admin_mo->getjoinLeft('categories.cgid as cgid,categories.cgcolor as cgcolor,cg_d.cgtitle as cgtitle','cg_d',array('categories'=>'cg_d.dcgid = categories.cgid'),array('cg_d.cglncode'=>$this->loginuser->ulang,'categories.cgtype'=>'VH','categories.cgactive'=>'1'));				$this->load->view('headers/place-edit',$data);				$this->load->view('sidemenu',$data);				$this->load->view('topmenu',$data);				$this->load->view('admin/place-edit',$data);				$this->load->view('footers/place-edit');				$this->load->view('messages');			}			else			{				/*if($this->Admin_mo->exist('usertypes','where utid <> '.$id.' and utname like "'.set_value('name').'"',''))				{					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';					redirect('usertypes/edit/'.$id, 'refresh');				}				else				{*/					$update_array = array('pcuid'=>$this->session->userdata('uid'), 'pcactive'=>set_value('active'), 'pctime'=>time());					if($this->Admin_mo->update('places', $update_array, array('pcid'=>$id)))					{						$this->Admin_mo->del('places_es', array('pepcid'=>$id));						foreach(set_value('price') as $category => $places_ess) { foreach($places_ess as $type => $price) { $places_es = $this->Admin_mo->set('places_es', array('pepcid'=>$id, 'pecateg'=>$category, 'petype'=>$type, 'peprice'=>$price)); } }						$_SESSION['time'] = time(); $_SESSION['message'] = 'success';					}					else					{						$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';					}					redirect('places', 'refresh');				//}			}		}		else		{			$data['admessage'] = 'Not Saved';			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';			redirect('places', 'refresh');		}		//redirect('places', 'refresh');		}		else		{		$data['title'] = 'places';		$data['admessage'] = 'youhavenoprivls';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->load->view('headers/places',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/messages',$data);		$this->load->view('footers/places');		$this->load->view('messages');		}	}	public function del($id)	{		$id = abs((int)($id));		if(strpos($this->loginuser->privileges, ',utdelete,') !== false && $id != '1' && in_array('UT',$this->sections))		{		$usertype = $this->Admin_mo->getrow('usertypes', array('utid'=>$id));		if(!empty($usertype))		{			$this->Admin_mo->del('usertypes', array('utid'=>$id));			$_SESSION['time'] = time(); $_SESSION['message'] = 'success';			redirect('usertypes', 'refresh');		}		else		{			$data['title'] = 'usertypes';			$data['admessage'] = 'youhavenoprivls';			$data['system'] = $this->mysystem;			$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);			$this->config->set_item('language', $this->loginuser->ulang);			$this->load->view('headers/usertypes',$data);			$this->load->view('sidemenu',$data);			$this->load->view('topmenu',$data);			$this->load->view('admin/messages',$data);			$this->load->view('footers/usertypes');			$this->load->view('messages');		}		}		else		{		$data['title'] = 'usertypes';		$data['admessage'] = 'youhavenoprivls';		$data['system'] = $this->mysystem;		$this->lang->load($this->loginuser->ulang, $this->loginuser->ulang);		$this->config->set_item('language', $this->loginuser->ulang);		$this->load->view('headers/usertypes',$data);		$this->load->view('sidemenu',$data);		$this->load->view('topmenu',$data);		$this->load->view('admin/messages',$data);		$this->load->view('footers/usertypes');		$this->load->view('messages');		}	}}