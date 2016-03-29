/**
 * Users 控制器
 */

define(['app','../services/UserEditor'],function(app){
    app.controller('users', ['$scope','UserEditor',function($scope,UserEditor) {
      $scope.title = "用户管理";
      UserEditor.init($scope);

      $scope.openUserEditor = function() {
          UserEditor.open();
      }

    }]);
});
