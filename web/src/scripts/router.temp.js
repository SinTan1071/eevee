var app = angular.module('App', ['ui.router','ng.ueditor']);

app.config(['$stateProvider', '$urlRouterProvider', function(s, u) {

  u.otherwise('/index');

  // Base
  s.state('index', {
    // 主界面
    url: '/index',
    templateUrl: 'templates/index.html'
  }).state('login', {
    // 登录
    url: '/login',
    templateUrl: 'templates/login.html'
  }).state('regist', {
    // 注册
    url: '/regist',
    templateUrl: 'templates/regist.html'
  });



  // UI Elements
  s.state('templatesPanels', {
    // 面板
    url: '/templates/panels',
    templateUrl: 'templates/panels.html'
  }).state('templatesIcons', {
    // icons
    url: '/templates/icons',
    templateUrl: 'templates/icons.html'
  }).state('templatesButtons', {
    // 按钮
    url: '/templates/buttons',
    templateUrl: 'templates/buttons.html',
  }).state('templatesCards', {
    // 卡片
    url: '/templates/cards',
    templateUrl: 'templates/cards.html'
  });

  // Medias
  s.state('templatesVideos', {
    url: '/templates/videos',
    templateUrl: 'templates/videos.html'
  });


  // 文章
  s.state('posts', {
    url: '/posts',
    templateUrl: 'views/posts/posts.html'
  });

  // 分类
  s.state('terms', {
    url: '/terms',
    templateUrl: 'views/terms/terms.html'
  });


  // 媒体
  s.state('medias', {
    url: '/medias',
    templateUrl: 'views/medias/index.html'
  });

  // 用户
  s.state('users', {
    url: '/users',
    templateUrl: 'views/users/users.html'
  });

  // 角色
  s.state('roles', {
    url: '/roles',
    templateUrl: 'views/roles/roles.html'
  });

  // 页面
  s.state('templatesPages', {
    // 所有页面
    url: '/templates/pages',
    templateUrl: 'templates/pages/pages.html'
  }).state('templatesNewPage', {
    // 新建页面
    url: '/templates/pages/new',
    templateUrl: 'templates/pages/new.html'
  });



}]);
