<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Limitedads extends CI_Controller {

public function __construct()
{
	parent::__construct();
	
	
}
	public function index()
	{
		//$this->load->view('welcome_message');
		
		$this->load->view('website/header');
		
		
		$this->load->view('website/footer');
		
		
		
	}
	public function check()
	{
	echo "hey";	
	}
}
