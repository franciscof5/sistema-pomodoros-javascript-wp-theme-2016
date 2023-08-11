"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'instamatic-instagram-post-generator/instamatic-video', {
    title: 'Instamatic Video Embed',
    icon: 'instagram',
    category: 'embed',
    attributes: {
        v : {
            default: '',
            type:   'string',
        },
        width : {
            default: '560',
            type:   'string',
        },
        height : {
            default: '',
            type:   'string',
        }
    },
    keywords: ['list', 'posts', 'instamatic'],
    edit: (function( props ) {
		var v = props.attributes.v;
        var width = props.attributes.width;
        var height = props.attributes.height;
		function updateMessage( event ) {
            props.setAttributes( { v: event.target.value} );
		}
        function updateMessage2( event ) {
            props.setAttributes( { width: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { height: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'Instamatic Media Embed ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to embed a Instagram media.'
                    )
                )
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Media ID/URL: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Input the ID or URL of the Instagram media to embed.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Input the video ID/URL', value: v, onChange: updateMessage, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Embed Width: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Input the embed width of the video.'
                )
            ),
			gcel(
				'input',
				{ type:'number',min:0,placeholder:'Embed width', value: width, onChange: updateMessage2, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Embed Height: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Input the embed height of the video.'
                )
            ),
			gcel(
				'textarea',
				{ rows:1,placeholder:'Embed height', value: height, onChange: updateMessage3, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );