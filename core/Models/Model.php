<?php

namespace Core\Models;

use DB;
use Core\Services\Status;

class Model extends DB
{
    /**
     * 资源数据表.
     *
     * @var array core\System\config\resources.php
     */
    protected $resources;

    public function __construct()
    {
        $this->resources = config('resources');
    }

   /**
    * 模型事务处理，支持DB和Eloquent.
    *
    * @param $callback
    *
    * @return mixed
    */
   public function transaction($callback)
   {
       DB::beginTransaction();

       try {
           $result = $callback($this);

           DB::commit();
       } catch (\Exception $e) {
           DB::rollBack();

           return $this->result(1003, $e->getMessage());
       }

       return $result;
   }

    /**
     * 生成资源ID.
     *
     * TODO 检验冲突问题
     *
     * @return string
     */
    public function getID()
    {
        return md5(sha1(uniqid(mt_rand(1, 1000000))));
    }

    /**
     * 获取资源数据表.
     *
     * @param string $resource
     *
     * @return string
     */
    public function resource($resource)
    {
        if (key_exists($resource, $this->resources)) {
            return $this->resources[$resource];
        } else {
            throw \Exception("Resource $resource is not exists");
        }
    }

    /**
     * 获取数据表查询对象.
     *
     * @param string $resource
     *
     * @return DB::table()
     */
    public function getTable($resource)
    {
        return DB::table($this->getTableName($resource));
    }

    /**
     * 获取数据表名.
     *
     * @param string $resource
     *
     * @return string
     */
    public function getTableName($resource)
    {
        if (key_exists($resource, $this->resources)) {
            return $this->resources[$resource];
        } else {
            throw \Exception("Resource $resource is not exists");
        }
    }

    public function result($status, $data = [])
    {
        return Status::result($status, $data);
    }
}
