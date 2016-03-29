<?php

namespace Core\Services;

use Core\Models\Model;

class Installer
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    /**
     * 安装环境检查
     *
     * 1、 stroage 文件是否有写权限
     * 2、 是否开启需要扩展
     */
    public function checkout()
    {
    }

    /**
     * 安装配置，获取需要依赖的安装信息，包括数据库和管理员信息。
     */
    public function config(){

    }

    /**
     * 完成数据迁移
     */
    public function migrate()
    {
    }

    /**
     * 注册系统资源
     */
    public function registerResources()
    {
        $status = null;

        $resources = $this->getResources();

        $table = $this->model->getTable('RESOURCE');

        foreach ($resources as $row) {
            $exsit = $this->model->table($table)->where('ident', $row['ident'])->get();

            if ($exsit) {
                $status[$row['ident']] = 'exist';
                continue;
            }

            if ($this->model->table($table)->insert($row)) {
                $status[$row['ident']] = 'success';
            }
        }

        return $status;
    }

    /**
     * 注册权限
     */
    public function registerPermissions()
    {
        $status = null;

        $permissions = $this->getPermissions();

        $table = $this->model->getTable('PERMISSION');

        foreach ($permissions as $row) {
            $exsit = $this->model->table($table)->where('ident', $row['ident'])->get();

            if ($exsit) {
                $status[$row['ident']] = 'exist';
                continue;
            }

            if ($this->model->table($table)->insert($row)) {
                $status[$row['ident']] = 'success';
            }
        }

        return $status;
    }


    /**
     * 注册超级管理员角色
     */
    public function registerRoot()
    {
        return 'register root user';
    }

    /**
     * 注册访客角色
     */
    public function registerGuest(){

    }


    /**
     * 读取资源配置文件.
     */
    protected function getResources()
    {
        $defaultResources = config('resources');

        return $this->generateResourceRows($defaultResources);
    }

    /**
     * 处理资源前缀，生成数据库可插入的记录。
     *
     * @param array $resources
     *
     * @return array
     */
    protected function generateResourceRows($resources)
    {
        $result = [];

        foreach ($resources as $resource => $table) {
            $resource = trim($resource);

            if (strpos($resource, 'L:') === 0) {
                continue;
            }

            $row['name'] = trans("resources.$resource");
            $row['ident'] = $resource;
            $row['source'] = 'LEHU';

            array_push($result, $row);
        }

        return $result;
    }

    /**
     * 获取系统权限列表.
     *
     */
    protected function getPermissions()
    {
        $defaultPermissions = config('permissions');

        return $this->generatePermissionRows($defaultPermissions);
    }

    /**
     * 生成权限可插入的数据库记录
     */
    protected function generatePermissionRows($permissions)
    {
        $result = [];

        foreach ($permissions as $permission) {
            $permission = trim($permission);

            if (strpos($permission, 'T:') === 0) {
                $permission = trim(substr($permission, 2));
                $row['type'] = ':type';
            } else {
                $row['type'] = 'single';
            }

            $row['name'] = trans("permissions.$permission");
            $row['ident'] = $permission;
            $row['resource_ident'] = $this->getPermissionResourceIdent($permission);
            $row['source'] = 'eevee';

            array_push($result, $row);
        }

        return $result;
    }


    protected function getPermissionResourceIdent($permission)
    {
        return explode('_', $permission)[0];
    }
}
