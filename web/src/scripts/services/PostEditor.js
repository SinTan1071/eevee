// Post 编辑器服务

define(['app','../directives/post.editor','jquery'],function(App){
    App.factory('PostEditor', function($compile) {
      return {
        init: function($scope) {
          $('#layout-view').append($compile($('<div post.editor></div>'))($scope));
        },
        open: function() {
          $("#post-editor").hide().removeClass('animated slideOutRight').addClass('animated slideInRight').show();
        }
      }
    });
});
