$( document ).ready(function() {

    /**
     * Load this function after page finish loading
     */
    setTimeout(function(){
        window.onload = load_comments();
    }, 1000);

    /**
     * ajax call to get the comment section
     */
    function load_comments(){
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {action : 'get_comments'},
            success: function( data, textStatus, jQxhr ){
                $('.comment-list').html( data );
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
    }

    /**
     * Action to submit the comment or reply
     */
    $(document).on('click', ".btn-primary",function(e){
        e.preventDefault();
       var parent_id = $(this).data('parent-comment');
       var form = $("#parent_comment_id_" + parent_id);
       var data = {};
       form.serializeArray().map(function(x){data[x.name] = x.value;});
        if(validate_comment_form(data)){
            data.action = 'add_comment';
            $.ajax({
                url: 'ajax.php',
                type: 'post',
                data: data,
                success: function( data, textStatus, jQxhr ){
                    data = JSON.parse(data);
                    if(data.status == "ok"){
                        load_comments();
                    }
                    else{
                        alert(data.message);
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });
        }
    });

    /**
     * Custom validation for comment form
     * @param array data
     * @returns {boolean}
     */
    function validate_comment_form(data){
        var error = false;
        var error_message = '';
        if(data.parent_comment_id == ''){
            error = true;
            error_message += 'Parent comment id is required';
        }
        if(isNaN(data.parent_comment_id)){
            error = true;
            error_message += 'Parent comment id must be a number';
        }
        if(isNaN(data.comment_level)){
            error = true;
            error_message += 'Comment level must be a number';
        }
        if(parseInt(data.comment_level) > 3){
            error = true;
            error_message += ',Cant have more that 3 nested replies';
        }
        if(data.author_name == ''){
            error = true;
            error_message += ',Author name is required ';
        }
        if(data.comment == ''){
            error = true;
            error_message += ',Comment is required';
        }
        if(error){
            alert(error_message);
            return false;
        }
        return true;
    }

});

$(document).on('click', '.reply-btn',function (e) {
    e.preventDefault();
    var data = {};
    var width = $(this).data('column-width');
    data.parent_id = $(this).data('parent-comment');
    data.comment_level = $(this).data('comment-level');
    data.action = 'get_reply_form';
    var reply_elem = $(this).closest('.row');
    $.ajax({
        url: 'ajax.php',
        type: 'post',
        data: data,
        success: function( data, textStatus, jQxhr ){
            reply_elem.next().html(data);
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
    });
});