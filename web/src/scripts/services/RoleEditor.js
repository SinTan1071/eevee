define(['app','../directives/role.editor','jquery'], function(app) {

  app.factory('RoleEditor', function($compile) {
    return {
      init: function($scope) {
        $('#layout-view').append($compile($('<div role.editor></div>'))($scope));
      },
      open: function() {
        $("#role-editor").hide().removeClass('animated slideOutRight').addClass('animated slideInRight').show();

      }
    }
  });
});
