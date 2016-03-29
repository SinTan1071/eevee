<?php

/**
 * 权限验证中间件.
 *
 * 权限验证的每个步骤封装成了函数，
 * 按照函数的定义顺序自下而上链式调用;
 * 调用过程中，函数之间传递的是验证是否通过的Bool值，
 * 如需终止验证，返回 false 即可。
 *
 * 验证过程中验证用户密钥和用户权限时，
 * 调用了Token和Permission服务。
 *
 * @author 古月(2016/03/11)
 */

namespace Core\Http\Middleware;

use Closure;
use Core\Models\User;

class Authenticate
{
    protected $request;
    //
    // protected $method;
    //
    // protected $resource;
    //
    // protected $guest;
    //
    // protected function generateVisitor()
    // {
    //     return $this->request;
    // }
    //
    // protected function getPermisssions()
    // {
    // }
    //
    // protected function authPermission()
    // {
    //     $permission = $this->resource.'.'.$this->method;
    // }
    //
    // protected function getRequestParams()
    // {
    //     $this->resource = strtolower($this->request->segment(2));
    //
    //     $this->method = $this->request->method();
    //
    //     return $this->authPermission();
    // }
    //
    // protected function getVisitorByAccessToken()
    // {
    // }
    //
    // protected function getAccessToken()
    // {
    //     $this->visitor->access_token = $request->header('X-ACCESS-TOKEN') || null;
    //
    //     return $this->getVisitorByAccessToken();
    // }
    //
    // protected function auth()
    // {
    //     $this->visitor = new Visitor();
    //
    //     return $this->getAccessToken();
    // }

    /**
     * 权限验证中间件.
     *
     * 如果权限验证成功，则返回接着调用下一中间
     * 如果失败，则会抛出 403 错误。
     */
    public function handle($request, Closure $next)
    {
        $this->request = $request;
        $this->request->geust = new User();


        // print_r($request->method());
        // echo '<br>';
        // print_r($request->url());
        // echo '<br>';
        // print_r($request->getPathInfo());
        // echo '<br>';

        return $next($request);

        // if ($this->auth()) {
        //     return $next($this->request);
        // } else {
        //     abort(403);
        // }
    }
}
