<?php

/**
 * 上下文服务
 *
 * 在接口业务逻辑中，有很多重复和相同的操作，
 * 上下文服务中对常用操作进行了封装，以简化业务逻辑的开发。
 *
 * @author 古月(2016/03)
 */

namespace Core\Services;

use Request;
use Illuminate\Http\Response;

class Context
{
    public $request;

    public $response;

    public $guest;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;

        $this->response = $response;

        // $this->guset = $request->guest;
    }
    /**
     * 获取GET参数.
     *
     * @return array GET请求参数
     */
    public function params($field = false, $default = false)
    {
        if ($field !== false) {
            return isset($_GET[$field]) ? $_GET[$field] : $default;
        }

        return $_GET;
    }

    /**
     * 获取请求头.
     *
     * @param string $header
     * @param bool   $require
     *
     * @return string
     */
    public function header($header, $require = false)
    {
        // $value = $this->request->header($header);
        $value = 'ra';

        if (!$value && $require) {
            throw new \Exception("The request header $header is required.", 1);
        }

        return $value;
    }

    /**
     * 获取请求数据
     * 只接收JSON格式.
     *
     * @return array 请求数据数组
     */
    public function data($field = false, $default = false)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($field) {
            return isset($data[$field]) ? $data[$field] : $default;
        }

        return $data;
    }

    /**
     * 获取请求文件.
     */
    public function file()
    {
    }

    /**
     * 响应函数
     * 以JSON格式输出。
     *
     * @param string $result     响应结果
     * @param int    $statusCode HTTP状态码
     *
     * @return Response
     */
    public function response($result = '', $statusCode = 200)
    {
        return response(json_encode($result), $statusCode)->header('Content-Type', 'application/json');
    }

    public function result($status, $data = null, $statusCode = 200)
    {
        return $this->response(Status::result($status, $data));
    }
}
