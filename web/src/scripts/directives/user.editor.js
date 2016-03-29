define(['app', 'jquery'], function(app) {

  app.directive('user.editor', function($http, $compile) {

    return {
      restrict: 'A',
      replace: true,
      scope: {},
      templateUrl: 'views/users/editor.html',
      controller: ['$scope', function($scope) {
        $scope.title = "编辑用户";
        $scope.closePostEditor = function() {
          $("#user-editor").addClass('animated slideOutRight');
        };
      }]
    };

  });

})
