<?php

/**
 * 资源服务
 *
 * @author 古月
 */

namespace Core\Services;

use Core\Models\Model;

class Resource
{
    protected $rows;

    protected $langs;

    protected $resources;

    public function __construct()
    {
        $this->rows = new Array();

        $this->langs = trans('resources');

        $this->resorces = config('resources');
    }

    public function register($row)
    {
        $model = new Model();
        return $model->table($model->tables['RESOURCE'])->insert($row);
    }

    protected function createRows()
    {
        foreach ($this->resources as $k => $v) {
          if($row = $this->getResource($k) !== false){
            array_push($this->rows,$row);
          }
        }
    }

    protected function getResource($ident){
        if(false){
          return false;
        }
        $name = $this->getResourceName($ident);

        return [
          'name' => $name,
          'ident'=> $ident,
        ];
    }



    protected function getResourceName($ident){
      return $this->langs[$ident];
    }
}
