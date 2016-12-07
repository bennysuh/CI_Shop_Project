<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Upload extends CI_Upload {

  public function multiple($field){
    // 判断字段值是否被设置
    if ( ! isset($_FILES[$field])){
        $this->set_error('upload_no_file_selected');
        return FALSE;
    }

    // 临时文件上传数组，用于整合自己想要的形式
    $tmpfiles = array();
    for ($i = 0, $len = count($_FILES[$field]['name']); $i < $len; $i ++){
      if ($_FILES[$field]['size'][$i]){
        $tmpfiles['_SR_' . $i] = array(
          'name'  => $_FILES[$field]['name'][$i],
          'type'  => $_FILES[$field]['type'][$i],
          'tmp_name' => $_FILES[$field]['tmp_name'][$i],
          'error' => $_FILES[$field]['error'][$i],
          'size'  => $_FILES[$field]['size'][$i],
          );
      }
    }

    //覆盖 $_FILES 内容
    $_FILES = $tmpfiles;

    $errors = array();
    $files  = array();
    $index  = 0;
    $_tmp_name = preg_replace('/(.[a-z]+)$/', '', $this->file_name);
    foreach ($_FILES as $key => $value){
      /*
       * 多文件上传的命名规则，用于替代CI中自由的文件命名方式
       *
       * -SR-17-50557-0.jpg
       * -SR-17-50557-1.jpg
       * -SR-17-50557-2.jpg
       */
       $this->_file_name_override = $_tmp_name . '-' . $index;
       if( ! $this->do_upload($key)) {
            $errors[$index] = $this->display_errors('', '');
            $this->error_msg = array();
       }else{
            $files[$index] = $this->data();
       }
       $index  ++;
    }
    // 返回数组
    return array(
                  'error' => $errors,
                  'files' => $files
                 );
  }

}
?>
