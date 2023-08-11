"use strict"; 
( function( wp ) {
	var registerPlugin = wp.plugins.registerPlugin;
	var PluginSidebar = wp.editPost.PluginSidebar;
	var el = wp.element.createElement;
    
	registerPlugin( 'instamatic-sidebar', {
		render: function() {
            function updateMessage( ) {
                var postId = wp.data.select("core/editor").getCurrentPostId();
                if (confirm("Are you sure you want to submit this post now?") == true) {
                    document.getElementById('instamatic_submit_post').setAttribute('disabled','disabled');
                    document.getElementById("instamatic_span").innerHTML = 'Posting status: Submitting... (please do not close or refresh this page) ';
                    var data = {
                         action: 'instamatic_post_now',
                         id: postId
                    };
                    jQuery.post(ajaxurl, data, function(response) {
                        document.getElementById('instamatic_submit_post').removeAttribute('disabled');
                        document.getElementById("instamatic_span").innerHTML = 'Posting status: Done! ';
                    }).fail( function(xhr) 
                    {
                        document.getElementById("instamatic_span").innerHTML = 'Error, please check the plugin\'s \'Activity and Logging\' menu for details!';
                        console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details.');
                    });
                } else {
                    return;
                }
            }
			return el( PluginSidebar,
				{
					name: 'instamatic-sidebar',
					icon: 'instagram',
					title: 'Instamatic Post Publisher',
				},
				el(
                    'div', 
                    { className: 'coderevolution_gutenberg_div' },
                    el(
                        'h4',
                        { className: 'coderevolution_gutenberg_title' },
                        'Publish Post to Instagram '
                    ),
                    el(
                        'input',
                        { type:'button', id:'instamatic_submit_post', value:'Post To Instagram Now!', onClick: updateMessage, className: 'coderevolution_gutenberg_button button button-primary' }
                    ),
                    el(
                    'br'
                    ),
                    el(
                    'br'
                    ),
                    el(
                        'div', 
                        {id:'instamatic_span'},
                        'Posting status: idle'
                    )
				)
			);
		},
	} );
} )( window.wp );