define(['angularAMD', 'angularRoute','./layout'], function(angularAMD) {
  var app = angular.module("Govel", ['ui.router']);

  app.config(function($stateProvider, $urlRouterProvider, $locationProvider, $uiViewScrollProvider) {
    //用于改变state时跳至顶部
    $uiViewScrollProvider.useAnchorScroll();
    // 默认进入先重定向
    $urlRouterProvider.otherwise('index');

    $stateProvider
      .state('index', angularAMD.route({
        url: '/index',
        templateUrl: 'templates/index.html',
        // controller: 'posts',
        // controllerUrl: 'controllers/posts'
      }))
      // posts 内容
      .state('posts', angularAMD.route({
        url: '/posts',
        templateUrl: 'views/posts/posts.html',
        controller: 'posts',
        controllerUrl: 'controllers/posts'
      }))
      // terms 分类栏目
      .state('terms', angularAMD.route({
        url: '/terms',
        templateUrl: 'views/terms/terms.html',
        controller: 'terms',
        controllerUrl: 'controllers/terms'
      }))
      // users 用户
      .state('users', angularAMD.route({
        url: '/users',
        templateUrl: 'views/users/users.html',
        controller: 'users',
        controllerUrl: 'controllers/users'
      }))
      // meidas 媒体
      .state('medias', angularAMD.route({
        url: '/medias',
        templateUrl: 'views/medias/medias.html'
      }))
      // roles 角色
      .state('roles', angularAMD.route({
        url: '/roles',
        templateUrl: 'views/roles/roles.html',
        controller: 'roles',
        controllerUrl: 'controllers/roles'
      }))
      // config 网站设置
      .state('configs_site', angularAMD.route({
        url: '/configs/site',
        templateUrl: 'views/configs/site.html',
        // controller: 'roles',
        // controllerUrl: 'controllers/roles'
      }))
      // config 邮箱设置
      .state('configs_email', angularAMD.route({
        url: '/configs/email',
        templateUrl: 'views/configs/email.html',
        // controller: 'roles',
        // controllerUrl: 'controllers/roles'
      }))
      // config 多媒体设置
      .state('configs_media', angularAMD.route({
        url: '/configs/media',
        templateUrl: 'views/configs/media.html',
        // controller: 'roles',
        // controllerUrl: 'controllers/roles'
      }));


  });
  return angularAMD.bootstrap(app);
});
