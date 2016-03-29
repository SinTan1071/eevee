app.directive('medias', function($http, $compile) {

  return {
    restrict: 'A',
    replace: true,
    scope: {},
    templateUrl: 'views/medias/medias.html',
    controller: ['$scope', function($scope) {
      $scope.title = "编辑用户";
      $scope.closePostEditor = function() {
        $("#user-editor").addClass('animated slideOutRight');
      };
    }]
  };
});
