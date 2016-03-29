
define(['app','../directives/user.editor', 'jquery'], function(app) {


app.factory('UserEditor', function($compile) {
  return {
    init: function($scope) {
      $('#layout-view').append($compile($('<div user.editor></div>'))($scope));
    },
    open: function() {
      $("#user-editor").hide().removeClass('animated slideOutRight').addClass('animated slideInRight').show();

    }
  }
});

});
