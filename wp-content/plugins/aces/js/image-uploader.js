jQuery(document).ready( function($){
	'use strict';

	// Upload Taxonomy Image Start

	function aces_image_upload(button_class){
		'use strict';
		var _custom_media = true,
		_orig_send_attachment = wp.media.editor.send.attachment;

		$('body').on('click', button_class, function(e){
			'use strict';
			var button_id = '#'+$(this).attr('id');
			var send_attachment_bkp = wp.media.editor.send.attachment;
			var button = $(button_id);
			_custom_media = true;

			wp.media.editor.send.attachment = function(props, attachment){
				'use strict';
				if ( _custom_media ){
				 	$('#taxonomy-image-id').val(attachment.id);
					$('#taxonomy-image-wrapper').html('<img class="custom_media_image" src="" style="margin: 0; padding: 0; max-height: 32px; float: none;" />');
					$('#taxonomy-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
				} else {
					return _orig_send_attachment.apply( button_id, [props, attachment] );
				}
			}

			wp.media.editor.open(button);
			return false;

		});

	}

	aces_image_upload('.aces_media_button.button'); 
  
	$('body').on('click','.aces_media_remove', function(){
		'use strict';
		$('#taxonomy-image-id').val('');
		$('#taxonomy-image-wrapper').html('<img class="custom_media_image" src="" style="margin: 0; padding: 0; max-height: 32px; float: none;" />');
	});

	$(document).ajaxComplete( function(event, xhr, settings) {
		'use strict';
		var response;
		var queryStringArr = settings.data.split('&');
		if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
			var xml = xhr.responseXML;
			response = $(xml).find('term_id').text();
			if(response != ""){
				$('#taxonomy-image-wrapper').html('');
			}
		}
	});

	// Upload Taxonomy Image End

	// Upload Background image of casino/game page - Start

	$('body').on('click', '.aces_upload_background_button', function(e){
		'use strict';
        	e.preventDefault();
            var button = $(this),
                custom_uploader = wp.media({
            title: 'Insert image',
            library : {
                type : 'image'
            },
            button: {
                text: 'Set background image'
            },
            multiple: false
        }).on('select', function() {
        	'use strict';
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).removeClass('button').html('<img class="aces-background-admin-image" src="' + attachment.url + '" style="max-width: 100%; width: auto; display:block;" />').next().val(attachment.id).next().show();
        })
        .open();
    });
 
    $('body').on('click', '.aces_remove_background_button', function(){
    	'use strict';
        $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
        return false;
    });

    // Upload Background image of casino/game page - End
  
});