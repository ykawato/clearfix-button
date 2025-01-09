(function() {
    tinymce.create('tinymce.plugins.clearfix_button', {
        init: function(ed) {
            ed.addButton('clearfix_button', {
                title: 'Insert Clearfix',
                icon: 'hr', // You can change to another icon if desired
                onclick: function() {
                    // Insert clearfix div PLUS a space (or invisible character)
                    // so that the cursor ends up AFTER the div
                    ed.insertContent('<div class="clearfix"></div>&nbsp;');
                }
            });
        }
    });

    // Register plugin
    tinymce.PluginManager.add('clearfix_button', tinymce.plugins.clearfix_button);
})();