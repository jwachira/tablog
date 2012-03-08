(function() {
    // Creates a new plugin class and a custom listbox
	
    tinymce.create('tinymce.plugins.themifyMenu', {
		init : function(ed, url) {
			tinymce.plugins.themifyMenu.theurl = url;			
		},
		createControl: function(n, cm) {
		    if (n != 'btnthemifyMenu') return null;

		    var c = cm.createSplitButton('themifyMenu', {
		        title : 'Shortcodes',
		        image : tinymce.plugins.themifyMenu.theurl + '/../img/favicon.png'
		    });
			
			p = this;
		    c.onRenderMenu.add(function(c, m) {
				ed = tinyMCE.activeEditor;
				
		        m.add({title : 'Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
		        
		        //Launch dialog
				p.themifyDialog( 'Video', 'video', 400, 200, m, ed );
				
				//Simple enclosing shortcodes
				p.themifyWrap('Quote', 'quote', m, ed);
				p.themifyWrap('Is Logged In', 'is_logged_in', m, ed);
				p.themifyWrap('Is Guest', 'is_guest', m, ed);
				
	        });
	
	        return c;
		},
		themifyDialog : function(t, sc, w, h, m, ed){
			m.add({
				title : t,
				onclick : function() {
					ed.windowManager.open({
						file : tinymce.plugins.themifyMenu.theurl + '/dialog.php?shortcode=' + sc + '&title=' + t,
						width : w,
						height : h,
						inline : 1
					});
				}
			});
		},
		themifyWrap : function(t, sc, m, ed) {
			m.add({
				title : t,
				onclick : function() {
					ed.selection.setContent('[' + sc + ']' + ed.selection.getContent() + '[/' + sc + ']');
				}
			})
		}
    });
    tinymce.PluginManager.add('themifyMenu', tinymce.plugins.themifyMenu);
})();
