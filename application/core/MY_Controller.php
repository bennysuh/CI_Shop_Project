<?php
/* 扩展CI控制器，将父控制器分为前台和后台 */
defined('BASEPATH') OR exit('No direct script access allowed');

//前台父控制器，开启皮肤功能
class Home_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_themes_on();
	}
}

//后台父控制器，关闭皮肤功能，进行权限认证
class Admin_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_themes_off();
		if(!$this->session->userdata('username')){
			redirect('admin/Privilege/login');
		}
	}
}
