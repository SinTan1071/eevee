<?php

namespace Core\Http\Controllers;

use Core\Services\Request;

class TestController extends Controller
{
    public function test(Request $request){
      print_r($request->run());
    }
}
