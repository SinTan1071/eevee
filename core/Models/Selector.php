<?php

namespace Core\Models;

class Selector
{
    protected $query;

    protected $params = [];

    protected $chars;

    protected $length;

    protected $field;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    public function parse($params)
    {
        foreach ($params as $op => $param) {
            switch ($op) {
              case 'or':
              case 'where':
                if (is_array($param)) {
                    foreach ($param as $value) {
                        $this->parseWhere($op, $value);
                    }
                } else {
                    $this->parseWhere($op, $param);
                }
                break;

              case 'in':
              case 'out':
                $this->parseIn($op, $param);
                break;

              case 'between':
              case 'outside':
                $this->parseBetween($op, $param);
                break;

              case 'fields':
                $this->query = $this->query->lists(explode(',', $param));
                break;

              case 'order':
                $sets = explode(':', $param);
                $this->query = $this->query->orderBy($sets[0], $sets[1]);
                break;

              case 'limit':
                $this->query = $this->query->take($param);
                break;

              case 'offset':
                $this->query = $this->query->skip($param);
                break;

              case 'first':
                $this->query = $this->query->skip($param);
                break;
           }
        }

        if (isset($params['first'])) {
            return $this->query->first();
        }

        if (isset($params['count'])) {
            return $this->query->first();
        }

        return $this->query->get();
    }

    protected function parseWhere($op, $param)
    {
        if ($op == 'or') {
            $this->query = count($param) == 2 ?
            $this->query->orWhere($param[0], $param[1]) :
            $this->query->orWhere($param[0], $param[1], $param[2]);
        } else {
            $this->query = count($param) == 2 ?
            $this->query->where($param[0], $param[1]) :
            $this->query->where($param[0], $param[1], $param[2]);
        }
    }
}
