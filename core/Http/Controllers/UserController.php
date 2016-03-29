<?php

namespace Core\Http\Controllers;

use Core\Models\User;
use Core\Services\Status;
use Core\Services\Context;

class UserController extends Controller
{

    public function postUser(Context $context,Status $status){
      $user = new User();
      $user->data($context->data())->add();
    }

    public function putUser(){

    }

    public function getUser(Context $context){

      $model = new User();

      $params = $context->params();

      $result = $model->getUsers($params);

      // return $context->response($result);

    }

    public function getUsers(Context $context){
      $model = new User();

      $params = $context->params();

      $result = $model->getUsers($params);
    }


    public function delete(){

    }

}
