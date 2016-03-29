// Post 编辑器指令
define(['app','jquery'],function(App){
    App.directive('post.editor', function($http, $compile) {
      return {
        restrict: 'A',
        replace: true,
        scope: {},
        templateUrl: 'views/posts/editor.html',
        controller: ['$scope', function($scope) {
          $scope.title = "文章编辑器";
          $scope.closePostEditor = function() {
            $("#post-editor").addClass('animated slideOutRight');
          };
        }]
      };
    });
});
