<?php

namespace Themes\le\Controllers;

use Core\Services\Controller;

class IndexController extends Controller
{
  public function index(){

    $result = $this->api('user.login')->params($_GET)->post();

    if($result->code==200){

      return $this->view('auth.index');
    }else{
      return $this->view('index');
    }
  }

  public function login(){
    return $this->view('auth.login');
  }

}
