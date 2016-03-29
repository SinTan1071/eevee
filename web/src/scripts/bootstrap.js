require.config({
  // 根路径为config.js所在路径，即js目录
  baseUrl : "scripts",
  // 模块路径定义　　　　
  paths: {　　　
    // ***框架组件***　　　
    'jquery': 'bower/jquery/dist/jquery.min',
    'angular': 'bower/angular/angular',
    'angularRoute': 'bower/angular-ui-router/release/angular-ui-router.min',
    'angularAMD': 'bower/angularAMD/angularAMD.min',
    'domReady': 'bower/domReady/domReady',
    // ***插件***
    // semantic
    'semantic' : 'bower/semantic/dist/semantic.min',
    // 滚动插件
    'slimScroll' : 'bower/jQuery-slimScroll/jquery.slimscroll.min',
    // 垂直菜单
    'navgoco' : 'bower/navgoco/src/jquery.navgoco.min',
    // 拖动排序
    'nestable':'bower/Nestable/jquery.nestable',
    // ***入口文件***
    'app': './app'
  },
  // 不兼容模块定义
  shim:{
      'angularAMD':{
        deps : ['angular']
      },
      'angular':{
          exports:'angular'
      },
      'angularRoute':{
          deps:['angular']
      },
      'slimScroll':{
          deps:['jquery']
      },
      'navgoco':{
          deps:['jquery']
      }
  },
  // 程序启动
  deps: ['app'],
  // 路由参数：防止缓存
  urlArgs: "bust=" + (new Date()).getTime()　　
});
