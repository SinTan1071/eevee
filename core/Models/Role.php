<?php

namespace Core\Models;

class Role extends Model
{

    public $timestamps = true;

    public function post($role)
    {
        $result = $this->transaction(function () use ($role) {

          // DB::table('roles_permissions')->insert($role['permissions']);

          $role = $this->create($role);
          // print_r($role->toArray());
          return $this->code(200, $role->toArray());

        });

        return $this->code(200, $result);;
    }

    public function put()
    {
    }

    public function delete()
    {

    }

    public function get($params)
    {

    }

    protected function postPermissions($user_id,$permissions){

    }

    protected function getPermissions($user_id,$permissions){

    }

}
