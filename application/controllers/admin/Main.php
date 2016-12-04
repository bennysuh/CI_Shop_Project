<?php
/* 后台主控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Admin_Controller{
  //展示后台首页
  public function index(){
    $this->load->view("index.html");
  }
  //展示头部
  public function top(){
    $this->load->view("top.html");
	}
  //展示菜单
	public function menu(){
		$this->load->view("menu.html");
	}
  //展示拖把
	public function drag(){
		$this->load->view("drag.html");
	}
  //展示内容
	public function content(){
		$this->load->view("main.html");
	}
}
