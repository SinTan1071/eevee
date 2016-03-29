<?php

namespace Core\Http\Controllers;

use Core\Services\Status;
use Core\Services\Context;
use Core\Services\Installer;

class SystemController extends Controller
{
    /**
     * 系统安装
     */
    public function install(Context $context, Status $status)
    {
        $installer = new Installer();

        $step = $context->params('step');

        switch ($step) {
          case 'migrate':
            $result = $installer->migrate();
            break;
          case 'resources':
            $result = $installer->registerResources();
            break;
          case 'permissions':
            $result = $installer->registerPermissions();
            break;
          case 'config':
            $result = $installer->registerResources();
            break;
          default:
           $result = ['nothing'];
            break;
        }

        return $context->response($status->result('success', $result));
    }

    /**
     * 系统设置
     */
    public function config()
    {
    }

    /**
     * 获取系统权限,按照资源分组给出.
     */
    public function getPermissions(Context $context, Status $status)
    {
    }

    /**
     *  系统版本
     */
    public function getVersion()
    {
        return response('LEHU 1.0');
    }
}
