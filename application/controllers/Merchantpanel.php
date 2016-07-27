<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchantpanel extends CI_Controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('common/Commonmodel');
	$this->load->helper('userdefined');
	
}

public function index()
{
	$this->load->view('merchant/header');
	
	$this->load->view('merchant/dashboard');
	$this->load->view('merchant/footer');	
}

public function editprofile()
{
	$this->load->view('merchant/header');
	$this->load->view('merchant/editprofile');
	$this->load->view('merchant/footer');
}

public function addadeal()
{
		$this->load->view('merchant/header');
		$this->load->view('merchant/addadeal');	
		$this->load->view('merchant/footer');
		
}//add a deal ends here


public function viewadeal()
{
		$this->load->view('merchant/header');
		$this->load->view('merchant/viewadeal');	
		$this->load->view('merchant/footer');
		
}//view a deal ends here


public function editadeal()
{
	
		$sessvari = $this->session->userdata('Business_Id')."_".'deal_pic';
		$this->session->set_userdata($sessvari,'');
		$this->load->view('merchant/header');
		$this->load->view('merchant/editadeal');	
		$this->load->view('merchant/footer');
}

public function addprintdeal()
{
		$this->load->view('merchant/header');
		$this->load->view('merchant/addprintdeal');	
		$this->load->view('merchant/footer');
		
}//add print deal ends here

public function viewprintdeal()
{
		$this->load->view('merchant/header');
		$this->load->view('merchant/viewprintdeal');	
		$this->load->view('merchant/footer');
		
}//view print deal ends here

public function editprintdeal()
{
		$this->load->view('merchant/header');
		$this->load->view('merchant/editprintdeal');	
		$this->load->view('merchant/footer');
}


} // Requestdispatcher class ends here
