jQuery(window).on("elementor/frontend/init", function () {
    /*
    * Checks if in the editor, if not stop the rest from executing
    */
    if ( !window.elementorFrontend.config.environmentMode.edit ) {
        return;
    }
    
    elementor.channels.editor.on('elementor:editor:create', function (panel) {

        if( panel.$el.hasClass('open') ){ return false; }
        var parent  = panel.$el.parents('#elementor-controls'),            
        cache_fld   = parent.find("[data-setting='meeting_cache']"),
        topic       = parent.find("[data-setting='topic']").val(),
        user_id     = parent.find("[data-setting='user_id']").val(),
        start_time  = parent.find("[data-setting='start_time']").val(),
        timezone    = parent.find("[data-setting='timezone']").val(),
        duration    = parent.find("[data-setting='duration']").val(),
        password    = parent.find("[data-setting='password']").val();
        var empty_arr = [ 
                            {"key":"user_id",    "value" : "Please select meeting hosts."} ,
                            {"key":"start_time", "value" : "Please select start time."} ,
                            {"key":"password",   "value" : "Password length can't be more than 10."} 
                        ];
        var meeting_id = "";                
        if ( cache_fld.val() !=="" ) {
            var meeting_data = JSON.parse( cache_fld.val() );
            if ( typeof meeting_data.id !=="undefined" ) {
                meeting_id = meeting_data.id;
            }
        }

        var invalid_param = [];                
        if ( !user_id ) {
            invalid_param.push( 'user_id' );
        }
        if ( !start_time ) {
            invalid_param.push( 'start_time' );
        }
        if ( password.length > 10 ) {
            invalid_param.push( 'password' );
        }
        if (invalid_param.length > 0) {
            jQuery.each( empty_arr, function( index , value ){
                if (jQuery.inArray( value.key , invalid_param ) != -1) {
                    panel.$el.find('.elementor-control-input-wrapper').append(
                        '<div class="alert alert-danger" role="alert">'+ value.value +'</div>');
                }
                setTimeout(function(){
                    panel.$el.find('.alert').fadeOut().remove();
                }, 2000 )
            })
            return false;
        }

        var form_data = {
            'meeting_id': meeting_id,
            'user_id'   : user_id,
            'start_time': start_time,
            'timezone'  : timezone,
            'duration'  : duration,
            'password'  : password,
            'topic'     : topic,
            'action'    : 'elementor_create_meeting', 
            'zoom_nonce': zoom_js.zoom_create_meeting_nonce,

        };
        jQuery.ajax({
            data: form_data,
            type: 'post',
            url: zoom_js.ajax_url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', zoom_js.nonce);
                panel.$el.addClass('open');
            },
            success: function (response) {
                if( typeof response !=='undefined' && typeof response.data !== 'undefined') {
                    cache_fld.val( JSON.stringify( response.data.data ) );
                    cache_fld.trigger('input');
                    panel.$el.find('.elementor-control-input-wrapper').append('<div class="alert alert-success" role="alert">'+ response.data.message[0] +'</div>');
                } else {
                    panel.$el.find('.elementor-control-input-wrapper').append('<div class="alert alert-danger" role="alert"> Something is wrong </div>');
                }
                panel.$el.removeClass('open');
                setTimeout(function(){
                    panel.$el.find('.alert').fadeOut().remove();
                }, 2000)
            },
            error : function (response){
            }
        });
    });
});


