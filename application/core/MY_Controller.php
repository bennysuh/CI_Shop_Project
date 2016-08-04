<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_themes_on();
	}
}

class Admin_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_themes_off();
		if(!$this->session->userdata('username')){
			redirect('Admin/Privilege/login');
		}
	}
}