<?php

/**
 * 用户模型
 * 定义了用户表相关的操作。
 *
 * @author 古月(2016/03)
 */

namespace Core\Models;

use Validator;

class User extends Model
{
    protected $user;

    /**
     * 添加用户
     * 用户创建依赖于角色，采用外键约束。
     * 故在用户创建之前，应对角色信息进行验证。
     *
     * @param array $user 用户信息
     *
     * @return result 成功返回创建后的用户
     */
    public function addUser($user)
    {
        $this->initializeUser($user);

        if (($validateResult = $this->validateUser()) !== true) {
            return $this->result('validateError', $validateResult);
        }

        if ($this->validateRole() === false) {
            return $this->result('roleNotExists');
        }

        $result = $this->transaction(function () {

          $this->processPassword();

          if ($this->getTable('USER')->insert($this->user)) {
              return $this->getUser($this->user['id']);
          };

          return $this->result('addUserError');

        });

        return $result;
    }

    // 更新用户
    // 更新用户信息时如果变更了角色
    // 则需要使用事务改写角色用户关系表，
    // 用户更新成功返回 True。

    public function updateUser()
    {
    }

    // 删除用户
    // 使用事务删除用户，处理用户与角色的关系，
    // 删除成功返回 True。
    public function deleteUser($params, $remove = false)
    {
    }

    /**
     * 获取用户.
     *
     * @param string $user_id
     * @param bool   $password
     */
    public function getUser($user_id, $password = false)
    {
        $user = $this->getTable('USER')->where('id', $user_id)->first();

        print_r($user);

        if ($user && !$password) {
            unset($user->password);
        }

        return $this->result('success', $user);
    }

    /**
     * 通过用户名获取用户.
     *
     * @param string $username
     *
     * @return $user
     */
    public function getUserByUsername($username)
    {

    }

    /**
     * 通过邮箱获取用户.
     *
     * @param sting $email $email
     *
     * @return $user
     */
    public function getUserByEmail($email)
    {
    }

    /**
     * 获取用户组.
     *
     * @param array $params 用户获取条件配置参数
     *
     * @return result 用户集
     */
    public function getUsers($params, $password = false)
    {
        // $selector = new Selector($this->getQuery('USER'));

        // $result = $selector->parse($params);

        // $result = $this->resource($this->getTable('USER'), $params);

        // if ($result->code == 200 && !$password) {
        //     foreach ($result->data as $key => $item) {
        //         unset($item->password);
        //     }
        //
        //     return $result;
        // }

        // return $result;

        return $params;
    }

    public function saveUserToken($user, $client = '', $expire = true)
    {
        $row = [
          'user_token' => uniqid(),
          'user_id' => $user->id,
          'app_id' => $client->ident,
        ];

        $table = $this->getTable('USERTOKEN');

        if ($table->where('user_id', $user->id)->first()) {
            $table->where('user_id', $user->id)->update($row);
        } else {
            return $this->getTable('USERTOKEN')->insert($row);
        }

        return $row['user_token'];
    }

    public function getUserByToken($token)
    {
        $table = $this->getTable('USERTOKEN');

        if ($row = $table->where('user_token', $token)->first()) {
            return $row;
        }

        return false;
    }

    /**
     * 初始化用户
     * 合并配置文件新用户设置，设置时间戳.
     *
     * @param array $user 用户数据
     * @param bool  $post 调用方法
     */
    protected function initializeUser($user)
    {
        $initialized = [
         'id' => $this->getID(),
         'role' => config('site.user.role', 'member'),
         'status' => config('site.user.status', 0),
        ];

        $this->user = array_merge($initialized, $user);
    }

    protected function validateUser()
    {
        $table = $this->getTableName('USER');

        $validator = Validator::make($this->user, [
                'username' => "required|unique:$table|max:255",
                'password' => 'required|min:6',
                'email' => "required|unique:$table|max:255",
                'role' => 'required',
            ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    protected function validateRole()
    {
        return true;
    }

    protected function authPassword($origin, $password)
    {
        return $this->encryptPassword($origin) == $password;
    }

    protected function processPassword()
    {
        $this->user['password'] = $this->encryptPassword($this->user['password']);
    }

    protected function encryptPassword($password)
    {
        return md5($password);
    }
}
