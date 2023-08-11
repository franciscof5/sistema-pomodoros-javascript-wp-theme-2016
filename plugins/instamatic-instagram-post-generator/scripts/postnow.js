"use strict";
function instamatic_post_now(postId)
{
    if (confirm("Are you sure you want to submit this post now?") == true) {
        document.getElementById('instamatic_submit_post').setAttribute('disabled','disabled');
        document.getElementById("instamatic_span").innerHTML = 'Submitting... (please do not close or refresh this page) ';
        var data = {
             action: 'instamatic_post_now',
             id: postId
        };
        jQuery.post(ajaxurl, data, function(response) {
            document.getElementById('instamatic_submit_post').removeAttribute('disabled');
            document.getElementById("instamatic_span").innerHTML = 'Done! ';
        }).fail( function(xhr) 
        {
            document.getElementById("instamatic_span").innerHTML = 'Error, please check the plugin\'s \'Activity and Logging\' menu for details!';
            console.log('Error occured in processing: ' + xhr.statusText + ' - please check plugin\'s \'Activity and Logging\' menu for details.');
        });
    } else {
        return;
    }
}