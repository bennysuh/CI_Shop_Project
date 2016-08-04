<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilege extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
		$this->load->library('form_validation');
	} 

	public function login(){
		$this->load->view('login.html');
	}

	public function code(){
		$val = array(
			'word_length' => 6
		);
		$code = create_captcha($val);
		$this->session->set_userdata('code',$code);
	}

	public function signin(){
		$this->form_validation->set_rules('username','用户名','required');
		$this->form_validation->set_rules('password','密码','required');
		$this->form_validation->set_rules('captcha','验证码','required');

		if($this->form_validation->run()){	
			$code = strtolower($this->session->userdata('code'));
			$captcha = strtolower($this->input->post('captcha'));
			if($captcha === $code){
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				if($username == 'admin' && $password == 'admin'){
					$this->session->set_userdata('username',$username);
					redirect('Admin/Main/index');
				}else{
					$data['url'] = site_url('Admin/Privilege/login');
					$data['wait'] = 3;
					$data['message'] = "用户名或密码错误!";
					$this->load->view('message.html',$data);
				}
			}else{
				$data['url'] = site_url('Admin/Privilege/login');
				$data['wait'] = 3;
				$data['message'] = '验证码填写错误!';
				$this->load->view('message.html',$data);
			}
		}else{
			$this->load->view('login.html');
		}
	}

	public function signout(){
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('Admin/Privilege/login');
	}
}