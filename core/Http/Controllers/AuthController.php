<?php

namespace Core\Http\Controllers;

use Core\Models\User;
use Core\Services\Context;

class AuthController extends Controller
{
    /**
     * 用户登录.
     *
     * @param Context $context
     */
    public function login(Context $context)
    {
        //获取请求信息
        $mode = $context->params('mode', 'username');

        $account = $context->data('account');

        $password = $context->data('password');

        $app_id = $context->header('X-APP-ID', true);

        $model = new User();

        // 判断登录方式
        switch ($mode) {
          case 'email':
            $result = $model->getUserByEmail($account, true);
            break;
          default:
            $result = $model->getUserByUsername($account, true);
            break;
        }

        // 验证密码
        if ($result->code != 200 || !$model->authPassword($password, $result->data->password)) {
            return $context->result('invialidAccountOrUsername');
        }


        $user = $result->data;

        // 生成 Token
        if (!($user->user_token = $model->generateUserToken($user, $app_id))) {
            return $context->result('generateUserTokenError');
        };

        unset($user->password);

        return $context->result('success', $user);
    }

    /**
     * 用户注册.
     *
     * @param Context $context
     */
    public function register(Context $context)
    {
        $data = $context->data();

        $userModel = new User();

        $result = $userModel->addUser($data);

        return $context->response($result);
    }

    // 忘记密码
    public function forgot()
    {
    }

    // 重置密码
    public function reset()
    {
    }

    // 发送邮件
    public function sendRegisterMail()
    {
    }

    public function sendRegisterSMS()
    {
    }

    public function sendForgotPasswordMail()
    {
    }

    public function sendForgotPasswordSMS()
    {
    }
}
