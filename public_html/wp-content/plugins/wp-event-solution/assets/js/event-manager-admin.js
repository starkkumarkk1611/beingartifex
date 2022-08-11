jQuery(document).ready(function ($) {
    'use strict';

    
    // load color picker   
    $("#etn_primary_color").wpColorPicker();
    $("#etn_secondary_color").wpColorPicker();

    $('body').on('click', '.etn_event_upload_image_button', function (e) {

        e.preventDefault();
        var multiple = false;

        if ($(this).data('multiple')) {
            multiple = Boolean($(this).data('multiple'));
        }

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library: {

                    type: 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: multiple
            }).on('select', function () {
                var attachment = custom_uploader.state().get('selection').first().toJSON();

                $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" alt="" />').next().val(attachment.id).next().show();


            })
            .open();
    });

    /*
     * Remove image event
     */
    $('body').on('click', '.essential_event_remove_image_button', function () {
        $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
        return false;
    });

    // select2 for meta box
    $('.etn_es_event_select2').select2();

    // social icon
    var etn_selected_social_event_icon = null;
    $(' .social-repeater').on('click', '.etn-social-icon', function () {

        etn_selected_social_event_icon = $(this);

    });

    $('.etn-social-icon-list i').on("click", function () {
        var icon_class_selected = $(this).data('class');
        etn_selected_social_event_icon.val(icon_class_selected);
        $('.etn-search-event-mng-social').val(icon_class_selected);
        etn_selected_social_event_icon.siblings('i').removeClass().addClass(icon_class_selected);
    });


    $('.etn-search-event-mng-social').on('input', function () {
        var search_value = $(this).val().toUpperCase();

        let all_social_list = $(".etn-social-icon-list i");

        $.each(all_social_list, function (key, item) {

            var icon_label = $(item).data('value');

            if (icon_label.toUpperCase().indexOf(search_value) > -1) {
                $(item).show();
            } else {
                $(item).hide();
            }

        });
    });

    var etn_social_rep = $('.social-repeater').length;

    if (etn_social_rep) {
        $('.social-repeater').repeater({

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {

                $(this).slideUp(deleteElement);

            },

        });
    }

    $('.etn-settings-nav li a').on('click', function(){
        var target = $(this).attr('data-id');
        $('.etn-settings-nav li a').removeClass('etn-settings-active');
        $("#"+target).fadeIn('slow').siblings(".etn-settings-tab").hide();
        $(this).addClass('etn-settings-active');
        return false;
    });

    // works only this page post_type=etn-schedule
    $('.etn_es_event_repeater_select2').select2();


    // event manager repeater
    var etn_repeater_markup_parent = $(".etn-event-manager-repeater-fld");
    var schedule_repeater = $(".schedule_repeater");
    var schedule_value = $("#etn_schedule_sorting");
    var speaker_sort = {};

    if ((schedule_value.val() !== undefined) && (schedule_value.val() !== '')) {
        speaker_sort = JSON.parse(schedule_value.val());
    }

    if (etn_repeater_markup_parent.length) {
        etn_repeater_markup_parent.repeater({
            show: function () {
                var repeat_length = $(this).parent().find('.etn-repeater-item').length;
                $(this).slideDown();
                $(this).find('.event-title').html($(this).parents('.etn-repeater-item').find(".etn-title").text() + " " + repeat_length);
                $(this).find('.select2').remove();
                $(this).find('.etn_es_event_repeater_select2').select2();

                // make schedule repeater sortable 
                var repeater_items_length = schedule_repeater.find('.sort_repeat').length;
                if (repeater_items_length > 0) {
                    schedule_repeater.find('.sort_repeat:last-child').attr("data-repeater-item", repeater_items_length - 1);
                    etn_drag_and_drop_sorting();
                }
                //time picker
                $(".sort_repeat").on('focus', '.etn-time', function(){
                    $(this).flatpickr({
                        enableTime: true,
                        noCalendar: true,
                        time_24hr: false,
                    });
                });
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
                speaker_sort = {};
                $(this).closest(".sort_repeat").remove();
                $(".sort_repeat").each(function (index, item) {
                    var $this = $(this);
                    if (typeof $this.data('repeater-item') !== undefined) {
                        var check_index = index == $(".sort_repeat").length ? index - 1 : index
                        $this.attr("data-repeater-item", check_index);
                        speaker_sort[index] = check_index;
                    }
                })
                schedule_value.val("").val(JSON.stringify(speaker_sort));
            },
            
        });
    }

    // Repetaer data re-ordering 
    if (schedule_repeater.length) {

        schedule_repeater.sortable({
            opacity: 0.7,
            revert: true,
            cursor: 'move',
            stop: function (e, ui) {
                etn_drag_and_drop_sorting();
            },
        });
    }

    function etn_drag_and_drop_sorting() {
        $(".sort_repeat").each(function (index, item) {
            var $this = $(this);
            if (typeof $this.data('repeater-item') !== "undefined") {
                var check_index = index == $(".sort_repeat").length ? index - 1 : index
                var repeat_value = $this.data('repeater-item') == $(".sort_repeat").length ? $this.data('repeater-item') - 1 : $this.data('repeater-item')
                speaker_sort[check_index] = repeat_value;
            }
        })
        schedule_value.val(JSON.stringify(speaker_sort));
    }

    // slide repeater
    $(document).on('click', '.etn-event-shedule-collapsible', function () {
        $(this).next('.etn-event-repeater-collapsible-content').slideToggle()
            .parents('.etn-repeater-item').siblings().find('.etn-event-repeater-collapsible-content').slideUp();

    });
    $('.etn-event-shedule-collapsible').first().trigger('click');
    // ./End slide repeater
    // ./end works only this page post_type=etn-schedule

    //  date picker
    $(".etn-date .etn-form-control, #etn_start_date, #etn_end_date").flatpickr();
   
    // event start date and end date validation
    var etn_start_date = $("#etn_start_date");
    var etn_end_date   = $("#etn_end_date");
    
    $("#etn_start_date,#etn_end_date").on('change',function () {
        var startDate = etn_start_date.val();
        var endDate   = etn_end_date.val();
        $(etn_start_date).parent().find(".required-text").remove();
        var $this     = $(this);

        if ( $this.attr('name') == "etn_start_date" ) {
            if((Date.parse(startDate) > Date.parse(endDate))) {
                etn_start_date.val("");
                $(etn_start_date).before('<span class="required-text">Start date should be greater than End date</span>');
            }else{
                etn_start_date.parent().find(".required-text").remove();
            }
        }
        else if( $this.attr('name') == "etn_end_date" ){
            if(startDate==''){
                etn_end_date.val("");
                etn_start_date.before('<span class="required-text">Please select start date first</span>');
            }else if ((Date.parse(startDate) > Date.parse(endDate))) {
                etn_end_date.val("");
                etn_end_date.before('<span class="required-text">End date should be greater than Start date</span>');
            }else{
                etn_end_date.parent().find(".required-text").remove();
            }
        }

    });

    // change date format to expected format
    const flatpicker_date_format_change =(selectedDates,format)=>{
        const date_ar         = selectedDates.map(date => flatpickr.formatDate(date, format));
        var new_selected_date = date_ar.toString();

        return new_selected_date;
    }

    function event_time_validation(type) {
        var etn_start   = $("#etn_start_time");
        var etn_end     = $("#etn_end_time");
        var start       = etn_start.attr("data-start_time");
        var end_time    = etn_end.attr("data-end_time");
            $(".etn-meta").parent().find(".required-text").remove();  

            if ( type =='etn_start_time' ) {
                if ( end_time !=="" && ( parseInt(end_time) <= parseInt(start) ) ) {
                    etn_end.val("");
                    $(".etn_end").val("")
                    etn_end.before('<span class="required-text">End time should be greater than Start time</span>');
                }
            } 
            else if ( type =='etn_end_time' ) {
                if ( start !=="" && ( parseInt(start) >= parseInt(end_time) )  ) {
                    etn_start.val("");
                    $(".etn_start").val("")
                    etn_start.before('<span class="required-text">Start time should be less than End time</span>');
                }
            }
    }
    
    // time picker
    $(".etn-time,#etn_start_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        allowInput: true,
        altInput: true,
        altInputClass:"etn-form-control etn_start",
        onClose: function(dateObj, dateStr, instance){
            // event start and end time validation
            var selected   = flatpicker_date_format_change( dateObj , "H:i" );
            $("#etn_start_time").attr("data-start_time", selected );
            // event_time_validation('etn_start_time');
        },
    });

    $("#etn_end_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        allowInput: true,
        altInput: true,
        altInputClass:"etn-form-control etn_end",
        onClose: function(dateObj, dateStr, instance){
            // event start and end time validation
            var selected   = flatpicker_date_format_change( dateObj , "H:i" );
            $("#etn_end_time").attr("data-end_time", selected );
            // event_time_validation('etn_end_time');
        }
    });

    var eventMnger = '#etn-general_options';
    if (window.location.hash) {
        eventMnger = window.location.hash;
    }

    $('.etn-settings-tab .nav-tab[href="' + eventMnger + '"]').trigger('click');
 
    // Previous tab active on reload or save
    if ($('.etn-settings-dashboard').length > 0) {
        var tab_get_href = localStorage.getItem('tab_href');
        var getTabId = JSON.parse(tab_get_href);
        let locationHash = tab_get_href===null ? "#etn-general_options" : getTabId.tab_href;
         if(locationHash && $( `.etn-tab li a[href='${locationHash}']`)[0]){
            $(`.etn-tab li:first-child`).removeClass("attr-active");
            $(`.attr-tab-pane:first-child`).removeClass("attr-active");
            $(`.etn-tab li a[href='${locationHash}']`).parent().addClass("attr-active");
            $(`.attr-tab-pane[id='${locationHash.substr(1)}']`).addClass("attr-active");
        }else{
            $('.etn-tab li:first-child').addClass("attr-active");
            $('.attr-tab-pane:first-of-type').addClass("attr-active");
        }

        // Hide submit button for Hooks tab
        var data_id = $(`.attr-tab-pane[id='${locationHash.substr(1)}']`).attr('data-id');
        var settings_submit = $(".etn_save_settings");
        if ( data_id =="tab6" ) {
            settings_submit.addClass("attr-hide");
        }
        else{
            settings_submit.removeClass("attr-hide");
        }
    }

    //admin settings tab
    $(document).on('click', ".etn-tab > li > a", function (e) {
        e.preventDefault();
        $(".etn-tab li").removeClass("attr-active");
        $(this).parent().addClass("attr-active");
        $(".attr-tab-content .attr-tab-pane").removeClass("attr-active");
        $(".attr-tab-pane[data-id='" + $(this).attr('data-id') + "']").addClass("attr-active");

        //set hash link
        let tab_href = $(this).attr("href");
        localStorage.setItem('tab_href', JSON.stringify({tab_href:tab_href}) );

        
        // Hide submit button for Hooks tab
        var data_id = $(this).attr('data-id');
        var settings_submit = $(".etn_save_settings");
        if ( data_id =="tab6" ) {
            settings_submit.addClass("attr-hide ");
        }
        else{
            settings_submit.removeClass("attr-hide ");
        }
    });

    // schedule tab
    $('.postbox .hndle').css('cursor', 'pointer');

    $('.schedule-tab').on('click', openScheduleTab);

    function openScheduleTab() {
        var title = $(this).data('title');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(title).style.display = "block";
    }

    $('.schedule-tab-shortcode').on('click', openScheduleTabShortCode);

    function openScheduleTabShortCode() {
        var title = $(this).data('title');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent-shortcode");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks-shortcode");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        let single_title = "shortcode_" + title;
        document.getElementById(single_title).style.display = "block";
    }

    // dashboard menu active class pass
    var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
    $("#toplevel_page_etn-events-manager .wp-submenu-wrap li a").each(function () {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).parent().addClass("current");
    });

    // ZOOM MODULE
    // zoom moudle on / off
    block_show_hide('#zoom_api', ".zoom_block");

    // add date time picker
    var start_time = $('#zoom_start_time');
    
    start_time.flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
    });

    start_time.attr('required', true);


    $('#zoom_meeting_password').attr('maxlength', '10');

    $(document).on('click', '.eye_toggle_click', function () {
        var get_id = $(this).parents('.etn-secret-key').children().attr('id');
        $(this).toggleClass('fa fa-eye fa fa-eye-slash');
        show_password(get_id);
    });
    // show hide password
    function show_password(id) {
        var pass = document.getElementById(id);
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }
    // check api connection
    $(document).on('click', '.check_api_connection', function (e) {
        e.preventDefault();
        var data = {
            action: 'zoom_connection',
            zoom_nonce: form_data.zoom_connection_check_nonce,
        }
        $.ajax({
            url: form_data.ajax_url,
            method: 'POST',
            data: data,
            success: function (data) {
                if (typeof data.data.message !== "undefined" && data.data.message.length > 0) {
                    alert(data.data.message[0]);
                }
            }
        });
    });

    $(".etn-settings-select").select2();


    /*-----------------Conditional Block --------------------*/

    $(".etn-conditional-control").on("change", function () {
        var _this = $(this);
        var conditional_control_content = _this.parents(".etn-label-item").next(".etn-label-item");
        if (_this.prop('checked')) {
            conditional_control_content.slideDown();
        } else {
            conditional_control_content.slideUp();
        }
    });
    $(".etn-conditional-control").trigger("change");

    /*------------------Conditional Block------------------*/

    // Set default ticket limit
    $(".repeater_button").on("click", function () {
        available_tickets();
    });

    function available_tickets() {
        var item = $(".etn-repeater-item");
        if ( typeof item !=="undefined" && item.length> 0 ) {
            for (let index = 0; index < item.length ; index++) {
                $('input[name="etn_ticket_variations['+index+'][etn_avaiilable_tickets]"]')
                .attr('placeholder','100,000');
                
            }
        }
    }

    $('input[name="etn_ticket_availability"]').on('change',function(){
        var $this = $(this);
        if ( $this.prop('checked') ) {
            var limit_info = $this.attr("data-limit_info");
            $this.siblings('.etn_switch_button_label').after('<div class="limit_info">'+ limit_info +'</div>')
        }else{
            $('.limit_info').remove();
        }
        // set default available ticket for 1st row
        $('input[name="etn_ticket_variations[0][etn_avaiilable_tickets]"]')
                .attr('placeholder','100,000');
    })

    $("#attendee_registration").on("change", function () {
        var _this = $(this);
        var attendeeConditionalInputField = _this.parents(".etn-label-item").nextAll();
        if (_this.prop('checked')) {
            attendeeConditionalInputField.slideDown();
        } else {
            //hide all conditional divs
            attendeeConditionalInputField.slideUp();

            //update input values
            $("#reg_require_phone").prop("checked", false);
            $("#reg_require_email").prop("checked", false);
            $("#disable_ticket_email").prop("checked", false);
        }
    });
    $("#attendee_registration").trigger("change");

    // Zoom password field length validation
    var zoom_password = $("#zoom_password");
    // if the id found , trigger the action
    if (zoom_password.length > 0) {
        zoom_password.prop('maxlength', 10)
    }

    //   custom tabs
    $(document).on('click', '.etn-tab-a', function (event) {
        event.preventDefault();

        $(this).parents(".schedule-tab-wrapper").find(".etn-tab").removeClass('tab-active');
        $(this).parents(".schedule-tab-wrapper").find(".etn-tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-active");
        $(this).parents(".schedule-tab-wrapper").find(".etn-tab-a").removeClass('etn-active');
        $(this).parent().find(".etn-tab-a").addClass('etn-active');
    });

 
      // **********************
    //  get from value in shortcode settings
    //  ****************************

    $(document).on('click', '.shortcode-generate-btn', function (event) {
        event.preventDefault();
        var arr = [];

        $(this).parents('.shortcode-generator-wrap').find(".etn-field-wrap").each(function(){
            var $this = $(this);
            var data = $this.find('.etn-setting-input').val();
            var option_name = $this.find('.etn-setting-input').attr('data-cat');
            var post_count = $this.find('.post_count').attr('data-count');

            if(option_name !=undefined && option_name !=''){
                data = option_name+' = '+ (data.length ? data : '""');
            }
            if(post_count !=undefined && post_count !=''){
                data = post_count+' = '+ (data.length ? data : '""');
            }
            arr.push(data);
        });


       var allData = arr.filter(Boolean);
       var shortcode = "["+ allData.join(' ') +"]";

      $(this).parents('.shortcode-generator-wrap').find('.etn_include_shortcode').val(shortcode);
      $(this).parents('.shortcode-generator-wrap').find('.copy_shortcodes').slideDown();
      
    });

    $(document).on('click', '.s-generate-btn', function (event) {
        var $this = $(this);
       $($this).parents('.shortcode-generator-wrap').find('.shortcode-generator-main-wrap').fadeIn();

       $($this).parents('.shortcode-generator-wrap').mouseup(function(e){
            var container = $(this).find(".shortcode-generator-inner");
            var container_parent = container.parent(".shortcode-generator-main-wrap");
            if(!container.is(e.target) && container.has(e.target).length === 0){
                container_parent.fadeOut();
            }
        });

    });
    $(document).on('click', '.shortcode-popup-close', function (event) {
       $(this).parents('.shortcode-generator-wrap').find('.shortcode-generator-main-wrap').fadeOut();
    });



    $(".etn-field-wrap").each(function(){
        $(this).find(".get_schedule_template").on('change', function(){
            $(this).find("option:selected").each(function(){
                var $this = $(this);
                var optionValue = $this.attr("value");
                if(optionValue === 'schedules'){
                    $this.parents(".shortcode-generator-inner").find('.etn-shortcode-select').attr("multiple", 'multiple');
                }else if(optionValue =='etn_pro_schedules_tab'){
                    $this.parents(".shortcode-generator-inner").find('.etn-shortcode-select').attr("multiple", 'multiple');
                } else{
                    $this.parents(".shortcode-generator-inner").find('.etn-shortcode-select').removeAttr("multiple");
                }
            });
        }).change();

    });
  


    show_conditinal_field($, ".get_template", 'etn_pro_speakers_classic', '.speaker_style');
    show_conditinal_field($, ".get_template", 'etn_pro_events_classic', '.event_pro_style');
    show_conditinal_field($, '.calendar-style select', "style ='style-1'", '.s-display-calendar');


    $('#recurrence_freq').on('change', function( e ){
        var _this                   = $(this);
        var freq_value              = _this.val();
        var day_interval_block      =  document.querySelector('#event-interval-day');
        var week_interval_block     =  document.querySelector('#event-interval-week');
        var month_interval_block    =  document.querySelector('#event-interval-month');
        var year_interval_block     =  document.querySelector('#event-interval-year');

        if(freq_value == 'day'){
            day_interval_block.style.display    = "flex";
            week_interval_block.style.display   = "none";
            month_interval_block.style.display  = "none";
            year_interval_block.style.display   = "none";
        }else if(freq_value == 'week'){
            week_interval_block.style.display   = "flex";
            day_interval_block.style.display    = "none";
            month_interval_block.style.display  = "none";
            year_interval_block.style.display   = "none";
        }else if(freq_value == 'month'){
            month_interval_block.style.display  = "flex";
            week_interval_block.style.display   = "none";
            day_interval_block.style.display    = "none";
            year_interval_block.style.display   = "none";
        }else if(freq_value == 'year'){
            year_interval_block.style.display   = "block";
            week_interval_block.style.display   = "none";
            month_interval_block.style.display  = "none";
            day_interval_block.style.display    = "none";
        } else {
            year_interval_block.style.display   = "none";
            week_interval_block.style.display   = "none";
            month_interval_block.style.display  = "none";
            day_interval_block.style.display    = "none";
        }
    });

    $('#recurrence_freq').trigger('change');

    $('#sell_tickets').on('change', function(){
        var _this   = $(this);
        if (_this.prop('checked')) {
            $('#etn-add-to-cart-redirect-settings').slideDown();
        } else {
            $('#etn-add-to-cart-redirect-settings').slideUp();
        }
    });
    $('#sell_tickets').trigger('change');
    
    // show event ticket variation stock count field depending on limited / unlimited settings
    $("input[name='etn_ticket_availability']").on("change", function () {
        var _this                   = $(this);
        var all_variation_counts    = $('.etn-ticket-stock-count');
        if (_this.prop('checked')) {
            all_variation_counts.each(function(){
                $(this).show();
            });
        } else {
            all_variation_counts.each(function(){
                $(this).hide();
            });
        }
    });
    $("input[name='etn_ticket_availability']").trigger("change");

});


function show_conditinal_field($, selectClass, optionName, showHideClass){
    $(selectClass).on('change', function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue === optionName){
                $(showHideClass).show();
            } else{
                $(showHideClass).hide();
            }
        });
    }).change();
}
 


//   copy text
function copyTextData(FIledid) {
    var FIledidData = document.getElementById(FIledid);
    if (FIledidData) {
        FIledidData.select();
        document.execCommand("copy");
    }
}

function block_show_hide(trigger, selector) {
    jQuery(trigger).on('change', function () {
        if (jQuery(trigger).prop('checked')) {
            jQuery(selector).fadeIn('slow');
        } else {
            jQuery(selector).fadeOut('slow');
        }
    })
}

function etn_remove_block(remove_block_object) {
    jQuery(remove_block_object.parent_block).on('click', remove_block_object.remove_button, function (e) {
        e.preventDefault();
        jQuery(this).parent(remove_block_object.removing_block).remove();
    });
}

// show/hide conditional field in shortcode generate
// function show_conditional_field($, selectClass, optionName, showHideClass ){
//     $(selectClass).on('change', function(){
//         $(this).find("option:selected").each(function(){
//             var optionValue = $(this).attr("value"); 
//             if(optionValue !== optionName){
//                 $('.shortcode-generator-inner').find(showHideClass).show();
//             } else{
//                 $('.shortcode-generator-inner').find(showHideClass).hide();
//             }
//         });
//     });
// }