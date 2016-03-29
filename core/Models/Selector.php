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

    public function parse($args)
    {
        foreach ($args as $key => $value) {
            switch ($key) {
            case 'where':
              if (($where = $this->parseWhere($value)) !== true) {
                  return $where;
              }
              break;
            default:
              break;
          }
        }
    }

    protected function parseWhere($arg)
    {
        $chars = preg_split('//u', trim($arg), -1);

        $length = count($chars);

        $tag = 0;   // 1 处理获取字段   2 获取操作符  3 寻找连接符  4 取SQL逻辑运算

        $params = [];

        $query = 'where';

        $field = '';

        $operator = '';

        $param = '';

        for ($i = 0; $i < $length - 1; ++$i) {
            $char = $chars[$i];

            if ($char == '(') {
                $tag = 1;
                continue;
            }

            if ($tag == 4) {
                $query = $char != ' ' ? $query.$char : $query;
            }

            if ($tag == 3) {
                $param .= $char;
                if ($i < $length - 1 &&  $chars[$i + 1] == ')') {
                    ++$i;

                    $params[$query][] = [$field, $operator, trim($param)];

                    list($query, $field, $operator, $param) = ['', '', '', ''];

                    $tag = 4;
                }
                continue;
            }

            if ($tag == 2) {
                $operator = $char != ' ' ? $operator.$char : $operator;

                if (preg_match('/(<>|:>|<:|:|>|<)/', $operator)) {
                    $tag = 3;
                }
                continue;
            }

            if ($tag == 1) {
                $field = $char != ' ' ? $field.$char : $field;
                if ($i < $length - 1 && in_array($chars[$i + 1], [':', '>', '<'])) {
                    $tag = 2;
                }
                continue;
            }

            continue;
        }
        echo '<pre>';
        print_r($params);
        echo '</pre>';
    }

    protected function validateFieldChar($char)
    {
        return preg_match('/[a-zA-Z1-9|-|_]/', $char);
    }
}
