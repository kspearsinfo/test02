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
});