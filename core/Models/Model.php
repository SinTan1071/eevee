<?php

namespace Core\Models;

use DB;
use Illuminate\Database\Eloquent\Model as Basic;

class Model extends Basic
{
    /**
     * 资源数据表.
     *
     * @var array core\System\config\resources.php
     */
    protected $resources;

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
        return substr(sha1(uniqid(mt_rand(1, 1000000))), 8, 24);
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
        $this->resources = config('resources');

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
    public function getQuery($resource)
    {
        if (key_exists($resource, $this->resources)) {
            return DB::table($this->resources[$resource]);
        } else {
            throw \Exception("Resource $resource is not exists");
        }
    }
}
