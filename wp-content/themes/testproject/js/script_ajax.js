jQuery.noConflict($);
/* Ajax functions */
jQuery(document).ready(function($) {
    //find scroll position
    $(window).scroll(function() {
        //init
        var that = $('#loadMore');
        var page = $('#loadMore').data('page');
        var newPage = page + 1;
        var ajaxurl = $('#loadMore').data('url');
        //check
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {

            //ajax call
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    page: page,
                    action: 'ajax_script_load_more'
                },
                error: function(response) {
                    console.log(response);
                },
                success: function(response) {
                    //check
                    if (response == 0) {
                        //check
                        if ($("#no-more").length == 0) {
                            $('#ajax-content').append('<div id="no-more" class="text-center"><h3>You reached the end of the line!</h3><p>No more posts to load.</p></div>');
                        }
                        $('#loadMore').hide();
                    } else {
                        $('#loadMore').data('page', newPage);
                        $('#ajax-content').append(response);
                    }
                }
            });
        }
    });


$(document).on("click", '.add_like', function(event) {


        var ajaxurl = $('#loadMore').data('url');
        var id = $(this).data('id');
        var liked = $(this).data('liked');
        var user_id = $(this).data('user_id');

        var outer_this = $(this);

    /*
    * Collecting data for ajax call.
    */
    var data = { action : 'post_like',
                id : id,
                liked: liked,
                user_id: user_id
    }  


    if(liked == 'true'){
                       $(this).removeClass('liked');
                       $(this).data('liked', 'false');  
                    }else{
                        $(this).addClass('liked');
                       $(this).data('liked', 'true'); 
     }

        /*
    * Making ajax request to save values.
    */  
    jQuery.ajax({
        url : ajaxurl,
        type : 'post',
        data : data,
        success : function( response ) {

               
                if(response.success){

                    // console.log(response); return;

                    

                     $(outer_this).next().html(' ').html(response.data);

                     
                    
                }
                else{
                    console.log(response.data);

                    }
        }

        });/* Ajax func ends here. */ 

    });
});

function changeColor()
{
   var icon = document.getElementById('heart');
   icon.style.color = "red";    
}