<?php
/* 后台权限控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilege extends CI_Controller{

	public function __construct(){
		parent::__construct();
		//加载扩展的CI captcha辅助函数
		$this->load->helper('captcha');
		//加载CI的表单验证类
		$this->load->library('form_validation');
	}
  //加载登陆页面
	public function login(){
		$this->load->view('login.html');
	}
  //加载验证码
	public function code(){
		$val = array(
			'word_length' => 4
		);
		//创建验证码
		$code = create_captcha($val);
		//将验证码存入SESSION
		$this->session->set_userdata('code',$code);
	}
	//验证登陆操作
	public function signin(){
		//客户端表单验证
		$this->form_validation->set_rules('username','用户名','required');
		$this->form_validation->set_rules('password','密码','required');
		$this->form_validation->set_rules('captcha','验证码','required');

		if($this->form_validation->run()){
			$code = strtolower($this->session->userdata('code'));
			$captcha = strtolower($this->input->post('captcha'));
			//验证码验证
			if($captcha === $code){
				$info['admin_name'] = $this->input->post('username',true);
				$info['password'] = md5($this->input->post('password',true));
				$this->load->model('Privilege_model');
				//用户密码验证
				if($this->Privilege_model->get_admin($info)){
					$this->session->set_userdata('username',$info['admin_name']);
					redirect('admin/Main/index');
				}else{
					$data['url'] = site_url('admin/Privilege/login');
					$data['wait'] = 3;
					$data['message'] = "用户名或密码错误!";
					$this->load->view('message.html',$data);
				}
			}else{
				$data['url'] = site_url('admin/Privilege/login');
				$data['wait'] = 3;
				$data['message'] = '验证码填写错误!';
				$this->load->view('message.html',$data);
			}
		}else{
			$this->load->view('login.html');
		}
	}
  //退出登陆操作
	public function signout(){
		//清除SESSION
		$this->session->unset_userdata('username');
		//销毁SESSION
		$this->session->sess_destroy();
		redirect('admin/Privilege/login');
	}
}
